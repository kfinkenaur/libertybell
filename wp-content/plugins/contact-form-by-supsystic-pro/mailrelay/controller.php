<?php
class mailrelayControllerCfs extends controllerCfs {
	public function getLists() {
		$res = new responseCfs();
		$this->getModule()->saveHostKey(reqCfs::get('post'));
		if(($lists = $this->getModel()->getLists()) !== false) {
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