<?php
class sgautorepondeurViewCfs extends viewCfs {
	public function generateAdminFields($form) {
		$isSupported = $this->getModule()->isSupported();
		if($isSupported) {
			$this->assign('form', $form);
		}
		$this->assign('isSupported', $isSupported);
		return parent::getContent('sgaAdminFields');
	}
}