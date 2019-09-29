<?php

/**
 * Сервис для работы с Unisender
 * Возвращается всегда массив статуса выполнения и ответ сервера
 *
 * Class UnisenderApi
 */
class UnisenderApi
{
	static protected $instance;

	private $apiKey;

	protected function __construct($apiKey)
	{
		$this->apiKey = $apiKey;
	}

	/**
	 * @param mixed $apiKey
	 *
	 * @return null|UnisenderApi
	 */
	public static function getInstance($apiKey = null)
	{
		if (self::$instance === null) {
			if (!$apiKey) {
				$apiKey = get_option('unisender_api_key');
			}

			if ($apiKey === null) {
				return null;
			}

			self::$instance = new self($apiKey);
		}

		return self::$instance;
	}

	public static function reInstance()
	{
		self::$instance = null;
		return self::getInstance();
	}

	private static function getApiUrl()
	{
		$locale = get_locale();
		$locale = explode('_', $locale);
		if (!in_array($locale[0], array('ru', 'en'))) {
			$locale = 'en';
		} else {
			$locale = $locale[0];
		}
		return 'https://api.unisender.com/'.$locale.'/api/';
	}

	/**
	 * Получение списка списков
	 *
	 * @return array|mixed
	 */
	public function getLists()
	{
		$method = 'getLists';
		$lists = self::exec($method, array());

		if ($lists['status'] === 'success') {
			$lists['data'] = self::idToKey($lists['data']);
		}

		return $lists;
	}

	/**
	 * Создание списка
	 *
	 * @param $newTitle
	 *
	 * @return array|mixed
	 */
	public function createList($newTitle)
	{
		$method = 'createList';
		$params['title'] = $newTitle;
		$listId = self::exec($method, $params);

		return $listId;
	}

	/**
	 * Обновление списка
	 *
	 * @param $listId
	 * @param $newTitle
	 *
	 * @return array|mixed
	 */
	public function updateList($listId, $newTitle)
	{
		$method = 'updateList';
		$params['list_id'] = $listId;
		$params['title'] = $newTitle;
		$listId = self::exec($method, $params);

		return $listId;
	}

	/**
	 * Удаление списка
	 *
	 * @param $listId
	 *
	 * @return array|mixed
	 */
	public function deleteList($listId)
	{
		$method = 'deleteList';
		$params['list_id'] = $listId;
		$listId = self::exec($method, $params);

		return $listId;
	}

	/**
	 * Получение инфо о пользователе (не подписчик)
	 *
	 * @return array|mixed
	 */
	public function getUserInfo()
	{
		$method = 'getUserInfo';
		$params['api_key'] = $this->apiKey;

		$response = self::exec($method, $params);

		return $response;
	}

	/**
	 * Создание нового пользователя
	 *
	 * @param $email
	 * @param $login
	 * @param $password
	 * @param $firstName
	 *
	 * @return array|mixed
	 */
	public function addNewUser($email, $login, $password, $firstName)
	{
		self::$instance->apiKey = null;
		$this->login = null;
		$method = 'register';
		$params = array(
			'email' => $email,
			'login' => $login,
			'password' => $password,
			'notify' => 1,
			'api_mode' => 'on',
			'need_confirm' => 1,
			'extra[firstname]' => $firstName
		);

		$newUser = self::exec($method, $params);

		return $newUser;
	}

	public function importContacts($listId, $offset, $limit)
	{
		$method = 'exportContacts';
		$params = array(
			'list_id' => $listId,
			'offset' => $offset,
			'limit' => $limit
		);

		$contacts = self::exec($method, $params);
		if (!empty($contacts['data']['data'])) {
			foreach ($contacts['data']['data'] as $i => $contact) {
				$contacts['data']['data'][$i] = array_combine($contacts['data']['field_names'], $contact);
			}
		}

		return array(
			'status' => 'success',
			'data' => $contacts['data']['data']
		);
	}

	/**
	 * Получение подписчиков пользователя из определенного списка
	 *
	 * @param $listId
	 * @param array $fields
	 * @param array $contacts
	 *
	 * @return array|mixed
	 */
	public function exportContacts($listId, array $fields, array $contacts)
	{
        $contacts = json_decode(json_encode($contacts),1);
		$method = 'importContacts';
		$params = array(
            'overwrite_lists' => '1',
            'double_optin' => '1',
			'field_names[0]' => 'email_list_ids',
			'field_names[1]' => 'phone_list_ids',
			'field_names[2]' => 'email_status',
			'field_names[3]' => 'phone_status'
		);
		$iF = 4;
		foreach ($fields as $f) {
			$params['field_names[' . $iF . ']'] = $f['name'];
			$iF++;
		}

		$requestedContacts = array();
		$iC = 0;

		foreach ($contacts as $contact) {
			$curr = "data[$iC]";

			$params[$curr . '[0]'] = $listId;
			$params[$curr . '[1]'] = $listId;
			if (!empty($contact['email'])) {
				$params[$curr . '[2]'] = 'active';
			}
			if (!empty($contact['phone'])) {
				$params[$curr . '[3]'] = 'active';
			}
			$iF = 4;
			foreach ($fields as $field) {
				if (!empty($contact[$field['connect']])) {
					$params[$curr . "[$iF]"] = $requestedContacts[$iC][$field['connect']] = $contact[$field['connect']];
					$iF++;
				}
			}

			$iC++;
		}

		$response = self::exec($method, $params);

		if ($response['status'] === 'error') {
			return $response;
		}
		$errors = array();
		foreach ($response['data']['log'] as $logs) {
			$email = !empty($requestedContacts[$logs['index']]['email'])
				? $requestedContacts[$logs['index']]['email']
				: '';
			$phone = !empty($requestedContacts[$logs['index']]['phone'])
				? $requestedContacts[$logs['index']]['phone']
				: '';
			$errors[] = array(
				'email' => $email,
				'phone' => $phone,
				'code' => $logs['code'],
				'message' => $logs['message']
			);
		}
		$response['data']['log'] = $errors;

		return $response;
	}

	public function subscribe($listId, $fields)
	{
		$method = 'subscribe';
		$params['list_ids'] = $listId;
        foreach ($fields as $id => $f) {
            $params['fields['.$id.']'] = $f;
        }

		$newSubscriber = self::exec($method, $params);

		return $newSubscriber;
	}

	/**
	 * Получение списка доп. полей
	 *
	 * @return array|mixed
	 */
	public function getFields()
	{
		$method = 'getFields';
		$fields = self::exec($method, array());

		if ($fields['status'] === 'success') {
			$fields['data'] = self::idToKey($fields['data']);
		}

		return $fields;
	}

	/**
	 * Создание доп. поля
	 *
	 * @param $params
	 *
	 * @return array|mixed
	 */
	public function createField($params)
	{
		$method = 'createField';
		$fieldId = self::exec($method, $params);

		return $fieldId;
	}

	/**
	 * Обновление доп. поля
	 *
	 * @param $params
	 *
	 * @return array|mixed
	 */
	public function updateField($params)
	{
		$method = 'updateField';
		$fieldId = self::exec($method, $params);

		return $fieldId;
	}


	/**
	 * Удаление доп. поля
	 *
	 * @param $fieldId
	 *
	 * @return array|mixed
	 */
	public function deleteField($fieldId)
	{
		$method = 'deleteField';
		$params['id'] = $fieldId;
		$isDeleted = self::exec($method, $params);

		return $isDeleted;
	}

	/**
	 * Получение списка кампаний
	 *
	 * @return array|mixed
	 */
	public function getCampaigns()
	{
		$method = 'getCampaigns';
		$campaigns = self::exec($method, array());
		if ($campaigns['status'] === 'success') {
			$campaigns['data'] = self::idToKey($campaigns['data']);
		}

		return $campaigns;
	}

	public function createCampaign($messageId, $startTime)
	{
		$method = 'createCampaign';
		$isCreated = self::exec($method, array(
			'message_id' => $messageId,
			'start_time' => $startTime
		));

		return $isCreated;
	}

	public function getMessage($id)
	{
		$method = 'getMessage';
		$message = self::exec($method, array('id' => $id));

		return $message;
	}

	public function getMessages($dateFrom, $dateTo)
	{
		$method = 'getMessages';
		$messages = self::exec($method, array(
			'date_from' => $dateFrom . ' 00:00',
			'date_to' => $dateTo . ' 23:59',
			'limit' => 100
		));

		return $messages;
	}

	public function createEmailMessage($params)
	{
		$method = 'createEmailMessage';
		$params['generate_text'] = 1;
		$message = self::exec($method, $params);

		return $message;
	}

    public function createSmsMessage($params)
    {
        $method = 'createSmsMessage';
        $message = self::exec($method, $params);

        return $message;
    }

	public function deleteMessage($id)
	{
		$method = 'deleteMessage';
		$params['message_id'] = $id;
		$isDeleted = self::exec($method, $params);

		return $isDeleted;
	}


	/**
	 * Выполнение запроса
	 *
	 * @param $method
	 * @param $params
	 *
	 * @return array|mixed
	 */
	private static function exec($method, $params)
	{
		$url = self::getApiUrl() . $method;
		$params['format'] = 'json';
		$params['platform'] = 'WordPress';
		if (self::$instance->apiKey) {
			$params['api_key'] = self::$instance->apiKey;
		}

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curl, CURLOPT_USERAGENT, 'HAC');
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        $response = curl_exec($curl);

		$response = str_replace('	', '\t', $response);
		curl_close($curl);

        if ($response === '') {
            $response = array(
                'status' => 'success',
                'data' => null
            );
            return $response;
        }
		try {
			$response = json_decode($response, 1);
			if ($response === null || !empty($response['error'])) {
				throw new UnisenderApiException($response);
			} else {
				$response = array(
					'status' => 'success',
					'data' => $response['result']
				);
			}
		} catch (UnisenderApiException $e) {
            $response = array(
                'status' => 'error',
                'message' => $e->getMessage()
            );
		}

		return $response;
	}

	public static function idToKey($array)
	{
		foreach ($array as $i => $element) {
			$array[$element['id']] = $element;
			unset($array[$i]);
		}

		return $array;
	}
}

class UnisenderApiException extends Exception
{
	protected $textdomain = 'unisender';

	public function __construct($error)
	{
		if (!$error) {
			$this->message = __('Unable to contact the server Unisender. Try later or contact Customer Support', $this->textdomain);
		} else {
			$this->message = $this->getMessageByCode($error);
		}
	}

	protected function getMessageByCode($error)
	{
		$message = '';
		$errors = array(
			'invalid_api_key' => __('Invalid API key', $this->textdomain),
			'access_denied' => __('API to be included in the account settings UniSender', $this->textdomain),
			'invalid_arg' => __('Introduced incorrect or incomplete data: ', $this->textdomain) . $error['error']
		);
        if (!empty($error['code']) && !empty($errors[$error['code']])) {
            $message .= $errors[$error['code']];
        } else {
            $message .= $error['error'];
        }

		return $message;
	}
}
