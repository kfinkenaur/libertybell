<?php
class sgautorepondeurModelCfs extends modelSubscribeCfs {
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
	public function subscribe($d, $form, $validateIp = false) {
		$email = isset($d['email']) ? trim($d['email']) : false;
		if(!empty($email)) {
			if(is_email($email)) {
				$list = isset($form['params']['tpl']['sub_sga_list_id']) ? $form['params']['tpl']['sub_sga_list_id'] : '';
				if(!empty($list)) {
					if(!$validateIp || $validateIp && frameCfs::_()->getModule('subscribe')->getModel()->checkOftenAccess(array('only_check' => true))) {
						$name = isset($d['name']) ? trim($d['name']) : '';
						$sgApi = $this->_getClient( $form['params']['tpl']['sub_sga_id'],  $form['params']['tpl']['sub_sga_activate_code'] );
						
						$sgApi->set('listeid', $list)
							->set('email', $email)
							->set('name', $name);
						if(isset($form['params']['fields'])
							&& !empty($form['params']['fields'])
						) {
							foreach($form['params']['fields'] as $f) {
								$k = $f['name'];
								if(in_array($k, array('name', 'email'))) continue;	// Ignore standard fields
								if(isset($d[ $k ])) {
									$sgApi->set( $k, $d[ $k ] );
								}
							}
						}
						try {
							$call = utilsCfs::jsonDecode( $sgApi->call('set_subscriber') );
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
					$this->pushError (__('No lists to add selected in admin area - contact site owner to resolve this issue.', CFS_LANG_CODE));
			} else
				$this->pushError (frameCfs::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($form), 'email');
		} else
			$this->pushError (frameCfs::_()->getModule('subscribe')->getModel()->getInvalidEmailMsg($form), 'email');
		return false;
	}
	private function _parseErrorsFromRes($bodyContent) {
		if (stristr($bodyContent,'informationmanquante')) { $this->pushError(__('Required fields are missing', CFS_LANG_CODE));/* il manque des champs obligatoires, vous pouvez ajouter ici votre code de gestion. */ };
		if (stristr($bodyContent,'emailexistant')) { $this->pushError(__('The email is already in the list', CFS_LANG_CODE));/* L'email existe déjà dans la liste, vous pouvez ajouter ici votre code de gestion. */ };
		if (stristr($bodyContent,'emailblackliste')) { $this->pushError(__('Registration was refused-blacklisted', CFS_LANG_CODE));/* L'inscription a été refusée-blacklistée, vous pouvez ajouter ici votre code de gestion. */ };
		if (stristr($bodyContent,'paysblackliste')) { $this->pushError(__('The country has been blocked', CFS_LANG_CODE));/* Le pays a été bloqué, vous pouvez ajouter ici votre code de gestion. */ };
		if (stristr($bodyContent,'nombreipimportant')) { $this->pushError(__('Too many entries with the same IP address', CFS_LANG_CODE));/* Trop d'inscriptions avec la même adresse IP, vous pouvez ajouter ici votre code de gestion. */ };
		if (stristr($bodyContent,'nouvellelisteok')) { $this->pushError(__('Ok Register following a behavioral segmentation', CFS_LANG_CODE));/* Inscription OK suite à une segmentation comportementale, vous pouvez ajouter ici votre code de gestion. */ };
		if (stristr($bodyContent,'demandeconfirmation')) { $this->_requireConfirm = true; /*Confirmation request sent - it's ok actually*/ return true; /* Demande de confirmation envoyée (double optin), vous pouvez ajouter ici votre code de gestion. */ };
		if (stristr($bodyContent,'inscriptionok')) { /*Registration is saved - it's ok too? hm...*/ return true; /* L'inscription est enregistrée (simple optin), vous pouvez ajouter ici votre code de gestion. */ };
		if (stristr($bodyContent,'mailformatincorrect')) { $this->pushError(__('The email is not the right format', CFS_LANG_CODE));/* L'email n'est pas au bon format, vous pouvez ajouter ici votre code de gestion. */ };
		if (stristr($bodyContent,'accesinterdit')) { $this->pushError(__('Error on one of the variables - User ID or List ID or Activation Code', CFS_LANG_CODE));/* Erreur sur une des variables $membreid ou $listeid ou $codeactivationclient, vous pouvez ajouter ici votre code de gestion. */ };
		return false;
	}
	public function requireConfirm() {
		if($this->_requireConfirm)
			return true;
		$destData = frameCfs::_()->getModule('subscribe')->getDestByKey( $this->getCode() );
		return $destData['require_confirm'];
	}
}