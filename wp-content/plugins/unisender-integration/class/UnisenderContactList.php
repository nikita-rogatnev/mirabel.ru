<?php

class UnisenderContactList extends UnisenderAbstract
{

	public function __construct()
	{
		if (!empty($_POST['action']) && $_POST['action'] === 'unisender_sync') {
			self::actionSync();
		}

		$this->section = 'ContactList';
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
		$lists = self::getLists();
		$this->render('list', array('lists' => $lists));
	}

	private function actionEdit()
	{
		$id = !empty($_GET['list']) ? (int)$_GET['list'] : null;

		if (!empty($_POST['action'])) {
			if (empty($_POST['title'])) {
				die(self::setResponse(false, __('Not all required fields are filled', $this->textdomain)));
			}
			//new list
			if ($id == 0) {
				$api = UnisenderApi::getInstance();
				$result = $api->createList($_POST['title']);
				if ($result['status'] === 'success') {
					$this->insertList(array(
						'id' => $result['data']['id'],
						'title' => $_POST['title']
					));
				} else {
					die(self::setResponse(false, $result['message']));
				}
				die(self::setResponse(
					true,
					__('New list has been successfully created', $this->textdomain),
					admin_url('tools.php?page=unisender&action=edit&list=' . $result['data']['id'])
				));
			}
			//existing list
			$wpList = self::getList($id);
			if (!$wpList) {
				die(self::setResponse(false, __('List with Id not found', $this->textdomain)));
			}

			$api = UnisenderApi::getInstance();
			$result = $api->updateList($wpList['id'], $_POST['title']);
			if ($result['status'] === 'success') {
				$this->updateList(array(
					'id' => $wpList['id'],
					'title' => $_POST['title']
				));
			} else {
				die(self::setResponse(false, $result['message']));
			}

			die(self::setResponse(true, __('List saved successfully', $this->textdomain)));
		}

        $wpList = array();
		if ($id !== 0) {
			$wpList = self::getList($id);
		}
		$this->render('edit', array('list' => $wpList));
	}

	private function actionDelete()
	{
		$id = !empty($_GET['list']) ? (int)$_GET['list'] : null;
		$wpList = self::getList($id);
		if (!$wpList) {
			die(self::setResponse(false, __('List with Id not found', $this->textdomain)));
		}
		$api = UnisenderApi::getInstance();
		$result = $api->deleteList($id);
		if ($result['status'] === 'success') {
			$this->deleteList($id);
			die(self::setResponse(
				true,
				__('List deleted', $this->textdomain),
				admin_url('tools.php?page=unisender')
			));
		} else {
			die(self::setResponse(false, $result['message']));
		}
	}

	private function actionDefault()
	{
		$id = !empty($_GET['list']) ? (int)$_GET['list'] : null;
		if (!$id) {
			die(self::setResponse(false, __('You have not specified Id list', $this->textdomain)));
		}
		$wpList = self::getList($id);
		if (!$wpList) {
			die(self::setResponse(false, __('List with Id not found', $this->textdomain)));
		}
		self::setAsDefault($wpList);
		die(self::setResponse(
			true,
			__('The list is selected by default', $this->textdomain),
			admin_url('tools.php?page=unisender'))
		);
	}

	private function actionExport()
	{
		$id = !empty($_GET['list']) ? (int)$_GET['list'] : null;
		if (!$id) {
			die(self::setResponse(false, __('You have not specified Id list', $this->textdomain)));
		}

		$wpList = self::getList($id);
		if (!$wpList) {
			die(self::setResponse(false, __('List with Id not found', $this->textdomain)));
		}

		if (!empty($_POST['action'])) {
			if (empty($_POST['user_role'])) {
				die(self::setResponse(false, __('Not all required fields are filled', $this->textdomain)));
			}

            $fields = UnisenderField::getFields();
            $limit = 500;
            $offset = 0;
            $result = array(
                'total' => 0,
                'inserted' => 0,
                'updated' => 0,
                'deleted' => 0,
                'new_emails' => 0,
                'invalid' => 0,
                'log' => array()
            );
			while (1) {
                $contacts = array();
                $i = 0;
                //получение пользователей. пока только группы добавлены.
                if ($_POST['user_role'] !== 'all') {
                    $users = get_users(array(
                        'offset' => $offset,
                        'number' => $limit,
                        'role' => $_POST['user_role']
                    ));
                } else {
                    $users = get_users(array(
                        'offset' => $offset,
                        'number' => $limit
                    ));
                }
                if (!count($users)) {
                    break;
                }

                //формирование правильного массива контактов с доп. полями
                foreach ($users as $u) {
                    foreach ($fields as $f) {
                        if (empty($f['connect'])) {
                            continue;
                        }
                        if (isset($u->data->$f['connect'])) {
                            $contacts[$i][$f['connect']] = $u->data->$f['connect'];
                        } elseif ($tmp = get_user_meta($u->data->ID)) {
                            $contacts[$i][$f['connect']] = $tmp;
                        }
                    }
                    $i++;
                }

                $api = UnisenderApi::getInstance();
                $resultTmp = $api->exportContacts($id, $fields, $contacts);
                if ($resultTmp['status'] === 'success') {
                    $result['total'] += $resultTmp['data']['total'];
                    $result['inserted'] += $resultTmp['data']['inserted'];
                    $result['updated'] += $resultTmp['data']['updated'];
                    $result['deleted'] += $resultTmp['data']['deleted'];
                    $result['new_emails'] += $resultTmp['data']['new_emails'];
                    $result['invalid'] += $resultTmp['data']['invalid'];
                    $result['log'] = array_merge($result['log'], $resultTmp['data']['log']);
                } else {
                    die(self::setResponse(
                        false,
                        __('Export incomplete. Error returned:', $this->textdomain).' . '.$resultTmp['message']
                    ));
                }

                $offset += $limit;
            }

            die(self::setResponse(true, __('Export completed', $this->textdomain))); //TODO не выводятся результаты
		}

		$this->render('export', array('list' => $wpList));
	}

    private function actionImport()
    {
	    $id = !empty($_GET['list']) ? (int)$_GET['list'] : null;
	    if (!$id) {
		    die(self::setResponse(false, __('You have not specified Id list', $this->textdomain)));
	    }
        $wpList = self::getList($id);
        if (!$wpList) {
            die(self::setResponse(false, __('List with Id not found', $this->textdomain)));
        }

        if (!empty($_POST['action'])) {
            if (empty($_POST['user_role'])) {
                die(self::setResponse(false, __('Not all required fields are filled', $this->textdomain)));
            }
            $api = UnisenderApi::getInstance();
            $offset = $newUserCount = 0;
            $limit = 1000;
            while (1) {
                $contacts = $api->importContacts($id, $offset, $limit);
                if ($contacts['status'] === 'error') {
                    die(self::setResponse(
                        false,
                        __('Import incomplete. Error returned: ', $this->textdomain).$contacts['message']
                    ));
                }
                if (!count($contacts['data'])) {
                    break;
                }

                foreach ($contacts['data'] as $contact) {
                    $existsUser = get_user_by('email', $contact['email']);
                    if ($existsUser !== false) {
                        continue;
                    }
                    $newUser = wp_create_user($contact['email'], '', $contact['email']);
                    if (is_numeric($newUser)) {
                        $newUserCount++;
                    }
                }

                $offset += $limit;
            }
            die(self::setResponse(true, __('Import completed. Create users' . ' '. $newUserCount)));
        }

	    $this->render('import', array('list' => $wpList));
    }

	public static function actionSync($isAuto = 0)
	{
		$isListSyncSuccess = UnisenderContactList::sync();
		if ($isListSyncSuccess !== true) {
			die(self::setResponse(false, $isListSyncSuccess['message']));
		}

		$isFieldSyncSuccess = UnisenderField::sync();
		if ($isFieldSyncSuccess !== true) {
			die(self::setResponse(false, $isFieldSyncSuccess['message']));
		}
		if (!$isAuto) {
			die(self::setResponse(true, __('Synchronization is completed', 'unisender')));
		}
	}

	public static function getList($id)
	{
		/* @var wpdb $wpdb */
		global $wpdb;
		$wpList = $wpdb->get_row('
			SELECT *
			FROM ' . $wpdb->prefix.'unisender_contact_list
			WHERE id = ' . (int)$id, ARRAY_A);
		return $wpList;
	}

	public static function getLists()
	{
		/* @var wpdb $wpdb */
		global $wpdb;
		$wpLists = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix.'unisender_contact_list', ARRAY_A);

		return $wpLists;
	}

    public static function getDefaultListId()
    {
        /* @var wpdb $wpdb */
        global $wpdb;
        $wpLists = $wpdb->get_var(
            'SELECT id FROM ' . $wpdb->prefix.'unisender_contact_list WHERE is_default LIMIT 1');

        return $wpLists;
    }

	protected static function insertList($list)
	{
		/* @var wpdb $wpdb */
		global $wpdb;

		$wpdb->insert(
			$wpdb->prefix.'unisender_contact_list',
			array(
				'id' => $list['id'],
				'title' => $list['title']
			),
			array(
				'%d',
				'%s'
			)
		);
		return true;
	}

	protected static function updateList($list)
	{
		/* @var wpdb $wpdb */
		global $wpdb;

		$wpdb->update(
			$wpdb->prefix.'unisender_contact_list',
			array(
				'title' => $list['title'],
				'is_default' => (int)isset($list['is_default'])
			),
			array('id' => $list['id'])
		);

		return true;
	}

	private function deleteList($id)
	{
		/* @var wpdb $wpdb */
		global $wpdb;

		$wpdb->delete(
			$wpdb->prefix.'unisender_contact_list',
			array('id' => $id)
		);

		return true;
	}

	public static function sync()
	{
		$wpLists = self::getLists();
		$api = UnisenderApi::getInstance();
		$uniLists = $api->getLists();
		if ($uniLists['status'] !== 'success') {
			return $uniLists;
		}
		$uniLists = $uniLists['data'];

		//Проверка и обновление существующих
		foreach ($wpLists as $wpIterator => $wpList) {
			if (!empty($uniLists[$wpList['id']])) {
				if ($wpList['title'] !== $uniLists[$wpList['id']]['title']) {
					self::updateList($uniLists[$wpList['id']]);
				}
				if ($wpList['is_default'] > 0) {
					$isDefaultExists = 1;
				}
				unset($uniLists[$wpList['id']], $wpLists[$wpIterator]);
			}
		}
		//Добавление новых списков
		if (count($uniLists) > 0) {
			foreach ($uniLists as $uniList) {
				self::insertList($uniList);
			}
		}
		//Удаление старых несинхронизированных списов
		if (count($wpLists) > 0) {
			foreach ($wpLists as $wpList) {
				self::deleteList($wpList['id']);
			}
		}

		if (!isset($isDefaultExists)) {
			$wpLists = self::getLists();
			$wpLists[0]['is_default'] = 1;
			self::updateList($wpLists[0]);
		}

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

	public static function setAsDefault($wpList)
	{
		/* @var wpdb $wpdb */
		global $wpdb;

		$wpList['is_default'] = 1;
		$wpdb->query('UPDATE ' . $wpdb->prefix.'unisender_contact_list SET is_default = 0');
		self::updateList($wpList);

		return true;
	}

}