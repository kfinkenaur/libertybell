<?php
class jetpackModelCfs extends modelSubscribeCfs {
	public function subscribe($d, $form, $validateIp = false) {
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email) && is_email($email)) {
			if(!$validateIp || $validateIp && frameCfs::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_check' => true))) {
				if(class_exists('Jetpack')) {
					if(class_exists('Jetpack_Subscriptions')) {
						$name = '';
						if(isset($d['name']) && !empty($d['name'])) {
							$name = trim($d['name']);
						}
						$userData = array('email' => $email);
						if(!empty($name)) {
							$firstLastNames = array_map('trim', explode(' ', $name));
							$userData['firstname'] = $firstLastNames[ 0 ];
							if(isset($firstLastNames[ 1 ]) && !empty($firstLastNames[ 1 ])) {
								$userData['lastname'] = $firstLastNames[ 1 ];
							}
						}
						if(isset($form['params']['fields'])
							&& !empty($form['params']['fields'])
						) {
							foreach($form['params']['fields'] as $f) {
								$k = $f['name'];
								if(in_array($k, array('name', 'email'))) continue;	// Ignore standard fields
								if(isset($d[ $k ])) {
									$userData[$k] = $d[ $k ];
								}
							}
						}
						$jetSubMod = new Jetpack_Subscriptions();
						$jetRes = $jetSubMod->subscribe($email, 0, false, array(
							'source'         => 'supsystic-form',
							'comment_status' => '',
							'server_data'    => $_SERVER,
							// Not sure - will they parsed or now - as there are no documentation about how put additional fields to Jetpack API. 
							// If you find it - you can change it here.
							'fields'		 => $userData,
						));
						if(!empty($jetRes) && isset($jetRes[ 0 ]) && !empty($jetRes[ 0 ])) {
							$res = $jetRes[ 0 ];
							if(is_object($res) && get_class($res) == 'Jetpack_Error') {
								$errorCodes = $res->get_error_codes();
								$jetErrors = array(
									'invalid_email' => __('Not a valid email address', CFS_LANG_CODE),
									'invalid_post_id' => __('Not a valid post ID', CFS_LANG_CODE),
									'unknown_post_id' => __('Unknown post', CFS_LANG_CODE),
									'not_subscribed' => __('Strange error.  Jetpack servers at WordPress.com could subscribe the email.', CFS_LANG_CODE),
									'disabled' => __('Site owner has disabled subscriptions.', CFS_LANG_CODE),
									'active' => __('Already subscribed.', CFS_LANG_CODE),
									'unknown' => __('Strange error.  Jetpack servers at WordPress.com returned something malformed.', CFS_LANG_CODE),
									'unknown_status' => __('Strange error.  Jetpack servers at WordPress.com returned something I didn\'t understand.', CFS_LANG_CODE),
								);
								foreach($errorCodes as $c) {
									$this->pushError ( isset($jetErrors[ $c ]) ? $jetErrors[ $c ] : __('Something is going wrong', CFS_LANG_CODE));
								}
							} else {
								return true;
							}
						} else
							$this->pushError (__('Empty response from Jetpack', CFS_LANG_CODE));
					} else
						$this->pushError (__('Subscriptions module is not activated in Jetpack plugin settings. Activate it before start using this subscribe method.', CFS_LANG_CODE));
				} else
					$this->pushError (__('Can\'t find Jetpack plugin on this server', CFS_LANG_CODE));
			}
		} else
			$this->pushError (frameCfs::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($form), 'email');
		return false;
	}
}