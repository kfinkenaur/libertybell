<?php
class verticalresponseControllerCfs extends controllerCfs {
	public function saveAccessToken() {
		$errors = array();
		$data = reqCfs::get('get');
		$reqUriArr = explode('/', reqCfs::getRequestUri());
		$formId = (int) $reqUriArr[ count($reqUriArr) - 1 ];	// Last part of uri: lalala/ololo/ID
		$data['id'] = $formId;
		if(!$this->getModel()->saveAccessToken($data)) {
			$errors = $this->getModel()->getErrors();
		}
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