<?php
class aweberViewCfs extends viewCfs {
	public function generateAdminFields($form) {
		$isSupported = $this->getModule()->isSupported();
		if($isSupported) {
			$isLoggedIn = $this->getModel()->isLoggedIn();
			if($isLoggedIn) {
				$this->assign('form', $form);
				frameCfs::_()->addScript('admin.'. $this->getCode(), $this->getModule()->getModPath(). 'js/admin.'. $this->getCode(). '.js');
			} else {
				/*$keySecret = isset($form['params']['tpl']['sub_aw_c_key'], $form['params']['tpl']['sub_aw_c_secret'])
					 && !empty($form['params']['tpl']['sub_aw_c_key']) && !empty($form['params']['tpl']['sub_aw_c_secret'])
					? array('key' => $form['params']['tpl']['sub_aw_c_key'], 'secret' => $form['params']['tpl']['sub_aw_c_secret'])
					: false;*/
				$authUrl = '';
				$keySecret = $this->getModel()->getKeySecret();
				//if(!empty($keySecret)) {
					$authUrl = $this->getModel()->getAuthUrl();
				//}
				$this->assign('clbUrl', $this->getModel()->getClbUrl());
				$this->assign('authUrl', $authUrl);
				$this->assign('keySecret', $keySecret);
				frameCfs::_()->addScript('admin.'. $this->getCode(). '.auth', $this->getModule()->getModPath(). 'js/admin.'. $this->getCode(). '.auth.js');
			}
			$this->assign('isLoggedIn', $isLoggedIn);
		}
		$this->assign('isSupported', $isSupported);
		return parent::getContent('awbAdminFields');
	}
}