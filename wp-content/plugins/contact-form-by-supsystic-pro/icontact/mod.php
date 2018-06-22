<?php
class icontactCfs extends moduleCfs {
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('subDestList', array($this, 'addSubDestList'));
	}
	public function isSupported() {
		return function_exists('curl_setopt');
	}
	public function addSubDestList($subDestList) {
		$subDestList['icontact'] = array('label' => __('iContact', CFS_LANG_CODE), 'require_confirm' => false);
		return $subDestList;
	}
}

