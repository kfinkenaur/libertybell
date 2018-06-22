<?php
class aweberModelCfs extends modelSubscribeCfs {
	/**
	 * Aweber client retrieve
	 */
	private function _getAweberInst() {
		static $instances = array();
		$keySecret = $this->getKeySecret();
		$sonsumerKey = $keySecret ? $keySecret['key'] : $this->_getKey();
		$consumerSecret = $keySecret ? $keySecret['secret'] : $this->_getSecret();
		$instHash = md5( $sonsumerKey. $consumerSecret );
		if(!isset($instances[ $instHash ])) {
			if(!class_exists('AWeberAPI'))
				require_once($this->getModule()->getModDir(). 'classes'. DS. 'aweber_api.php');
			$instances[ $instHash ] = new AWeberAPI( $sonsumerKey, $consumerSecret );
		}
		return $instances[ $instHash ];
	}
	public function subscribe($d, $form, $validateIp = false) {
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email)) {
			if(is_email($email)) {
				$lists = isset($form['params']['tpl']['sub_aweber_lists']) ? $form['params']['tpl']['sub_aweber_lists'] : array();
				if(!empty($lists)) {
					if(!$validateIp || $validateIp && frameCfs::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_check' => true))) {
						$dataToSend = array('email' => $email, 'ip_address' => utilsCfs::getIP());
						if(isset($d['name']) && !empty($d['name'])) {
							$dataToSend['name'] = trim( $d['name'] );
						}
						if(isset($form['params']['fields'])
							&& !empty($form['params']['fields'])
						) {
							foreach($form['params']['fields'] as $f) {
								$k = $f['name'];
								if(in_array($k, array('name', 'email'))) continue;	// Ignore standard fields
								if(isset($d[ $k ])) {
									if(!isset($dataToSend['custom_fields']))
										$dataToSend['custom_fields'] = array();
									$dataToSend['custom_fields'][$k] = $d[ $k ];
								}
							}
						}
						try {
							$client = $this->_getAweberInst();
							$account = $this->_getAccount($client);
							foreach($lists as $listId) {
								$aweberLists = $account->lists->find(array('id' => $listId));
								if($aweberLists) {
									$aweberList = $aweberLists[ 0 ];
									$aweberSubscribers = $aweberList->subscribers;
									$newSubscriber = $aweberSubscribers->create( $dataToSend );
								}
							}
						} catch(AWeberAPIException $exc) {
							$this->pushError($exc->message);
							return false;
						}
						if($validateIp) {
							frameCfs::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_add' => true));
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
	private function _getAccount( $client ) {
		$ts = $this->_getTokenSecret();
		return $client->getAccount($ts['t'], $ts['s']);
	}
	public function getLists($d = array()) {
		$client = $this->_getAweberInst();
		$client->adapter->debug = false;
		$account = $this->_getAccount( $client );
		$lists = $account->lists;
		if(!empty($lists)) {
			$listsDta = array();
			foreach($lists as $list) {
				$listsDta[ $list->id ] = $list->name;
			}
			return $listsDta;
		} else {
			$this->pushError(__('Can not find your Aweber lists', CFS_LANG_CODE));
		}
		return false;
	}
	//private $_key = 'AkyfzIUi4ihyQfrHqB0tKrre';
	//private $_secret = 'KW3BwBtv8l9z4OlwyrwpGbcY7Azh66I5Th9VAHKZ';
	
	private $_key = '';
	private $_secret = '';
	private function _getKey() {
		return $this->_key;
	}
	private function _getSecret() {
		return $this->_secret;
	}
	private function _setKeySecret( $d = array() ) {
		$this->_key = $d['key'];
		$this->_secret = $d['secret'];
	}
	public function getClbUrl() {
		return (is_ssl() ? 'https://' : 'http://'). $_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'];
	}
	public function getAuthUrl( $d = array() ) {
		/*if(isset($d['key'], $d['secret']) 
			&& !empty($d['key']) 
			&& !empty($d['key'])
		) {
			$this->_setKeySecret( $d );
		}*/
		$client = $this->_getAweberInst();
		$callbackUrl = isset($d['clb_url']) ? $d['clb_url'] : $this->getClbUrl();
		try {
			list($requestToken, $requestTokenSecret) = $client->getRequestToken($callbackUrl);
			$this->_setReqData( $requestToken, $requestTokenSecret, $callbackUrl );
		} catch(AWeberAPIException $e) {
			$this->pushError($e->getMessage());
			return false;
		}
		return $client->getAuthorizeUrl();
	}
	private function _setReqData( $requestToken, $requestTokenSecret, $callbackUrl ) {
		frameCfs::_()->getModule('options')->getModel()->save('awb_req_data', array('token' => $requestToken, 'tokenSecret' => $requestTokenSecret, 'clb_url' => $callbackUrl));
	}
	public function getReqData() {
		return frameCfs::_()->getModule('options')->get('awb_req_data');
	}
	public function setOAuth() {
		$client = $this->_getAweberInst();
		$reqData = $this->getReqData();
		$client->user->tokenSecret = $reqData['tokenSecret'];
		$client->user->requestToken = reqCfs::getVar('oauth_token', 'get');
		$client->user->verifier = reqCfs::getVar('oauth_verifier', 'get');
		try {
			list($accessToken, $accessTokenSecret) = $client->getAccessToken();
			$this->_saveAccessTokenSecret( $accessToken, $accessTokenSecret );
			frameCfs::_()->getModule('options')->getModel()->save('awb_req_data', array());	// Clear it
		} catch(AWeberAPIException $e) {
			$this->pushError( $e->getMessage() );
		}
		return $reqData['clb_url'];
	}
	public function saveKeySecret( $d = array() ) {
		$save = array_filter(array(
			'key' => isset($d['key']) ? trim($d['key']) : false,
			'secret' => isset($d['secret']) ? trim($d['secret']) : false,
		));
		if(!empty($save)) {
			update_option('cfs_aw_ks', utilsCfs::encodeArrayTxt($save));
		}
	}
	public function getKeySecret() {
		$keySecret = get_option('cfs_aw_ks');
		if(!empty($keySecret)) {
			return utilsCfs::decodeArrayTxt( $keySecret );
		}
		return false;
	}
	private function _saveAccessTokenSecret( $accessToken, $accessTokenSecret ) {
		frameCfs::_()->getModule('options')->getModel()->save('awb_user', utilsCfs::encodeArrayTxt(array('t' => $accessToken, 's' => $accessTokenSecret)));
	}
	private function _getTokenSecret() {
		$optVal = frameCfs::_()->getModule('options')->get('awb_user');
		return $optVal ? utilsCfs::decodeArrayTxt( $optVal ) : false;
	}
	public function isLoggedIn() {
		$tokenSecret = $this->_getTokenSecret();
		if(!empty($tokenSecret)) {
			try {
				$client = $this->_getAweberInst();
				$this->_getAccount( $client );
			} catch(AWeberAPIException $e) {
				return false;
			}
		}
		return $tokenSecret ? true : false;
	}
	
}