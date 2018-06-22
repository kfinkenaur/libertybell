<?php
class wp_subscribeViewCfs extends viewCfs {
	public function generateAdminFields($form) {
		$isSupported = $this->getModule()->isSupported();
		if($isSupported) {
			$this->assign('availableUserRoles', $this->getModule()->getAvailableUserRolesForSelect());
			$this->assign('wpCsvExportUrl', uriCfs::mod('wp_subscribe', 'getWpCsvList', array('id' => $form['id'])));
			$this->assign('form', $form);
		}
		$this->assign('isSupported', $isSupported);
		return parent::getContent('wpsubAdminFields');
	}
	public function displaySuccessPage($form, $res, $forReg = false) {
		$this->assign('form', $form);
		$this->assign('res', $res);
		$this->assign('forReg', $forReg);
		parent::display('subSuccessPage');
	}
}