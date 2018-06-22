<?php
class infusionsoftViewCfs extends viewCfs {
	public function generateAdminFields($form) {
		$isSupported = $this->getModule()->isSupported();
		if($isSupported) {
			$isAutentificated = $this->getModel()->isAutentificated();
			if($isAutentificated) {
				$this->assign('form', $form);
				frameCfs::_()->addScript('admin.'. $this->getCode(), $this->getModule()->getModPath(). 'js/admin.'. $this->getCode(). '.js');
			} else {
				$this->assign('authUrl', $this->getModel()->getAuthUrl());
			}
			$this->assign('isAutentificated', $isAutentificated);
		}
		$this->assign('isSupported', $isSupported);
		return parent::getContent('isAdminFields');
	}
}