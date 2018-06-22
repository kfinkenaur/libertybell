<?php
class fb_conversionCfs extends moduleCfs {
	public function init() {
		parent::init();
		$form['html'] = dispatcherCfs::addFilter('formHtml', array($this, 'checkForm'), 10, 3);
	}
	public function checkForm( $formHtml, $form, $params ) {
		if(isset($params['frontend'])
			&& $params['frontend']
			&& isset($form['params']['tpl']['enb_fb_convert'], $form['params']['tpl']['fb_convert_base'])
			&& $form['params']['tpl']['enb_fb_convert']
			&& $form['params']['tpl']['fb_convert_base']
		) {
			$formHtml .= $form['params']['tpl']['fb_convert_base'];
			frameCfs::_()->addScript('fb_conversion.frontend.js', $this->getModPath(). 'js/fb_conversion.frontend.js');
		}
		return $formHtml;
	}
}

