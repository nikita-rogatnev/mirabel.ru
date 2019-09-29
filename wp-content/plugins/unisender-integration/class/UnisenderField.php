<?php

if(!function_exists('wp_get_current_user')) {
	include(ABSPATH . "wp-includes/pluggable.php");
}

class UnisenderField extends UnisenderAbstract
{
	public function __construct()
	{
		$this->section = 'Field';
		$action = !empty($_GET['action']) ? $_GET['action'] : 'index';
		$method = 'action'.ucfirst($action);
		if (method_exists($this, $method)) {
			$this->$method();
		} else {
			$this->actionIndex();
		}
	}

	public function actionIndex()
	{
		$fields = self::getFields(true);
		$this->render('list', array('fields' => $fields));
	}

	private function actionEdit()
	{
		$id = !empty($_GET['field']) ? (int)$_GET['field'] : null;

		if (!empty($_POST['action'])) {
			if (empty($_POST['public_name'])) {
				die(self::setResponse(false, __('Not all required fields are filled', $this->textdomain)));
			}

			//Валидация имени поля
			$isValid = preg_match('~^[A-z][A-z0-9_-]+$~i', $_POST['name'], $matches);
			if (!$isValid) {
				die(self::setResponse(false, __('The placeholder contains invalid characters', $this->textdomain)));
			}

			$connect = null;
			//проверка связанного поля и его существование
			$connectTmp = !empty($_POST['connect']) ? strtolower($_POST['connect']) : null;
			if (null !== $connectTmp) {
				$fields = get_userdata(get_current_user_id());
				foreach ($fields->data as $name => $f) {
					if ($name === $connectTmp) {
						$connect = $connectTmp;
						break;
					}
				}
				if (!$connect && get_user_meta(get_current_user_id(), $connectTmp, true)) {
					$connect = $connectTmp;
				}
				if (empty($connect)) {
					die(self::setResponse(false, __('Related WP field is not found', $this->textdomain)));
				}
			}

			//new field
			if (empty($id)) {
				$api = UnisenderApi::getInstance();
				$result = $api->createField(array(
					'public_name' => $_POST['public_name'],
					'name' => $_POST['name'],
					'type' => $_POST['type']
				));
				if ($result['status'] === 'success') {
					self::insertField(array(
						'id' => $result['data']['id'],
						'public_name' => $_POST['public_name'],
						'name' => $_POST['name'],
						'placeholder' => $_POST['placeholder'],
						'type' => $_POST['type'],
						'connect' => $connect,
						'is_enabled' => (int) isset($_POST['is_enabled']),
						'is_in_form' => (int) isset($_POST['is_in_form']),
						'is_form_required' => (int) isset($_POST['is_form_required'])
					));
				} else {
					die(self::setResponse(false, $result['message']));
				}
				die(self::setResponse(
					true,
					__('The new additional field successfully created', $this->textdomain),
					admin_url('tools.php?page=unisender&action=edit&field=' . $result['data']['id'])
				));
			}

			//existing field
			$wpField = self::getField($id);
			if (!$wpField) {
				die(self::setResponse(false, __('Additional field with this Id is not found', $this->textdomain)));
			}

			$api = UnisenderApi::getInstance();
			$result = $api->updateField(array(
				'id' => $wpField['id'],
				'public_name' => (string) $_POST['public_name'],
				'name' => (string) $_POST['name']
			));
			if ($result['status'] === 'success') {
				self::updateField(array(
					'id' => $wpField['id'],
					'public_name' => $_POST['public_name'],
					'name' => $_POST['name'],
					'placeholder' => (string) $_POST['placeholder'],
					'connect' => $connect,
					'is_enabled' => (int) isset($_POST['is_enabled']),
					'is_in_form' => (int) isset($_POST['is_in_form']),
					'is_form_required' => (int) isset($_POST['is_form_required'])
				));
			} else {
				die(self::setResponse(false, $result['message']));
			}

			die(self::setResponse(true, __('The additional field saved successfully', $this->textdomain)));
		}

        $wpField = array();
		if ($id !== 0) {
			$wpField = self::getField($id);
		}

		$this->render('edit', array('field' => $wpField));
	}

	private function actionDelete()
	{
		$id = !empty($_GET['field']) ? (int)$_GET['field'] : null;
		if (!$id) {
			die(self::setResponse(false, __('You have not specified Id field', $this->textdomain)));
		}
		$wpField = self::getField($id);
		if (!$wpField) {
			die(self::setResponse(false, __('Additional field with this Id is not found', $this->textdomain)));
		}
		$api = UnisenderApi::getInstance();
		$result = $api->deleteField($id);
		if ($result['status'] === 'success') {
			self::deleteField($id);
			die(self::setResponse(
				true,
				__('An additional field is removed', $this->textdomain),
				admin_url('tools.php?page=unisender&section=field')
			));
		} else {
			die(self::setResponse(false, $result['message']));
		}
	}

	public static function sync()
	{
		$wpFields = self::getFields(true);
		$api = UnisenderApi::getInstance();
		$uniFields = $api->getFields();
		if ($uniFields['status'] !== 'success') {
			return $uniFields;
		}
		$uniFields = $uniFields['data'];

		//Проверка и обновление существующих
		foreach ($wpFields as $i => $wpField) {
			if (!empty($uniFields[$wpField['id']])) {
				$wpField = array_merge($wpField, $uniFields[$wpField['id']]);
				self::updateField($wpField);
				unset($uniFields[$wpField['id']], $wpFields[$i]);
			}
		}
		//Добавление новых полей
		if (count($uniFields) > 0) {
			foreach ($uniFields as $uniField) {
				self::insertField($uniField);
			}
		}
		//Удаление старых несинхронизированных списов

		if (count($wpFields) > 0) {
			foreach ($wpFields as $wpField) {
				self::deleteField($wpField['id']);
			}
		}

		return true;
	}

	public static function getField($id)
	{
		/* @var wpdb $wpdb */
		global $wpdb;
		$wpFields = $wpdb->get_row('
			SELECT *
			FROM ' . $wpdb->prefix.'unisender_field
			WHERE id = ' . (int)$id, ARRAY_A);
		return $wpFields;
	}

	public static function getFields($isAll = false, $isForm = false)
	{
		/* @var wpdb $wpdb */
		global $wpdb;

        $where = ' WHERE 1';
		$where .= !$isAll ? ' AND is_enabled = 1' : '';
        $where .= $isForm ? ' AND is_in_form = 1' : '';
		$wpFields = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix.'unisender_field '.$where.' ORDER BY form_position', ARRAY_A);
        array_unshift($wpFields, array(
            'id' => null,
            'name' => 'email',
            'public_name' => 'E-mail',
            'is_enabled' => 1,
            'is_in_form' => 1,
            'form_position' => 0,
            'is_form_required' => 1,
            'connect' => 'user_email'
        ));

		return $wpFields;
	}

	public static function insertField($field)
	{
		/* @var wpdb $wpdb */
		global $wpdb;

		$wpdb->insert(
			$wpdb->prefix.'unisender_field',
			array(
				'id' => $field['id'],
				'name' => $field['name'],
				'public_name' => $field['public_name'],
				'placeholder' => !empty($field['placeholder']) ? $field['placeholder'] : null,
				'type' => $field['type'],
				'connect' => !empty($field['connect']) ? $field['connect'] : null,
                'is_enabled' => !empty($field['is_enabled']),
                'is_in_form' => !empty($field['is_in_form']),
                'is_form_required' => !empty($field['is_form_required']),
				'form_position' => !empty($field['form_position']) ? $field['form_position'] : null
			)
		);
		return true;
	}

	public static function updateField($field)
	{
		/* @var wpdb $wpdb */
		global $wpdb;

		$wpdb->update(
			$wpdb->prefix.'unisender_field',
			array(
				'name' => $field['name'],
				'public_name' => $field['public_name'],
				'placeholder' => $field['placeholder'],
		        'type' => $field['type'],
			    'connect' => $field['connect'],
                'is_enabled' => $field['is_enabled'],
                'is_in_form' => $field['is_in_form'],
                'is_form_required' => $field['is_form_required'],
				'form_position' => !empty($field['form_position']) ? $field['form_position'] : null
			),
			array('id' => $field['id'])
		);

		return true;
	}

	public static function deleteField($id)
	{
		/* @var wpdb $wpdb */
		global $wpdb;

		$wpdb->delete(
			$wpdb->prefix.'unisender_field',
			array('id' => $id)
		);

		return true;
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

