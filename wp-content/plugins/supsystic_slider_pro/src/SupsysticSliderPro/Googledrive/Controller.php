<?php

class SupsysticSliderPro_Googledrive_Controller extends SupsysticSlider_Core_BaseController
{
	protected function getModelAliases()
	{
		return array(
			'photos' => 'SupsysticSlider_Photos_Model_Photos',
			'slider' => 'SupsysticSlider_Slider_Model_Sliders',
		);
	}
	public function requireNonces() {
		return array(
			'completeAction',
			'logoutAction',
			'sideloadSaveAction',
		);
	}

	public function indexAction(Rsc_Http_Request $request)
	{
		if (!get_option('googledrive_token')) {
			return $this->authorizationAction($request);
		}
		/**
		 * @var Google_Client $client
		 */
		$client = $this->getModule('googledrive')->getClient();
		$client->setAccessToken(get_option('googledrive_token'));

		if($client->isAccessTokenExpired()){
			return $this->authorizationAction($request);
		}

		$googleDrive = new Google_Service_Drive($client);
		$root = null;
		$parentFolder = null;
		$folders = array();
		$images = array();

		//get current folder
		$root = $request->query->get('folder');
		//if folder not set starts in root
		if(!$root){
			$root = 'root';
			$parentFolder = null;
		}else{
			$folderData = $googleDrive->files->get($root,array(
				'fields' => 'parents'
			));
			$parentFolder = $folderData->parents[0];
		}

		$pageToken = null;
		do {
			try {
				$listFiles = $googleDrive->files->listFiles(array(
					'q' => "(mimeType='application/vnd.google-apps.folder' or mimeType='image/jpeg') and '$root' in parents",
					'spaces' => 'drive',
					'pageToken' => $pageToken,
					'pageSize' => 999,
					'fields' => 'files(trashed,folderColorRgb,id,kind,mimeType,name,starred,thumbnailLink,webContentLink,webViewLink),nextPageToken',
				));
			} catch(Exception $e) {
				return $this->authorizationAction($request);
			}

			$pageToken = $listFiles->getNextPageToken();

			foreach ($listFiles->getFiles() as $file) {
				if($file->trashed){
					continue;
				}

				if($file->mimeType == 'application/vnd.google-apps.folder'){
					$folders[] = array(
						'id' => $file->id,
						'name' => $file->name,
						'color' => $file->folderColorRgb,
					);
				}else{
					$images[] = array(
						'id' => $file->id,
						'name' => $file->name,
						'thumbnailLink' => $file->thumbnailLink,
						'webContentLink' => $file->webContentLink,
					);
				}
			}
		} while ($pageToken != null);

		$galleryId = $request->query->get('id');
		$galleryTitle = $this->getModule('slider')->getCurrentSlider($galleryId)->title;
		return $this->response('@googledrive/index.twig',array(
			'id' => $galleryId,
			'galleryName' => $galleryTitle,
			'parentFolder' => $parentFolder,
			'folders' => $folders,
			'images' => $images,
		));
	}

	public function authorizationAction(Rsc_Http_Request $request){
		$galleryId = $request->query->get('id');
		$galleryTitle = $this->getModule('slider')->getCurrentSlider($galleryId)->title;
		/**
		 * @var Google_Client $client
		 */
		$client = $this->getModule('googledrive')->getClient();
		$client->setState(urlencode($this->getEnvironment()
			->generateUrl('googledrive','complete',array(
				'id' => $galleryId,
			))
		));

		$url  = 'http://supsystic.com/authenticator/index.php/authenticator/drive';

		 $url.= '?ref=' . base64_encode($this->getEnvironment()
			->generateUrl('googledrive','complete',array(
				'id' => $galleryId,
				'_wpnonce' => wp_create_nonce('supsystic-slider')
			)));

		return $this->response('@googledrive/authorization.twig',array(
			'url' => $url,
			'id' => $galleryId,
			'galleryName' => $galleryTitle
		));
	}

	public function completeAction(Rsc_Http_Request $request){
		$code = $request->query->get('googleAuthCode');
		$galleryId = $request->query->get('id');

		if (!$code) {
			$message = $this->translate('Authorization code is not specified.');
			return $this->response(
				'error.twig',
				array(
					'message' => $message,
				)
			);
		}
		try {
			/**
			 * @var Google_Client $client
			 */
			error_log('test' , 0);
			$client = $this->getModule('googledrive')->getClient();
			error_log('test2' , 0);
			update_option('googledrive_token',$client->authenticate($code));
			error_log('test3' , 0);
		} catch (Exception $e) {
			return $this->response(
				'error.twig',
				array(
					'message' => $e->getMessage(),
				)
			);
		}

		return $this->redirect($this->generateUrl('googledrive','index',array('id'=>$galleryId)));
	}

	public function logoutAction(Rsc_Http_Request $request)
	{
		$galleryId = $request->query->get('id');

		/**
		 * @var Google_Client $client
		 */
		$client = $this->getModule('googledrive')->getClient();
		$client->revokeToken(get_option('googledrive_token'));
		delete_option('googledrive_token');

		return $this->redirect($this->generateUrl('googledrive', 'index', array('id' => $galleryId)));
	}

	public function sideloadSaveAction(Rsc_Http_Request $request){

		$selectedImages = $request->post->get('urls');
		$galleriesModule = $this->getModule('slider');

		/**
		 * @var GridGalleryPro_Googledrive_Module $module
		 */
		$module = $this->getModule('googledrive');
		$photos = new SupsysticSlider_Photos_Model_Photos();
		$attachID = array();

		$client = $this->getModule('googledrive')->getClient();
		$client->setAccessToken(get_option('googledrive_token'));

		if(!$client->isAccessTokenExpired() && $module->createTmpFolder()){
			$googleDrive = new Google_Service_Drive($client);

			foreach ($selectedImages as $image) {
				$content = $googleDrive->files->get($image['id'], array(
					'alt' => 'media' ));

				$localFile = str_replace('%','',urlencode($image['name']));
				$fp = fopen($module->getTmpFolder().$localFile,'w',true);
				fwrite($fp,$content);
				fclose($fp);
				$url = $module->getTmpUrl().$localFile;

				$id = $this->media_sideload_image($url, 0);

				if($photos->add($id))
					$attachID[] = $photos->getInsertId();
				
			}

			$module->cleanTmpFolder();
		}

		return $this->response(Rsc_Http_Response::AJAX,
			array('msh' => 'Loaded', 'ids' => $attachID));
	}

	public function media_sideload_image($file, $post_id, $desc = null)
	{
		if (!empty($file)) {
			// Set variables for storage, fix file filename for query strings.
			preg_match('/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches);
			$file_array = array();
			$file_array['name'] = basename($matches[0]);

			// Download file to temp location.
			$file_array['tmp_name'] = download_url($file);

			// If error storing temporarily, return the error.
			if (is_wp_error($file_array['tmp_name'])) {
				return $file_array['tmp_name'];
			}

			// Do the validation and storage stuff.
			$id = media_handle_sideload($file_array, $post_id, $desc);

			// If error storing permanently, unlink.
			if (is_wp_error($id)) {
				@unlink($file_array['tmp_name']);
				return $id;
			}

			$src = wp_get_attachment_url($id);
		}

		// Finally check to make sure the file has been saved, then return the HTML.
		if (!empty($src)) {
			$alt = isset($desc) ? esc_attr($desc) : '';
			$html = "<img src='$src' alt='$alt' />";
			return $id;
		}
	}

}

