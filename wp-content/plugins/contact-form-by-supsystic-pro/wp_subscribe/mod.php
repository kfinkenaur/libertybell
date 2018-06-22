<?php 
class wp_subscribeCfs extends moduleCfs {
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('subDestList', array($this, 'addSubDestList'));
	}
	public function addSubDestList($subDestList) {
		$subDestList['wp_subscribe'] = array('label' => __('WordPress', CFS_LANG_CODE), 'require_confirm' => true);
		return $subDestList;
	}
	public function getAvailableUserRolesForSelect() {
		global $wp_roles;
		$res = array();
		$allRoles = $wp_roles->roles;
		$editableRoles = apply_filters('editable_roles', $allRoles);
		
		if(!empty($editableRoles)) {
			foreach($editableRoles as $role => $data) {
				if(in_array($role, array('administrator', 'editor'))) continue;
				if($role == 'subscriber') {	// Subscriber - at the begining of array
					$res = array($role => $data['name']) + $res;
				} else {
					$res[ $role ] = $data['name'];
				}
			}
		}
		return $res;
	}
	public function isSupported() {
		return true;
	}
	public function install() {
		if (!dbCfs::exist("@__subscribers")) {
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			  dbDelta(dbCfs::prepareQuery("CREATE TABLE `@__subscribers` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`username` VARCHAR(128) NULL DEFAULT NULL,
				`email` VARCHAR(128) NOT NULL,
				`hash` VARCHAR(128) NOT NULL,
				`activated` TINYINT(1) NOT NULL DEFAULT '0',
				`form_id` int(11) NOT NULL DEFAULT '0',
				`date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				`all_data` TEXT NOT NULL,
				PRIMARY KEY (`id`)
			  ) DEFAULT CHARSET=utf8;"));
		}
	}
	public function activate() {
		$this->install();
	}
}