<?php

class UnisenderActivation extends UnisenderAbstract
{
	static public function addMenuPages()
	{

        if (!empty($_POST['action']) && strpos($_POST['action'], 'unisender_') === false) {
            return;
        }
		if (!get_option('unisender_api_key')) {
			add_management_page(
				'Unisender Integration',
				'Unisender',
				'edit_plugins',
				'unisender',
				array('UnisenderActivation', 'addManagementPage')
			);
			if (!empty($_POST)) {
				new UnisenderActivation();
			}
		} else {
			if (array_key_exists('field', $_GET)
			    || (array_key_exists('section', $_GET) && $_GET['section'] === 'field')) {
				add_management_page(
					'Unisender Integration',
					'Unisender',
					'edit_plugins',
					'unisender',
					array('UnisenderField', 'addManagementPage')
				);
				if (!empty($_POST)) {
					new UnisenderField();
				}

			} elseif (array_key_exists('section', $_GET) && $_GET['section'] === 'form') {
				add_management_page(
					'Unisender Integration',
					'Unisender',
					'edit_plugins',
					'unisender',
					array('UnisenderForm', 'addManagementPage')
				);
				if (!empty($_POST)) {
					new UnisenderForm();
				}
			} elseif (array_key_exists('messageId', $_GET)
			          || (array_key_exists('section', $_GET) && $_GET['section'] === 'message')) {
				add_management_page(
					'Unisender Integration',
					'Unisender',
					'edit_plugins',
					'unisender',
					array('UnisenderMessage', 'addManagementPage')
				);
				if (!empty($_POST)) {
					new UnisenderMessage();
				}
			} else {
				add_management_page(
					'Unisender Integration',
					'Unisender',
					'edit_plugins',
					'unisender',
					array('UnisenderContactList', 'addManagementPage')
				);
				if (!empty($_POST)) {
					new UnisenderContactList();
				}
			}
		}
	}

	public function actionIndex()
	{
		include(dirname(plugin_dir_path(__FILE__)) . '/tpl/Activation/connection.php');

		return true;
	}

	public function actionLogin()
	{
		if (empty($_POST['api_key'])) {
			die(self::setResponse(false, __('Not all required fields are filled', $this->textdomain)));
		}

		$apiKey = $_POST['api_key'];

		$api    = UnisenderApi::getInstance($apiKey);
		$result = $api->getUserInfo();
		if ($result['status'] === 'success') {
			update_option('unisender_api_key', $apiKey);

			UnisenderContactList::actionSync(1);
			die(self::setResponse(true, __('Authorization successful', $this->textdomain), admin_url('tools.php?page=unisender')));
		}

		die(self::setResponse(false, $result['message']));
	}

	public function actionRegistration()
	{
		if (empty($_POST['login']) || empty($_POST['email']) || empty($_POST['firstName']) ||
		    empty($_POST['password']) || empty($_POST['passwordRepeat'])
		) {
			die(self::setResponse(false, __('Not all required fields are filled', $this->textdomain)));
		}

		if ($_POST['password'] !== $_POST['passwordRepeat']) {
			die(self::setResponse(false, __('The entered passwords do not match', $this->textdomain)));
		}

		$api = UnisenderApi::getInstance();
		$result = $api->addNewUser($_POST['email'], $_POST['login'], $_POST['password'], $_POST['firstName']);
		if ($result['status'] === 'success') {
			update_option('unisender_api_key', $result['data']['api_key']);
			update_option('unisender_login', $_POST['login']);
			$api->reInstance();
			die(self::setResponse(true, __('Congratulations upon successful registration! In your e-mail message sent to complete the registration', $this->textdomain), admin_url('tools.php?page=unisender')));
		}

		die(self::setResponse(false, $result['message']));
	}

	public static function activatePlugin()
	{
		self::addOptions();
		self::createTables();
	}

	public static function deactivatePlugin()
	{
		self::removeOptions();
		self::removeTables();
	}

	private static function addOptions()
	{
		add_option('unisender_api_key', '');
		add_option('unisender_login', '');
		add_option('unisender_form_title', __('Subscribe', 'unisender'));
		add_option('unisender_form_success', '');
		add_option('unisender_is_create_user', '0');
	}

	private static function removeOptions()
	{
		delete_option('unisender_api_key');
		delete_option('unisender_login');
		delete_option('unisender_form_title');
		delete_option('unisender_form_success');
		delete_option('unisender_is_create_user');
	}

	private static function createTables()
	{
        /* @var wpdb $wpdb */
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$charset_collate = 'utf8 COLLATE utf8_unicode_ci';

		if ($wpdb->get_var('SHOW TABLES LIKE "' . $wpdb->prefix.'unisender_field' . '"') === null) {
			$sql = '
				CREATE TABLE ' . $wpdb->prefix.'unisender_field' . '
				(
					`id` int(11) NOT NULL,
					`public_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
					`name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
					`placeholder` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
				    `type` enum("string","number","text","bool","date") COLLATE utf8_unicode_ci DEFAULT NULL,
				    `is_enabled` tinyint(1) DEFAULT NULL,
				    `is_in_form` tinyint(1) DEFAULT NULL,
				    `form_position` tinyint(1) DEFAULT NULL,
				    `is_form_required` tinyint(1) DEFAULT NULL,
				    `connect` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,

					PRIMARY KEY (id)
				)
				ENGINE=InnoDB DEFAULT CHARACTER SET ' . $charset_collate;
			$wpdb->query($sql);
		}

		if ($wpdb->get_var('SHOW TABLES LIKE "' . $wpdb->prefix.'unisender_contact_list' . '"') === null) {
			$sql = '
				CREATE TABLE ' . $wpdb->prefix.'unisender_contact_list' . '
				(
					`id` int(11) NOT NULL,
					`title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
					`is_default` tinyint(1) DEFAULT NULL,
					`is_auto_sync` tinyint(1) DEFAULT NULL,

					PRIMARY KEY (id)
				)
				ENGINE=InnoDB DEFAULT CHARACTER SET ' . $charset_collate;
			$wpdb->query($sql);
		}
	}

	private static function removeTables()
	{
        /* @var wpdb $wpdb */
		global $wpdb;

		if ($wpdb->get_var('SHOW TABLES LIKE "' . $wpdb->prefix . 'unisender_field' . '"') !== null) {
			$sql = 'DROP TABLE ' . $wpdb->prefix.'unisender_field';
			$wpdb->query($sql);
		}

		if ($wpdb->get_var('SHOW TABLES LIKE "' . $wpdb->prefix . 'unisender_contact_list' . '"') !== null) {
			$sql = 'DROP TABLE ' . $wpdb->prefix.'unisender_contact_list';
			$wpdb->query($sql);
		}
	}

	public static function addManagementPage()
	{
		wp_enqueue_style('unisender_admin', dirname(plugin_dir_url(__FILE__)) . '/css/unisender_admin.css', false);
		wp_enqueue_script('unisender_admin', dirname(plugin_dir_url(__FILE__)) . '/js/unisender_admin.js');

		$jsTrans = array(
			'deleteQuestion' => __('Are you sure you want to delete an item', 'unisender'),
			'defaultQuestion' => __('Set a list of the default #', 'unisender')
		);
		wp_localize_script('unisender_admin', 'unisenderJsTrans', $jsTrans);

		if (empty($_POST)) {
			new self();
		}
	}
}
