<?php

class UnisenderMessage extends UnisenderAbstract
{
	public function __construct()
	{
		$this->section = 'Message';
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
		$dateFrom = !empty($_GET['date_from']) ? $_GET['date_from'] : date('Y-m-d', mktime(0, 0, 0, date('m')-1, date('d'), date('Y')));
		$dateTo = !empty($_GET['date_to']) ? $_GET['date_to'] : date('Y-m-d', time());
		$api = UnisenderApi::getInstance();
		$messages = $api->getMessages($dateFrom, $dateTo);
		if ($messages['status'] === 'success') {
			$messages = UnisenderApi::idToKey(!empty($messages['data']) ? $messages['data'] : array());
		} else {
			$error = __('Unable to contact the server Unisender. Try later or contact Customer Support');
		}
		$lists = UnisenderContactList::getLists();
		$lists = UnisenderApi::idToKey($lists);

        if ((!empty($messages['status']) && $messages['status'] === 'error')
            || !count($messages)) {
            $messages = array();
        }

		foreach ($messages as $i => $message) {
			if (!empty($lists[$message['list_id']])) {
				$messages[$i]['list'] = $lists[$message['list_id']];
			} else {
				$messages[$i]['list']['title'] = __('The list is not defined', $this->textdomain);
			}
		}

		$this->render('list', array('messages' => $messages));
	}

    private function actionNew()
	{
		$api = UnisenderApi::getInstance();
		$lists = UnisenderContactList::getLists();

		if (!empty($_POST['action'])) {
			if (empty($_POST['subject']) || empty($_POST['sender_name'])
		    || empty($_POST['sender_email']) || empty($_POST['list_id']) || empty($_POST['body'])) {
				die(self::setResponse(false, __('Not all required fields are filled', $this->textdomain)));
			}
            //нормальные ссылки
            $_POST['body'] = stripcslashes($_POST['body']);
            //выполняю короткие теги
            $_POST['body'] = do_shortcode($_POST['body']);

            $result = $api->createEmailMessage($_POST);

			if ($result['status'] !== 'success') {
				die(self::setResponse(false, $result['message']));
			}

			die(self::setResponse(true, __('Letter successfully created', $this->textdomain).'. '.__('Attention. New letter can appear in the list within one minute', $this->textdomain), admin_url('tools.php?page=unisender&section=message')));
		}

		$message = array();
		$this->render('new', array('lists' => $lists));
	}

    private function actionNewSms()
    {
        $api = UnisenderApi::getInstance();
        $lists = UnisenderContactList::getLists();

        if (!empty($_POST['action'])) {
            if (empty($_POST['sender']) || empty($_POST['body']) || empty($_POST['list_id'])) {
                die(self::setResponse(false, __('Not all required fields are filled', $this->textdomain)));
            }
            //нормальные ссылки
            $_POST['body'] = stripcslashes($_POST['body']);

            $result = $api->createSmsMessage($_POST);

            if ($result['status'] !== 'success') {
                die(self::setResponse(false, $result['message']));
            }

            die(self::setResponse(true, __('An SMS was successfully created', $this->textdomain).'. '.__('Attention. New letter can appear in the list within one minute', $this->textdomain), admin_url('tools.php?page=unisender&section=message')));
        }

        $message = array();
	    $this->render('newSms', array('lists' => $lists));
    }

	private function actionView()
	{
		if (empty($_GET['messageId'])) {
			die(self::setResponse(false, __('First select a letter or SMS', $this->textdomain)));
		}
		$message = self::getMessage((int)$_GET['messageId']);
		if (!empty($message['status']) && $message['status'] === 'error') {
//			$error = __('Unable to contact the server Unisender. Try later or contact Customer Support', $this->textdomain);
			if (!empty($message['message'])) {
				$error = $message['message'];
			}
			include(dirname(plugin_dir_path(__FILE__)) . '/tpl/error.php');
		} else {
			$lists = UnisenderApi::idToKey(UnisenderContactList::getLists());
			if (!empty($lists[$message['list_id']])) {
				$message['list'] = $lists[$message['list_id']];
			} else {
				$message['list']['title'] = __('The list is not defined', $this->textdomain);
			}

			if ($message['service_type'] === 'sms') {
				$this->render('viewSms', array('message' => $message));
			} else {
				$this->render('view', array('message' => $message));
			}
		}
	}

	static public function actionGetLetterBody()
	{
		if (empty($_GET['messageId'])) {
			die(self::setResponse(false, __('First select a letter or SMS', 'unisender')));
		}
		$message = self::getMessage((int)$_GET['messageId']);
		if (!empty($message['status']) && $message['status'] === 'error') {
			die(self::setResponse(false, $message['messageId']));
		}

		die($message['body']);
	}

	private function actionCopy()
	{
		if (empty($_GET['messageId'])) {
			die(self::setResponse(false, __('First select a letter or SMS', $this->textdomain), admin_url('tools.php?page=unisender&section=message')));
		}
		$message = self::getMessage((int)$_GET['messageId']);
		if (!empty($message['status']) && $message['status'] === 'error') {
			die(self::setResponse(false, $message['message']));
		}

		$lists = UnisenderApi::idToKey(UnisenderContactList::getLists());
        if ($message['service_type'] === 'sms') {
            if (!empty($_POST['action'])) {
                $this->actionNewSms();
            }
	        $this->render('newSms', array('message' => $message, 'lists' => $lists));
        } else {
            if (!empty($_POST['action'])) {
                $this->actionNew();
            }
	        $this->render('new', array('message' => $message, 'lists' => $lists));
        }
	}

	private function actionDelete()
	{
		if (!$_GET['messageId']) {
			die(self::setResponse(false, __('First select a letter or SMS', $this->textdomain)));
		}
		$api = UnisenderApi::getInstance();
		$result = $api->deleteMessage((int)$_GET['messageId']);
		if ($result['status'] === 'success') {
			die(self::setResponse(
				true,
				__('Message deleted', $this->textdomain),
				admin_url('tools.php?page=unisender&section=message')
			));
		} else {
			die(self::setResponse(false, $result['message']));
		}
	}

	public function actionCampaign()
	{
		if (!$_GET['messageId']) {
			die(self::setResponse(false, __('First select a letter or SMS', $this->textdomain)));
		}
		$message = self::getMessage((int)$_GET['messageId']);
		$lists = UnisenderApi::idToKey(UnisenderContactList::getLists());
		if (!empty($lists[$message['list_id']])) {
			$message['list'] = $lists[$message['list_id']];
		} else {
			$message['list']['title'] = __('The list is not defined', $this->textdomain);
		}

		if (!empty($_POST['action'])) {
			if (empty($_POST['start_date']) && empty($_POST['start_now'])) {
				die(self::setResponse(false, __('You have not specified when sending messages', $this->textdomain)));
			}

			$api = UnisenderApi::getInstance();
			$result = $api->createCampaign($message['id'], $_POST['start_date']);
			if ($result['status'] === 'success') {
				die(self::setResponse(
					true,
					__('Subscribe queued. All messages will be sent', $this->textdomain) . ' ' .$result['data']['count'],
					admin_url('tools.php?page=unisender&section=message')
				));
			} else {
				die(self::setResponse(false, $result['message'].'. '.__('Maybe there are no active contacts in list or required fields are not filled', $this->textdomain)));
			}
		}

		$this->render('campaign', array('message' => $message));
	}

	public static function getMessage($id)
	{
		$api = UnisenderApi::getInstance();
		$message = $api->getMessage($id);
		if ($message['status'] === 'success') {
			$message = array_shift($message['data']);
		}

		return $message;
	}

	public static function addManagementPage()
	{
		wp_enqueue_style('unisender_admin', dirname(plugin_dir_url(__FILE__)) . '/css/unisender_admin.css', false);
		wp_enqueue_script('unisender_admin', dirname(plugin_dir_url(__FILE__)) . '/js/unisender_admin.js');
		wp_enqueue_style('unisender_datetime', dirname(plugin_dir_url(__FILE__)) . '/css/jquery.datetimepicker.css', false);
		wp_enqueue_script('unisender_datetime', dirname(plugin_dir_url(__FILE__)) . '/js/jquery.datetimepicker.js');

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