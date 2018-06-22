<?php
class add_fieldsCfs extends moduleCfs {
	private $_filesDir = 'cfs-upload-files';
	public function init() {
		parent::init();
		dispatcherCfs::addAction('beforeFormEdit', array($this, 'connectEditForm'));
		dispatcherCfs::addAction('afterFormSuccessSubmit', array($this, 'afterFormSuccessSubmit'), 10, 2);
	}
	public function connectEditForm( $form ) {
		frameCfs::_()->addScript(CFS_CODE. 'add_fields.admin', $this->getModPath(). 'js/add_fields.admin.js');
	}
	public function generateValuePreset( $preset ) {
		$res = '';
		switch($preset) {
			case 'user_ip':
				$res = utilsCfs::getIP();
				break;
			case 'user_country_code': case 'user_country_label':
				importClassCfs('SxGeo', CFS_HELPERS_DIR. 'SxGeo.php');
				$sxGeo = new SxGeo(CFS_FILES_DIR. 'SxGeo.dat');
				$ip = utilsCfs::getIP ();
				$res = $sxGeo->getCountry( $ip );
				if($preset == 'user_country_label' && $res) {
					$res = frameCfs::_()->getTable('countries')->get('name', array('iso_code_2' => $res), '', 'one');
				}
				break;
			case 'page_url':
				$res = uriCfs::getFullUrl();
				break;
			case 'page_title':	// We will take page title from frontend - because it can be different depending on wp settings and other plugins / themes
				$this->bindFrontendAssets();
				break;
		}
		return $res;
	}
	public function generateFieldHtml($htmlType, $fullName, $htmlParams, $form, $field) {
		$res = '';
		$methodName = '_generateFieldHtml_'. $htmlType;
		if(method_exists($this, $methodName)) {
			$res = call_user_func_array(array($this, $methodName), array($fullName, $htmlParams, $form, $field));
		}
		return $res;
	}
	private function _generateFieldHtml_file($fullName, $htmlParams, $form) {
		// Old ajaxfile methods
		/*$this->bindFrontendAssets();
		$htmlMethod = 'ajaxfile';
		$htmlParams['url'] = uriCfs::mod('add_fields', 'uploadFile', array(
			'id' => $form['id'], 
			'_wpnonce' => wp_create_nonce('upload-file-'. $form['id']),
			'reqType' => 'ajax',
		));
		if(isset($htmlParams['placeholder']) && !empty($htmlParams['placeholder'])) {
			$htmlParams['buttonName'] = $htmlParams['placeholder'];
		}
		$htmlParams['onSubmit'] = 'cfsBeforeStartFileUpload';
		$htmlParams['onComplete'] = 'cfsAfterFileUpload';
		$htmlParams['responseType'] = 'json';
		$htmlParams['addHidden'] = true;
		return htmlCfs::$htmlMethod($fullName, $htmlParams). '<span class="cfsFileSubmitMsg"></span>';*/
		$this->bindFrontendAssets();
		frameCfs::_()->addScript('jquery-ui-widget');
		frameCfs::_()->addScript(CFS_CODE. 'add_fields.jquery.iframe-transport', $this->getModPath(). 'js/ajaxfile/jquery.iframe-transport.js');
		frameCfs::_()->addScript(CFS_CODE. 'add_fields.jquery.fileupload', $this->getModPath(). 'js/ajaxfile/jquery.fileupload.js', array('jquery-ui-widget'));
		frameCfs::_()->addStyle(CFS_CODE. 'add_fields.files.frontend', $this->getModPath(). 'css/add_fields.files.frontend.css');

		$htmlMethod = 'file';
		$htmlParams['attrs'] = isset($htmlParams['attrs']) ? $htmlParams['attrs'] : '';
		$fullName = str_replace(']', '_file]', $fullName). '[]';
		$buttonId = htmlCfs::nameToClassId( 'cfsUploadbut_'. $fullName );
		$htmlParams['attrs'] .= ' data-url="'. uriCfs::mod('add_fields', 'uploadFile', array(
			'id' => $form['id'], 
			'_wpnonce' => wp_create_nonce('upload-file-'. $form['id']),
			'reqType' => 'ajax',
		)). '" id="'. $buttonId. '" multiple';
		return htmlCfs::$htmlMethod($fullName, $htmlParams)
			. '<div class="cfsFileUploadProgressFull"><div class="cfsFileUploadProgress"></div></div>'
			. '<span class="cfsFileSubmitMsg"></span>'
			. '<span class="cfsFileList"></span>';
	}
	private function _generateFieldHtml_rating($fullName, $htmlParams, $form, $field) {
		$this->bindFrontendAssets();
		frameCfs::_()->getModule('templates')->loadFontAwesome();
		$shellId = 'cfsRateShell_'. mt_rand(1, 999999);
		$res = '';
		$iconClass = 'fa fa-'. (isset($field['icon_class']) ? $field['icon_class'] : 'star');
		if(isset($field['icon_size']) && !empty($field['icon_size'])) {
			$iconClass .= ' fa-'. $field['icon_size'];
		}
		$iconStylesArr = array('margin-right' => '2px');
		$iconStyle = '';
		if(isset($field['icon_color']) && !empty($field['icon_color'])) {
			$iconStylesArr['color'] = $field['icon_color'];
		}
		if(isset($field['icon_selected_color']) && !empty($field['icon_selected_color'])) {
			$res .= '<style type="text/css">#'. $shellId. ' i:hover, #'. $shellId. ' a.active i { color: '. $field['icon_selected_color']. ' !important; }</style>';
		}
		if(!empty($iconStylesArr)) {
			$iconStyle = 'style="'. utilsCfs::arrToCss( $iconStylesArr ). '"';
		}
		$iconsNum = isset($field['rate_num']) ? (int) $field['rate_num'] : 0;
		if( !$iconsNum ) {
			$iconsNum = 5; // By default
		}
		$res .= '<span id="'. $shellId. '" class="cfsRateShell">';
		for($i = 1; $i <= $iconsNum; $i++) {
			$res .= '<a href="'. $i. '" class="cfsRateBtn"><i class="'. $iconClass. '" '. $iconStyle. '></i></a>';
		}
		$res .= htmlCfs::hidden( $fullName );
		return $res;
	}
	public function bindFrontendAssets() {
		frameCfs::_()->addScript(CFS_CODE. 'add_fields.frontend', $this->getModPath(). 'js/add_fields.frontend.js');
	}
	private function _generateFormData_file($f, $value, $form) {
		$res = '';
		if(!empty($value)) {
			if(!is_array($value)) $value = array( $value );
			foreach($value as $v) {
				$idPubHash = explode('|', $v);
				$id = is_numeric($idPubHash[ 0 ]) ? (int) $idPubHash[ 0 ] : false;
				if($id) {
					$file = frameCfs::_()->getTable('files')->get('*', array('id' => $id), '', 'row');
					if($file && md5($id. $file['hash']) == $idPubHash[ 1 ]) {
						$res .= '<a href="'. $this->getFileUrl( $file ). '" target="_blank">'. esc_html($file['name']). '</a> ';
					}
				}
			}
		}
		return $res;
	}
	private function _generateFormData_rating($f, $value, $form) {
		$res = '';
		if(!empty($value)) {
			return $value;
		}
		return $res;
	}
	public function validateField($htmlType, $f, $value, $form) {
		return false;	// Do nothing for now
	}
	public function getFileUrl($file) {
		return uriCfs::mod('add_fields', 'getFile', array('id' => $file['id'], 'hash' => $file['hash']));
	}
	public function generateFormData($htmlType, $f, $value, $form) {
		$res = '';
		$methodName = '_generateFormData_'. $htmlType;
		if(method_exists($this, $methodName)) {
			$res = call_user_func_array(array($this, $methodName), array($f, $value, $form));
		}
		return $res;
	}
	public function install() {
		/**
		* Files table
		*/
	   if(!dbCfs::exist("@__files")) {
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta(dbCfs::prepareQuery("CREATE TABLE IF NOT EXISTS `@__files` (
			 `id` int(11) NOT NULL AUTO_INCREMENT,
			 `fid` int(11) NOT NULL DEFAULT '0',
			 `field_name` varchar(255) NOT NULL,
			 `name` varchar(255) NOT NULL,
			 `dest_name` varchar(255) NOT NULL,
			 `path` varchar(255) NOT NULL,
			 `mime_type` varchar(255) DEFAULT NULL,
			 `size` int(11) NOT NULL DEFAULT '0',
			 `hash` varchar (255) NOT NULL,
			 `date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			 PRIMARY KEY (`id`)
		   ) DEFAULT CHARSET=utf8"));
	   }
	   if (!dbCfs::exist("@__forms_rating")) {
			if(!function_exists('dbDelta')) {
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			}
			  dbDelta(dbCfs::prepareQuery("CREATE TABLE `@__forms_rating` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`fid` int(11) NOT NULL DEFAULT '0',
				`field_name` varchar(255) NOT NULL,
				`rate` MEDIUMINT(5) NOT NULL DEFAULT '0',
				`max_rate` MEDIUMINT(5) NOT NULL DEFAULT '0',
				`date_created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
			  ) DEFAULT CHARSET=utf8;"));
		}
	}
	public function activate() {
		$this->install();
	}
	public function getFilesDir() {
        return $this->_filesDir;
    }
    public function getFullFilePath($name) {
        $uploadsInfo = wp_upload_dir();
        return $uploadsInfo['baseurl']. '/'. $this->getFilesDir(). '/'. $name;
    }
    public function getFullFileDir($name) {
        $uploadsInfo = wp_upload_dir();
        return $uploadsInfo['basedir']. DS. $this->getFilesDir(). DS. $name;
    }
	private function _generateFieldHtml_checkboxsubscribe($fullName, $htmlParams, $form) {
		$htmlMethod = 'checkbox';
		return htmlCfs::$htmlMethod($fullName, $htmlParams);
	}
	private function _generateFormData_checkboxsubscribe($f, $value, $form) {
		return $value ? __('Yes', CFS_LANG_CODE) : __('No', CFS_LANG_CODE);
	}
	public function afterFormSuccessSubmit( $fields, $form ) {
		//var_dump($fields, $form);
		foreach($form['params']['fields'] as $field) {
			
			if($field['html'] == 'rating' 
				&& isset($fields[ $field['name'] ]) 
				&& !empty($fields[ $field['name'] ])
			) {
				$this->getModel('rating')->insert(array(
					'fid' => $form['id'],
					'field_name' => $field['name'],
					'rate' => (int) $fields[ $field['name'] ],
					'max_rate' => (int) $field['rate_num'],
				));
			}
		}
	}
	public function getRatingStatsTab( $form ) {
		return $this->getView()->getRatingStatsTab( $form );
	}
}

