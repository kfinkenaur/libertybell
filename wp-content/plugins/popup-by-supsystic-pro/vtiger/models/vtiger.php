<?php
class vtigerModelPps extends modelPps {
	private $_url = '';
	private $_username = '';
	private $_accessKey = '';
	
	private $_lastRequireConfirm = false;

	private function _doReq($action, $method = 'GET', $data = array()) {
		$method = strtoupper( $method );
		$args = array('operation' => $action);
		if(!empty($data)) {
			$args = array_merge($args, $data);
		}
		$url = $this->_getUrl();
		if($method == 'GET') {
			$url .= '?'. http_build_query($args);
		}
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_CAINFO, framePps::_()->getModule('subscribe')->getModDir(). 'classes'. DS. 'cacert.pem');

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		if($method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
		}
		$result = curl_exec($ch);
		$curlError = curl_error($ch);
		curl_close($ch);

		if(!$result && $curlError) {
			$this->pushError( $curlError );
		}

		if($result) {
			$result = json_decode($result, true);
			if(!empty($result) && !$result['success']) {
				$this->pushError( $result['error']['message'] );
				return false;
			}
			return $result['result'];
		}
		return false;
	}
	private function _getSessionData() {
		$chalange = $this->_doReq('getchallenge', 'GET', array('username' => $this->_username));
		if($chalange) {
			$sessionData = $this->_doReq('login', 'POST', array(
				'username' => $this->_username, 
				'accessKey' => md5($chalange['token']. $this->_accessKey),
			));
			if($sessionData) {
				return $sessionData;
			} else
				$this->pushError(__('Can not retrieve session data', PPS_LANG_CODE));
		} else
			$this->pushError(__('Can not retrieve token data', PPS_LANG_CODE));
		return false;
	}
	private function _setUrl( $url ) {
		if(strpos($url, 'webservice.php') === false) {
			$url = rtrim( $url, '/' ). '/webservice.php';
		}
		$this->_url = $url;
	}
	private function _getUrl() {
		return $this->_url;
	}
	private function _setApiData( $url, $name, $key ) {
		$this->_setUrl( $url );
		$this->_username = $name;
		$this->_accessKey = $key;
	}
	public function subscribe($d, $popup, $validateIp = false) {
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email)) {
			if(is_email($email)) {
				$popup['params']['tpl']['sub_vtig_url'] = isset($popup['params']['tpl']['sub_vtig_url']) ? trim($popup['params']['tpl']['sub_vtig_url']) : false;
				$popup['params']['tpl']['sub_vtig_name'] = isset($popup['params']['tpl']['sub_vtig_name']) ? trim($popup['params']['tpl']['sub_vtig_name']) : false;
				$popup['params']['tpl']['sub_vtig_key'] = isset($popup['params']['tpl']['sub_vtig_key']) ? trim($popup['params']['tpl']['sub_vtig_key']) : false;
				if(empty($popup['params']['tpl']['sub_vtig_url'])) {
					$this->pushError(__('Empty URL for Vtiger settings in admin area for PopUp', PPS_LANG_CODE));
				}
				if(empty($popup['params']['tpl']['sub_vtig_name'])) {
					$this->pushError(__('Empty Username for Vtiger settings in admin area for PopUp', PPS_LANG_CODE));
				}
				if(empty($popup['params']['tpl']['sub_vtig_key'])) {
					$this->pushError(__('Empty Access Key for Vtiger settings in admin area for PopUp', PPS_LANG_CODE));
				}
				if(!$this->haveErrors()) {
					if(!$validateIp || $validateIp && framePps::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_check' => true))) {
						$sendData = array('email' => $email);
						$name = isset($d['name']) ? trim($d['name']) : '';
						if(!empty($name)) {
							$sendData['name'] = $name;
							$firstLastName = explode(' ', $name);
							if(count($firstLastName) > 1) {
								$sendData['firstname'] = $firstLastName[ 0 ];
								$sendData['lastname'] = $firstLastName[ 1 ];
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
						$this->_setApiData( $popup['params']['tpl']['sub_vtig_url'], $popup['params']['tpl']['sub_vtig_name'], $popup['params']['tpl']['sub_vtig_key'] );
						$session = $this->_getSessionData();
						if($session) {
							$sendData['assigned_user_id'] = $session['userId'];
							if($this->_doReq('create', 'POST', array(
								'sessionName' => $session['sessionName'], 
								'elementType' => 'Contacts',
								'element' => json_encode($sendData),
							))) {
								return true;
							}
						}
					}
				}
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