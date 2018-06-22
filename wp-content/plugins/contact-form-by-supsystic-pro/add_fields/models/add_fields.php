<?php
class add_fieldsModelCfs extends modelCfs {
	public function uploadFile($d = array(), $files = array()) {
		$id = isset($d['id']) ? (int) $d['id'] : false;
		if($id) {
			$form = frameCfs::_()->getModule('forms')->getModel()->getById( $id );
			if($form) {
				$files = isset($files['fields']) ? $files['fields'] : false;
				//var_dump($files);
				if(!empty($files)) {
					$file = array();
					$formField = array();
					foreach($form['params']['fields'] as $field) {
						$searchFileName = $field['name']. '_file';
						if($field['html'] == 'file' 
							&& isset($files['name'][ $searchFileName ]) 
							&& !empty($files['name'][ $searchFileName ])
						) {
							foreach($files as $key => $fileData) {
								$file[ $key ] = $fileData[ $searchFileName ];
							}
							$formField = $field;
							break;
						}
					}
					if(!empty($file)) {
						// To correct recognize multiple upload feature
						foreach($file as $k => $v) {
							$file[ $k ] = is_array( $v ) ? array_shift($v) : $v;
						}
						if(isset($formField['max_size']) && !empty($formField['max_size'])) {
							$maxSize = (float) $formField['max_size'];
							$fileSizeMb = $file['size'] / 1024 / 1024;
							if($maxSize && $fileSizeMb > $maxSize) {
								$this->pushError(sprintf(__('File size is too big, maximum file size for %s is %sMb', CFS_LANG_CODE), $formField['label'], $formField['max_size']));
								return false;
							}
						}
						if(isset($formField['vn_pattern'])) {
							$formField['vn_pattern'] = trim( $formField['vn_pattern'] );
							if(!empty($formField['vn_pattern'])) {
								$types = array_map('trim', explode(',', $formField['vn_pattern']));
								if(!empty($types)) {
									$fileType = wp_check_filetype($file['name']);
									if(!in_array($fileType['ext'], $types)) {
										$this->pushError(sprintf(__('File type is invalid, %s is supported only %s types', CFS_LANG_CODE), $formField['label'], implode(', ', $types)));
										return false;
									}
								}
							}
						}
						importClassCfs('fileuploaderCfs');
						$uploader = new fileuploaderCfs();
						$destFileName = md5( $file['name']. $this->_getFileSalt() );
						if($uploader->validate($file, $this->getDestDirForForm( $id ), $destFileName)) {
							// Clear prev. possible uploads for this file
							// For multiple file upload - this will not work
							//$this->checkClearFile($id, $formField['name'], $uploader);
							if($uploader->upload(array('fid' => $id, 'field_name' => $formField['name']))) {
								return $uploader->getFileInfo();
							} else
								$this->pushError( $uploader->getError() );
						} else
							$this->pushError( $uploader->getError() );
					} else
						$this->pushError(__('Can not find file in request', CFS_LANG_CODE));
				} else
					$this->pushError(__('Empty fiels provided', CFS_LANG_CODE));
				
			} else
				$this->pushError(__('Missing Form', CFS_LANG_CODE));
		} else
			$this->pushError(__('Missing ID', CFS_LANG_CODE));
		return false;
	}
	public function checkClearFile($fid, $fieldName, $uploader) {
		$file = frameCfs::_()->getTable('files')->get('*', array('fid' => $fid, 'field_name' => $fieldName), '', 'row');
		if(!empty($file)) {
			$uploader->delete( $file );
		}
	}
	private function _getFileSalt() {
		return defined('NONCE_SALT') ? NONCE_SALT : 'nUIEGH#*G8gHG*#HGh3g##h3039GH#';
	}
	public function getDestDirForForm( $id ) {
		return $this->getModule()->getFilesDir(). DS. $id;
	}
	public function removeFile( $d = array() ) {
		$idPubHash = explode('|', $d['hash']);
		$id = is_numeric($idPubHash[ 0 ]) ? (int) $idPubHash[ 0 ] : false;
		$file = frameCfs::_()->getTable('files')->get('*', array('id' => $id, 'fid' => (int) $d['fid']), '', 'row');
		if($file && md5($id. $file['hash']) == $idPubHash[ 1 ]) {
			importClassCfs('fileuploaderCfs');
			$uploader = new fileuploaderCfs();
			$uploader->delete( $file );
			return true;
		} else
			$this->pushError(__('Can not find file', CFS_LANG_CODE));
		return false;
	}
}