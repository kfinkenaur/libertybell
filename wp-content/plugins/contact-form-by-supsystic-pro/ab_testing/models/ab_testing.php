<?php
class ab_testingModelCfs extends modelCfs {
	public function create($d = array()) {
		$d['label'] = isset($d['label']) ? trim($d['label']) : '';
		$d['base_id'] = isset($d['base_id']) ? (int) $d['base_id'] : 0;
		if($d['base_id']) {
			if(!empty($d['label'])) {
				$formModel = frameCfs::_()->getModule('forms')->getModel();
				$base = $formModel->getById($d['base_id']);
				unset($base['id']);
				$base['label'] = $d['label'];
				$base['ab_id'] = $d['base_id'];
				if($formModel->insertFromOriginal( $base )) {
					return true;
				} else
					$this->pushError( $formModel->getErrors() );
			} else
				$this->pushError(__('Enter Name', CFS_LANG_CODE), 'label');
		} else
			$this->pushError(__('Empty Base ID', CFS_LANG_CODE));
		return false;
	}
	public function clearForBase($baseId) {
		$baseId = (int) $baseId;
		if($baseId) {
			$formModel = frameCfs::_()->getModule('forms')->getModel();
			if($formModel->delete(array('ab_id' => $baseId))) {
				return true;
			} else
				$this->pushError( $formModel->getErrors() );
		} else
			$this->pushError(__('Empty Base ID', CFS_LANG_CODE));
		return false;
	}
}
