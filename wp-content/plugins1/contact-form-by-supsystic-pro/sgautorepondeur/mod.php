<?php
class sgautorepondeurCfs extends moduleCfs {
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('subDestList', array($this, 'addSubDestList'));
	}
	public function addSubDestList($subDestList) {
		$subDestList['sgautorepondeur'] = array('label' => __('SG Autorepondeur', CFS_LANG_CODE), 'require_confirm' => false);
		return $subDestList;
	}
	public function isLoggedIn() {
		return $this->getModel()->isLoggedIn();
	}
	public function isSupported() {
		return true;
	}
}

