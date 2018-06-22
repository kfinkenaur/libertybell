<?php
/**
 * For now this is just dummy mode to identify that we have installed licensed version
 */
class licensePps extends modulePps {
	public function init() {
		parent::init();
		dispatcherPps::addFilter('mainAdminTabs', array($this, 'addAdminTab'));
		add_action('admin_notices', array($this, 'checkActivation'));
		add_action('init', array($this, 'addAfterInit'));
		$this->_licenseCheck();
		$this->_updateDb();

        // add licence activate/renew link to plugin control panel on plugins list
		if(is_admin()) {
			$pathInfo = pathinfo(dirname(__FILE__));
			$plugName = plugin_basename($pathInfo['dirname'] . DS. 'popup-by-supsystic-pro.php');
			add_filter('plugin_action_links_'. $plugName, array($this, 'addLicenseLinkForPlug') );
		}
	}
	public function addAfterInit() {
		if(!function_exists('getProPlugDirPps'))
			return;
		add_action('in_plugin_update_message-'. getProPlugDirPps(). '/'. getProPlugFilePps(), array($this, 'checkDisabledMsgOnList'), 1, 2);
	}
	public function checkDisabledMsgOnList($plugin_data, $r) {
		if($this->getModel()->isExpired()) {
			$licenseTabUrl = framePps::_()->getModule('options')->getTabUrl('license');
			echo '<br />'
			. sprintf(__('Your license has expired. Once you extend your license - you will be able to Update PRO version. To extend PRO version license - follow <a href="%s" target="_blank">this link</a>, then - go to <a href="%s">License</a> tab anc click on "Re-activate" button to re-activate your PRO version.', PPS_LANG_CODE), $this->getExtendUrl(), $licenseTabUrl);
		}
	}
	public function checkActivation() {
		if(!$this->getModel()->isActive()) {
			$isDismissable = true;
			$msgClasses = 'error';
			if($this->getModel()->isExpired()) {
				$msg = sprintf(
					__('Your plugin PRO license is expired. It means your PRO version will work as usual - with all features and options, but you will not be able to update the PRO version and use PRO support. To extend PRO version license - follow <a href="%s" target="_blank">this link</a>', PPS_LANG_CODE),
					$this->getExtendUrl()
				);
			} else {
				$msg = sprintf(
					__('You need to activate your copy of PRO version %s plugin. Go to <a href="%s">License</a> tab and finish your software activation process.', PPS_LANG_CODE),
					PPS_WP_PLUGIN_NAME,
					framePps::_()->getModule('options')->getTabUrl('license')
				);
			}
			// Make it little bit pretty)
			$msg = '<p>'. $msg. '</p>';
			
			if($isDismissable) {
				$dismiss = (int) framePps::_()->getModule('options')->get('dismiss_pro_opt');
				if($dismiss) return;	// it was already dismissed by user - no need to show it again
				// Those classes required to display close "X" button in message
				$msgClasses .= ' notice is-dismissible supsystic-pro-notice pps-notification';
				// And ofcorse - connect our core scripts (to use core ajax handler), and script with saving "dismiss_pro_opt" option ajax send request
				framePps::_()->getModule('templates')->loadCoreJs();
				framePps::_()->addScript('pps.admin.license.notices', $this->getModPath(). 'js/admin.license.notices.js');
			}
			$html = '<div class="'. $msgClasses. '">'. $msg. '</div>';
			echo $html;
		}
	}
	public function getExtendUrl() {
		return $this->getModel()->getExtendUrl();
	}
	public function addAdminTab($tabs) {
		$tabs[ $this->getCode() ] = array(
			'label' => __('License', PPS_LANG_CODE), 'callback' => array($this, 'getTabContent'), 'fa_icon' => 'fa-hand-o-right', 'sort_order' => 999,
		);
		return $tabs;
	}
	public function getTabContent() {
		return $this->getView()->getTabContent();
	}
	private function _licenseCheck() {
		if($this->getModel()->isActive()) {
			$this->getModel()->check();
			$this->getModel()->checkPreDeactivateNotify();
		}
	}
	private function _updateDb() {
		$this->getModel()->updateDb();
	}
    public function addLicenseLinkForPlug($links) {
        if(is_array($links)) {
            $linkTitle = '';
            $expired = $this->getController()->getModel()->isExpired();
            $isActive = $this->getController()->getModel()->isActive();

            if(!$isActive) {
                $linkTitle = __('Activate License', PPS_LANG_CODE);
            } elseif ($expired) {
                $linkTitle = __('Renew License', PPS_LANG_CODE);
            }
            if($linkTitle) {
                $href = framePps::_()->getModule('options')->getTabUrl('license');
                $links[] = '<a href="' . $href . '">' . $linkTitle . '</a>';
            }
        }
        return $links;
    }
}
