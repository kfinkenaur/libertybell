<?php
class myemmaCfs extends moduleCfs {
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('subDestList', array($this, 'addSubDestList'));
	}
	public function addSubDestList($subDestList) {
		$subDestList['myemma'] = array('label' => __('Emma', CFS_LANG_CODE), 'require_confirm' => false);
		return $subDestList;
	}
	public function isSupported() {
		return function_exists('curl_setopt');
	}
}

