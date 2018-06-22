<?php
class mailchimpControllerCfs extends controllerCfs {
	public function getLists() {
		$res = new responseCfs();
		if(($lists = $this->getModel()->getLists(reqCfs::get('post'))) !== false) {
			$res->addData('lists', $lists);
		} else
			$res->pushError ($this->getModel()->getErrors());
		return $res->ajaxExec();
	}
	public function getGroups() {
		$res = new responseCfs();
		if(($groups = $this->getModel()->getGroups(reqCfs::get('post'))) !== false) {
			$res->addData('groups', $groups);
		} else
			$res->pushError ($this->getModel()->getErrors());
		return $res->ajaxExec();
	}
	public function getPermissions() {
		return array(
			CFS_USERLEVELS => array(
				CFS_ADMIN => array('getLists', 'getGroups')
			),
		);
	}
}

