<?php
class get_responseCfs extends moduleCfs {
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('subDestList', array($this, 'addSubDestList'));
	}
	public function isSupported() {
		return function_exists('curl_setopt');
	}
	public function addSubDestList($subDestList) {
		$subDestList['get_response'] = array('label' => __('GetResponse', CFS_LANG_CODE), 'require_confirm' => false);
		return $subDestList;
	}
}

