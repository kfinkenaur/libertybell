<?php 
class mailpoetCfs extends moduleCfs {
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('subDestList', array($this, 'addSubDestList'));
	}
	public function addSubDestList($subDestList) {
		$subDestList['mailpoet'] = array('label' => __('MailPoet', CFS_LANG_CODE), 'require_confirm' => true);
		return $subDestList;
	}
	public function isSupported() {
		return class_exists('WYSIJA');
	}
}