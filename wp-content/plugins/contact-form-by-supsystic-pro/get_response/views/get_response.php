<?php
class get_responseViewCfs extends viewCfs {
	public function generateAdminFields($form) {
		$isSupported = $this->getModule()->isSupported();
		if($isSupported) {
			// TODO: Correct this link
			$this->assign('helpImgLink', $this->getModule()->getModPath(). 'img/help.jpg');
			$this->assign('form', $form);
			frameCfs::_()->addScript('admin.'. $this->getCode(), $this->getModule()->getModPath(). 'js/admin.'. $this->getCode(). '.js');
		}
		$this->assign('isSupported', $isSupported);
		return parent::getContent('grAdminFields');
	}
}