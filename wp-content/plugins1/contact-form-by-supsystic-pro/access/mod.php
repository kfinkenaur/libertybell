<?php
class accessCfs extends moduleCfs {
	private $_accessRoles = array();
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('adminMenuAccessCap', array($this, 'modifyAccessCap'));
		dispatcherCfs::addFilter('formListBeforeRender', array($this, 'checkFormListBeforeRender'));
	}
	public function modifyAccessCap($mainCap) {
		if($this->onlyForAdmin()) {
			return $mainCap;
		}
		$accessRoles = $this->getAccessRolesList();
		$inCaps = array();
		$ignoreCaps = array('edit_plugins');
		foreach($accessRoles as $role) {
			$allRoleData = get_role( $role );
			if($allRoleData && $allRoleData->capabilities) {
				$roleInCaps = array();
				foreach($allRoleData->capabilities as $cKey => $cVal) {
					if($cVal && !in_array($cKey, $ignoreCaps)) {
						$roleInCaps[] = $cKey;
					}
				}
				if(empty($inCaps))
					$inCaps = $roleInCaps;
				else
					$inCaps = array_intersect ($inCaps, $roleInCaps);
			}
		}
		if(!empty($inCaps))
			return array_shift($inCaps);
		return false;
	}
	public function onlyForAdmin() {
		$accessRoles = $this->getAccessRolesList();
		if(empty($accessRoles) || count($accessRoles) == 1 && in_array('administrator', $accessRoles))
			return true;
		return false;
	}
	public function getAccessRolesList() {
		if(empty($this->_accessRoles)) {
			$this->_accessRoles = frameCfs::_()->getModule('options')->get('access_roles');
			if(empty($this->_accessRoles) || !is_array($this->_accessRoles))
				$this->_accessRoles = array();
			if(!in_array('administrator', $this->_accessRoles))	// Admin should always have access to plugin
				$this->_accessRoles[] = 'administrator';
		}
		return $this->_accessRoles;
	}
	public function checkFormListBeforeRender($forms) {
		if(!empty($forms)) {
			$currentUserRole = NULL;
			$dataRemoved = false;
			foreach($forms as $i => $p) {
				if(isset($p['params']['main']['hide_for_user_roles'])
					&& !empty($p['params']['main']['hide_for_user_roles'])
				) { // Check if form need to be hidden for some user roles
					if(is_null($currentUserRole)) {
						$currentUserRole = utilsCfs::getCurrentUserRole();
					}
					
					$hideShowRevert = isset($p['params']['main']['hide_for_user_roles_show']) && (int) $p['params']['main']['hide_for_user_roles_show'];
					if(((!$hideShowRevert && in_array($currentUserRole, $p['params']['main']['hide_for_user_roles'])) 
						|| ($hideShowRevert && (!in_array($currentUserRole, $p['params']['main']['hide_for_user_roles']) || !$currentUserRole))
					)) {
						unset($forms[ $i ]);
						$dataRemoved = true;
					}
				}
			}
			if($dataRemoved) {
				$forms = array_values( $forms );
			}
		}
		return $forms;
	}
}

