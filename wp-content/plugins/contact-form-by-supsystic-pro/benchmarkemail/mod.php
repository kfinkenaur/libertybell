<?php
class benchmarkemailCfs extends moduleCfs {
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('subDestList', array($this, 'addSubDestList'));
		dispatcherCfs::addAction('afterFormUpdate', array($this, 'saveUsernamePassword'));
	}
	public function isSupported() {
		return function_exists('curl_setopt');
	}
	public function addSubDestList($subDestList) {
		$subDestList['benchmarkemail'] = array('label' => __('Benchmark', CFS_LANG_CODE), 'require_confirm' => false);
		return $subDestList;
	}
	public function saveUsernamePassword($d = array()) {
		if(isset($d['sub_be_login'])) {
			$this->getModel()->setApiUsername( $d['sub_be_login'] );
		}
		if(isset($d['sub_be_pass'])) {
			$this->getModel()->setApiPassword( $d['sub_be_pass'] );
		}
	}
}

