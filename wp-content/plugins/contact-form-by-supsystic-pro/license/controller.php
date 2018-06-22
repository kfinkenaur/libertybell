<?php
class licenseControllerCfs extends controllerCfs {
	public function activate() {
		$res = new responseCfs();
		if($this->getModel()->activate(reqCfs::get('post'))) {
			$res->addMessage(__('Done', CFS_LANG_CODE));
		} else
			$res->pushError ($this->getModel()->getErrors());
		$res->ajaxExec();
	}
	public function getPermissions() {
		return array(
			CFS_USERLEVELS => array(
				CFS_ADMIN => array('activate')
			),
		);
	}
}

