<?php
class dotmailerModelPps extends modelPps {
	private $_lastRequireConfirm = false;
	private $_apiUrl = 'https://apiconnector.com/v2/';

	private function _doReq($action, $auth = array(), $reqType = 'GET', $reqData = array()) {
		//encode the data as json string
		$requestBody = '';
		if(!empty($reqData))
			$requestBody = json_encode($reqData);

		//initialise curl session
		$ch = curl_init();

		//curl options
		curl_setopt($ch, CURLAUTH_BASIC, CURLAUTH_DIGEST);
		curl_setopt($ch, CURLOPT_USERPWD, $auth['sub_dms_api_user'] . ':' . $auth['sub_dms_api_password']); // credentials
		if(!empty($requestBody)) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
		}
		if(!empty($requestBody) || $reqType == 'POST')
			curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_URL, $this->_apiUrl. $action);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Accept: ' . 'application/json' ,'Content-Type: application/json'));

		//curl execute and json decode the response
		$responseBody = json_decode(curl_exec($ch));

		//close curl session
		curl_close($ch);

		return $responseBody;
	}
	public function getLists($d) {
		if(!empty($d['sub_dms_api_user'])) {
			if(!empty($d['sub_dms_api_password'])) {
				$listsData = array();
				$listsRes = $this->_doReq('address-books', $d);
				if($listsRes && !empty($listsRes) && is_array($listsRes)) {
					foreach($listsRes as $l) {
						$listsData[] = array('id' => $l->id, 'name' => $l->name. ' ('. (int) $l->contacts. ')');
					}
					return $listsData;
				} elseif(is_object($listsRes) && isset($listsRes->message) && !empty($listsRes->message)) {
					$this->pushError($listsRes->message);
				} else {
					$this->pushError(__('Can not get Lists', PPS_LANG_CODE));
				}
				return false;
			} else
				$this->pushError(__('Please enter your API password', PPS_LANG_CODE), 'params[tpl][sub_dms_api_password]');
		} else
			$this->pushError(__('Please enter your API username', PPS_LANG_CODE), 'params[tpl][sub_dms_api_user]');
		return false;
	}
	public function subscribe($d, $popup, $validateIp = false) {
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email)) {
			if(is_email($email)) {
				$lists = isset($popup['params']['tpl']['sub_dms_lists']) ? $popup['params']['tpl']['sub_dms_lists'] : array();
				if(!empty($lists)) {
					if(!$validateIp || $validateIp && framePps::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_check' => true))) {
						$sendData = array('Email' => $email, 'EmailType' => 'Html');
						if(isset($popup['params']['tpl']['sub_dms_optin']) && !empty($popup['params']['tpl']['sub_dms_optin'])) {
							$sendData['OptInType'] = $popup['params']['tpl']['sub_dms_optin'];
						}
						$addData = array();
						$name = isset($d['name']) ? trim($d['name']) : '';
						if(!empty($name)) {
							$firstLastName = explode(' ', $name);
							if(count($firstLastName) > 1) {
								$addData[] = array('Key' => 'FIRSTNAME', 'Value' => $firstLastName[ 0 ]);
								$addData[] = array('Key' => 'LASTNAME', 'Value' => $firstLastName[ 1 ]);
							}
							$addData[] = array('Key' => 'FULLNAME', 'Value' => $name);
						}
						if(isset($popup['params']['tpl']['sub_fields'])
							&& !empty($popup['params']['tpl']['sub_fields'])
						) {
							foreach($popup['params']['tpl']['sub_fields'] as $k => $f) {
								if(in_array($k, array('email', 'name'))) continue;	// Ignore standard fields
								if(isset($d[ $k ])) {
									$addData[] = array('Key' => $k, 'Value' => $d[ $k ]);
								}
							}
						}
						if(!empty($addData)) {
							$sendData['dataFields'] = $addData;
						}
						$contact = $this->_doReq('contacts', $popup['params']['tpl'], 'POST', $sendData);
						if($contact) {
							// Add it to lists
							foreach($lists as $l) {
								$this->_doReq('address-books/'. $l. '/contacts', $popup['params']['tpl'], 'POST', $contact);
							}
							return true;
						} elseif(is_object($contact) && isset($contact->message) && !empty($contact->message)) {
							$this->pushError($contact->message);
						}
						return false;
					}
				} else
					$this->pushError (__('No Address Book to add selected in admin area - contact site owner to resolve this issue.', PPS_LANG_CODE));
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