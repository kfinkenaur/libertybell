<?php
class conditional_logicViewCfs extends viewCfs {
	public function getMainFormTab() {
		frameCfs::_()->addScript('admin.'. $this->getCode(), $this->getModule()->getModPath(). 'js/admin.'. $this->getCode(). '.js');
		frameCfs::_()->addStyle('admin.'. $this->getCode(), $this->getModule()->getModPath(). 'css/admin.'. $this->getCode(). '.css');
		$this->assign('conditionTypes', array(
			'field' => __('Field', CFS_LANG_CODE),
			'user' => __('User', CFS_LANG_CODE),
		));
		$this->assign('conditionEqs', array(
			'eq' => __('Equal', CFS_LANG_CODE),
			'like' => __('Like', CFS_LANG_CODE),
			'more' => __('More', CFS_LANG_CODE),
			'less' => __('Less', CFS_LANG_CODE),
		));
		$this->assign('booleanEqs', array(
			'or' => __('Or', CFS_LANG_CODE),
			'and' => __('And', CFS_LANG_CODE),
		));
		$this->assign('userConditionTypes', array(
			'country' => __('From', CFS_LANG_CODE),
			'lang' => __('Language', CFS_LANG_CODE),
			'url' => __('URL', CFS_LANG_CODE),
		));
		$this->assign('languages', utilsCfs::getLanguagesForSelect());
		$this->assign('userUrlEqs', array(
			'eq' => __('Equal', CFS_LANG_CODE),
			'like' => __('Like', CFS_LANG_CODE),
		));
		$this->assign('logicTypes', array(
			'field' => __('Field', CFS_LANG_CODE),
			'redirect' => __('Redirect', CFS_LANG_CODE),
			'sendto' => __('Send to', CFS_LANG_CODE),
		));
		$this->assign('logicFieldActions', array(
			'show' => __('Show', CFS_LANG_CODE),
			'hide' => __('Hide', CFS_LANG_CODE),
			'prefill' => __('Set Value', CFS_LANG_CODE),
			'add' => __('Add Value', CFS_LANG_CODE),
			'substruct' => __('Substruct Value', CFS_LANG_CODE),
			'add_currency' => __('Add Currency', CFS_LANG_CODE),
			'substruct_currency' => __('Substruct Currency', CFS_LANG_CODE),
		));
		
		return parent::getContent('clAdminTab');
	}
}