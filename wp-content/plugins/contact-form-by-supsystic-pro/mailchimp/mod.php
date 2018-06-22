<?php 
class mailchimpCfs extends moduleCfs {
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('subDestList', array($this, 'addSubDestList'));
	}
	public function addSubDestList($subDestList) {
		$subDestList['mailchimp'] = array('label' => __('MailChimp', CFS_LANG_CODE), 'require_confirm' => true);
		return $subDestList;
	}
	public function isSupported() {
		if(!function_exists('curl_init')) {
			return false;
		}
		return true;
	}
}