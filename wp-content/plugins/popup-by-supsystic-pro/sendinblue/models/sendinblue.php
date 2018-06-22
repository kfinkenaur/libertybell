<?php
class sendinblueModelPps extends modelPps {
	private $_client = null;
	private $_lastRequireConfirm = false;
	private function _getClient($apiKey) {
		if($this->_client)
			return $this->_client;
		if(!class_exists('SendingBlueMailin')) {
			require_once($this->getModule()->getModDir(). 'classes'. DS. 'mailing.php');
		}
		$this->_client = new SendingBlueMailin('https://api.sendinblue.com/v2.0', $apiKey);
		return $this->_client;
	}
	private function _doReq($apiKey, $action, $data = array()) {
		try {
			return call_user_func_array(array($this->_getClient($apiKey), $action), array( $data ));
		} catch (RuntimeException $e) {
			$this->pushError( $e->getMessage() );
			return false;
		}
	}
	public function getLists($d) {
		$apiKey = isset($d['api_key']) ? trim($d['api_key']) : false;
		if(!empty($apiKey)) {
			$listsData = array();
			$listsRes = $this->_doReq($apiKey, 'get_lists');
			if($listsRes && $listsRes['code'] == 'success') {
				if(isset($listsRes['data']) && !empty($listsRes['data'])) {
					foreach($listsRes['data'] as $l) {
						$listsData[] = array('id' => $l['id'], 'name' => $l['name']. ' ('. (int) $l['total_subscribers']. ')');
					}
					return $listsData;
				} else
					$this->pushError(__('You have no list for now. Create them at first in your SendingBlue account', PPS_LANG_CODE));
			} elseif(isset($listsRes['message']) && !empty($listsRes['message'])) {
				$this->pushError($listsRes['message']);
			} else {
				$this->pushError(__('Can not get Lists', PPS_LANG_CODE));
			}
			return false;
		} else
			$this->pushError(__('Please enter your API key', PPS_LANG_CODE), 'params[tpl][sub_sb_lists]');
		return false;
		
	}
	public function subscribe($d, $popup, $validateIp = false) {
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email)) {
			if(is_email($email)) {
				$lists = isset($popup['params']['tpl']['sub_sb_lists']) ? $popup['params']['tpl']['sub_sb_lists'] : array();
				if(!empty($lists)) {
					if(!$validateIp || $validateIp && framePps::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_check' => true))) {
						$sendData = array('email' => $email, 'listid' => $lists);
						$addData = array();
						$name = isset($d['name']) ? trim($d['name']) : '';
						if(!empty($name)) {
							$firstLastName = explode(' ', $name);
							if(count($firstLastName) > 1) {
								$addData['FIRSTNAME'] = $firstLastName[ 0 ];
								$addData['LASTNAME'] = $firstLastName[ 1 ];
							} else {
								$addData['NAME'] = $name;
							}
						}
						if(isset($popup['params']['tpl']['sub_fields'])
							&& !empty($popup['params']['tpl']['sub_fields'])
						) {
							foreach($popup['params']['tpl']['sub_fields'] as $k => $f) {
								if(in_array($k, array('email'))) continue;	// Ignore standard fields
								if(isset($d[ $k ])) {
									$addData[ $k ] = $d[ $k ]; 
								}
							}
						}
						if(!empty($addData)) {
							$sendData['attributes'] = $addData;
						}
						$apiKey = $popup['params']['tpl']['sub_sb_api_key'];
						$res = $this->_doReq($apiKey, 'create_update_user', $sendData);
						if($res && $res['code'] == 'success') {
							return true;
						} elseif(isset($res['message']) && !empty($res['message'])) {
							$this->pushError($res['message']);
						}
						return false;
					}
				} else
					$this->pushError (__('No lists to add selected in admin area - contact site owner to resolve this issue.', PPS_LANG_CODE));
			} else
				$this->pushError (framePps::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($popup), 'email');
		} else
			$this->pushError (framePps::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($popup), 'email');
		return false;
	}
	public function requireConfirm() {
		if($this->_lastRequireConfirm)
			return true;
		$destData = framePps::_()->getModule('subscribe')->getDestByKey( $this->getCode() );
		return $destData['require_confirm'];
	}
}