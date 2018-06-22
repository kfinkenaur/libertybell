<?php
class sendinblueViewCfs extends viewCfs {
	public function generateAdminFields($form) {
		$isSupported = $this->getModule()->isSupported();
		if($isSupported) {
			$this->assign('form', $form);
			frameCfs::_()->addScript('admin.'. $this->getCode(), $this->getModule()->getModPath(). 'js/admin.'. $this->getCode(). '.js');
		}
		$this->assign('isSupported', $isSupported);
		$this->assign('helpImgLink', $this->getModule()->getModPath(). 'img/help.jpg');
		return parent::getContent('sbAdminFields');
	}
}