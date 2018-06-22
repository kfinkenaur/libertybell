<?php
class sgautorepondeurModelPps extends modelPps {
	private $_requireConfirm = false;
	
	private $_clients = array();
	private function _getClient( $membreid, $codeactivation ) {
		$memberClientKey = md5( $membreid. $codeactivation );
		if(!isset($this->_clients[ $memberClientKey ])) {
			if(!class_exists('API_SG')) {
				require_once($this->getModule()->getModDir(). 'classes'. DS. 'API_SG.php');
			}
			$this->_clients[ $memberClientKey ] = new API_SG( $membreid, $codeactivation );
		}
		return $this->_clients[ $memberClientKey ];
	}
	public function subscribe($d, $popup, $validateIp = false) {
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email)) {
			if(is_email($email)) {
				$list = isset($popup['params']['tpl']['sub_sga_list_id']) ? $popup['params']['tpl']['sub_sga_list_id'] : '';
				if(!empty($list)) {
					if(!$validateIp || $validateIp && framePps::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_check' => true))) {
						$name = isset($d['name']) ? trim($d['name']) : '';
						$sgApi = $this->_getClient( $popup['params']['tpl']['sub_sga_id'],  $popup['params']['tpl']['sub_sga_activate_code'] );
						
						$sgApi->set('listeid', $list)
							->set('email', $email)
							->set('name', $name);
						if(isset($popup['params']['tpl']['sub_fields'])
							&& !empty($popup['params']['tpl']['sub_fields'])
						) {
							foreach($popup['params']['tpl']['sub_fields'] as $k => $f) {
								if(in_array($k, array('name', 'email'))) continue;	// Ignore standard fields
								if(isset($d[ $k ])) {
									$sgApi->set( $k, $d[ $k ] );
								}
							}
						}
						try {
							$call = utilsPps::jsonDecode( $sgApi->call('set_subscriber') );
							if($call['valid']) {
								return true;
							} else {
								$this->pushError( $call['reponse'] );
							}
						} catch(Exception $e) {
							$this->pushError($e->getMessage());
						}
						return false;
					}
				} else
					$this->pushError (__('No lists to add selected in admin area - contact site owner to resolve this issue.', PPS_LANG_CODE));
			} else
				$this->pushError (framePps::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($popup), 'email');
		} else
			$this->pushError (framePps::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($popup), 'email');
		return false;
	}
	public function requireConfirm() {
		if($this->_requireConfirm)
			return true;
		$destData = framePps::_()->getModule('subscribe')->getDestByKey( $this->getCode() );
		return $destData['require_confirm'];
	}
}