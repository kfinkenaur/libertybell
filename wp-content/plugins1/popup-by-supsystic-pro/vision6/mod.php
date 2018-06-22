<?php
class vision6Pps extends modulePps {
	public function init() {
		parent::init();
		dispatcherPps::addFilter('subDestList', array($this, 'addSubDestList'));
	}
	public function isSupported() {
		return function_exists('stream_context_create') && function_exists('json_encode');
	}
	public function addSubDestList($subDestList) {
		$subDestList['vision6'] = array('label' => __('Vision6', PPS_LANG_CODE), 'require_confirm' => false);
		return $subDestList;
	}
}

