<?php
class subscribeModelCfs extends modelCfs {
	private $_dest = '';
	private $_lastForm = null;	// Some small internal caching
	private $_lastExternalModel = null;
	
	private $_alreadySubscribedSuccess = false;
	
	public function subscribe($d, $form, $validateIp = false) {
		if($form) {
			if($form && isset($form['params']) 
				&& isset($form['params']['tpl']['enb_subscribe']) 
				&& isset($form['params']['tpl']['sub_dest'])
			) {
				$dest = $form['params']['tpl']['sub_dest'];
				// Check subscribe model
				$externalModel = frameCfs::_()->getModule($dest) ? frameCfs::_()->getModule($dest)->getModel() : NULL;
				if($externalModel) {
					// Check if there are subscribe checkbox, and if so - check if it's checked
					foreach($form['params']['fields'] as $f) {
						if($f['html'] == 'checkboxsubscribe' && !isset($d[ $f['name'] ])) {
							return true;	// Checkbox for subscribe exists, but was not checked - ignore full subscription procedure
						}
					}
					$this->_dest = $dest;
					$this->_lastForm = $form;
					//$d = dbCfs::prepareHtmlIn($d);

					$res = $externalModel->subscribe($d, $form, $validateIp);
					if(!$res) {
						$externalErrors = $externalModel->getErrors();
						if(!empty($externalErrors)) {
							$this->pushError($externalErrors);
						}
					}
					if($res) {
						$this->_lastForm = $form;
						$this->_lastExternalModel = $externalModel;
						dispatcherCfs::addFilter('contactSuccessMsg', array($this, 'modifySuccessMsg'), 10, 2);
						dispatcherCfs::addFilter('contactSuccessRedirectUrl', array($this, 'modifySuccessUrl'), 10, 2);
						$this->checkSendNewNotification($d, $form);
						$this->checkCreateWpUser($d, $form, $dest);
					}
					return $res;

				} else
					$this->pushError (__('Something goes wrong', CFS_LANG_CODE));
			} else
				$this->pushError (__('Empty or invalid ID', CFS_LANG_CODE));
		} else
			$this->pushError (__('Empty or invalid ID', CFS_LANG_CODE));
		return false;
	}
	public function modifySuccessMsg($msg, $form) {
		$requireConfirm = $this->_lastExternalModel && $this->_lastExternalModel->requireConfirm();
		$newMsg = '';
		if($requireConfirm && isset($form['params']['tpl']['sub_txt_confirm_sent'])) {
			$newMsg = trim( $form['params']['tpl']['sub_txt_confirm_sent'] );
		} elseif(!$requireConfirm && isset($form['params']['tpl']['sub_txt_success'])) {
			$newMsg = trim( $form['params']['tpl']['sub_txt_success'] );
		}
		if($form 
			&& $form['id'] == $this->_lastForm['id']
			&& !empty($newMsg)
		) {
			$msg = $newMsg;
		}
		return $msg;
	}
	public function modifySuccessUrl($url, $form) {
		if($form 
			&& $form['id'] == $this->_lastForm['id']
			&& isset($form['params']['tpl']['sub_redirect_url'])
		) {
			$url = $form['params']['tpl']['sub_redirect_url'];
		}
		return $url;
	}
	public function checkCreateWpUser($d, $form, $dest) {
		if(isset($form['params']['tpl']['sub_create_wp_user']) 
			&& $form['params']['tpl']['sub_create_wp_user']
			&& $dest != 'wordpress'
		) {
			frameCfs::_()->getModule('wp_subscribe')->getModel()->subscribe($d, $form, false);
		}
	}
	public function checkSendNewNotification($d, $form, $forReg = false) {
		$pref = $forReg ? 'reg' : 'sub';
		$adminEmail = get_bloginfo('admin_email');
		if(!isset($form['params']['tpl'][$pref. '_new_email'])) {
			$sendTo = $adminEmail;	// For case when it was just not existed before, but notification should still come
		} else {
			$sendTo = isset($form['params']['tpl'][$pref. '_new_email']) && !empty($form['params']['tpl'][$pref. '_new_email'])
				? trim($form['params']['tpl'][$pref. '_new_email'])
				: false;
		}
		if(!empty($sendTo)) {
			$blogName = wp_specialchars_decode(get_bloginfo('name'));
			$defSubject = $forReg ? __('New User notification', CFS_LANG_CODE) : __('New Subscriber notification', CFS_LANG_CODE);
			$emailSubject = empty($blogName) 
				? $defSubject
				: sprintf(__('New Subscriber on %s', CFS_LANG_CODE), $blogName);
			if(isset($form['params']['tpl'][$pref. '_new_subject']) 
				&& !empty($form['params']['tpl'][$pref. '_new_subject'])
			) {
				$emailSubject = $form['params']['tpl'][$pref. '_new_subject'];
			}
			$defContent = $forReg 
				? __('You have new user registration on your site <a href="[siteurl]">[sitename]</a>, here us user information:<br />[subscriber_data]', CFS_LANG_CODE)
				: __('You have new subscriber on your site <a href="[siteurl]">[sitename]</a>, here is subscriber information:<br />[subscriber_data]', CFS_LANG_CODE);
			$emailContent = isset($form['params']['tpl'][$pref. '_new_message']) && !empty($form['params']['tpl'][$pref. '_new_message'])
				? $form['params']['tpl'][$pref. '_new_message']
				: $defContent;
			$subscriberDataArr = array();
			if(isset($form['params']['tpl'][$pref. '_fields'])
				&& !empty($form['params']['tpl'][$pref. '_fields'])
			) {
				foreach($form['params']['tpl'][$pref. '_fields'] as $k => $f) {
					if(isset($d[ $k ])) {
						$subscriberDataArr[] = sprintf($f['label']. ': %s', $d[ $k ]) . '<br />';
					}
				}
			}
			$replaceVariables = array(
				'sitename' => $blogName,
				'siteurl' => get_bloginfo('wpurl'),
				'subscriber_data' => implode('<br />', $subscriberDataArr),
				'subscribe_url' => dbCfs::prepareHtmlIn(reqCfs::getVar('HTTP_REFERER', 'server')),
			);
			foreach($replaceVariables as $k => $v) {
				$emailSubject = str_replace('['. $k. ']', $v, $emailSubject);
				$emailContent = str_replace('['. $k. ']', $v, $emailContent);
			}
			$addMailParams = array();
			// Check attachments
			$attach = $this->_extractAttach($form, $pref. '_attach_new_message');
			if(!empty($attach)) {
				$addMailParams['attach'] = $attach;
			}
			frameCfs::_()->getModule('mail')->send($sendTo,
				$emailSubject,
				$emailContent,
				$blogName,
				$adminEmail,
				$blogName,
				$adminEmail,
				array(),
				$addMailParams);
		}
	}
	public function getDest() {
		return $this->_dest;
	}
	public function getLastForm() {
		return $this->_lastForm;
	}
	/**
	 * Just public alias for private method
	 */
	public function checkOftenAccess($d = array()) {
		return $this->_checkOftenAccess( $d );
	}
	private function _checkOftenAccess($d = array()) {
		if((int) frameCfs::_()->getModule('options')->get('disable_subscribe_ip_antispam'))
			return true;
		//return true;
		$onlyCheck = isset($d['only_check']) ? $d['only_check'] : false;
		$onlyAdd = isset($d['only_add']) ? $d['only_add'] : false;
		$ip = utilsCfs::getIP();
		if(empty($ip)) {
			$this->pushError(__('Can\'t detect your IP, please don\'t spam', CFS_LANG_CODE));
			return false;
		}
		$accessByIp = get_option(CFS_CODE. '_access_py_ip');
		if(empty($accessByIp)) {
			$accessByIp = array();
		}
		$time = time();
		$break = false;
		if($onlyAdd) {
			$accessByIp[ $ip ] = $time;
			update_option(CFS_CODE. '_access_py_ip', $accessByIp);
			return true;
		}
		// Clear old values
		if(!empty($accessByIp)) {
			foreach($accessByIp as $k => $v) {
				if($time - (int) $v >= 3600)
					unset($accessByIp[ $k ]);
			}
		}
		if(isset($accessByIp[ $ip ])) {
			if($time - (int) $accessByIp[ $ip ] <= 30 * 60) {
				$break = true;
			} else
				$accessByIp[ $ip ] = $time;
		} else {
			$accessByIp[ $ip ] = $time;
		}
		if(!$onlyCheck)
			update_option(CFS_CODE. '_access_py_ip', $accessByIp);
		if($break) {
			$this->pushError(__('You just subscribed from this IP', CFS_LANG_CODE));
			return false;
		}
		return true;
	}
	/**
	 * Public alias for _getInvalidEmailMsg() method
	 */
	public function getInvalidEmailMsg($form = array()) {
		return $this->_getInvalidEmailMsg($form);
	}
	private function _getInvalidEmailMsg($form = array(), $forReg = false, $existsProblem = false) {
		$pref = $forReg ? 'reg' : 'sub';
		$msg = !empty($form) && isset($form['params']['tpl'][$pref. '_txt_invalid_email'])
			? $form['params']['tpl'][$pref. '_txt_invalid_email']
			: __('Empty or invalid email', CFS_LANG_CODE);
		if($existsProblem 
			&& !empty($form) 
			&& isset($form['params']['tpl'][$pref. '_txt_exists_email']) 
			&& !empty($form['params']['tpl'][$pref. '_txt_exists_email'])
		) {
			$msg = $form['params']['tpl'][$pref. '_txt_exists_email'];
		}
		return $msg;
	}
	public function extractAttach(&$form, $key) {
		return $this->_extractAttach($form, $key);
	}
	private function _extractAttach(&$form, $key) {
		$res = array();
		if(isset($form['params']['tpl'][ $key ]) && !empty($form['params']['tpl'][ $key ])) {
			foreach($form['params']['tpl'][ $key ] as $attach) {
				if(empty($attach)) continue;
				$attachPath = str_replace(content_url(), WP_CONTENT_DIR, $attach);
				$res[] = $attachPath;
			}
		}
		return $res;
	}
	/*
	 * Public alias for _getUsernameFromEmail() method
	 */
	public function getUsernameFromEmail($email, $username = '') {
		return $this->_getUsernameFromEmail($email, $username);
	}
	private function _getUsernameFromEmail($email, $username = '') {
		if(!empty($username)) {
			if(username_exists($username)) {
				return $this->_getUsernameFromEmail($email, $username. mt_rand(1, 9999));
			}
			return $username;
		} else {
			$nameHost = explode('@', $email);
			if(username_exists($nameHost[0])) {
				return $this->_getUsernameFromEmail($nameHost[0]. mt_rand(1, 9999). '@'. $nameHost[1], $username);
			}
			return $nameHost[0];
		}
	}
	public function alreadySubscribedSuccess() {
		return $this->_alreadySubscribedSuccess;
	}
}