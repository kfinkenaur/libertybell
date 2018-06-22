<?php
class subscribeViewCfs extends viewCfs {
	public function generateFormStart_wordpress($form) {
		return $this->_generateFormStartCommon($form, 'wordpress');
	}
	public function generateFormEnd_wordpress($form) {
		return $this->_generateFormEndCommon($form);
	}
	public function generateFormStart_aweber($form) {
		return '<form class="cfsSubscribeForm cfsSubscribeForm_aweber" method="post" action="https://www.aweber.com/scripts/addlead.pl">';
	}
	public function generateFormEnd_aweber($form) {
		$redirectUrl = isset($form['params']['tpl']['sub_redirect_url']) && !empty($form['params']['tpl']['sub_redirect_url'])
			? $form['params']['tpl']['sub_redirect_url']
			: false;
		if(!empty($redirectUrl)) {
			$redirectUrl = trim($redirectUrl);
			if(strpos($redirectUrl, 'http') !== 0) {
				$redirectUrl = 'http://'. $redirectUrl;
			}
		}
		if(empty($redirectUrl)) {
			$redirectUrl = uriCfs::getFullUrl();
		}
		$res = '';
		$res .= htmlCfs::hidden('listname', array('value' => $form['params']['tpl']['sub_aweber_listname']));
		$res .= htmlCfs::hidden('meta_message', array('value' => '1'));
		$res .= htmlCfs::hidden('meta_required', array('value' => 'email'));
		$res .= htmlCfs::hidden('redirect', array('value' => $redirectUrl));
		if(isset($form['params']['tpl']['sub_aweber_adtracking']) && !empty($form['params']['tpl']['sub_aweber_adtracking'])) {
			$res .= htmlCfs::hidden('meta_adtracking', array('value' => $form['params']['tpl']['sub_aweber_adtracking']));
		}
		$res .= '</form>';
		return $res;
	}
	public function generateFormStart_mailchimp($form) {
		return $this->_generateFormStartCommon($form, 'mailchimp');
	}
	public function generateFormEnd_mailchimp($form) {
		return $this->_generateFormEndCommon($form);
	}
	public function generateFormStart_mailpoet($form) {
		return $this->_generateFormStartCommon($form, 'mailpoet');
	}
	public function generateFormEnd_mailpoet($form) {
		return $this->_generateFormEndCommon($form);
	}
	public function generateFormStart_newsletter($form) {
		return $this->_generateFormStartCommon($form, 'newsletter');
	}
	public function generateFormEnd_newsletter($form) {
		return $this->_generateFormEndCommon($form);
	}
	private function _generateFormStartCommon($form, $key = '') {
		$res = '<form class="cfsSubscribeForm'. (empty($key) ? '' : ' cfsSubscribeForm_'. $key).'" action="'. CFS_SITE_URL. '" method="post">';
		if(in_array($form['original_id'], array(31))) {	// For those templates - put message up to the form
			$res .= '<div class="cfsSubMsg"></div>';
		}
		return $res;
	}
	private function _generateFormEndCommon($form) {
		$res = '';
		$res .= htmlCfs::hidden('mod', array('value' => 'subscribe'));
		$res .= htmlCfs::hidden('action', array('value' => 'subscribe'));
		$res .= htmlCfs::hidden('id', array('value' => $form['id']));
		$res .= htmlCfs::hidden('_wpnonce', array('value' => wp_create_nonce('subscribe-'. $form['id'])));
		if(!in_array($form['original_id'], array(31))) {	// For those templates - put message up to the form
			$res .= '<div class="cfsSubMsg"></div>';
		}
		$res .= '</form>';
		return $res;
	}
	/**
	 * Public alias for _generateFormStartCommon() method
	 */
	public function generateFormStartCommon($form, $key = '') {
		return $this->_generateFormStartCommon($form, $key);
	}
	/**
	 * Public alias for _generateFormEndCommon() method
	 */
	public function generateFormEndCommon($form) {
		return $this->_generateFormEndCommon($form);
	}
	public function getFormEditTab( $form ) {
		frameCfs::_()->addScript(CFS_CODE. '.admin.subscribe', $this->getModule()->getModPath(). 'js/admin.subscribe.js');
		$subDestListForSelect = array();
		$subDestList = $this->getModule()->getDestList();
		foreach($subDestList as $k => $v) {
			$subDestListForSelect[ $k ] = $v['label'];
		}
		$this->assign('subDestListForSelect', $subDestListForSelect);
		$this->assign('form', $form);
		$this->assign('promoModPath', frameCfs::_()->getModule('supsystic_promo')->getAssetsUrl());
		return parent::getContent('subFormEditTab');
	}
}
