<?php 
class jetpackCfs extends moduleCfs {
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('subDestList', array($this, 'addSubDestList'));
	}
	public function addSubDestList($subDestList) {
		$subDestList['jetpack'] = array('label' => __('Jetpack', CFS_LANG_CODE), 'require_confirm' => true);
		return $subDestList;
	}
	public function isSupported() {
		return class_exists('Jetpack') && class_exists('Jetpack_Subscriptions');
	}
}