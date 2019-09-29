<?php

class UnisenderForm extends UnisenderAbstract
{
	private $action;

	public function __construct()
	{
		$this->section = 'Form';
		if (!empty($_POST['action']) && strstr($_POST['action'], 'unisender')) {
			$this->action = substr($_POST['action'], 10);
			switch ($_GET['action']) {
				case 'edit':
				default:
					$this->actionEdit();
					break;
			}
		} else {
			$this->actionIndex();
		}
	}

	public function actionIndex()
	{
		$this->render('form', array(
			'lists' => UnisenderContactList::getLists(),
			'defaultListId' => UnisenderContactList::getDefaultListId(),
			'fields' => UnisenderField::getFields()
		));
	}

	private function actionEdit()
	{
		//Опции формы
		if (empty($_POST['unisender_form_title']) || empty($_POST['unisender_form_success']) || empty($_POST['list_id'])) {
			die(self::setResponse(false, __('Not all required fields are filled', $this->textdomain)));
		}

		$wpList = UnisenderContactList::getList((int) $_POST['list_id']);
		if (!$wpList) {
			die(self::setResponse(false, __('The contact list is not found', $this->textdomain)));
		}
		UnisenderContactList::setAsDefault($wpList);


		update_option('unisender_form_title', $_POST['unisender_form_title']);
		update_option('unisender_form_success', $_POST['unisender_form_success']);
		update_option('unisender_is_create_user', (int)isset($_POST['unisender_is_create_user']));
		update_option('unisender_is_create_user', (int)isset($_POST['unisender_is_create_user']));

		//поля формы
		if (!empty($_POST['fields'])) {
			$wpFields = UnisenderField::getFields();
			foreach ($wpFields as $field) {
				if (!isset($_POST['fields'][$field['id']])) {
					$field['is_in_form'] = $field['is_form_required'] = 0;
					$field['form_position'] = array_search($field['id'], array_keys($_POST['fields']));
				} else {
					$field['is_in_form'] = (int) isset($_POST['fields'][$field['id']]['is_in_form']);
					$field['is_form_required'] = (int) isset($_POST['fields'][$field['id']]['is_form_required']);
					$field['form_position'] = array_search($field['id'], array_keys($_POST['fields']));
				}
				UnisenderField::updateField($field);
			}
		}

		die(self::setResponse(
			true,
			__('Form settings saved', $this->textdomain),
			admin_url('tools.php?page=unisender&section=form')
		));
	}

    static public function actionSubscribe()
    {
        $fields = UnisenderField::getFields(false, true);
        $defaultListId = UnisenderContactList::getDefaultListId();
        $params = array();
        foreach ($fields as $f) {
            if ($f['is_form_required'] === 1 && !array_key_exists($f['name'], $_POST)) {
                die(self::setResponse(false, __('You did not fill the required field', 'unisender').' '.$f['public_name']));
            }
            $params[$f['name']] = $_POST[$f['name']];
        }
        $api = UnisenderApi::getInstance();
        $isSubscribed = $api->subscribe($defaultListId, $params);
        if ($isSubscribed['status'] === 'success') {
	        $message = get_option('unisender_form_success');
	        if (empty($message)) {
		        $message = __('Thanks for subscribe', 'unisender');
	        }
            die(self::setResponse(true, $message));
        } else {
            die(self::setResponse(false, $isSubscribed['message']));
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