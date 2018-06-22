<?php

/**
 * Swiper-Slider module.
 *
 * Allows to use Swiper-Slider as Slider by Supsystic module.
 */
class SupsysticSliderPro_Comparison_Module extends Rsc_Mvc_Module implements SupsysticSlider_Slider_Interface
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
		return 'Comparison Slider';
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
				'supsysticSlider-comparison-settings',
				$this->getLocationUrl() . '/assets/js/settings.js',
				array(),
				'1.0.0',
				true
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

		foreach($slider->images as $key => $value) {
			$slider->images[$key]->attachment['description'] = html_entity_decode(
				$slider->images[$key]->attachment['description']
			);
		}

		return $twig->render('@comparison/markup.twig', array('slider' => $slider));

	}


	/**
	 * Enqueue javascript.
	 */
	public function enqueueJavascript()
	{
		wp_enqueue_script('jquery');

		wp_enqueue_script(
			'supsysticSlider-comparisonSliderPlugin',
			$this->getLocationUrl() . '/assets/js/cocoen.min.js',
			array(),
			'1.0.0',
			true
		);
		wp_enqueue_script(
			'supsysticSlider-comparisonSlider-frontend',
			$this->getLocationUrl() . '/assets/js/cocoen-jquery.min.js',
			array(),
			'1.0.0',
			true
		);
		wp_enqueue_script(
			'supsysticSlider-comparisonSlider-frontend',
			$this->getLocationUrl() . '/assets/js/frontend.js',
			array(),
			'1.0.0',
			true
		);
		wp_enqueue_script(
			'supsysticSlider-comparisonSlider-frontend-test',
			$this->getLocationUrl() . '/assets/js/test.js',
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
			'supsysticSlider-comparisonSliderPluginStyles',
			$this->getLocationUrl() . '/assets/css/cocoen.min.css',
			array(),
			'1.0.0',
			'all'
		);
	}

	public function getSettingsTemplate()
	{
		return '@comparison/settings.twig';
	}

	public function getSliderTemplate()
	{
		return '@comparison/markup.twig';
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