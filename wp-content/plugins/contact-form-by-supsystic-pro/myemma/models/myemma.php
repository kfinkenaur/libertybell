<?php
class myemmaModelCfs extends modelSubscribeCfs {
	private $_client = null;
	private function _getClient( $accountId, $pubApiKey, $priApiKey ) {
		if(empty($this->_client)) {
			if(!class_exists('Emma')) {
				require_once($this->getModule()->getModDir(). 'classes'. DS. 'Emma.php');
			}
			$this->_client = new Emma( $accountId, $pubApiKey, $priApiKey );
		}
		return $this->_client;
	}
	public function getLists( $d ) {
		$accountId = isset($d['sub_mem_acc_id']) ? trim($d['sub_mem_acc_id']) : false;
		$pubApiKey = isset($d['sub_mem_pud_key']) ? trim($d['sub_mem_pud_key']) : false;
		$priApiKey = isset($d['sub_mem_priv_key']) ? trim($d['sub_mem_priv_key']) : false;
		if(empty($accountId)) {
			$this->pushError(__('Please enter your Account ID', CFS_LANG_CODE), 'params[tpl][sub_mem_acc_id]');
		}
		if(empty($pubApiKey)) {
			$this->pushError(__('Please enter your Public API Key', CFS_LANG_CODE), 'params[tpl][sub_mem_pud_key]');
		}
		if(empty($priApiKey)) {
			$this->pushError(__('Please enter your Private API Key', CFS_LANG_CODE), 'params[tpl][sub_mem_priv_key]');
		}
		if(!$this->haveErrors()) {
			try {
				$client = $this->_getClient($accountId, $pubApiKey, $priApiKey);
				$groups = $client->myGroups();
				if($groups && ($groups = utilsCfs::jsonDecode($groups))) {
					$listsDta = array();
					foreach($groups as $g) {
						$listsDta[ $g['member_group_id'] ] = $g['group_name'];
					}
					return $listsDta;
				}
			} catch(Exception $e) {
				$this->pushError( $e->getMessage() );
			}
		}
		return false;
	}
	public function subscribe($d, $form, $validateIp = false) {
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email)) {
			if(is_email($email)) {
				$lists = isset($form['params']['tpl']['sub_mem_lists']) ? $form['params']['tpl']['sub_mem_lists'] : array();
				if(!empty($lists)) {
					if($this->isLoggedIn()) {
						if(!$validateIp || $validateIp && frameCfs::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_check' => true))) {
							

							$addData = array(
								'email' => $email,
								'fields' => array(),
								'group_ids' => $lists,
							);
							if(isset($form['params']['fields'])
								&& !empty($form['params']['fields'])
							) {
								foreach($form['params']['fields'] as $f) {
									$k = $f['name'];
									if(in_array($k, array('email'))) continue;	// Ignore standard fields
									if(isset($d[ $k ])) {
										$addData['fields'][ $k ] = $d[ $k ];
									}
								}
							}
							try {
								$client = $this->_getClient($form['params']['tpl']['sub_mem_acc_id'], $form['params']['tpl']['sub_mem_pud_key'], $form['params']['tpl']['sub_mem_priv_key']);
								$added = $client->membersAddSingle( $addData );	// TODO: Make at least one test here
								return true;	// What else? We didn't get trial account from MyEmma corp.
							} catch(Exception $e) {
								$this->pushError( $e->getMessage() );
							}
							return false;
						}
					} else
						$this->pushError (__('Can not detect Host and API key. Contact site owner to resolve this issue.', CFS_LANG_CODE));
				} else
					$this->pushError (__('No lists to add selected in admin area - contact site owner to resolve this issue.', CFS_LANG_CODE));
			} else
				$this->pushError (frameCfs::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($form), 'email');
		} else
			$this->pushError (frameCfs::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($form), 'email');
		return false;
	}
	public function requireConfirm() {
		$destData = frameCfs::_()->getModule('subscribe')->getDestByKey( $this->getCode() );
		return $destData['require_confirm'];
	}
}