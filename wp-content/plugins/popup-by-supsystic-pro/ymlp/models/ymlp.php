<?php
class ymlpModelPps extends modelPps {
	private $_client = null;
	private $_lastRequireConfirm = false;
	private function _getClient($apiKey, $username) {
		if($this->_client)
			return $this->_client;
		if(!class_exists('YMLP_API')) {
			require_once($this->getModule()->getModDir(). 'classes'. DS. 'YMLP_API.class.php');
		}
		$this->_client = new YMLP_API($apiKey, $username);
		return $this->_client;
	}
	public function getLists($d) {
		$apiKey = isset($d['api_key']) ? trim($d['api_key']) : false;
		$username = isset($d['username']) ? trim($d['username']) : false;
		if(!empty($apiKey)) {
			if(!empty($username)) {
				$this->_getClient($apiKey, $username);
				$listsRes = $this->_client->GroupsGetList();
				if(!$this->_client->ErrorMessage) {
					if(!empty($listsRes)) {
						$listsData = array();
						foreach($listsRes as $l) {
							$listsData[] = array('id' => $l['ID'], 'name' => $l['GroupName']. ' ('. (int) $l['NumberOfContacts']. ')');
						}
						return $listsData;
					} else
						$this->pushError(__('You have no Groups for now. Create them at first in your YMLP account', PPS_LANG_CODE));
				} else 
					$this->pushError( $this->_client->ErrorMessage );
			} else
				$this->pushError(__('Please enter your Username from YMLP account', PPS_LANG_CODE), 'params[tpl][sub_ymlp_api_key]');
		} else
			$this->pushError(__('Please enter your API key', PPS_LANG_CODE), 'params[tpl][sub_ymlp_api_key]');
		return false;
	}
	public function subscribe($d, $popup, $validateIp = false) {
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email)) {
			if(is_email($email)) {
				$lists = isset($popup['params']['tpl']['sub_ymlp_lists']) ? $popup['params']['tpl']['sub_ymlp_lists'] : array();
				if(!empty($lists)) {
					if(!$validateIp || $validateIp && framePps::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_check' => true))) {
						$addFields = array();
						$name = isset($d['name']) ? trim($d['name']) : '';
						if(!empty($name)) {
							$addFields['name'] = $name;
							$firstLastName = explode(' ', $name);
							if(count($firstLastName) > 1) {
								$addFields['first_name'] = $firstLastName[ 0 ];
								$addFields['last_name'] = $firstLastName[ 1 ];
							}
						}
						if(isset($popup['params']['tpl']['sub_fields'])
							&& !empty($popup['params']['tpl']['sub_fields'])
						) {
							foreach($popup['params']['tpl']['sub_fields'] as $k => $f) {
								if(in_array($k, array('name', 'email'))) continue;	// Ignore standard fields
								if(isset($d[ $k ])) {
									$addFields[ $k ] = $d[ $k ]; 
								}
							}
						}
						$this->_getClient( $popup['params']['tpl']['sub_ymlp_api_key'], $popup['params']['tpl']['sub_ymlp_name'] );
						foreach($lists as $l) {
							$res = $this->_client->ContactsAdd($email, $addFields, $l);
							if(!$res || $this->_client->ErrorMessage) {
								$this->pushError($this->_client->ErrorMessage ? $this->_client->ErrorMessage : __('Can not add email. Please contact site owner.', PPS_LANG_CODE));
								return false;
							}
							if(isset($res['Code']) && (int) $res['Code'] > 0) {
								$this->pushError($res['Output']);
								return false;
							}
						}
						return true;
					}
				} else
					$this->pushError (__('No groups to add selected in admin area - contact site owner to resolve this issue.', PPS_LANG_CODE));
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