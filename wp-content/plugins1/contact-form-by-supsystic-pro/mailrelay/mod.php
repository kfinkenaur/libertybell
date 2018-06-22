<?php
class mailrelayCfs extends moduleCfs {
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('subDestList', array($this, 'addSubDestList'));
		dispatcherCfs::addAction('afterFormUpdate', array($this, 'saveHostKey'));
	}
	public function addSubDestList($subDestList) {
		$subDestList['mailrelay'] = array('label' => __('Mailrelay', CFS_LANG_CODE), 'require_confirm' => false);
		return $subDestList;
	}
	public function isLoggedIn() {
		return $this->getModel()->isLoggedIn();
	}
	public function isSupported() {
		return true;
	}
	public function saveHostKey($d = array()) {
		if(isset($d['sub_mr_api_host'])) {
			$this->getModel()->setApiHost( $d['sub_mr_api_host'] );
		}
		if(isset($d['sub_mr_api_key'])) {
			$this->getModel()->setApiKey( $d['sub_mr_api_key'] );
		}
	}
}

