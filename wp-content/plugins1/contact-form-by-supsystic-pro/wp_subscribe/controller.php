<?php
class wp_subscribeControllerCfs extends controllerCfs {
	public function getWpCsvList() {
		$id = (int) reqCfs::getVar('id');
		$forReg = (int) reqCfs::getVar('for_reg');
		$form = frameCfs::_()->getModule('forms')->getModel()->getById( $id );

		importClassCfs('filegeneratorCfs');
		importClassCfs('csvgeneratorCfs');

		$fileTitle = $forReg 
			? sprintf(__('Registered from %s', CFS_LANG_CODE), htmlspecialchars( $form['label'] )) 
			: sprintf(__('Subscribed to %s', CFS_LANG_CODE), htmlspecialchars( $form['label'] ));
		$csvGenerator = new csvgeneratorCfs( $fileTitle );
		$labels = array(
			'username' => __('Username', CFS_LANG_CODE),
			'email' => __('Email', CFS_LANG_CODE),
		);
		// Add additional subscribe fields
		if(isset($form['params']['fields']) && !empty($form['params']['fields'])) {
			foreach($form['params']['fields'] as $f) {
				$k = $f['name'];
				if(in_array($k, array('name', 'email'))) continue;	// Ignore standard fields
				$labels[ 'sub_field_'. $k ] = $f['label'];
			}
		}
		$labels = array_merge($labels, array(
			'activated' => __('Activated', CFS_LANG_CODE),
			'form_id' => __('Form ID', CFS_LANG_CODE),
			'date_created' => __('Date Created', CFS_LANG_CODE),
		));
		$selectFields = array('all_data');
		foreach($labels as $lKey => $lName) {
			if(strpos($lKey, 'sub_field_') === 0) continue;
			$selectFields[] = $lKey;
		}
		$model = $forReg ? frameCfs::_()->getModule('login')->getModel() : $this->getModel();
		$list = $model->setSelectFields( $selectFields )->setWhere(array('form_id' => $id))->getFromTbl();
		$row = $cell = 0;
		foreach($labels as $l) {
			$csvGenerator->addCell($row, $cell, $l);
			$cell++;
		}
		$row = 1;
		if(!empty($list)) {
			foreach($list as $s) {
				$cell = 0;
				foreach($labels as $k => $l) {
					$getKey = $k;
					if(strpos($getKey, 'sub_field_') === 0) {
						$getKey = str_replace('sub_field_', '', $getKey);
						$allData = empty($s['all_data']) ? array() : utilsCfs::unserialize($s['all_data']);
						$value = isset($allData[ $getKey ]) ? $allData[ $getKey ] : '';
					} else {
						$value = $s[ $getKey ];
					}
					$csvGenerator->addCell($row, $cell, $value);
					$cell++;
				}
				$row++;
			}
		} else {
			$cell = 0;
			$noUsersMsg = $forReg 
				? __('There are no members for now', CFS_LANG_CODE) 
				: __('There are no subscribers for now', CFS_LANG_CODE);
			$csvGenerator->addCell($row, $cell, $noUsersMsg);
		}
		$csvGenerator->generate();
	}
	public function confirm() {
		$res = new responseCfs();
		$forReg = (int) reqCfs::getVar('for_reg', 'get');
		if(!$this->getModel()->confirm(reqCfs::get('get'), $forReg)) {
			$res->pushError ($this->getModel()->getErrors());
		}
		$lastForm = $this->getModel()->getLastForm();
		$this->getView()->displaySuccessPage($lastForm, $res, $forReg);
		exit();
	}
	public function getPermissions() {
		return array(
			CFS_USERLEVELS => array(
				CFS_ADMIN => array('getWpCsvList')
			),
		);
	}
}

