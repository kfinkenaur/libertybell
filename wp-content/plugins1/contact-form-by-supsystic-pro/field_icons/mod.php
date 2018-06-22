<?php
class field_iconsCfs extends moduleCfs {
	private $_frontAssetsLoaded = false;
	public function init() {
		parent::init();
		dispatcherCfs::addAction('formInputHtml', array($this, 'checkFormField'), 10, 3);
	}
	public function checkFormField( $fieldHtml, $field, $htmlParams ) {
		if(isset($field['icon_class']) && !empty($field['icon_class'])) {
			$htmlType = $field['html'];
			$skipFor = array('rating');
			if(!in_array($htmlType, $skipFor)) {
				
				$iconClass = 'fa-'. $field['icon_class'];
				$iconStyles = '';
				$iconStylesArr = array();
				if(isset($field['icon_size']) && !empty($field['icon_size'])) {
					$iconClass .= ' fa-'. $field['icon_size'];
				}
				if(isset($field['icon_color']) && !empty($field['icon_color'])) {
					$iconStylesArr['color'] = $field['icon_color'];
				}
				if(!empty($iconStylesArr)) {
					$iconStyles = 'style="'. utilsCfs::arrToCss( $iconStylesArr ). '"';
				}
				$iconHtml = '<i class="fa '. $iconClass. ' cfsFieldIcon" '. $iconStyles. '></i>';
				if(in_array($htmlType, array('button', 'submit'))) {
					$fieldHtml = htmlCfs::button(array_merge($htmlParams, array(
						'value' => $iconHtml. $htmlParams['value'],
					)));
				} else {
					$fieldHtml = $iconHtml. $fieldHtml;
				}
				if(!$this->_frontAssetsLoaded) {
					frameCfs::_()->addStyle('frontend.field_iconsCfs', $this->getModPath(). 'css/frontend.field_icons.css');
					frameCfs::_()->addScript('frontend.field_iconsCfs', $this->getModPath(). 'js/frontend.field_icons.js');
					frameCfs::_()->getModule('templates')->loadFontAwesome();
					$this->_frontAssetsLoaded = true;
				}
			}
		}
		return $fieldHtml;
	}
}

