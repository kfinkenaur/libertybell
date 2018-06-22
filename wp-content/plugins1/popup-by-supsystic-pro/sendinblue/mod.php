<?php
class sendinbluePps extends modulePps {
	public function init() {
		parent::init();
		dispatcherPps::addFilter('subDestList', array($this, 'addSubDestList'));
	}
	public function isSupported() {
		return function_exists('curl_setopt');
	}
	public function addSubDestList($subDestList) {
		$subDestList['sendinblue'] = array('label' => __('SendinBlue', PPS_LANG_CODE), 'require_confirm' => false);
		return $subDestList;
	}
}

