<?php
class salesforceCfs extends moduleCfs {
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('subDestList', array($this, 'addSubDestList'));
	}
	public function isSupported() {
		return function_exists('curl_setopt');
	}
	public function addSubDestList($subDestList) {
		$subDestList['salesforce'] = array('label' => __('SalesForce - Web-to-Lead', CFS_LANG_CODE), 'require_confirm' => false);
		return $subDestList;
	}
}

