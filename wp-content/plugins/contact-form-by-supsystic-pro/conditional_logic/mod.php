<?php
class conditional_logicCfs extends moduleCfs {
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('formsEditTabs', array($this, 'addEditTab'));
		dispatcherCfs::addAction('formBeforeShow', array($this, 'checkShowForForm'));
		dispatcherCfs::addFilter('sendContactTo', array($this, 'sendContactTo'), 10, 3);
	}
	public function addEditTab( $tabs ) {
		$tabs['cfsFormConditionalLogic'] = array(
			'title' => __('Conditional Logic', CFS_LANG_CODE), 
			'content' => $this->getMainFormConditionalLogicTab(),
			'fa_icon' => 'fa-flask',
			'sort_order' => 90,
		);
		return $tabs;
	}
	public function getMainFormConditionalLogicTab() {
		return $this->getView()->getMainFormTab();
	}
	public function checkShowForForm( $form ) {
		if(isset($form['params']) 
			&& isset($form['params']['cl']) 
			&& !empty($form['params']['cl'])
		) {
			frameCfs::_()->addScript(CFS_CODE. '.frontend.'. $this->getCode(), $this->getModPath(). 'js/frontend.'. $this->getCode(). '.js');
			$clData = array();
			foreach($form['params']['cl'] as $cl) {
				if(isset($cl['cond']) && !empty($cl['cond'])) {
					foreach($cl['cond'] as $cond) {
						if(isset($cond['type']) 
							&& $cond['type'] == 'user' 
						) {
							switch($cond['user_type']) {
								case 'country':
									if(!isset($clData['country'])) {
										$clData['country'] = strtoupper( $this->_getCountryCode() );	// We store it in upper case in database
									}
									break;
								case 'lang':
									if(!isset($clData['lang'])) {
										$clData['lang'] = strtolower( utilsCfs::getBrowserLangCode() );	// We store it in lower case in database
									}
									break;
							}
						}
					}
				}
			}
			frameCfs::_()->addJSVar(CFS_CODE. '.frontend.'. $this->getCode(), 'cfsClData_'. $form['id'], $clData);
		}
	}
	private function _getCountryCode() {
		if(!class_exists('SxGeo')) {
			importClassCfs('SxGeo', CFS_HELPERS_DIR. 'SxGeo.php');
			$sxGeo = new SxGeo(CFS_FILES_DIR. 'SxGeo.dat');
		}
		return $sxGeo->getCountry( utilsCfs::getIP () );
	}
	public function sendContactTo( $to, $fieldsData, $form ) {
		if(isset($form['params']) 
			&& isset($form['params']['cl']) 
			&& !empty($form['params']['cl'])
			&& isset($fieldsData['cfs_cl_save_321'])
		) {
			$clSave = array();
			$clSaveStrs = explode('|', $fieldsData['cfs_cl_save_321']);
			if(!empty($clSaveStrs)) {
				foreach($clSaveStrs as $clS) {
					$clD = explode('=', $clS);
					$clSave[ $clD[0] ] = (int) $clD[1];
				}
			}
			foreach($form['params']['cl'] as $id => $cl) {
				if(isset($clSave[ $id ]) && $clSave[ $id ]) {
					if(isset($cl['logic'])) {
						foreach($cl['logic'] as $l) {
							if($l['type'] == 'sendto' && !empty($l['sendto'])) {
								$to = trim( $l['sendto'] );
							}
						}
					}
				}
			}
		}
		return $to;
	}
}

