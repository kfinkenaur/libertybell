<?php
class arpreachCfs extends moduleCfs {
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('subDestList', array($this, 'addSubDestList'));
	}
	public function addSubDestList($subDestList) {
		$subDestList['arpreach'] = array('label' => __('arpReach', CFS_LANG_CODE), 'require_confirm' => false);
		return $subDestList;
	}
	public function isSupported() {
		return true;
	}
	public function generateFormStart($form, $subDest) {
		return '<form method="post" action="'. (isset($form['params']['tpl']['sub_ar_form_action']) ? $form['params']['tpl']['sub_ar_form_action'] : '').'">';
	}
	public function generateFormEnd($form) {
		return '</form>';
	}
}

