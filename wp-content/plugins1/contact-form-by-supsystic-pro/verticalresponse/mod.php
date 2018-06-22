<?php
class verticalresponseCfs extends moduleCfs {
	private $_redirectAlias = 'verticalresponse/cfs/auth/return';
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('subDestList', array($this, 'addSubDestList'));
		$code = reqCfs::getVar('code', 'get');
		if(!empty($code) && strpos(reqCfs::getRequestUri(), $this->_redirectAlias)) {
			$this->getController()->saveAccessToken();
		}
	}
	public function isSupported() {
		return true;
	}
	public function addSubDestList($subDestList) {
		$subDestList['verticalresponse'] = array('label' => __('Vertical Response', CFS_LANG_CODE), 'require_confirm' => false);
		return $subDestList;
	}
	public function isLoggedIn() {
		return $this->getModel()->isLoggedIn();
	}
	public function getRedirectAlias() {
		return $this->_redirectAlias;
	}
}

