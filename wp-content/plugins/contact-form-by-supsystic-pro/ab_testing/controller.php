<?php
class ab_testingControllerCfs extends controllerCfs {
	private $_useFormsModel = false;
	public function create() {
		$res = new responseCfs();
		if($this->getModel()->create(reqCfs::get('post'))) {
			$res->addMessage(__('Done', CFS_LANG_CODE));
		} else
			$res->pushError ($this->getModel()->getErrors());
		$res->ajaxExec();
	}
	public function getListForTbl() {
		$this->_useFormsModel = true;
		$this->getModule()->setListForBaseId( (int)reqCfs::getVar('base_id') );
		//parent::getListForTbl();
		frameCfs::_()->getModule('forms')->getController()->getListForTbl();
	}
	public function clear() {
		$res = new responseCfs();
		if($this->getModel()->clearForBase(reqCfs::getVar('base_id', 'post'))) {
			$res->addMessage(__('Done', CFS_LANG_CODE));
		} else
			$res->pushError($this->getModel()->getErrors());
		$res->ajaxExec();
	}
	public function getModel($name = '') {
		if($this->_useFormsModel) {
			$model = frameCfs::_()->getModule('forms')->getModel();
			return $model;
		}
		return parent::getModel( $name );
	}
	public function getPermissions() {
		return array(
			CFS_USERLEVELS => array(
				CFS_ADMIN => array('create', 'getListForTbl', 'clear')
			),
		);
	}
}

