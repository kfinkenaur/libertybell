<?php 
class aweberCfs extends moduleCfs {
	public function init() {
		parent::init();
		$this->_trySetOAuth();
		dispatcherCfs::addFilter('subDestList', array($this, 'addSubDestList'));
	}
	public function addSubDestList($subDestList) {
		$subDestList['aweber'] = array('label' => __('Aweber', CFS_LANG_CODE), 'require_confirm' => true);
		return $subDestList;
	}
	public function isSupported() {
		if(!function_exists('curl_init')) {
			return false;
		}
		return true;
	}
	private function _trySetOAuth() {
		$oauthToken = reqCfs::getVar('oauth_token', 'get');
		if(!empty($oauthToken) && frameCfs::_()->isAdminPlugOptsPage()) {
			$reqData = $this->getModel()->getReqData();
			if(!empty($reqData)) {
				if(($redirect = $this->getModel()->setOAuth())) {
					$errors = $this->getModel()->getErrors();
					if(!empty($errors)) {
						$redirect = uriCfs::_(array('baseUrl' => $redirect, 'cfsErrors' => $errors));
					}
					redirectCfs( $redirect );
				}
			}
		}
	}
}