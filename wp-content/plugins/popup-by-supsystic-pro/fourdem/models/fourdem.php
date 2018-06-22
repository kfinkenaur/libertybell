<?php
class fourdemModelPps extends modelPps {
	private $_lastRequireConfirm = false;
	private function _doReq($action, $data = array()) {
		$args = array_merge(array(
			'Command' => $action,
			'ResponseFormat' => 'JSON',
		), $data);

		//Insert here provided 4marketing server address
		$apiServerAddress = "http://mailchef.4dem.it";

		$defaults = array (
			CURLOPT_POST => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_URL => $apiServerAddress . '/api.php',
			CURLOPT_USERAGENT => '4marketing',
			CURLOPT_FRESH_CONNECT => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FORBID_REUSE => 1,
			CURLOPT_TIMEOUT => 2,
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_POSTFIELDS => http_build_query( $args ),
		);
		$ch = curl_init ();
		curl_setopt_array ( $ch, $defaults );
		$response = curl_exec ( $ch );
		$curlError = curl_error($ch);
		curl_close ( $ch );
		
		if(empty($response) && !empty($curlError)) {
			$this->pushError( $curlError );
			return false;
		}
		if(empty($response)) {
			$this->pushError(__('Empty response from server', PPS_LANG_CODE));
			return false;
		}
		$response = json_decode ( $response, true );
		if(!$response['Success'] && $response['ErrorText']) {
			$this->pushError( $response['ErrorText'] );
			return false;
		}
		return $response;
	}
	private function _getSessionData( $username, $password ) {
		return $this->_doReq('User.Login', array(
			'Username' => $username,
			'Password' => $password,
		));
	}
	public function getLists($d) {
		$username = isset($d['username']) ? trim($d['username']) : false;
		$password = isset($d['pass']) ? trim($d['pass']) : false;
		if(!empty($username)) {
			if(!empty($password)) {
				$session = $this->_getSessionData( $username, $password );
				if($session) {
					$listsRes = $this->_doReq('Lists.Get', array(
						'SessionID' => $session['SessionID'],
						'OrderField' => 'ListID',
						'OrderType' => 'ASC',
					));
					if($listsRes) {
						if(isset($listsRes['Lists']) && !empty($listsRes['Lists'])) {
							$listsData = array();
							foreach($listsRes['Lists'] as $l) {
								$listsData[] = array('id' => $l['ListID'], 'name' => $l['Name']. ' ('. (int) $l['SubscriberCount']. ')');
							}
							return $listsData;
						} else
							$this->pushError(__('You have no list for now. Create them at first in your 4Dem.it account', PPS_LANG_CODE));
					}
				}
			} else
				$this->pushError(__('Please enter your Password', PPS_LANG_CODE), 'params[tpl][sub_4d_pass]');
		} else
			$this->pushError(__('Please enter your Username', PPS_LANG_CODE), 'params[tpl][sub_4d_name]');
		return false;
	}
	public function subscribe($d, $popup, $validateIp = false) {
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email)) {
			if(is_email($email)) {
				$lists = isset($popup['params']['tpl']['sub_4d_lists']) ? $popup['params']['tpl']['sub_4d_lists'] : array();
				if(!empty($lists)) {
					if(!$validateIp || $validateIp && framePps::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_check' => true))) {
						$sendData = array('EmailAddress' => $email);
						$name = isset($d['name']) ? trim($d['name']) : '';
						if(!empty($name)) {
							$sendData['CustomFieldname'] = $name;
							$firstLastName = explode(' ', $name);
							if(count($firstLastName) > 1) {
								$sendData['CustomFieldfirstname'] = $firstLastName[ 0 ];
								$sendData['CustomFieldlastname'] = $firstLastName[ 1 ];
							}
						}
						if(isset($popup['params']['tpl']['sub_fields'])
							&& !empty($popup['params']['tpl']['sub_fields'])
						) {
							foreach($popup['params']['tpl']['sub_fields'] as $k => $f) {
								if(in_array($k, array('name', 'email'))) continue;	// Ignore standard fields
								if(isset($d[ $k ])) {
									$sendData[ 'CustomField'. $k ] = $d[ $k ]; 
								}
							}
						}
						$sendData['IPAddress'] = utilsPps::getIP();

						foreach($lists as $l) {
							$sendData['ListID'] = $l;
							$res = $this->_doReq('Subscriber.Subscribe', $sendData);
							if(!$res) {
								return false;
							}
							if(!$res['Success']) {
								$this->pushError(__('Can not subscribe', PPS_LANG_CODE). (isset($res['ErrorCode']) ? ' error code - '. $res['ErrorCode'] : ''));
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