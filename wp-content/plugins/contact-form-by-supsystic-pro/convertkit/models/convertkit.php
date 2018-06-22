<?php
class convertkitModelCfs extends modelSubscribeCfs {
	private $_lastRequireConfirm = false;
	public function getLists($d) {
		$d['api_key'] = isset($d['api_key']) ? trim($d['api_key']) : false;
		if(empty($d['api_key'])) {
			$this->pushError(__('Please enter your API Key', CFS_LANG_CODE), 'params[tpl][sub_ck_api_key]');
		}
		if(!$this->haveErrors()) {
			$formsData = $this->_req('forms', $d['api_key']);
			if(!empty($formsData)) {
				if(isset($formsData['forms']) && !empty($formsData['forms'])) {
					$res = array();
					foreach($formsData['forms'] as $f) {
						$res[] = array('id' => $f['id'], 'name' => $f['name']);
					}
					return $res;
				} else
					$this->pushError(__('You have no forms. Please create form at first under your ConvertKit account', CFS_LANG_CODE));
			}
		}
		return false;
	}
	private function _req($action, $apiKey, $data = array()) {
		$reqData = array();
		$reqData['method'] = empty($data) ? 'GET' : 'POST';

		if(!empty($data)) {
			$reqData['body'] = $data;	
		}
		$response = wp_remote_post('https://api.convertkit.com/v3/'. $action. '?api_key='. $apiKey, $reqData);
		if (!is_wp_error($response)) {
			if(isset($response['body']) && !empty($response['body']) && ($resArr = utilsCfs::jsonDecode($response['body']))) {
				return $resArr;
			} else
				$this->pushError(__('There was a problem with sending request to our authentication server. Please try later.', CFS_LANG_CODE));
		} else
			$this->pushError( $response->get_error_message() );
	}
	public function subscribe($d, $form, $validateIp = false) {
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email)) {
			if(is_email($email)) {
				$apiKey = trim($form['params']['tpl']['sub_ck_api_key']);
				$forms = $form['params']['tpl']['sub_ck_lists'];
				if(!empty($apiKey) && !empty($forms)) {
					if(!$validateIp || $validateIp && frameCfs::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_check' => true))) {
						$name = isset($d['name']) ? trim($d['name']) : '';
						$addData = array('email' => $email);
						if(!empty($name)) {
							$addData['name'] = $name;
						}
						if(isset($form['params']['fields'])
							&& !empty($form['params']['fields'])
						) {
							foreach($form['params']['fields'] as $f) {
								$k = $f['name'];
								if(in_array($k, array('name', 'email'))) continue;	// Ignore standard fields
								if(isset($d[ $k ])) {
									$addData[ $k ] = $d[ $k ]; 
								}
							}
						}
						foreach($forms as $fid) {
							$res = $this->_req('forms/'. $fid. '/subscribe', $apiKey, $addData);
							if($res && isset($res['subscription']) && isset($res['subscription']['id'])) {
								if(isset($res['subscription']['state']) && $res['subscription']['state'] == 'inactive') {	// Maybe this mean that it require confirnation? Didn't found this in docs, let's try go in this way, and see what will happen?:)
									$this->_lastRequireConfirm = true;
								}
							} else {
								$this->pushError(__('Some error occured during subscription. Please make sure that you entered all information correct.', CFS_LANG_CODE));
								return false;
							}
						}
						return true;
					}
				} else
					$this->pushError(__('Please make sure that you entered your API Key and selected forms in admin area', CFS_LANG_CODE));
				

			} else
				$this->pushError (frameCfs::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($form), 'email');
		} else
			$this->pushError (frameCfs::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($form), 'email');
		return false;
	}
	public function requireConfirm() {
		if($this->_lastRequireConfirm)
			return true;
		$destData = frameCfs::_()->getModule('subscribe')->getDestByKey( $this->getCode() );
		return $destData['require_confirm'];
	}
}