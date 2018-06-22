<?php


class SupsysticSliderPro_License_Model_Helper extends SupsysticSlider_Core_BaseModel
{
    private $siteUrl;

    private $_apiUrl = '';

    private $options;

    private $errors;

    /**
     * Constructor.
     */
    public function __construct(Rsc_Environment $environment = null)
    {
        parent::__construct();

        $this->environment = $environment;
        $this->siteUrl = get_bloginfo('wpurl') . '/';
        $this->_initApiUrl();
    }

    public function getPrefix()
    {
        if (null === $this->environment) {
            throw new RuntimeException('Environment not yet injected.');
        }

        return $this->environment->getConfig()->get('hooks_prefix');
    }

    public function check($options) {
        $time = time();
        $this->options = $options;
        //Replace Slider by Supsystic code here
        $lastCheck = (int) get_option('_last_important_check_' . $this->getPrefix());
        if(!$lastCheck || ($time - $lastCheck) >= 5 * 24 * 3600 /** 0/*remove last!!!*/) {
            $resData = $this->_req('check', array_merge(array(
                'url' => $this->siteUrl,
                'plugin_code' => $this->_getPluginCode(),
            ), $this->getCredentials()));
            if($resData) {
                $this->_updateLicenseData( $resData['data']['save_data'] );
            } else {
                $this->_setExpired($options);
            }
            //replace slider code
            update_option('_last_important_check_'. $this->getPrefix(), $time);
        } else {
            $daysLeft = $options->get('license_days_left');
            if($daysLeft) {
                $lastServerCheck = $options->get('license_last_check');
                $day = 24 * 3600;
                $daysPassed = floor(($time - $lastServerCheck) / $day);
                if($daysPassed > 0) {
                    $daysLeft -= $daysPassed;
                    $options->save('license_days_left', $daysLeft);
                    $options->save('license_last_check', time());
                    if($daysLeft < 0) {
                        $this->_setExpired($options);
                    }
                }
            }
        }
        return true;
    }
    public function activate($d = array(), $options) {
        if(!$this->options) {
            $this->options = $options;
        }
        $d['mail'] = isset($d['mail']) ? trim($d['mail']) : '';
        $d['key'] = isset($d['key']) ? trim($d['key']) : '';
        if(!empty($d['mail'])) {
            if(!empty($d['key'])) {
                $this->setCredentials($d['mail'], $d['key']);
                if(($resData = $this->_req('activate', array_merge(array(
                        'url' => $this->siteUrl,
                        'plugin_code' => $this->_getPluginCode(),
                    ), $this->getCredentials()))) != false) {
                    $this->_updateLicenseData( $resData['data']['save_data'] );
                    $this->_setActive();
                    return true;
                }
            } else {
                //$this->pushError(__('Please enter your License Key', PPS_LANG_CODE), 'key');
            }
        } else {
            //$this->pushError(__('Please enter your Email address', PPS_LANG_CODE), 'email');
        }
        $this->_removeActive();
        return false;
    }
    private function _updateLicenseData($saveData) {
        $this->options->save('license_save_name', $saveData['license_save_name']);
        $this->options->save('license_save_val', $saveData['license_save_val']);
        $this->options->save('license_days_left', $saveData['days_left']);
        $this->options->save('license_last_check', time());
        //dbPps::query('UPDATE @__modules SET active = 1 WHERE ex_plug_dir IS NOT NULL AND ex_plug_dir != "" AND code != "license"');
    }
    private function _setExpired($options) {
        //replace slider code here
        update_option('_last_expire_'. $this->getPrefix(), 1);
        $this->_removeActive();
        if($this->enbOptimization()) {
//            dbPps::query('UPDATE @__modules SET active = 0 WHERE ex_plug_dir IS NOT NULL AND ex_plug_dir != "" AND code != "license"');
            $options->save('license_days_left', -1);
        }
    }
    public function isExpired() {
        //replace slider code here
        return (int) get_option('_last_expire_'. $this->getPrefix());
    }
    public function isActive($options) {
        $option = get_option($options->get('license_save_name'));
        return ($option && $option == $options->get('license_save_val'));
    }
    public function _setActive() {
        update_option('_site_transient_update_plugins', ''); // Trigger plugins updates check
        update_option($this->options->get('license_save_name'), $this->options->get('license_save_val'));
        //replace slider code here
        delete_option('_last_expire_'. $this->getPrefix());
    }
    public function _removeActive() {
        $name = $this->options->get('license_save_name');
        if(!empty($name)) {
            delete_option($name);
        }
    }
    public function setCredentials($email, $key) {
        $this->setEmail($email);
        $this->setLicenseKey($key);
    }
    public function setEmail($email) {
        $this->options->save('license_email', base64_encode( $email ));
    }
    public function setLicenseKey($key) {
        $this->options->save('license_key', base64_encode( $key ));
    }
	public function getEmail($options) {
		if($this->options) {
			return base64_decode( $this->options->get('license_email') );
		} else if($options) {
			return base64_decode( $options->get('license_email') );
		} else {
			return false;
		}
	}
	public function getLicenseKey($options) {
		if($this->options) {
			return base64_decode( $this->options->get('license_key') );
		} else if($options) {
			return base64_decode( $options->get('license_key') );
		} else {
			return false;
		}
	}
    public function getCredentials($options = null) {
        return array(
            'email' => $this->getEmail($options),
            'key' => $this->getLicenseKey($options),
        );
    }
    private function _req($action, $data = array()) {
        $data = array_merge($data, array(
            'mod' => 'manager',
            'pl' => 'lms',
            'action' => $action,
        ));
        $response = wp_remote_post($this->_apiUrl, array(
            'body' => $data
        ));
        if(is_wp_error($response)) {
			// Try it with native CURL - maybe this will work
			$curlNativeTry = $this->_reqWithCurl($data);
			if($curlNativeTry) {
				$response = array('body' => $curlNativeTry);
			}
		}
        if (!is_wp_error($response)) {
            if(isset($response['body']) && !empty($response['body']) && ($resArr = $this->jsonDecode($response['body']))) {
                if(!$resArr['error']) {
                    return $resArr;
                } else {
                    //Error
                    $this->pushError($resArr['errors']);
                }
            } else {
                $this->pushError((isset($response['response']) && $response['response']['message'] && !empty($response['response']['message'])? $response['response']['message'] : $this->trans('There was a problem with sending request to our authentication server. Please try latter.')));
            }
        } else {
            $this->pushError($response);
        }
        return false;
    }
	private function _reqWithCurl($data) {
		if(!function_exists('curl_init')) return false;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->_apiUrl);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__). DS. 'cacert.pem');

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$result = curl_exec($ch);

		curl_close($ch);
		return $result ? $result : false;
	}
    private function _initApiUrl() {
        if(empty($this->_apiUrl)) {
            $this->_apiUrl = 'http://supsystic.com/';
        }
    }
    public function enbOptimization() {
        return false;
    }
    public function checkPreDeactivateNotify($options) {
        $daysLeft = (int) $options->get('license_days_left');
        if($daysLeft > 0 && $daysLeft <= 3) {	// Notify before 3 days
            add_action('admin_notices', array($this, 'showPreDeactivationNotify'));
        }
    }
    public function showPreDeactivationNotify() {
        $daysLeft = (int) $this->options->get('license_days_left');
        $msg = '';
        if($daysLeft == 0) {
            $msg = 'License for plugin will expire today.';
        } elseif($daysLeft == 1) {
            $msg = 'License for plugin will expire tomorrow.';
        } else {
            $msg = 'License for plugin will expire in ' . $daysLeft . ' days.';
        }
        echo '<div class="error">'. $msg. '</div>';
    }
    public function updateDb() {
        if(!$this->enbOptimization())
            return;
        $time = time();
        //replace slider code here
        $lastCheck = (int) get_option('_last_wp_check_imp_'. $this->getPrefix());
        if(!$lastCheck || ($time - $lastCheck) >= 5 * 24 * 3600 /** 0/*remove last!!!*/) {
            if($this->isActive($this->options)) {
                //dbPps::query('UPDATE @__modules SET active = 1 WHERE ex_plug_dir IS NOT NULL AND ex_plug_dir != "" AND code != "license"');
            } else {
                //dbPps::query('UPDATE @__modules SET active = 0 WHERE ex_plug_dir IS NOT NULL AND ex_plug_dir != "" AND code != "license"');
            }
            //remove slider code here
            update_option('_last_wp_check_imp_'. $this->getPrefix(), $time);
        }
    }
    private function _getPluginCode() {
        return $this->environment->getConfig()->get('plugin_product_code');
    }
    public function getExtendUrl() {
        $license = $this->getCredentials();
        $license['key'] = md5($license['key']);
        $license = urlencode(base64_encode(implode('|', $license)));
        return $this->_apiUrl. '?mod=manager&pl=lms&action=extend&plugin_code='. $this->_getPluginCode(). '&lic='. $license;
    }
    private function jsonDecode($str) {
        if(is_array($str))
            return $str;
        if(is_object($str))
            return (array)$str;
        return empty($str) ? array() : json_decode($str, true);
    }

    private function pushError($error)
    {
        if (is_wp_error($error) && method_exists($error, 'get_error_message')) {
            $error = $error->get_error_message();
        }

        if (is_object($error) && !method_exists($error, '__toString')) {
            $error = (array)$error;
        }

        if (is_array($error)) {
            $error = array_pop($error);
        }

        $this->errors[] = $error;
    }

    public function getErrors()
    {
        $errors = $this->errors;
        $this->errors = array();

        return $errors;
    }

    public function getFirstError()
    {
        return reset($this->errors);
    }

    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    public function haveErrors()
    {
        return $this->hasErrors();
    }

    private function trans($str)
    {
        if ($this->environment instanceof Rsc_Environment) {
            return $this->environment->translate($str);
        }

        return __($str);
    }
} 