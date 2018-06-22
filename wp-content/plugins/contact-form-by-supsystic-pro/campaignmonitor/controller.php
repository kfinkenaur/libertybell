<?php
class campaignmonitorControllerCfs extends controllerCfs {
	public function saveAccessToken() {
		$errors = array();
		if(!$this->getModel()->saveAccessToken(reqCfs::get('get'))) {
			$errors = $this->getModel()->getErrors();
		}
		$formId = (int) reqCfs::getVar('id');
		$redirectUrl = $formId ? frameCfs::_()->getModule('forms')->getEditLink( $formId ) : frameCfs::_()->getModule('options')->getTabUrl('forms');
		$redirectUrlData = array('baseUrl' => $redirectUrl);
		if(!empty($errors)) {
			$redirectUrlData['cfsErrors'] = $errors;
		}
		redirectCfs( uriCfs::_($redirectUrlData) );
	}
	public function getLists() {
		$res = new responseCfs();
		if(($lists = $this->getModel()->getLists()) !== false) {
			$res->addData('lists', $lists);
			//$res->addData('selected_lists', $this->getModel()->getSyncLists());
		} else
			$res->pushError ($this->getModel()->getErrors());
		return $res->ajaxExec();
	}
	public function getPermissions() {
		return array(
			CFS_USERLEVELS => array(
				CFS_ADMIN => array('saveAccessToken', 'getLists')
			),
		);
	}
}