<?php
class feedblitzCfs extends moduleCfs {
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('subDestList', array($this, 'addSubDestList'));
	}
	public function addSubDestList($subDestList) {
		$subDestList['feedblitz'] = array('label' => __('FeedBlitz', CFS_LANG_CODE), 'require_confirm' => true);
		return $subDestList;
	}
	public function isSupported() {
		return true;
	}
}

