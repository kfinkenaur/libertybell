<?php


class SupsysticSliderPro_Googledrive_Module extends Rsc_Mvc_Module
{

	private $_client;
	private $_tmpFolder;
	private $_tmpUrl;

	/**
	 * {@inheritdoc}
	 */
	public function onInit()
	{
		$this->_client = false;
		if (!class_exists('Google_Client')) {
			require_once dirname(__FILE__)."/api/Google/autoload.php";
		}

		$wpUploadDir = wp_upload_dir(null,false);
		$this->_tmpFolder = $wpUploadDir['basedir']. '/grid-gallery/googledrive-tmp/' ;
		$this->_tmpUrl = $wpUploadDir['baseurl']. '/grid-gallery/googledrive-tmp/' ;

	}

	/**
	 * Get client for working with google drive
	 * @return Google_Client
	 * @throws Google_Exception
	 */
	public function getClient()
	{
		if($this->_client === false){
			
			$this->_client = new Google_Client();
			$this->_client->setClientId('917290043125-534inl2ha2pdn641r2ebir1a1skme2qe.apps.googleusercontent.com');
			$this->_client->setClientSecret('p92NzUx1n0rNKciQMd5MHm37');
			$this->_client->setRedirectUri('http://supsystic.com/authenticator/index.php/authenticator/drive/complete/');
			$this->_client->addScope(Google_Service_Drive::DRIVE_READONLY);
		}
		return $this->_client;
	}

	public function getTmpFolder(){
		return $this->_tmpFolder;
	}
	public function getTmpUrl(){
		return $this->_tmpUrl;
	}

	public function createTmpFolder(){
		if(!is_dir($this->_tmpFolder) && !@mkdir($this->_tmpFolder)){
			return false;
		}
		return true;
	}

	public function cleanTmpFolder(){
		$files = glob($this->_tmpFolder.'*');
		foreach($files as $file){
			@unlink($file);
		}
	}

}