<?php
class mailpoetViewCfs extends viewCfs {
	public function generateAdminFields($form) {
		$isSupported = $this->getModule()->isSupported();
		if($isSupported) {
			$mailPoetLists = WYSIJA::get('list', 'model')->get(array('name', 'list_id'), array('is_enabled' => 1));
			$mailPoetListsSelect = array();
			if(!empty($mailPoetLists)) {
				foreach($mailPoetLists as $l) {
					$mailPoetListsSelect[ $l['list_id'] ] = $l['name'];
				}
			}
			$this->assign('mailPoetListsSelect', $mailPoetListsSelect);
			$this->assign('form', $form);
		}
		$this->assign('isSupported', $isSupported);
		return parent::getContent('mptAdminFields');
	}
}