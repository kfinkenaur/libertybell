<?php
class ab_testingCfs extends moduleCfs {
	private $_getListForBase = 0;
	private $_currBaseId = 0;
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('formsEditTabs', array($this, 'addFormEditTab'), 10, 2);	// Add AB tab
		dispatcherCfs::addFilter('formIdBeforeShow', array($this, 'formIdBeforeShowCheck'));
		dispatcherCfs::addAction('beforeFormEdit', array($this, 'addTopBtns'));
		dispatcherCfs::addFilter('formStatsSorted', array($this, 'addFormAbStats'), 10, 3);	// Add statistics from AB tests
	}
	public function addFormEditTab( $tabs, $form ) {
		if(empty($form['ab_id'])) {	// Do not add AB Testing tab - for AB Test forms
			$tabs['cfsFormAbTesting'] = array(
				'title' => __('Testing', CFS_LANG_CODE), 
				'content' => $this->getView()->getFormEditTab( $form ),
				'icon_content' => '<b>A/B</b>',
				'avoid_hide_icon' => true,
				'sort_order' => 55,
			);
		}
		return $tabs;
	}
	public function getAdIdsList( $id, $params = array() ) {
		$where = array('ab_id' => $id, 'active' => 1);
		if(isset($params['with_labels']) && $params['with_labels']) {
			return frameCfs::_()->getTable('forms')->get('id, label', $where);
		} else {
			return frameCfs::_()->getTable('forms')->get('id', $where, '', 'col');
		}
	}
	public function formIdBeforeShowCheck( $id ) {
		$abIds = $this->getAdIdsList( $id );
		if(!empty($abIds)) {	// Have some test forms
			// Basic form id will be included in lottery here
			$abIds[] = $id;
			return $abIds[ mt_rand(0, (count($abIds) - 1)) ];
		}
		return $id;
 	}
	public function setListForBaseId($id) {
		$this->_getListForBase = $id;
	}
	public function getListForBaseId() {
		return $this->_getListForBase;
	}
	public function addTopBtns($form) {
		if(isset($form['ab_id']) && !empty($form['ab_id'])) {	// Is AB testing form
			$this->_currBaseId = $form['ab_id'];
			dispatcherCfs::addAction('beforeAdminBreadcrumbs', array($this, 'showEditFormFormControls'));
			dispatcherCfs::addFilter('mainBreadcrumbs', array($this, 'mainBreadcrumbsClear'));
		}
	}
	public function mainBreadcrumbsClear($breadcrumbs) {
		if(!empty($this->_currBaseId)) {
			$breadcrumbs = array();	// No breadcrumbs - for AB test forms
		}
		return $breadcrumbs;
	}
	public function showEditFormFormControls() {
		$this->getView()->displayEditFormControls( $this->_currBaseId );
	}
	public function addAbTestStats($allStats, $form) {
		if(empty($form['ab_id'])) {	// Is not AB testing form
			$abForms = frameCfs::_()->getModule('forms')->getModel()->addWhere(array('ab_id' => $form['id']))->getFromTbl();
			if(!empty($abForms)) {
				$statModel = frameCfs::_()->getModule('statistics')->getModel();
				if(!empty($allStats)) {
					// Change initial form name in graphs
					foreach($allStats as $i => $stat) {
						$allStats[ $i ]['label'] = $allStats[ $i ]['label']. ' - '. $form['label'];
					}
				}
				foreach($abForms as $p) {
					$statsForAb = $statModel->getAllForFormId($p['id']);
					if($statsForAb) {
						foreach($statsForAb as $i => $stat) {
							$statsForAb[ $i ]['label'] = $statsForAb[ $i ]['label']. ' - '. $p['label'];
						}
						if(!$allStats) {
							$allStats = array();
						}
						$allStats = array_merge($allStats, $statsForAb);
					}
				}
			}
		}
		return $allStats;
	}
	public function addFormAbStats($allStats, $id, $params) {
		//var_dump($allStats, $id, $params);exit();
		$abIdsLabels = $this->getAdIdsList( $id, array('with_labels' => true) );
		if(!empty($abIdsLabels)) {	// Have some test forms
			$statsModel = frameCfs::_()->getModule('statistics')->getModel();
			foreach($abIdsLabels as $abForm) {
				$abStats = $statsModel->getAllForFormSorted($abForm['id'], $params);
				if($abStats) {
					foreach($abStats as $iAbStat => $abStat) {
						$abStats[ $iAbStat ]['label'] .= ' ['. $abForm['label']. ']';
					}
					$allStats = array_merge($allStats, $abStats);
				}
			}
		}
		return $allStats;
	}
}

