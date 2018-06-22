<?php
class mailchimpModelCfs extends modelSubscribeCfs {
	/**
	 * MailChimp client retrieve
	 */
	private function _getMailchimpInst($key) {
		static $instances = array();
		if(!isset($instances[ $key ])) {
			if(!class_exists('mailChimpClientCfs'))
				require_once($this->getModule()->getModDir(). 'classes'. DS. 'mailChimpClient.php');
			$instances[ $key ] = new mailChimpClientCfs( $key );
		}
		return $instances[ $key ];
	}
	public function subscribe($d, $form, $validateIp = false) {
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email)) {
			if(is_email($email)) {
				$lists = isset($form['params']['tpl']['sub_mailchimp_lists']) ? $form['params']['tpl']['sub_mailchimp_lists'] : array();
				$apiKey = isset($form['params']['tpl']['sub_mailchimp_api_key']) ? trim($form['params']['tpl']['sub_mailchimp_api_key']) : array();
				if(!empty($lists)) {
					if(!empty($apiKey)) {
						if(!$validateIp || $validateIp && frameCfs::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_check' => true))) {
							$name = '';
							if(isset($d['name']) && !empty($d['name'])) {
								$name = trim($d['name']);
							}
							$client = $this->_getMailchimpInst( $apiKey );
							$member = array(
								'email' => $email,
							);
							$dataToSend = array('email' => $member);
							if(!empty($name)) {
								$firstLastNames = array_map('trim', explode(' ', $name));
								$dataToSend['merge_vars'] = array(
									'FNAME' => $firstLastNames[ 0 ],
								);
								if(isset($firstLastNames[ 1 ]) && !empty($firstLastNames[ 1 ])) {
									$dataToSend['merge_vars']['LNAME'] = $firstLastNames[ 1 ];
								}
								$dataToSend['merge_vars']['NAME'] = $name;
							}
							if(isset($form['params']['fields'])
								&& !empty($form['params']['fields'])
							) {
								foreach($form['params']['fields'] as $f) {
									$k = $f['name'];
									if(in_array($k, array('name', 'email'))) continue;	// Ignore standard fields
									if(isset($d[ $k ])) {
										if(!isset($dataToSend['merge_vars']))
											$dataToSend['merge_vars'] = array();
										$dataToSend['merge_vars'][$k] = $d[ $k ];
									}
								}
							}
							// Disable double opt-in
							if(isset($form['params']['tpl']['sub_dsbl_dbl_opt_id']) && $form['params']['tpl']['sub_dsbl_dbl_opt_id']) {
								$dataToSend['double_optin'] = false;
								if(isset($form['params']['tpl']['sub_mc_enb_welcome']) && $form['params']['tpl']['sub_mc_enb_welcome']) {
									$dataToSend['send_welcome'] = true;
								}
							}
							foreach($lists as $listId) {
								$dataToSend['id'] = $listId;
								if(isset($dataToSend['merge_vars']['groupings']))	// It can be set from prev. subscribe list
									unset($dataToSend['merge_vars']['groupings']);
								// Check if groups was selected for this list
								if(isset($form['params']['tpl']['sub_mailchimp_groups']) && !empty($form['params']['tpl']['sub_mailchimp_groups'])) {
									$grouping = array();
									// It can be set from Form using special subscribe additional field with type - mailchimp_groups_list
									if(isset($d['mailchimp_goup'])) {
										$listParentGroupGroupIds = explode('|', $d['mailchimp_goup']);
										if(count($listParentGroupGroupIds) == 3) {
											if(!isset($grouping[ $listParentGroupGroupIds[ 1 ] ]))
												$grouping[ $listParentGroupGroupIds[ 1 ] ] = array('id' => $listParentGroupGroupIds[ 1 ], 'groups' => array());
											$grouping[ $listParentGroupGroupIds[1] ]['groups'][] = base64_decode( $listParentGroupGroupIds[ 2 ] );
										}
									} else {
										foreach($form['params']['tpl']['sub_mailchimp_groups'] as $group) {
											$listParentGroupGroupIds = explode('|', $group);
											if($listParentGroupGroupIds[ 0 ] == $listId) {
												if(!isset($grouping[ $listParentGroupGroupIds[ 1 ] ]))
													$grouping[ $listParentGroupGroupIds[ 1 ] ] = array('id' => $listParentGroupGroupIds[ 1 ], 'groups' => array());
												$grouping[ $listParentGroupGroupIds[ 1 ] ]['groups'][] = base64_decode( $listParentGroupGroupIds[ 2 ] );
											}
										}
									}
									if(!empty($grouping)) {
										foreach($grouping as $g) {
											$dataToSend['merge_vars']['groupings'][] = $g;
										}
									}
								}
								$res = $client->call('lists/subscribe', $dataToSend);
								if(!$res) {
									$this->pushError (__('Something going wrong while trying to send data to MailChimp. Please contact site owner.', CFS_LANG_CODE));
									return false;
								} elseif(isset($res['status']) && $res['status'] == 'error') {
									if(isset($res['name']) && $res['name'] == 'List_AlreadySubscribed') {
										$this->_alreadySubscribedSuccess = true;
										continue;	// User already subscribed - then ok, just go futher
									} elseif(isset($res['name']) && $res['name'] == 'List_MergeFieldRequired') {
										$res['error'] = $this->_mailchimpReplaceTagVariables($client, $lists, $listId, $res['error']);
									}
									$this->pushError ( $res['error'] );
									return false;
								}
							}
							if($validateIp) {
								frameCfs::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_add' => true));
							}
							return true;
						}
					} else
						$this->pushError (__('No API key entered in admin area - contact site owner to resolve this issue.', CFS_LANG_CODE));
				} else
					$this->pushError (__('No lists to add selected in admin area - contact site owner to resolve this issue.', CFS_LANG_CODE));
			} else
				$this->pushError (frameCfs::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($form), 'email');
		} else
			$this->pushError (frameCfs::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($form), 'email');
		return false;
	}
	/**
	 * Replace MailChimp list bariables tags - into their names - to make it understandable for users
	 * @param object $client Mailchimp API client
	 * @param array $lists All lists IDs - to retrive variables for all lists in one time
	 * @param numeric $listId Current List ID - to find variable name in exactly this list
	 * @param string $str String for replace
	 * @return string Modified (replaced) $str parameter
	 */
	private function _mailchimpReplaceTagVariables($client, $lists, $listId, $str) {
		// We can't use here only one variable - as result for get list variables can fail 
		// - and we don't need to re-send it again
		static $listsVariables = false;
		static $listsVariablesCalled = false;
		if(!$listsVariablesCalled) {
			$listsVariablesRes = $client->call('lists/merge-vars', array('id' => $lists));
			if($listsVariablesRes && isset($listsVariablesRes['data']) && !empty($listsVariablesRes['data'])) {
				$listsVariables = array();
				foreach($listsVariablesRes['data'] as $lvrd) {
					$listsVariables[ $lvrd['id'] ] = array();
					if(isset($lvrd['merge_vars']) && !empty($lvrd['merge_vars'])) {
						foreach($lvrd['merge_vars'] as $mergeVar) {
							$listsVariables[ $lvrd['id'] ][ $mergeVar['tag'] ] = $mergeVar['name'];
						}
					}
				} 
			}
			$listsVariablesCalled = true;
		}
		if($listsVariables && isset($listsVariables[ $listId ]) && !empty($listsVariables[ $listId ])) {
			foreach($listsVariables[ $listId ] as $mvTag => $mvName) {
				$str = str_replace($mvTag, $mvName, $str);
			}
		}
		// Remove standard notification about entering value: obviously if there are error here - you need to enter value
		$str = trim(str_replace('- Please enter a value', '', $str));
		return $str;
	}
	public function getLists($d = array()) {
		$key = isset($d['key']) ? trim($d['key']) : '';
		if(!empty($key)) {
			$client = $this->_getMailchimpInst( $key );
			$apiRes = $client->call('lists/list', array('limit' => 100, 'sort_field' => 'web'));
			if($apiRes && is_array($apiRes) && isset($apiRes['data']) && !empty($apiRes['data'])) {
				$listsDta = array();
				foreach($apiRes['data'] as $list) {
					$listsDta[ $list['id'] ] = $list['name'];
				}
				return $listsDta;
			} else {
				if(isset($apiRes['errors']) && !empty($apiRes['errors'])) {
					$this->pushError($apiRes['errors']);
				} elseif(isset($apiRes['error']) && !empty($apiRes['error'])) {
					$this->pushError($apiRes['error']);
				} else {
					$this->pushError(__('There was some problem while trying to get your lists. Make sure that your API key is correct.', CFS_LANG_CODE));
				}
			}
		} else
			$this->pushError(__('Empty API key', CFS_LANG_CODE));
		return false;
	}
	public function getGroups($d = array()) {
		$key = isset($d['key']) ? trim($d['key']) : '';
		$listIds = isset($d['listIds']) && is_array($d['listIds']) && !empty($d['listIds']) 
			? array_map('trim', $d['listIds']) 
			: false;
		if(!empty($key)) {
			if(!empty($listIds)) {
				$client = $this->_getMailchimpInst( $key );
				$groups = array();
				foreach($listIds as $lid) {
					$apiRes = $client->call('lists/interest-groupings', array('id' => $lid));
					if($apiRes && is_array($apiRes) && !isset($apiRes['errors']) && !isset($apiRes['error'])) {
						foreach($apiRes as $pGroup) {
							if(isset($pGroup['groups']) && !empty($pGroup['groups'])) {
								foreach($pGroup['groups'] as $group) {
									$groups[ $lid. '|'. $pGroup['id']. '|'. base64_encode($group['name']) ] = $pGroup['name']. ' - '. $group['name'];
								}
							}
						}
					} else {
						if(isset($apiRes['errors']) && !empty($apiRes['errors'])) {
							$this->pushError($apiRes['errors']);
						} elseif(isset($apiRes['error']) && !empty($apiRes['error'])) {
							$this->pushError($apiRes['error']);
						} else {
							$this->pushError(__('There was some problem while trying to get your lists. Make sure that your API key is correct.', CFS_LANG_CODE));
						}
					}
				}
				return $groups;
			} else
				$this->pushError(__('Select some Lists before', CFS_LANG_CODE));
		} else
			$this->pushError(__('Empty API key', CFS_LANG_CODE));
		return false;
	}
}