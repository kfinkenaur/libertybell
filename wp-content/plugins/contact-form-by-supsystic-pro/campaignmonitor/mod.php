<?php
class campaignmonitorCfs extends moduleCfs {
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('subDestList', array($this, 'addSubDestList'));
	}
	public function addSubDestList($subDestList) {
		$subDestList['campaignmonitor'] = array('label' => __('Campaign Monitor', CFS_LANG_CODE), 'require_confirm' => false);
		return $subDestList;
	}
	public function isLoggedIn() {
		return $this->getModel()->isLoggedIn();
	}
	public function isSupported() {
		return true;
	}
}

