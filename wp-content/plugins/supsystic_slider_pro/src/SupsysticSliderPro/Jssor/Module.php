<?php

/**
 * jssor-Slider module.
 *
 * Allows to use Jssor-Slider as Slider by Supsystic module.
 */
class SupsysticSliderPro_Jssor_Module extends Rsc_Mvc_Module implements SupsysticSlider_Slider_Interface
{

    const OPT_TRUE  = 'true';
    const OPT_FALSE = 'false';

    /**
     * Module initialization.
     * Loads assets and registers current module as slider.
     */
    public function onInit()
    {
        $dispatcher = $this->getEnvironment()->getDispatcher();

        // Load module assets.
        //add_action('admin_footer', array($this, 'loadAssets'));
        add_action('admin_enqueue_scripts', array($this, 'loadAssets'));

        $twig = $this->getEnvironment()->getTwig();
        $twig->addFunction(new Twig_SimpleFunction('do_shortcode', 'do_shortcode'));
    }

    /**
     * Returns default slider settings.
     *
     * @return array
     */
    public function getDefaults()
    {
        return array(
            'general' => array(
                'mode' => 'horizontal'
            ),
            'effects' => array(
                'arrows' => 'jssora01',
                'bullet' => 'disable',
                'responsive' => 'false',
                'thumbnails' => array(
                    'enable' => 'false',
                    'type' => 'horizontal'
                ),
                'slideshow' => 'false',
				'slideshowDisableEffects' => 'false',
                'slideshowSpeed' => '1500'
            ),
            'properties' => array(
                'width'  => 400,
                'height' => 240,
                'shadow' => 'disable'
            ),
			'post_settings' => array(
				'title'  => 'true',
				'date' => 'true',
				'excerpt' => 'false',
				'read_more' => 'true'
			),
        );
    }

    public function getPresetSettings($presetName) {
        return $this->getDefaults();
    }

    public function loadAssets()
    {
        $environment = $this->getEnvironment();

        if(!$this->isPluginPage()){
            return;
        }

        if ($environment->isAction('view')) {
            wp_enqueue_script(
                'supsysticSlider-jssor-settings',
                $this->getLocationUrl() . '/assets/js/settings.js',
                array(),
                '1.0.0',
                true
            );

            wp_enqueue_script(
                'supsysticSlider-slide-editor',
                $this->getLocationUrl() . '/assets/js/slide-content-editor.js',
                array(),
                '1.0.0',
                true
            );

            wp_enqueue_style(
                'supsysticSlider-slide-buttons',
                $this->getLocationUrl() . '/assets/css/caption-buttons.css',
                array(),
                '1.0.0',
                'all'
            );

            wp_enqueue_script('jquery-ui-slider');

            wp_enqueue_script(
                'supsysticSlider-jssor-preview',
                $this->getLocationUrl() . '/assets/js/frontend.js',
                array(),
                '1.0.0',
                true
            );
        }

        wp_enqueue_script(
            'supsysticSlider-jssor',
            $this->getLocationUrl() . '/assets/js/jssor.js',
            array(),
            '1.0.0',
            true
        );

        wp_enqueue_script(
            'supsysticSlider-jssor-slider',
            $this->getLocationUrl() . '/assets/js/jssor.slider.js',
            array(),
            '1.0.0',
            true
        );

        wp_enqueue_script(
            'supsysticSlider-jssor-ytiframe',
            $this->getLocationUrl() . '/assets/js/jssor.player.ytiframe.js',
            array(),
            '1.0.0',
            true
        );

        /*wp_enqueue_script(
            'supsysticSlider-jssor-frontend',
            $this->getLocationUrl() . '/assets/js/frontend.js',
            array(),
            '1.0.0',
            true
        );*/

        wp_enqueue_style(
            'supsysticSlider-jssorSliderStyles',
            $this->getLocationUrl() . '/assets/css/jssor-slider-styles.css',
            array(),
            '1.0.0',
            'all'
        );

        wp_enqueue_style(
            'supsysticSlider-slide-content-styles',
            $this->getLocationUrl() . '/assets/css/editor-styles.css',
            array(),
            '1.0.0',
            'all'
        );

    }

    /**
     * Renders specified slider and returns markup.
     *
     * @param object $slider Slider.
     * @return string
     */
    public function render($slider)
    {
        $twig = $this->getEnvironment()->getTwig();

        foreach($slider->images as $key => $value) {
            $slider->images[$key]->attachment['description'] = html_entity_decode(
				$slider->images[$key]->attachment['description']
			);
        }
        
        return $twig->render('@jssor/markup.twig', array('slider' => $slider));
    }

    /**
     * Returns slider name.
     *
     * @return string
     */
    public function getSliderName()
    {
        return 'Jssor Slider';
    }

    /**
     * Enqueue javascript.
     */
    public function enqueueJavascript()
    {
        wp_enqueue_script('jquery');

        wp_enqueue_script(
            'supsysticSlider-jssor',
            $this->getLocationUrl() . '/assets/js/jssor.js',
            array(),
            '1.0.0',
            true
        );

        wp_enqueue_script(
            'supsysticSlider-jssorSlider',
            $this->getLocationUrl() . '/assets/js/jssor.slider.js',
            array(),
            '1.0.0',
            true
        );

        wp_enqueue_script(
            'supsysticSlider-frontend-jssorSlider',
            $this->getLocationUrl() . '/assets/js/frontend.js',
            array(),
            '1.0.0',
            true
        );

        wp_enqueue_script(
            'supsysticSlider-jssor-ytiframe',
            $this->getLocationUrl() . '/assets/js/jssor.player.ytiframe.js',
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

    public function getSettingsTemplate()
    {
        return '@jssor/settings.twig';
    }

    public function getSliderTemplate()
    {
        return '@jssor/markup.twig';
    }

    /**
     * Enqueue stylesheet.
     */
    public function enqueueStylesheet()
    {
        wp_enqueue_style(
            'supsysticSlider-jssorSliderStyles',
            $this->getLocationUrl() . '/assets/css/jssor-slider-styles.css',
            array(),
            '1.0.0',
            'all'
        );

        wp_enqueue_style(
            'supsysticSlider-slide-buttons',
            $this->getLocationUrl() . '/assets/css/caption-buttons.css',
            array(),
            '1.0.0',
            'all'
        );
    }

    /**
     * Is this slider available to use in free version.
     *
     * @return bool
     */
    public function isFree()
    {
        return false;
    }
}