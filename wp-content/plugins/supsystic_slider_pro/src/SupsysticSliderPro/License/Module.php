<?php


class SupsysticSliderPro_License_Module extends Rsc_Mvc_Module
{
    private $options;

    private $helper;

    /**
     * {@inheritdoc}
     */
    public function onInit()
    {
        $environment = $this->getEnvironment();
        $config = $environment->getConfig();

        $this->registerMenu();

        $config->add('disable_msg', '');

        add_action('admin_footer', array($this, 'loadAssets'));

        add_action('admin_notices', array($this, 'checkActivation'));
        add_action('init', array($this, 'addAfterInit'));

        $this->_licenseCheck();
        $this->filterActionLinks();
    }

    public function getLocationUrl()
    {
        return untrailingslashit(plugin_dir_url(__FILE__));
    }

    public function addLicenseLink($links)
    {
        $environment = $this->getEnvironment();

        if (is_array($links)) {
            $linkTitle = null;
            $options = $this->getOptions();
            $helper = $this->getHelper();
            $expired = $helper->isExpired();
            $isActive = $helper->isActive($options);

            if (!$isActive) {
                $linkTitle = $environment->translate('Activate License');
            } elseif ($expired) {
                $linkTitle = $environment->translate('Renew License');
            }

            if ($linkTitle) {
                $href = $environment->generateUrl('license');
                $links[] = '<a href="' . $href . '">' . $linkTitle . '</a>';
            }
        }

        return $links;
    }

    /**
     * Loads the assets required by the module
     */
    public function loadAssets()
    {
        $environment = $this->getEnvironment();

        if (!$environment->isModule('license')) {
            return;
        }

        wp_enqueue_script(
            'supsysticSlider-license-js',
            $this->getLocationUrl() . '/assets/js/license.js',
            array(),
            '1.0.0',
            'all'
        );

        wp_enqueue_style(
            'supsysticSlider-license-style',
            $this->getLocationUrl() . '/assets/css/license-styles.css',
            array(),
            '1.0.0',
            'all'
        );
    }

    protected function registerMenu() {
        $menu = $this->getEnvironment()->getMenu();

        $submenu = $menu->createSubmenuItem();
        $submenu->setCapability('manage_options')
            ->setMenuSlug($menu->getMenuSlug() . '&module=license')
            ->setMenuTitle($this->translate('License'))
            ->setPageTitle($this->translate('License'))
            ->setModuleName('license')
			->setSortOrder(80);

        $menu->addSubmenuItem('license', $submenu)->register();
    }

    public function addAfterInit() {
        if(!function_exists('getProPlugDirPps'))
            return;
        //add_action('in_plugin_update_message-'. getProPlugDirPps(). '/'. getProPlugFilePps(), array($this, 'checkDisabledMsgOnList'), 1, 2);
    }
    public function checkDisabledMsgOnList($plugin_data, $r) {
        if($this->getHelper()->isExpired()) {
            $msg = 'Your license is expired. Once you extend your license - you will be able to Update PRO version. Go to License tab and click on "Re-activate" button to re-activate your PRO version.';
            $this->getEnvironment()->getConfig()->set('disable_msg', $msg);
        }
    }

    public function isActive()
    {
        return $this->getHelper()->isActive($this->getOptions());
    }

    public function checkActivation() {
        $options = $this->getOptions();

        if(!$this->getHelper()->isActive($options)) {
			$isDismissable = true;
			$msgClasses = 'error';
            if($this->getHelper()->isExpired()) {
				$msg = sprintf(
					'Your plugin PRO license is expired. It means your PRO version will work as usual - with all features and options, but you will not be able to update the PRO version and use PRO support. To extend PRO version license - follow <a href="%s" target="_blank">this link</a>',
					$this->getExtendUrl()
				);
			} else {
				$msg = sprintf(
					'You need to activate your copy of PRO version %s. Go to <a href="%s">License</a> tab and finish your software activation process.',
					$this->getEnvironment()->getMenu()->getMenuTitle(),
					$this->getEnvironment()->generateUrl('license')
				);
            }
			// Make it little bit pretty)
			$msg = '<p>'. $msg. '</p>';
			if($isDismissable) {
				$dismiss = (int) $this->getOptions()->get('dismiss_pro_opt');
				if($dismiss) return;	// it was already dismissed by user - no need to show it again
				// Those classes required to display close "X" button in message
				$msgClasses .= ' notice is-dismissible supsystic-pro-notice ss-notification';
				wp_enqueue_script(
					'ss-supsystic-dismiss-license-js',
					$this->getLocationUrl() . '/assets/js/dismiss.license.js',
					array(),
					'1.0.0',
					'all'
				);
			}
            $html = '<div class="'. $msgClasses. '">'. $msg. '</div>';
            echo $html;
        }
    }
    public function getExtendUrl() {
        return $this->getHelper()->getExtendUrl();
    }
    private function _licenseCheck() {
        $options = $this->getOptions();
        $helper = $this->getHelper();

        if ($helper->isActive($options)) {
            $helper->check($options);
            $helper->checkPreDeactivateNotify($options);
//            $this->load();
        }
    }
    private function _updateDb() {
        $this->getHelper()->updateDb();
    }

    private function getModuleNamespace(Rsc_Mvc_Module $module /* deprecated */)
    {
        $config = $this->getEnvironment()->getConfig();

        return $config->get('pro_modules_prefix');
    }

    private function getModel($name)
    {
        $className = $this->buildModelClassName($name);

        if (!class_exists($className)) {
            throw new InvalidArgumentException(sprintf('Can\'t find model %s.', $className));
        }

        $model = new $className($this->getEnvironment());

        return $model;
    }

    private function buildModelClassName($name)
    {
        return $this->getModuleNamespace($this) . '_' . ucfirst($this->getModuleName()) . '_Model_' . ucfirst($name);
    }

    public function getOptions()
    {
        if (null === $this->options) {
            $this->options = $this->getModel('options');
        }

        return $this->options;
    }

    public function getHelper()
    {
        if (null === $this->helper) {
            $this->helper = $this->getModel('helper');
        }

        return $this->helper;
    }

    private function filterActionLinks()
    {
        $root = $this->getEnvironment()->getPluginPath();
        $pluginId = plugin_basename($root . '/index.php');

        add_filter(
            'plugin_action_links_' . $pluginId,
            array($this, 'addLicenseLink')
        );
    }
} 