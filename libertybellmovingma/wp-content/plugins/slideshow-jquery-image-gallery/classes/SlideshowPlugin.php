<?php
/**
 * Class SlideslowPlugin is called whenever a slideshow do_action tag is come across.
 * Responsible for outputting the slideshow's HTML, CSS and Javascript.
 *
 * @since 1.0.0
 * @author: Stefan Boonstra
 * @version: 03-03-2013
 */
class SlideshowPlugin {

	/** int $sessionCounter */
	private static $sessionCounter = 0;

	/**
	 * Function deploy prints out the prepared html
	 *
	 * @since 1.2.0
	 * @param int $postId
	 */
	static function deploy($postId = null){
		echo self::prepare($postId);
	}

	/**
	 * Function prepare returns the required html and enqueues
	 * the scripts and stylesheets necessary for displaying the slideshow
	 *
	 * Passing this function no parameter or passing it a negative one will
	 * result in a random pick of slideshow
	 *
	 * @since 2.1.0
	 * @param int $postId
	 * @return String $output
	 */
	static function prepare($postId = null){

		$post = null;

		// Get post by its ID, if the ID is not a negative value
		if(is_numeric($postId) && $postId >= 0)
			$post = get_post($postId);

		// Get slideshow by slug when it's a non-empty string
		if($post === null && is_string($postId) && !is_numeric($postId) && !empty($postId)){
			$query = new WP_Query(array(
				'post_type' => SlideshowPluginPostType::$postType,
				'name' => $postId,
				'orderby' => 'post_date',
				'order' => 'DESC',
				'suppress_filters' => true
			));

			if($query->have_posts())
				$post = $query->next_post();
		}

		// When no slideshow is found, get one at random
		if($post === null){
			$post = get_posts(array(
				'numberposts' => 1,
				'offset' => 0,
				'orderby' => 'rand',
				'post_type' => SlideshowPluginPostType::$postType,
				'suppress_filters' => true
			));

			if(is_array($post))
				$post = $post[0];
		}

		// Exit on error
		if($post === null)
			return '<!-- Wordpress Slideshow - No slideshows available -->';

		// Log slideshow's issues to be able to track them on the page.
		$log = array();

		// Get views
		$views = SlideshowPluginSlideshowSettingsHandler::getViews($post->ID);
		if(!is_array($views) || count($views) <= 0)
			$log[] = 'No views were found';

		// Get settings
		$settings = SlideshowPluginSlideshowSettingsHandler::getSettings($post->ID);
		$styleSettings = SlideshowPluginSlideshowSettingsHandler::getStyleSettings($post->ID);

		// The slideshow's session ID, allows JavaScript and CSS to distinguish between multiple slideshows
		$sessionID = self::$sessionCounter++;

		// Try to get a custom stylesheet
		if(isset($styleSettings['style'])){

			// Try to get the custom style's version
			$customStyle = get_option($styleSettings['style'], false);
			$customStyleVersion = false;
			if($customStyle){
				$customStyleVersion = get_option($styleSettings['style'] . '_version', false);
			}

			// Style name and version
			if($customStyle && $customStyleVersion){
				$styleName = $styleSettings['style'];
				$styleVersion = $customStyleVersion;
			}else{
				$styleName = str_replace('.css', '', $styleSettings['style']);
				$styleVersion = SlideshowPluginMain::$version;
			}
		}else{
			$styleName = 'style-light';
			$styleVersion = SlideshowPluginMain::$version;
		}

		// Register function stylesheet
		wp_enqueue_style(
			'slideshow-jquery-image-gallery-stylesheet_functional',
			SlideshowPluginMain::getPluginUrl() . '/style/' . __CLASS__ . '/functional.css',
			array(),
			SlideshowPluginMain::$version
		);

		// Enqueue stylesheet
		wp_enqueue_style(
			'slideshow-jquery-image-gallery-ajax-stylesheet_' . $styleName,
			admin_url('admin-ajax.php?action=slideshow_jquery_image_gallery_load_stylesheet&style=' . $styleName),
			array(),
			$styleVersion
		);

		// Include output file to store output in $output.
		$output = '';
		ob_start();
		include(SlideshowPluginMain::getPluginPath() . '/views/' . __CLASS__ . '/slideshow.php');
		$output .= ob_get_clean();

		// Enqueue slideshow script
		wp_enqueue_script(
			'slideshow-jquery-image-gallery-script',
			SlideshowPluginMain::getPluginUrl() . '/js/' . __CLASS__ . '/slideshow.min.js',
			array('jquery'),
			SlideshowPluginMain::$version
		);

		// Set dimensionWidth and dimensionHeight if dimensions should be preserved
		if(isset($settings['preserveSlideshowDimensions']) && $settings['preserveSlideshowDimensions'] == 'true'){

			$aspectRatio = explode(':', $settings['aspectRatio']);

			// Width
			if(isset($aspectRatio[0]) && is_numeric($aspectRatio[0]))
				$settings['dimensionWidth'] = $aspectRatio[0];
			else
				$settings['dimensionWidth'] = 1;

			// Height
			if(isset($aspectRatio[1]) && is_numeric($aspectRatio[1]))
				$settings['dimensionHeight'] = $aspectRatio[1];
			else
				$settings['dimensionHeight'] = 1;
		}

		// Include slideshow settings by localizing them
		wp_localize_script(
			'slideshow-jquery-image-gallery-script',
			'SlideshowPluginSettings_' . $sessionID,
			$settings
		);

		// Return output
		return $output;
	}
}
