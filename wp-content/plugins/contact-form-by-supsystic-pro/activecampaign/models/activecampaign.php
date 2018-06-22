<?php
class activecampaignModelCfs extends modelSubscribeCfs {
	private $_client = null;
	private $_lastRequireConfirm = false;
	public function getClient($apiUrl, $apiKey) {
		if($this->_client)
			return $this->_client;
		if(!class_exists('jsonRPCClient')) {
			require_once($this->getModule()->getModDir(). 'classes'. DS. 'ActiveCampaign.class.php');
		}
		$this->_client = new ActiveCampaign($apiUrl, $apiKey);
		return $this->_client;
	}
	public function getLists($d) {
		$apiUrl = isset($d['api_url']) ? trim($d['api_url']) : false;
		$apiKey = isset($d['api_key']) ? trim($d['api_key']) : false;
		if(!empty($apiKey)) {
			if(!empty($apiUrl)) {
				$listsData = array();
				$listsRes = $this->getClient($apiUrl, $apiKey)->api('list/list', array('ids' => 'all', 'api_output' => 'json'));
				if($listsRes && isset($listsRes->error) && !empty($listsRes->error)) {
					$this->pushError(array($listsRes->error, __('Please make sure that you created some Lists under your Active Campaign account.', CFS_LANG_CODE)));
					return false;
				}
				if(is_string($listsRes)) {
					$this->pushError(array($listsRes, __('Make sure that you entered correct API data.', CFS_LANG_CODE)));
					return false;
				}
				$i = 0;
				$stop = false;
				while(!$stop) {
					if(isset($listsRes->$i)) {
						$listsData[] = array('id' => $listsRes->$i->id, 'name' => $listsRes->$i->name);
					} else 
						$stop = true;
					$i++;
				}
				return empty($listsData) ? false : $listsData;
			} else 
				$this->pushError(__('Please enter your API URL', CFS_LANG_CODE), 'params[tpl][sub_ac_api_url]');
		} else
			$this->pushError(__('Please enter your API key', CFS_LANG_CODE), 'params[tpl][sub_ac_api_key]');
		return false;
		
	}
	public function subscribe($d, $form, $validateIp = false) {
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email)) {
			if(is_email($email)) {
				$lists = isset($form['params']['tpl']['sub_ac_lists']) ? $form['params']['tpl']['sub_ac_lists'] : array();
				if(!empty($lists)) {
					if(!$validateIp || $validateIp && frameCfs::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_check' => true))) {
						$apiUrl = $form['params']['tpl']['sub_ac_api_url'];
						$apiKey = $form['params']['tpl']['sub_ac_api_key'];
						
						$name = isset($d['name']) ? trim($d['name']) : '';
						$client =  $this->getClient($apiUrl, $apiKey);
						$addData = array('email' => $email);
						if(!empty($name)) {
							$firstLastName = explode(' ', $name);
							$addData['first_name'] = $firstLastName[ 0 ];
							if(isset($firstLastName[ 1 ]) && !empty($firstLastName[ 1 ])) {
								$addData['last_name'] = $firstLastName[ 1 ];
							}
						}
						$predefinedKeys = array('first_name', 'last_name', 'phone', 'orgname');
						if(isset($form['params']['fields'])
							&& !empty($form['params']['fields'])
						) {
							foreach($predefinedKeys as $k) {
								foreach($form['params']['fields'] as $f) {
									if($k == $f['name'] && isset($d[ $k ])) {
										$addData[ $k ] = $d[ $k ];
										break;
									}
								}
							}
							foreach($form['params']['fields'] as $f) {
								$k = $f['name'];
								if(in_array($k, array_merge(array('name', 'email'), $predefinedKeys))) continue;	// Ignore standard fields
								if(isset($d[ $k ])) {
									$addData['field[%'. $k. '%,0]'] = $d[ $k ]; 
								}
							}
						}
						foreach($lists as $listId) {
							$addData['p['. $listId. ']'] = $listId;
							$addData['status['. $listId. ']'] = 1;
							try {
								$res = $client->api('contact/sync', $addData);
								if (!(int)$res->success) {
									$this->pushError(sprintf(__('Add contact failed with error: %s', CFS_LANG_CODE), $res->error));
									return false;
								}
							} catch(Exception $e) {
								$errorMsg = $e->getMessage();
								$this->pushError( $errorMsg );
								return false;
							}
						}
						return true;
					}
				} else
					$this->pushError (__('No lists to add selected in admin area - contact site owner to resolve this issue.', CFS_LANG_CODE));
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