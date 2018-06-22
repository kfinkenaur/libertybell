<?php
class mailpoetModelCfs extends modelSubscribeCfs {
	public function subscribe($d, $form, $validateIp = false) {
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email) && is_email($email)) {
			if(!$validateIp || $validateIp && frameCfs::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_check' => true))) {
				if($this->getModule()->isSupported()) {
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
					$userFields = array();
					if(isset($form['params']['fields'])
						&& !empty($form['params']['fields'])
					) {
						foreach($form['params']['fields'] as $f) {
							$k = $f['name'];
							if(in_array($k, array('name', 'email'))) continue;	// Ignore standard fields
							if(isset($d[ $k ])) {
								$userFields[$k] = $d[ $k ];
							}
						}
					}
					$dataSubscriber = array(
						'user' => $userData,
						'user_list' => array('list_ids' => array( $form['params']['tpl']['sub_mailpoet_list'] )),
					);
					if(!empty($userFields)) {
						$dataSubscriber['user_field'] = $userFields;
					}
					$helperUser = WYSIJA::get('user', 'helper');
					if($helperUser->addSubscriber($dataSubscriber)) {
						if($validateIp) {
							frameCfs::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_add' => true));
						}
						return true;
					} else {
						$messages = $helperUser->getMsgs();
						$this->pushError( (!empty($messages) && isset($messages['error']) && !empty($messages['error']) ? $messages['error'] : __('Some error occured during subscription process', CFS_LANG_CODE))); 
					}
				} else
					$this->pushError (__('Can\'t find MailPoet on this server', CFS_LANG_CODE));
			}
		} else
			$this->pushError (frameCfs::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($form), 'email');
		return false;
	}
}