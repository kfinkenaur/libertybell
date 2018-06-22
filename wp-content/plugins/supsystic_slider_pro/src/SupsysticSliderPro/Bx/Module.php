<?php


class SupsysticSliderPro_Bx_Module extends SupsysticSlider_Bx_Module implements SupsysticSlider_Slider_Interface
{
    /**
     * {@inheritdoc}
     */
    public function onInit()
    {
        parent::onInit();
        // Switch controller to the PRO version.
        $this->setOverloadController(true);
    }

    /**
     * {@inheritdoc}
     */
    public function enqueueJavascript()
    {
        wp_enqueue_scripts('jquery');

        wp_enqueue_script(
            'supsysticSlider-bxSliderPluginFitvid',
            $this->getLocationUrl() . '/assets/plugins/jquery.fitvids.js',
            array(),
            '1.0.0',
            true
        );

        wp_enqueue_script(
            'supsysticSlider-bxSliderPlugin',
            $this->getLocationUrl() . '/assets/js/jquery.bxslider.js',
            array(),
            '1.0.0',
            true
        );

        wp_enqueue_script(
            'supsysticSlider-bxSlider',
            $this->getLocationUrl() . '/assets/js/frontend.js',
            array(),
            '1.0.0',
            true
        );

        wp_enqueue_script(
            'google-font-loader',
            '//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js',
            array(),
            '1.0.0',
            true
        );
    }


    /**
     * {@inheritdoc}
     */
    public function getDefaults()
    {
        return array_merge(
            parent::getDefaults(),
            array(
                'pro' => array(
                    'video'  => self::OPT_TRUE,
                    'useCSS' => self::OPT_FALSE
                )
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getSettingsTemplate()
    {
        return '@bx_pro/settings.twig';
    }

    public function getSliderTemplate()
    {
        return '@bx_pro/markup.twig';
    }


} 