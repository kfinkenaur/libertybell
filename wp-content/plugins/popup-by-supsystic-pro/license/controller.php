<?php
class licenseControllerPps extends controllerPps {
	public function activate() {
		$res = new responsePps();
		if($this->getModel()->activate(reqPps::get('post'))) {
			$res->addMessage(__('Done', PPS_LANG_CODE));
		} else
			$res->pushError ($this->getModel()->getErrors());
		$res->ajaxExec();
	}
	public function dismissNotice() {
		$res = new responsePps();
		framePps::_()->getModule('options')->getModel()->save('dismiss_pro_opt', 1);
		$res->ajaxExec();
	}
	public function getPermissions() {
		return array(
			PPS_USERLEVELS => array(
				PPS_ADMIN => array('activate', 'dismissNotice')
			),
		);
	}
}

