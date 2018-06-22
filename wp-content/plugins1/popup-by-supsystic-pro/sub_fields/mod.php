<?php
class sub_fieldsPps extends modulePps {
	public function init() {
		parent::init();
		dispatcherPps::addAction('beforePopupEditRender', array($this, 'addAdminAssets'));
		dispatcherPps::addAction('afterPopupEdit', array($this, 'addAdminControls'));
		
	}
	public function addAdminAssets($popup) {
		framePps::_()->addScript(PPS_CODE. '.admin.sub_fields', $this->getModPath(). 'js/admin.sub_fields.js');
	}
	public function addFrontendAssets() {
		framePps::_()->addScript(PPS_CODE. '.frontend.sub_fields', $this->getModPath(). 'js/frontend.sub_fields.js');
	}
	public function addAdminControls($popup) {
		$this->getView()->displayAdminControls();
	}
	public function generateValuePreset( $preset ) {
		$res = '';
		switch($preset) {
			case 'user_ip':
				$res = utilsPps::getIP();
				break;
			case 'user_country_code': case 'user_country_label':
				importClassPps('SxGeo', PPS_HELPERS_DIR. 'SxGeo.php');
				$sxGeo = new SxGeo(PPS_FILES_DIR. 'SxGeo.dat');
				$ip = utilsPps::getIP ();
				$res = $sxGeo->getCountry( $ip );
				if($preset == 'user_country_label' && $res) {
					$res = framePps::_()->getTable('countries')->get('name', array('iso_code_2' => $res), '', 'one');
				}
				break;
			case 'page_url':
				$res = uriPps::getFullUrl();
				break;
			case 'page_title':	// We will take page title from frontend - because it can be different depending on wp settings and other plugins / themes
				$this->addFrontendAssets();
				break;
		}
		return $res;
	}
}