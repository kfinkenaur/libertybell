<?php
class verticalresponseViewCfs extends viewCfs {
	public function generateAdminFields($form) {
		$isSupported = $this->getModule()->isSupported();
		if($isSupported) {
			$isLoggedIn = $this->getModule()->isLoggedIn();
			$this->assign('form', $form);
			$this->assign('isLoggedIn', $isLoggedIn);
			if($isLoggedIn) {
				frameCfs::_()->addScript('admin.'. $this->getCode(), $this->getModule()->getModPath(). 'js/admin.'. $this->getCode(). '.js');
			} else {
				$this->assign('authUrl', $this->getModel()->getAuthUrl( $form['id'] ));
			}
		}
		$this->assign('isSupported', $isSupported);
		return parent::getContent('vrAdminFields');
	}
}