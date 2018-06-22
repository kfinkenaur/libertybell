<?php
class sendgridCfs extends moduleCfs {
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('subDestList', array($this, 'addSubDestList'));
		dispatcherCfs::addAction('afterFormUpdate', array($this, 'saveUsernamePassword'));
	}
	public function addSubDestList($subDestList) {
		$subDestList['sendgrid'] = array('label' => __('SendGrid', CFS_LANG_CODE), 'require_confirm' => false);
		return $subDestList;
	}
	public function isLoggedIn() {
		return $this->getModel()->isLoggedIn();
	}
	public function isSupported() {
		return true;
	}
	public function saveUsernamePassword($d = array()) {
		if(isset($d['sub_sg_api_name'])) {
			$this->getModel()->setApiUsername( $d['sub_sg_api_name'] );
		}
		if(isset($d['sub_sg_api_key'])) {
			$this->getModel()->setApiPassword( $d['sub_sg_api_key'] );
		}
	}
}

