<?php
class sendgridModelPps extends modelPps {
	private $_CIPHER = null;//MCRYPT_RIJNDAEL_128; // Rijndael-128 is AES
    private $_MODE   = null;//MCRYPT_MODE_CBC;
	private $_username = '';
	private $_password = '';
	public function getLists() {
		$listsDta = array();
		$listsRes = $this->makeRequest('contactdb/lists', 'GET');
		if($listsRes && is_array($listsRes) && !empty($listsRes['lists'])) {
			foreach($listsRes['lists'] as $list) {
				$listsDta[ $list['id'] ] = $list['name'];
			}
		} elseif(!$this->haveErrors())
			$this->pushError(__('You have no lists. Login to your SendGrid account and create your first list before start using this functionality.', PPS_LANG_CODE));
		return empty($listsDta) ? false : $listsDta;
	}
	public function getApiUsername() {
		if(empty($this->_username)) {
			$this->_username = $this->_decrypt( framePps::_()->getModule('options')->get($this->getCode(). '_username') );
		}
		return $this->_username;
	}
	public function getApiPassword() {
		if(empty($this->_password)) {
			$this->_password = $this->_decrypt( framePps::_()->getModule('options')->get($this->getCode(). '_password') );
		}
		return $this->_password;
	}
	public function setApiUsername($username) {
		framePps::_()->getModule('options')->getModel()->save($this->getCode(). '_username', $this->_encrypt($username));
	}
	public function setApiPassword($password) {
		framePps::_()->getModule('options')->getModel()->save($this->getCode(). '_password', $this->_encrypt($password));
	}
	public function makeRequest($address, $type, $data = array()) {
		$res = array();
		/*if(is_array($data)) {
			$data['api_user'] = $this->getApiUsername();
			$data['api_key'] = $this->getApiPassword();
		}*/
		$url = 'https://api.sendgrid.com/v3/';
		//newsletter/lists/get
		$request =  $url. $address;
		// Generate curl request
		$session = curl_init($request);
		// Tell curl to use HTTP POST
		if($type == 'POST') {
			curl_setopt ($session, CURLOPT_POST, true);
			// Tell curl that this is the body of the POST
			curl_setopt ($session, CURLOPT_POSTFIELDS, json_encode($data));
		}
		// Tell curl not to return headers, but do return the response
		curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

		curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $this->getApiPassword()));

		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		// Verify SSL
		curl_setopt($session, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($session, CURLOPT_CAINFO, dirname(__FILE__). DS. 'cacert.pem');
		// obtain response
		$response = curl_exec($session);
		$curlError = curl_error($session);
		curl_close($session);

		if(empty($response)) {
			$res['error'] = empty($curlError) ? langPps::_('Some error occured during connection to the server') : $curlError;
		} else {
			$res = utilsPps::jsonDecode($response);
		}
		if(isset($res['error']) && !empty($res['error'])) {
			$this->pushError($res['error']);
			return false;
		}
		if(isset($res['errors']) && !empty($res['errors'])) {
			foreach($res['errors'] as $e) {
				$this->pushError( $e['message'] );
			}
			return false;
		}
		return $res;
	}
	private function _encrypt($pureString, $encryptionKey = '') {
		if(empty($encryptionKey))
			$encryptionKey = $this->_getEncriptKey();
		if(function_exists('mcrypt_encrypt')) {
			$this->_initCript();
			$encryptionKey = substr($encryptionKey, 0, 16);
			$ivSize = mcrypt_get_iv_size($this->_CIPHER, $this->_MODE);
			$iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
			$ciphertext = mcrypt_encrypt($this->_CIPHER, $encryptionKey, $pureString, $this->_MODE, $iv);
			return base64_encode($iv. $ciphertext);
		} else {
			return base64_encode($pureString);
		}
	}
	private function _decrypt($encryptedString, $encryptionKey = '') {
		if(empty($encryptionKey))
			$encryptionKey = $this->_getEncriptKey();
		if(function_exists('mcrypt_encrypt')) {
			$this->_initCript();
			$encryptionKey = substr($encryptionKey, 0, 16);
			$ciphertext = base64_decode($encryptedString);
			$ivSize = mcrypt_get_iv_size($this->_CIPHER, $this->_MODE);
			if (strlen($ciphertext) < $ivSize) {
				return false;
			}
			$iv = substr($ciphertext, 0, $ivSize);
			$ciphertext = substr($ciphertext, $ivSize);
			$plaintext = mcrypt_decrypt($this->_CIPHER, $encryptionKey, $ciphertext, $this->_MODE, $iv);
			return rtrim($plaintext, "\0");
		} else {
			$decryptedString = base64_decode($encryptedString);
			return $decryptedString;
		}
	}
	private function _initCript() {
		if(defined('MCRYPT_RIJNDAEL_128')) {
			$this->_CIPHER = MCRYPT_RIJNDAEL_128; // Rijndael-128 is AES
		}
		if(defined('MCRYPT_MODE_CBC')) {
			$this->_MODE = MCRYPT_MODE_CBC;
		}
	}
	private function _getEncriptKey() {
		$authKey = AUTH_KEY;
		if(strlen($authKey) < 16) {
			for($i = strlen($authKey); $i < 16; $i++) {
				$authKey .= '1';
			}
		}
		return $authKey;
	}
	public function isLoggedIn() {
		$password = $this->getApiPassword();
		return !empty($password);
	}
	public function subscribe($d, $popup, $validateIp = false) {
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email)) {
			if(is_email($email)) {
				$lists = isset($popup['params']['tpl']['sub_sg_lists']) ? $popup['params']['tpl']['sub_sg_lists'] : array();
				if(!empty($lists)) {
					if($this->isLoggedIn()) {
						if(!$validateIp || $validateIp && framePps::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_check' => true))) {
							$name = isset($d['name']) ? trim($d['name']) : '';
							$addData = array(
								'email' => $email,
							);
							if($name) {
								$firstLastName = explode(' ', $name);
								$addData['first_name'] = $firstLastName[ 0 ];
								if(isset($firstLastName[ 1 ])) {
									$addData['last_name'] = $firstLastName[ 1 ];
								}
							}
							if(isset($popup['params']['tpl']['sub_fields'])
								&& !empty($popup['params']['tpl']['sub_fields'])
							) {
								foreach($popup['params']['tpl']['sub_fields'] as $k => $f) {
									if(in_array($k, array('name', 'email'))) continue;	// Ignore standard fields
									if(isset($d[ $k ])) {
										$addData[ $k ] = $d[ $k ]; 
									}
								}
							}
						
							$res = $this->makeRequest('contactdb/recipients', 'POST', array($addData));
							if($res && $res['persisted_recipients'] && $res['persisted_recipients'][ 0 ]) {
								$addedId = $res['persisted_recipients'][ 0 ];
								foreach($lists as $listId) {
									$res = $this->makeRequest('contactdb/lists/'. $listId. '/recipients', 'POST', array($addedId));
								}
								return true;
							}
						}
					} else
						$this->pushError (__('Can not detect authorization of account owner. Contact site owner to resolve this issue.', PPS_LANG_CODE));
				} else
					$this->pushError (__('No lists to add selected in admin area - contact site owner to resolve this issue.', PPS_LANG_CODE));
			} else
				$this->pushError (framePps::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($popup), 'email');
		} else
			$this->pushError (framePps::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($popup), 'email');
		return false;
	}
	public function requireConfirm() {
		$destData = framePps::_()->getModule('subscribe')->getDestByKey( $this->getCode() );
		return $destData['require_confirm'];
	}
}