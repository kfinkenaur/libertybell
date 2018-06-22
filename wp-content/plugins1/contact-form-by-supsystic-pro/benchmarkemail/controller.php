<?php
class benchmarkemailControllerCfs extends controllerCfs {
	public function getLists() {
		$res = new responseCfs();
		$this->getModule()->saveUsernamePassword(reqCfs::get('post'));
		if(($lists = $this->getModel()->getLists(reqCfs::get('post'))) !== false) {
			$res->addData('lists', $lists);
		} else
			$res->pushError ($this->getModel()->getErrors());
		return $res->ajaxExec();
	}
	public function getPermissions() {
		return array(
			CFS_USERLEVELS => array(
				CFS_ADMIN => array('getLists')
			),
		);
	}
}