<?php
class subscribeCfs extends moduleCfs {
	private $_destList = array();
	public function init() {
		parent::init();
		dispatcherCfs::addFilter('formsEditTabs', array($this, 'addFormEditTab'), 10, 2);	// Add Subscribe tab
	}
	public function addFormEditTab( $tabs, $form ) {
		$tabs['cfsFormSubscribe'] = array(
			'title' => __('Subscribe', CFS_LANG_CODE), 
			'content' => $this->getView()->getFormEditTab( $form ),
			'fa_icon' => 'fa-users',
			'sort_order' => 50,
		);
		return $tabs;
	}
	public function getDestList() {
		if(empty($this->_destList)) {
			// All subscribe engines will be added in subscripton modules using hook "subDestList"
			$this->_destList = dispatcherCfs::applyFilters('subDestList', array());
		}
		return $this->_destList;
	}
	public function getDestByKey($key) {
		$this->getDestList();
		return isset($this->_destList[ $key ]) ? $this->_destList[ $key ] : false;
	}
}

