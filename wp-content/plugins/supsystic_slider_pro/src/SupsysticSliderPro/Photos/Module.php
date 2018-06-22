<?php


class SupsysticSliderPro_Photos_Module extends SupsysticSlider_Photos_Module
{
    public function onInit()
    {
        $this->setOverloadController(true);

        $dispatcher = $this->getEnvironment()->getDispatcher();
        $dispatcher->on('after_ui_loaded', array($this, 'loadVideoAssets'));

        parent::onInit();
    }

    /**
     * Loads assets to add video support.
     *
     * @param SupsysticSlider_Ui_Module $ui UI module.
     */
    public function loadVideoAssets(SupsysticSlider_Ui_Module $ui)
    {
        $url            = untrailingslashit(plugin_dir_url(__FILE__));
        $preventCaching = $this->getEnvironment()->isDev();
        $environment = $this->getEnvironment();

        $ui->add(new SupsysticSlider_Ui_BackendJavascript('jquery-ui-dialog'));

        if($environment->getPluginName() != 'ssl'){
            return;
        }

        $ui->add(
            new SupsysticSlider_Ui_BackendJavascript(
                'rsVideoSupport',
                $url . '/assets/js/video.js',
                $preventCaching
            )
        );
    }
} 