<?php
class vision6ModelPps extends modelPps {
	private $_client = null;
	private $_lastRequireConfirm = false;
	private function _getClient($apiKey) {
		if($this->_client)
			return $this->_client;
		if(!class_exists('Vision6ApiWrapper')) {
			require_once($this->getModule()->getModDir(). 'classes'. DS. 'api.class.php');
		}
		$this->_client = new Vision6ApiWrapper('https://app.vision6.com/api/jsonrpcserver', $apiKey);
		return $this->_client;
	}
	private function _doReq($apiKey, $action, $data = array()) {
		try {
			return call_user_func_array(array($this->_getClient($apiKey), 'invokeMethod'), array_merge( array($action), $data ));
		} catch (RuntimeException $e) {
			$this->pushError( $e->getMessage() );
			return false;
		}
	}
	public function getLists($d) {
		$apiKey = isset($d['api_key']) ? trim($d['api_key']) : false;
		if(!empty($apiKey)) {
			$listsRes = $this->_doReq($apiKey, 'searchLists');
			if($listsRes !== false) {
				if(!empty($listsRes)) {
					$listsData = array();
					foreach($listsRes as $l) {
						$listsData[] = array('id' => $l['id'], 'name' => $l['name']. ' ('. (int) $l['contact_count']. ')');
					}
					return $listsData;
				} else
					$this->pushError(__('You have no list for now. Create them at first in your Vision6 account', PPS_LANG_CODE));
			}
			return false;
		} else
			$this->pushError(__('Please enter your API key', PPS_LANG_CODE), 'params[tpl][sub_v6_lists]');
		return false;
	}
	public function subscribe($d, $popup, $validateIp = false) {
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email)) {
			if(is_email($email)) {
				$lists = isset($popup['params']['tpl']['sub_v6_lists']) ? $popup['params']['tpl']['sub_v6_lists'] : array();
				if(!empty($lists)) {
					if(!$validateIp || $validateIp && framePps::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_check' => true))) {
						$sendData = array('email' => $email);
						$name = isset($d['name']) ? trim($d['name']) : '';
						if(!empty($name)) {
							$sendData['name'] = $name;
							$firstLastName = explode(' ', $name);
							if(count($firstLastName) > 1) {
								$sendData['First Name'] = $firstLastName[ 0 ];
								$sendData['Last Name'] = $firstLastName[ 1 ];
							}
						}
						if(isset($popup['params']['tpl']['sub_fields'])
							&& !empty($popup['params']['tpl']['sub_fields'])
						) {
							foreach($popup['params']['tpl']['sub_fields'] as $k => $f) {
								if(in_array($k, array('name', 'email'))) continue;	// Ignore standard fields
								if(isset($d[ $k ])) {
									$sendData[ $k ] = $d[ $k ]; 
								}
							}
						}
						$apiKey = $popup['params']['tpl']['sub_v6_api_key'];
						foreach($lists as $l) {
							$res = $this->_doReq($apiKey, 'subscribeContact', array($l, $sendData));
							if(!$res) {
								return false;
							}
						}
						return true;
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