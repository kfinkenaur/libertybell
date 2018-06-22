<?php
class vtigerViewPps extends viewPps {
	public function generateAdminFields($popup) {
		$isSupported = $this->getModule()->isSupported();
		if($isSupported) {
			$this->assign('popup', $popup);
		}
		$this->assign('isSupported', $isSupported);
		$this->assign('helpImgLink', $this->getModule()->getModPath(). 'img/help.jpg');
		return parent::getContent('vtigAdminFields');
	}
}