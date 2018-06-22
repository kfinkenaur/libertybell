<?php
class wp_subscribeModelCfs extends modelSubscribeCfs {
	private $_lastForm = NULL;
	private $_requireConfirm = false;
	public function __construct() {
		$this->_setTbl('subscribers');
	}
	public function subscribe($d, $form, $validateIp = false, $forReg = false) {
		//$forReg = false;	// This is from our prev. plugin - Form
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email)) {
			if(is_email($email)) {
				if(!email_exists($email)) {
					if(!$validateIp || $validateIp && frameCfs::_()->getModule('subscribe')->getModel()->checkOftenAccess()) {
						$username = '';
						$pref = $forReg ? 'reg' : 'sub';
						if((isset($d['name']) && !empty($d['name'])) || isset($d['name'])) {
							$username = trim($d['name']);
						}
						$username = frameCfs::_()->getModule('subscribe')->getModel()->getUsernameFromEmail($email, $username);
						$ignoreConfirm = (isset($form['params']['tpl'][$pref. '_ignore_confirm']) && $form['params']['tpl'][$pref. '_ignore_confirm']);
						$confirmHash = md5($email. NONCE_KEY);
						$saveData = array(
							'username' => $username,
							'email' => $email,
							'hash' => $confirmHash,
							'form_id' => $form['id'],
							'all_data' => utilsCfs::serialize( $d ),
							'activated' => $ignoreConfirm ? 1 : 0,
						);
						/*if($forReg) {
							$formSubId = frameCfs::_()->getModule('login')->getModel()->insert( $saveData );
							if(!$formSubId) {
								$this->pushError( frameCfs::_()->getModule('login')->getModel()->getErrors() );
							}
						} else {*/
							$formSubId = $this->insert( $saveData );
						//}
						$this->_requireConfirm = $ignoreConfirm ? false : true;
						if($ignoreConfirm) {
							return $this->createWpSubscriber($form, $email, $username, $d, $forReg);
						} else {
							if($formSubId) {
								$this->sendWpUserConfirm($username, $email, $confirmHash, $form, $forReg, $d);
								return true;
							}
						}
					}
				} else {
					$this->setEmailExists(true);
					$this->pushError (frameCfs::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($form, $forReg, true), 'email');
				}
			} else
				$this->pushError (frameCfs::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($form, $forReg), 'email');
		} else
			$this->pushError (frameCfs::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($form, $forReg), 'email');
		return false;
	}
	public function createWpSubscriber($form, $email, $username, $d, $forReg = false) {
		$pref = $forReg ? 'reg' : 'sub';
		$password = wp_generate_password();
		$userId = wp_create_user($username, $password, $email);
		if($userId && !is_wp_error($userId)) {
			if(!function_exists('wp_new_user_notification')) {
				frameCfs::_()->loadPlugins();
			}
			// If there was selected some special role - check it here
			$this->_lastForm = $form;
			if(isset($form['params']['tpl'][$pref. '_wp_create_user_role']) 
				&& !empty($form['params']['tpl'][$pref. '_wp_create_user_role']) 
				&& $form['params']['tpl'][$pref. '_wp_create_user_role'] != 'subscriber'
			) {
				$user = new WP_User($userId);
				$user->set_role( $form['params']['tpl'][$pref. '_wp_create_user_role'] );
			}
			if(isset($form['params']['tpl'][$pref. '_fields'])
				&& !empty($form['params']['tpl'][$pref. '_fields'])
			) {
				foreach($form['params']['tpl'][$pref. '_fields'] as $k => $f) {
					if(in_array($k, array('name', 'email'))) continue;	// Ignore standard fields
					if(isset($d[ $k ])) {
						wp_update_user(array('ID' => $userId, $k => $d[ $k ]));
					}
				}
			}
			$this->_sendNewUserNotification($form, $userId, $password, $d, $forReg);
			return true;
		} else {
			$defaultErrorMsg = $forReg ? __('Can\'t registrate for now. Please try again later.', CFS_LANG_CODE) : __('Can\'t subscribe for now. Please try again later.', CFS_LANG_CODE);
			$this->pushError (is_wp_error($userId) ? $userId->get_error_message() : $defaultErrorMsg);
		}
		return false;
	}
	private function _sendNewUserNotification($form, $userId, $password, $d, $forReg = false) {
		$pref = $forReg ? 'reg' : 'sub';
		$emailSubject = isset($form['params']['tpl'][$pref. '_txt_subscriber_mail_subject']) ? $form['params']['tpl'][$pref. '_txt_subscriber_mail_subject'] : false;
		$emailContent = isset($form['params']['tpl'][$pref. '_txt_subscriber_mail_message']) ? $form['params']['tpl'][$pref. '_txt_subscriber_mail_message'] : false;
		if($emailSubject && $emailContent) {
			$user = get_userdata( $userId );
			$blogName = wp_specialchars_decode(get_bloginfo('name'));
			$adminEmail = isset($form['params']['tpl'][$pref. '_txt_subscriber_mail_from']) 
				? $form['params']['tpl'][$pref. '_txt_subscriber_mail_from']
				: get_bloginfo('admin_email');
			$replaceVariables = array(
				'sitename' => $blogName,
				'siteurl' => get_bloginfo('wpurl'),
				'user_login' => $user->user_login,
				'user_email' => $user->user_email,
				'password' => $password,
				'login_url' => wp_login_url(),
				'subscribe_url' => dbCfs::prepareHtmlIn(reqCfs::getVar('HTTP_REFERER', 'server')),
			);
			if(!empty($d)) {
				foreach($d as $k => $v) {
					$replaceVariables[ 'user_'. $k ] = $v;
				}
			}
			foreach($replaceVariables as $k => $v) {
				$emailSubject = str_replace('['. $k. ']', $v, $emailSubject);
				$emailContent = str_replace('['. $k. ']', $v, $emailContent);
			}
			$addMailParams = array();
			// Check attachments
			$attach = frameCfs::_()->getModule('subscribe')->getModel()->extractAttach($form, 'sub_attach_subscriber');
			if(!empty($attach)) {
				$addMailParams['attach'] = $attach;
			}
			frameCfs::_()->getModule('mail')->send($user->user_email,
				$emailSubject,
				$emailContent,
				$blogName,
				$adminEmail,
				$blogName,
				$adminEmail,
				array(),
				$addMailParams);
		} else {	// Just use standard wp method
			if(isset($form['params']['tpl'][$pref. '_txt_subscriber_mail_subject']) 
				&& empty($form['params']['tpl'][$pref. '_txt_subscriber_mail_subject'])
				&& isset($form['params']['tpl'][$pref. '_txt_subscriber_mail_message']) 
				&& empty($form['params']['tpl'][$pref. '_txt_subscriber_mail_message'])
			) {
				// User do not want any notifications - just don't send them at all
				return;
			}
			wp_new_user_notification($userId, $password);
		}
	}
	public function setEmailExists($state) {
		$this->_emailExists = $state;
	}
	public function getEmailExists($email = '') {
		if(!empty($email)) {
			$this->setEmailExists( email_exists($email) );
		}
		return $this->_emailExists;
	}
	public function sendWpUserConfirm($username, $email, $confirmHash, $form, $forReg = false, $d = array()) {
		$pref = $forReg ? 'reg' : 'sub';
		$blogName = wp_specialchars_decode(get_bloginfo('name'));
		$confirmLinkData = array('email' => $email, 'hash' => $confirmHash);
		if($forReg) {
			$confirmLinkData['for_reg'] = 1;
		}
		$replaceVariables = array(
			'sitename' => $blogName,
			'siteurl' => get_bloginfo('wpurl'),
			'confirm_link' => uriCfs::mod('wp_subscribe', 'confirm', $confirmLinkData),
			'subscribe_url' => dbCfs::prepareHtmlIn(reqCfs::getVar('HTTP_REFERER', 'server')),
		);
		if(!empty($d)) {
			foreach($d as $k => $v) {
				$replaceVariables[ 'user_'. $k ] = $v;
			}
		}
		$adminEmail = isset($form['params']['tpl'][$pref. '_txt_confirm_mail_from']) 
			? $form['params']['tpl'][$pref. '_txt_confirm_mail_from']
			: get_bloginfo('admin_email');
		$confirmSubject = isset($form['params']['tpl'][$pref. '_txt_confirm_mail_subject']) && !empty($form['params']['tpl'][$pref. '_txt_confirm_mail_subject'])
				? $form['params']['tpl'][$pref. '_txt_confirm_mail_subject']
				: __('Confirm subscription on [sitename]', CFS_LANG_CODE);
		$confirmContent = isset($form['params']['tpl'][$pref. '_txt_confirm_mail_message']) && !empty($form['params']['tpl'][$pref. '_txt_confirm_mail_message'])
				? $form['params']['tpl'][$pref. '_txt_confirm_mail_message']
				: __('You subscribed on site <a href="[siteurl]">[sitename]</a>. Follow <a href="[confirm_link]">this link</a> to complete your subscription. If you did not subscribe here - just ignore this message.', CFS_LANG_CODE);
		foreach($replaceVariables as $k => $v) {
			$confirmSubject = str_replace('['. $k. ']', $v, $confirmSubject);
			$confirmContent = str_replace('['. $k. ']', $v, $confirmContent);
		}
		$addMailParams = array();
		// Check attachments
		$attach = frameCfs::_()->getModule('subscribe')->getModel()->extractAttach($form, 'sub_attach_confirm');
		if(!empty($attach)) {
			$addMailParams['attach'] = $attach;
		}
		frameCfs::_()->getModule('mail')->send($email,
			$confirmSubject,
			$confirmContent,
			$blogName,
			$adminEmail,
			$blogName,
			$adminEmail,
			array(),
			$addMailParams);
	}
	public function confirm($d = array(), $forReg = false) {
		$d['email'] = isset($d['email']) ? trim($d['email']) : '';
		$d['hash'] = isset($d['hash']) ? trim($d['hash']) : '';
		$form = array();
		if(!empty($d['email']) && !empty($d['hash'])) {
			$selectSubscriberData = array(
				'email' => $d['email'],
				'hash' => $d['hash'], 
				'activated' => 0,
			);
			$subscribeModel =/* $forReg ? frameCfs::_()->getModule('login')->getModel() : */$this;
			$subscriber = $subscribeModel
				->setWhere($selectSubscriberData)
				->getFromTbl(array('return' => 'row'));
			if(empty($subscriber) && $forReg) {
				$this->pushError( $this->getErrors() );
			}
			if(!empty($subscriber)) {
				if(isset($subscriber['form_id']) && !empty($subscriber['form_id'])) {
					$form = frameCfs::_()->getModule('forms')->getModel()->getById($subscriber['form_id']);
					$this->_lastForm = $form;
				}
				$subscriber['all_data'] = isset($subscriber['all_data']) ? utilsCfs::unserialize($subscriber['all_data']) : array();
				$res = $this->createWpSubscriber($form, $subscriber['email'], $subscriber['username'], $subscriber['all_data'], $forReg);
				if($res) {
					$subscribeModel->update(array('activated' => 1), array('id' => $subscriber['id']));
				}
				return $res;
			}
		}
		// One and same error for all other cases
		$this->pushError(__('Send me some info, pls', CFS_LANG_CODE));
		return false;
	}
	public function getLastForm() {
		return $this->_lastForm;
	}
	public function requireConfirm() {
		return $this->_requireConfirm;
	}
}