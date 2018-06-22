<?php
class add_fieldsControllerCfs extends controllerCfs {
	public function uploadFile() {
		$res = new responseCfs();
		$data = reqCfs::get('get');
		$id = isset($data['id']) ? (int) $data['id'] : 0;
		$nonce = isset($_REQUEST['_wpnonce']) ? $_REQUEST['_wpnonce'] : reqCfs::getVar('_wpnonce');
		if(!wp_verify_nonce($nonce, 'upload-file-'. $id)) {
			die('Some error with your request.........');
		}
		if(($fileData = $this->getModel()->uploadFile($data, reqCfs::get('files')))) {
			$res->addMessage(esc_html(sprintf(__('File %s Uploaded', CFS_LANG_CODE), $fileData['name'])));
			$res->addData('pub_hash', $fileData['id']. '|'. md5($fileData['id']. $fileData['hash']));
			$res->addData('name', $fileData['name']);
			$res->addData('field_name', $fileData['field_name']);
		} else
			$res->pushError($this->getModel()->getErrors());
		$res->ajaxExec();
	}
	public function getFile() {
		$id = (int) reqCfs::getVar('id', 'get');
		$hash = dbCfs::prepareHtmlIn(trim(reqCfs::getVar('hash', 'get')));
		if(!empty($id) && !empty($hash)) {
			$file = frameCfs::_()->getTable('files')->get('*', array('id' => $id, 'hash' => $hash), '', 'row');
			if($file) {
				 header("Content-type: ".$file['mime_type']);
				// lem9 & loic1: IE need specific headers
                if (defined('PMA_USR_BROWSER_AGENT') && PMA_USR_BROWSER_AGENT == 'IE') {
					header('Content-Disposition: inline; filename="'.$file['name'].'"');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
                } else {
					header('Content-Disposition: attachment; filename="'.$file['name'].'"');
					header('Expires: 0');
					header('Pragma: no-cache');
                }
				$uploadDir = wp_upload_dir(null, false);
                $path = $uploadDir['basedir']. DS. $this->getModel()->getDestDirForForm( $file['fid'] ). DS. $file['dest_name'];
				ob_clean();   // discard any data in the output buffer (if possible)
                flush();      // flush headers (if possible)
                readfile($path);
				exit();
			}
		}
	}
	public function removeFile() {
		$res = new responseCfs();
		if($this->getModel()->removeFile(reqCfs::get('post'))) {
			$res->addMessage(__('Done', CFS_LANG_CODE));
		} else
			$res->pushError($this->getModel()->getErrors());
		$res->ajaxExec();
	}
	public function getPermissions() {
		return array(
			CFS_USERLEVELS => array(
				CFS_ADMIN => array()
			),
		);
	}
}

