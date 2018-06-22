<?php
class ab_testingViewCfs extends viewCfs {
	public function getFormEditTab($form) {
		frameCfs::_()->getModule('templates')->loadJqGrid();
		frameCfs::_()->addScript('admin.ab_testing', $this->getModule()->getModPath(). 'js/admin.ab_testing.js');
		frameCfs::_()->addJSVar('admin.ab_testing', 'cfsAbTblDataUrl', uriCfs::mod('ab_testing', 'getListForTbl', array('reqType' => 'ajax', 'base_id' => $form['id'])));
		
		$this->assign('form', $form);
		add_action('admin_footer', array($this, 'showAdNewForm'));
		return parent::getContent('abFormEditTab');
	}
	/**
	 * For show be on footer - as in other case it will be in base form edit form - and this is incorrect for HTML: have child form element in other form element
	 */
	public function showAdNewForm() {
		parent::display('abNewForm');
	}
	public function displayEditFormControls($baseId) {
		$this->assign('editBaseLink', frameCfs::_()->getModule('forms')->getEditLink( $baseId, 'cfsFormAbTesting' ));
		parent::display('abEditFormControls');
	}
}
