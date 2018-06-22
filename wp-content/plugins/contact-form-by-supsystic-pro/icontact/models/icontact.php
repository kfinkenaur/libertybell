<?php
class icontactModelCfs extends modelSubscribeCfs {
	private $_lastRequireConfirm = false;
	public function getClient($params) {
		if(!class_exists('iContactApi')) {
			require_once($this->getModule()->getModDir(). 'classes'. DS. 'iContactApi.php');
		}
		return iContactApi::getInstance()->setConfig(array(
			'appId'       => $params['sub_ic_app_id'], 
			'apiUsername' => $params['sub_ic_app_user'],
			'apiPassword' => $params['sub_ic_app_pass'], 
		));
	}
	public function getLists($d) {
		
		$d['app_id'] = isset($d['app_id']) ? trim($d['app_id']) : false;
		$d['app_user'] = isset($d['app_user']) ? trim($d['app_user']) : false;
		$d['app_pass'] = isset($d['app_pass']) ? trim($d['app_pass']) : false;
		if(empty($d['app_id'])) {
			$this->pushError(__('Please enter your Application ID', CFS_LANG_CODE), 'params[tpl][sub_ic_app_id]');
		}
		if(empty($d['app_user'])) {
			$this->pushError(__('Please enter your API Username', CFS_LANG_CODE), 'params[tpl][sub_ic_app_user]');
		}
		if(empty($d['app_pass'])) {
			$this->pushError(__('Please enter your API Password', CFS_LANG_CODE), 'params[tpl][sub_ic_app_pass]');
		}
		if(!$this->haveErrors()) {
			$client = $this->getClient(array(
				'sub_ic_app_id' => $d['app_id'],
				'sub_ic_app_user' => $d['app_user'],
				'sub_ic_app_pass' => $d['app_pass'],
			));
			try {
				$res = $client->getLists();
				if(!empty($res)) {
					$lists = array();
					foreach($res as $r) {
						$lists[] = array('id' => $r->listId, 'name' => $r->name);
					}
					return $lists;
				} else 
					$this->pushError(__('You have no lists in your iContact account for now.', CFS_LANG_CODE));
			} catch(Exception $e) {
				$this->pushError($client->getErrors());
			}
		}
		return false;
		
	}
	public function subscribe($d, $form, $validateIp = false) {
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email)) {
			if(is_email($email)) {
				if(!$validateIp || $validateIp && frameCfs::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_check' => true))) {
					
					$client = $this->getClient(array(
						'sub_ic_app_id' => $form['params']['tpl']['sub_ic_app_id'],
						'sub_ic_app_user' => $form['params']['tpl']['sub_ic_app_user'],
						'sub_ic_app_pass' => $form['params']['tpl']['sub_ic_app_pass'],
					));
					//$addData = array($email, null, null);
					//$apiKey = $form['params']['tpl']['sub_ic_app_id'];
					$name = isset($d['name']) ? trim($d['name']) : '';
					$addData = array('email' => $email);
					if(!empty($name)) {
						$addData['name'] = $name;
					}
					if(isset($form['params']['fields'])
						&& !empty($form['params']['fields'])
					) {
						foreach($form['params']['fields'] as $f) {
							$k = $f['name'];
							if(in_array($k, array('name', 'email'))) continue;	// Ignore standard fields
							if(isset($d[ $k ])) {
								$addData[ $k ] = $d[ $k ]; 
							}
						}
					}
					$callData = array($email, null);
					$checkKeyCall = array('prefix', 'first', 'last', 'sSufix', 'street', 'street2', 'city', 'state', 'postal', 'phone', 'fax', 'busines');
					$i = count($callData);
					foreach($checkKeyCall as $ck) {
						$found = false;
						foreach($addData as $k => $v) {
							if(strpos(strtolower($k), $ck) !== false) {
								$callData[ $i ] = $v;
								$found = true;
								break;
							}
						}
						if(!$found) {
							$callData[ $i ] = null;
						}
						$i++;
					}
					try {
						$contact = call_user_func_array(array($client, 'addContact'), $callData);
						if($contact && $contact->contactId) {
							$lists = isset($form['params']['tpl']['sub_ic_lists']) ? $form['params']['tpl']['sub_ic_lists'] : array();
							if(!empty($lists)) {
								foreach($lists as $lId) {
									$client->subscribeContactToList($contact->contactId, $lId, 'normal');
								}
							}
							return true;
						} else
							$this->pushError (__('Can\'t add contact', CFS_LANG_CODE));
						return true;
					} catch(Exception $e) {
						$this->pushError ($e->getMessage());
					}
				}
			} else
				$this->pushError (frameCfs::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($form), 'email');
		} else
			$this->pushError (frameCfs::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($form), 'email');
		return false;
	}
	public function requireConfirm() {
		if($this->_lastRequireConfirm)
			return true;
		$destData = frameCfs::_()->getModule('subscribe')->getDestByKey( $this->getCode() );
		return $destData['require_confirm'];
	}
}