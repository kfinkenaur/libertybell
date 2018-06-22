<?php
class infusionsoftControllerCfs extends controllerCfs {
	public function getPermissions() {
		return array(
			CFS_USERLEVELS => array(
				CFS_ADMIN => array('getLists')
			),
		);
	}
}