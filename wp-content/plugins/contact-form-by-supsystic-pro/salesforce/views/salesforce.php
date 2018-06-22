<?php
class salesforceViewCfs extends viewCfs {
	public function generateAdminFields($form) {
		$isSupported = $this->getModule()->isSupported();
		if($isSupported) {
			$this->assign('form', $form);
			frameCfs::_()->addScript('admin.'. $this->getCode(), $this->getModule()->getModPath(). 'js/admin.'. $this->getCode(). '.js');
		}
		$this->assign('helpImgUrl', $this->getModule()->getModPath(). 'img/help.jpg');
		$this->assign('isSupported', $isSupported);
		return parent::getContent('sfAdminFields');
	}
}