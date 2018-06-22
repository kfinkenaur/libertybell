<?php

/**
 * Swiper-Slider module.
 *
 * Allows to use Swiper-Slider as Slider by Supsystic module.
 */
class SupsysticSliderPro_Swiper_Module extends Rsc_Mvc_Module implements SupsysticSlider_Slider_Interface
{
    const OPT_TRUE  = 'true';
    const OPT_FALSE = 'false';

    /**
     * Module initialization.
     * Loads assets and registers current module as slider.
     */
    public function onInit()
    {
        // Load module assets.
	    add_action('admin_enqueue_scripts', array($this, 'loadAssets'));
    }
	/**
	 * Returns slider name.
	 */
	public function getSliderName() {
		return 'Swiper Slider';
	}

    /**
     * Loads plugin assets.
     *
     */
    public function loadAssets()
    {
	    $environment = $this->getEnvironment();

	    if(!$this->isPluginPage()){
		    return;
	    }

	    if ($environment->isAction('view')) {
		    wp_enqueue_script(
			    'supsysticSlider-swiper-settings',
			    $this->getLocationUrl() . '/assets/js/settings.js',
			    array(),
			    '1.0.0',
			    true
		    );
		    wp_enqueue_style(
			    'supsysticSlider-swiper-buttons',
			    $this->getLocationUrl() . '/assets/css/backend-swiper.css',
			    array(),
			    '1.0.0',
			    'all'
		    );
	    }
    }

    /**
     * Returns default slider settings.
     *
     * @return array
     */
    public function getDefaults()
    {
        return array(
        	'properties'=>array(
        		'width' => 400,
		        'height'=> 240,
	        ),
        	'general' => array(
		        'effect' => 'coverflow',
		        'direction' => "horizontal",
		        'slidesPerView' => 3,
		        'loop' => 'true',
		        'keyboardControl' => 'true',
		        'mousewheelControl' => 'true',
		        'grabCursor' => 'true',
	        ),
	        'effects' => array (
		        'coverflow'  => array(
					'rotate' => 0,
					'stretch' => 50,
					'depth' => 100,
					'modifier' => 1,
					'slideShadows'  => 'false',
	            ),
		        'flip'   => array(
			        'limitRotation' => 'true',
			        'slideShadows' => 'true',
		        )
	        ),
	        'advanced' => array(
		        'nextButton' => 'button-next',
		        'prevButton' => 'button-prev',
		        'lazyLoading' => 'false',
		        'pagination' => 'pagination',
		        'centeredSlides' => 'false',
	        ),
        );
    }

    public function getPresetSettings($presetName) {
        return $this->getDefaults();
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
        
//        foreach($slider->images as $key => $value) {
//            $link = get_post_meta($value->attachment_id, '_slider_link');
//            $target = get_post_meta($value->attachment_id, 'target');
//
//			if($link && !empty($link)) {
//                $slider->images[$key]->attachment['external_link'] = $link[0];
//            }
//            if($target && !empty($target)) {
//                $slider->images[$key]->attachment['target'] = $target[0];
//            }
//
//            $slider->images[$key]->attachment['description'] = html_entity_decode($slider->images[$key]->attachment['description']);
//        }
//
//        return $twig->render('@swiper/markup.twig', array('slider' => $slider));


	    foreach($slider->images as $key => $value) {
		    $slider->images[$key]->attachment['description'] = html_entity_decode(
			    $slider->images[$key]->attachment['description']
		    );
	    }

	    return $twig->render('@swiper/markup.twig', array('slider' => $slider));

    }


    /**
     * Enqueue javascript.
     */
    public function enqueueJavascript()
    {
        wp_enqueue_script('jquery');

        wp_enqueue_script(
            'supsysticSlider-coinSliderPlugin',
            $this->getLocationUrl() . '/assets/js/swiper.jquery.js',
            array(),
            '1.0.0',
            true
        );

        wp_enqueue_script(
            'supsysticSlider-coinSlider-frontend',
            $this->getLocationUrl() . '/assets/js/frontend.js',
            array(),
            '1.0.0',
            true
        );

    }

	/**
	 * Enqueue stylesheet.
	 */
	public function enqueueStylesheet()
	{
		wp_enqueue_style(
			'supsysticSlider-swiperSliderPluginStyles',
			$this->getLocationUrl() . '/assets/css/swiper.css',
			array(),
			'1.0.0',
			'all'
		);
	}

    public function getSettingsTemplate()
    {
        return '@swiper/settings.twig';
    }

    public function getSliderTemplate()
    {
        return '@swiper/markup.twig';
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