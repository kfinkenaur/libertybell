<?php
/**
 * Class SlideshowPluginSlideshowSettingsHandler handles all database/settings interactions for the slideshows.
 *
 * @since 2.1.20
 * @author Stefan Boonstra
 * @version 01-02-2013
 */
class SlideshowPluginSlideshowSettingsHandler {

	/** Nonce */
	static $nonceAction = 'slideshow-jquery-image-gallery-nonceAction';
	static $nonceName = 'slideshow-jquery-image-gallery-nonceName';

	/** Setting keys */
	static $settingsKey = 'settings';
	static $styleSettingsKey = 'styleSettings';
	static $slidesKey = 'slides';

	/** Cached settings stored by slideshow ID */
	static $settings = array();
	static $styleSettings = array();
	static $slides = array();

	/**
	 * Returns all settings that belong to the passed post ID retrieved from
	 * database, merged with default values from getDefaults(). Does not merge
	 * if mergeDefaults is false.
	 *
	 * If all data (including field information and description) is needed,
	 * set fullDefinition to true. See getDefaults() documentation for returned
	 * values. mergeDefaults must be true for this option to have any effect.
	 *
	 * If enableCache is set to true, results are saved into local storage for
	 * more efficient use. If data was already stored, cached data will be
	 * returned, unless $enableCache is set to false. Settings will not be
	 * cached.
	 *
	 * @since 2.1.20
	 * @param int $slideshowId
	 * @param boolean $fullDefinition (optional, defaults to false)
	 * @param boolean $enableCache (optional, defaults to true)
	 * @param boolean $mergeDefaults (optional, defaults to true)
	 * @return mixed $settings
	 */
	static function getAllSettings($slideshowId, $fullDefinition = false, $enableCache = true, $mergeDefaults = true){

		$settings = array();
		$settings[self::$settingsKey] = self::getSettings($slideshowId, $fullDefinition, $enableCache,  $mergeDefaults);
		$settings[self::$styleSettingsKey] = self::getStyleSettings($slideshowId, $fullDefinition, $enableCache,  $mergeDefaults);
		$settings[self::$slidesKey] = self::getSlides($slideshowId, $enableCache);

		return $settings;
	}

	/**
	 * Returns settings retrieved from database.
	 *
	 * For a full description of the parameters, see getAllSettings().
	 *
	 * @since 2.1.20
	 * @param int $slideshowId
	 * @param boolean $fullDefinition (optional, defaults to false)
	 * @param boolean $enableCache (optional, defaults to true)
	 * @param boolean $mergeDefaults (optional, defaults to true)
	 * @return mixed $settings
	 */
	static function getSettings($slideshowId, $fullDefinition = false, $enableCache = true, $mergeDefaults = true){

		if(!is_numeric($slideshowId) || empty($slideshowId))
			return array();

		// Set caching to false and merging defaults to true when $fullDefinition is set to true
		if($fullDefinition){
			$enableCache = false;
			$mergeDefaults = true;
		}

		// If no cache is set, or cache is disabled
		if(!isset(self::$settings[$slideshowId]) || empty(self::$settings[$slideshowId]) || !$enableCache){
			// Meta data
			$settingsMeta = get_post_meta(
				$slideshowId,
				self::$settingsKey,
				true
			);
			if(!$settingsMeta || !is_array($settingsMeta))
				$settingsMeta = array();

			// If the settings should be merged with the defaults as a full definition, place each setting in an array referenced by 'value'.
			if($fullDefinition)
				foreach($settingsMeta as $key => $value)
					$settingsMeta[$key] = array('value' => $value);

			// Get defaults
			$defaults = array();
			if($mergeDefaults)
				$defaults = self::getDefaultSettings($fullDefinition);

			// Merge with defaults, recursively if a the full definition is required
			if($fullDefinition)
				$settings = array_merge_recursive(
					$defaults,
					$settingsMeta
				);
			else
				$settings = array_merge(
					$defaults,
					$settingsMeta
				);

			// Cache if cache is enabled
			if($enableCache){
				self::$settings[$slideshowId] = $settings;
			}
		}else{
			// Get cached settings
			$settings = self::$settings[$slideshowId];
		}

		// Return
		return $settings;
	}

	/**
	 * Returns style settings retrieved from database.
	 *
	 * For a full description of the parameters, see getAllSettings().
	 *
	 * @since 2.1.20
	 * @param int $slideshowId
	 * @param boolean $fullDefinition (optional, defaults to false)
	 * @param boolean $enableCache (optional, defaults to true)
	 * @param boolean $mergeDefaults (optional, defaults to true)
	 * @return mixed $settings
	 */
	static function getStyleSettings($slideshowId, $fullDefinition = false, $enableCache = true, $mergeDefaults = true){

		if(!is_numeric($slideshowId) || empty($slideshowId))
			return array();

		// Set caching to false and merging defaults to true when $fullDefinition is set to true
		if($fullDefinition){
			$enableCache = false;
			$mergeDefaults = true;
		}

		// If no cache is set, or cache is disabled
		if(!isset(self::$styleSettings[$slideshowId]) || empty(self::$styleSettings[$slideshowId]) || !$enableCache){
			// Meta data
			$styleSettingsMeta = get_post_meta(
				$slideshowId,
				self::$styleSettingsKey,
				true
			);
			if(!$styleSettingsMeta || !is_array($styleSettingsMeta))
				$styleSettingsMeta = array();

			// If the settings should be merged with the defaults as a full definition, place each setting in an array referenced by 'value'.
			if($fullDefinition)
				foreach($styleSettingsMeta as $key => $value)
					$styleSettingsMeta[$key] = array('value' => $value);

			// Get defaults
			$defaults = array();
			if($mergeDefaults)
				$defaults = self::getDefaultStyleSettings($fullDefinition);

			// Merge with defaults, recursively if a the full definition is required
			if($fullDefinition)
				$styleSettings = array_merge_recursive(
					$defaults,
					$styleSettingsMeta
				);
			else
				$styleSettings = array_merge(
					$defaults,
					$styleSettingsMeta
				);

			// Cache if cache is enabled
			if($enableCache){
				self::$styleSettings[$slideshowId] = $styleSettings;
			}
		}else{
			// Get cached settings
			$styleSettings = self::$styleSettings[$slideshowId];
		}

		// Return
		return $styleSettings;
	}

	/**
	 * Returns slides retrieved from database.
	 *
	 * For a full description of the parameters, see getAllSettings().
	 *
	 * @since 2.1.20
	 * @param int $slideshowId
	 * @param boolean $enableCache (optional, defaults to true)
	 * @return mixed $settings
	 */
	static function getSlides($slideshowId, $enableCache = true){

		if(!is_numeric($slideshowId) || empty($slideshowId))
			return array();

		// If no cache is set, or cache is disabled
		if(!isset(self::$slides[$slideshowId]) ||	empty(self::$slides[$slideshowId]) || !$enableCache){
			// Meta data
			$slides = get_post_meta(
				$slideshowId,
				self::$slidesKey,
				true
			);
		}else{
			// Get cached settings
			$slides = self::$slides[$slideshowId];
		}

		// Sort slides by order ID
		if(is_array($slides))
			ksort($slides);
		else
			$slides = array();

		// Return
		return $slides;
	}

	/**
	 * Returns an array of SlideshowPluginSlideshowView objects if $returnAsObjects is true, otherwise returns an array
	 * of view arrays that contain slide properties.
	 *
	 * To prevent the result from being cached set $enableCache to false. It's set to true by default.
	 *
	 * @since 2.2.0
	 * @param int $slideshowId
	 * @param bool $returnAsObjects (optional, defaults to true)
	 * @param bool $enableCache (optional, defaults to true)
	 * @return mixed $views
	 */
	static function getViews($slideshowId, $returnAsObjects = true, $enableCache = true){

		// Get slides
		$slides = self::getSlides($slideshowId, $enableCache);

		// Get settings. Since in version 2.2.X slides aren't put into views yet, this has to be done manually
		$settings = SlideshowPluginSlideshowSettingsHandler::getSettings($slideshowId, false, $enableCache);
		$slidesPerView = 1;
		if(isset($settings['slidesPerView']))
			$slidesPerView = $settings['slidesPerView'];

		// Loop through slides, forcing them into views
		$i = 0;
		$viewId = -1;
		$views = array();
		if(is_array($slides)){
			foreach($slides as $slide){

				// Create new view when view is full or not yet created
				if($i % $slidesPerView == 0){

					$viewId++;
					if($returnAsObjects)
						$views[$viewId] = new SlideshowPluginSlideshowView();
					else
						$views[$viewId] = array();
				}

				// Add slide to view
				if($returnAsObjects)
					$views[$viewId]->addSlide($slide);
				else
					$views[$viewId][] = $slide;

				$i++;
			}
		}

		return $views;
	}

	/**
	 * Get new settings from $_POST variable and merge them with
	 * the old and default settings.
	 *
	 * @since 2.1.20
	 * @param int $postId
	 * @return int $postId
	 */
	static function save($postId){

		// Verify nonce, check if user has sufficient rights and return on auto-save.
		if(get_post_type($postId) != SlideshowPluginPostType::$postType ||
			(!isset($_POST[self::$nonceName]) || !wp_verify_nonce($_POST[self::$nonceName], self::$nonceAction)) ||
			!current_user_can('edit_post', $postId) ||
			(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE))
			return $postId;

		// Old settings
		$oldSettings = self::getSettings($postId);
		$oldStyleSettings = self::getStyleSettings($postId);

		// Get new settings from $_POST, making sure they're arrays
		$newPostSettings = $newPostStyleSettings = $newPostSlides = array();
		if(isset($_POST[self::$settingsKey]) && is_array($_POST[self::$settingsKey]))
			$newPostSettings = $_POST[self::$settingsKey];
		if(isset($_POST[self::$styleSettingsKey]) && is_array($_POST[self::$styleSettingsKey]))
			$newPostStyleSettings = $_POST[self::$styleSettingsKey];
		if(isset($_POST[self::$slidesKey]) && is_array($_POST[self::$slidesKey]))
			$newPostSlides = $_POST[self::$slidesKey];

		// Merge new settings with its old values
		$newSettings = array_merge(
			$oldSettings,
			$newPostSettings
		);

		// Merge new style settings with its old values
		$newStyleSettings = array_merge(
			$oldStyleSettings,
			$newPostStyleSettings
		);

		// Save settings
		update_post_meta($postId, self::$settingsKey, $newSettings);
		update_post_meta($postId, self::$styleSettingsKey, $newStyleSettings);
		update_post_meta($postId, self::$slidesKey, $newPostSlides);

		// Return
		return $postId;
	}

	/**
	 * Returns an array of all defaults. The array will be returned
	 * like this:
	 * array([settingsKey] => array([settingName] => [settingValue]))
	 *
	 * If all default data (including field information and description)
	 * is needed, set fullDefinition to true. Data in the full definition is
	 * build up as follows:
	 * array([settingsKey] => array([settingName] => array('type' => [inputType], 'value' => [value], 'default' => [default], 'description' => [description], 'options' => array([options]), 'dependsOn' => array([dependsOn], [onValue]), 'group' => [groupName])))
	 *
	 * Finally, when you require the defaults as they were programmed in,
	 * set this parameter to false. When set to true, the database will
	 * first be consulted for user-customized defaults. Defaults to true.
	 *
	 * @since 2.1.20
	 * @param mixed $key (optional, defaults to null, getting all keys)
	 * @param boolean $fullDefinition (optional, defaults to false)
	 * @param boolean $fromDatabase (optional, defaults to true)
	 * @return mixed $data
	 */
	static function getAllDefaults($key = null, $fullDefinition = false, $fromDatabase = true){

		$data = array();
		$data[self::$settingsKey] = self::getDefaultSettings($fullDefinition, $fromDatabase);
		$data[self::$styleSettingsKey] = self::getDefaultStyleSettings($fullDefinition, $fromDatabase);

		return $data;
	}

	/**
	 * Returns an array of setting defaults.
	 *
	 * For a full description of the parameters, see getAllDefaults().
	 *
	 * @since 2.1.20
	 * @param boolean $fullDefinition (optional, defaults to false)
	 * @param boolean $fromDatabase (optional, defaults to true)
	 * @return mixed $data
	 */
	static function getDefaultSettings($fullDefinition = false, $fromDatabase = true){

		// Much used data for translation
		$yes = __('Yes', 'slideshow-plugin');
		$no = __('No', 'slideshow-plugin');

		// Default values
		$data = array(
			'animation' => 'slide',
			'slideSpeed' => '1',
			'descriptionSpeed' => '0.4',
			'intervalSpeed' => '5',
			'slidesPerView' => '1',
			'maxWidth' => '0',
			'aspectRatio' => '3:1',
			'height' => '200',
			'stretchImages' => 'true',
			'showDescription' => 'true',
			'hideDescription' => 'true',
			'preserveSlideshowDimensions' => 'false',
			'enableResponsiveness' => 'true',
			'play' => 'true',
			'loop' => 'true',
			'pauseOnHover' => 'true',
			'controllable' => 'true',
			'hideNavigationButtons' => 'false',
			'showPagination' => 'true',
			'hidePagination' => 'true',
			'controlPanel' => 'false',
			'hideControlPanel' => 'true',
			'random' => 'false',
			'avoidFilter' => 'true'
		);

		// Read defaults from database and merge with $data, when $fromDatabase is set to true
		if($fromDatabase)
			$data = array_merge(
				$data,
				$customData = get_option(SlideshowPluginGeneralSettings::$defaultSettings, array())
			);

		// Full definition
		if($fullDefinition){
			$data = array(
				'animation' => array('type' => 'select', 'default' => $data['animation'], 'description' => __('Animation used for transition between slides', 'slideshow-plugin'), 'options' => array('slide' => __('Slide Left', 'slideshow-plugin'), 'slideRight' => __('Slide Right', 'slideshow-plugin'), 'slideUp' => __('Slide Up', 'slideshow-plugin'), 'slideDown' => __('Slide Down', 'slideshow-plugin'), 'directFade' => __('Direct Fade', 'slideshow-plugin'), 'fade' => __('Fade', 'slideshow-plugin'), 'random' => __('Random Animation', 'slideshow-plugin')), 'group' => __('Animation', 'slideshow-plugin')),
				'slideSpeed' => array('type' => 'text', 'default' => $data['slideSpeed'], 'description' => __('Number of seconds the slide takes to slide in', 'slideshow-plugin'), 'group' => __('Animation', 'slideshow-plugin')),
				'descriptionSpeed' => array('type' => 'text', 'default' => $data['descriptionSpeed'], 'description' => __('Number of seconds the description takes to slide in', 'slideshow-plugin'), 'group' => __('Animation', 'slideshow-plugin')),
				'intervalSpeed' => array('type' => 'text', 'default' => $data['intervalSpeed'], 'description' => __('Seconds between changing slides', 'slideshow-plugin'), 'group' => __('Animation', 'slideshow-plugin')),
				'slidesPerView' => array('type' => 'text', 'default' => $data['slidesPerView'], 'description' => __('Number of slides to fit into one slide', 'slideshow-plugin'), 'group' => __('Display', 'slideshow-plugin')),
				'maxWidth' => array('type' => 'text', 'default' => $data['maxWidth'], 'description' => __('Maximum width. When maximum width is 0, maximum width is ignored', 'slideshow-plugin'), 'group' => __('Display', 'slideshow-plugin')),
				'aspectRatio' => array('type' => 'text', 'default' => $data['aspectRatio'], 'description' => sprintf('<a href="' . __('http://en.wikipedia.org/wiki/Aspect_ratio_(image)', 'slideshow-plugin') . '" title="' . __('More info', 'slideshow-plugin') . '" target="_blank">' . __('Proportional relationship%s between slideshow\'s width and height (width:height)', 'slideshow-plugin'), '</a>'), 'dependsOn' => array('settings[preserveSlideshowDimensions]', 'true'), 'group' => __('Display', 'slideshow-plugin')),
				'height' => array('type' => 'text', 'default' => $data['height'], 'description' => __('Slideshow\'s height', 'slideshow-plugin'), 'dependsOn' => array('settings[preserveSlideshowDimensions]', 'false'), 'group' => __('Display', 'slideshow-plugin')),
				'stretchImages' => array('type' => 'radio', 'default' => $data['stretchImages'], 'description' => __('Fit image into slide (Stretch image)', 'slideshow-plugin'), 'options' => array('true' => $yes, 'false' => $no), 'group' => __('Display', 'slideshow-plugin')),
				'preserveSlideshowDimensions' => array('type' => 'radio', 'default' => $data['preserveSlideshowDimensions'], 'description' => __('Shrink slideshow\'s height when width shrinks', 'slideshow-plugin'), 'options' => array('true' => $yes, 'false' => $no), 'group' => __('Display', 'slideshow-plugin')),
				'enableResponsiveness' => array('type' => 'radio', 'default' => $data['enableResponsiveness'], 'description' => __('Enable responsiveness (Shrink slideshow\'s width when page\'s width shrinks)', 'slideshow-plugin'), 'options' => array('true' => $yes, 'false' => $no), 'dependsOn' => array('settings[showDescription]', 'true'), 'group' => __('Display', 'slideshow-plugin')),
				'showDescription' => array('type' => 'radio', 'default' => $data['showDescription'], 'description' => __('Show title and description', 'slideshow-plugin'), 'options' => array('true' => $yes, 'false' => $no), 'group' => __('Display', 'slideshow-plugin')),
				'hideDescription' => array('type' => 'radio', 'default' => $data['hideDescription'], 'description' => __('Hide description box, pop up when mouse hovers over', 'slideshow-plugin'), 'options' => array('true' => $yes, 'false' => $no), 'dependsOn' => array('settings[showDescription]', 'true'), 'group' => __('Display', 'slideshow-plugin')),
				'play' => array('type' => 'radio', 'default' => $data['play'], 'description' => __('Automatically slide to the next slide', 'slideshow-plugin'), 'options' => array('true' => $yes, 'false' => $no), 'group' => __('Control', 'slideshow-plugin')),
				'loop' => array('type' => 'radio', 'default' => $data['loop'], 'description' => __('Return to the beginning of the slideshow after last slide', 'slideshow-plugin'), 'options' => array('true' => $yes, 'false' => $no), 'group' => __('Control', 'slideshow-plugin')),
				'pauseOnHover' => array('type' => 'radio', 'default' => $data['loop'], 'description' => __('Pause slideshow when mouse hovers over', 'slideshow-plugin'), 'options' => array('true' => $yes, 'false' => $no), 'group' => __('Control', 'slideshow-plugin')),
				'controllable' => array('type' => 'radio', 'default' => $data['controllable'], 'description' => __('Activate navigation buttons', 'slideshow-plugin'), 'options' => array('true' => $yes, 'false' => $no), 'group' => __('Control', 'slideshow-plugin')),
				'hideNavigationButtons' => array('type' => 'radio', 'default' => $data['hideNavigationButtons'], 'description' => __('Hide navigation buttons, show when mouse hovers over', 'slideshow-plugin'), 'options' => array('true' => $yes, 'false' => $no), 'dependsOn' => array('settings[controllable]', 'true'), 'group' => __('Control', 'slideshow-plugin')),
				'showPagination' => array('type' => 'radio', 'default' => $data['showPagination'], 'description' => __('Activate pagination', 'slideshow-plugin'), 'options' => array('true' => $yes, 'false' => $no), 'group' => __('Control', 'slideshow-plugin')),
				'hidePagination' => array('type' => 'radio', 'default' => $data['hidePagination'], 'description' => __('Hide pagination, show when mouse hovers over', 'slideshow-plugin'), 'options' => array('true' => $yes, 'false' => $no), 'dependsOn' => array('settings[showPagination]', 'true'), 'group' => __('Control', 'slideshow-plugin')),
				'controlPanel' => array('type' => 'radio', 'default' => $data['controlPanel'], 'description' => __('Activate control panel (play and pause button)', 'slideshow-plugin'), 'options' => array('true' => $yes, 'false' => $no), 'group' => __('Control', 'slideshow-plugin')),
				'hideControlPanel' => array('type' => 'radio', 'default' => $data['hideControlPanel'], 'description' => __('Hide control panel, show when mouse hovers over', 'slideshow-plugin'), 'options' => array('true' => $yes, 'false' => $no), 'dependsOn' => array('settings[controlPanel]', 'true'), 'group' => __('Control', 'slideshow-plugin')),
				'random' => array('type' => 'radio', 'default' => $data['random'], 'description' => __('Randomize slides', 'slideshow-plugin'), 'options' => array('true' => $yes, 'false' => $no), 'group' => __('Miscellaneous', 'slideshow-plugin')),
				'avoidFilter' => array('type' => 'radio', 'default' => $data['avoidFilter'], 'description' => sprintf(__('Avoid content filter (disable if \'%s\' is shown)', 'slideshow-plugin'), SlideshowPluginShortcode::$bookmark), 'options' => array('true' => $yes, 'false' => $no), 'group' => __('Miscellaneous', 'slideshow-plugin'))
			);
		}

		// Return
		return $data;
	}

	/**
	 * Returns an array of style setting defaults.
	 *
	 * For a full description of the parameters, see getAllDefaults().
	 *
	 * @since 2.1.20
	 * @param boolean $fullDefinition (optional, defaults to false)
	 * @param boolean $fromDatabase (optional, defaults to true)
	 * @return mixed $data
	 */
	static function getDefaultStyleSettings($fullDefinition = false, $fromDatabase = true){

		// Default style settings
		$data = array(
			'style' => 'style-light.css'
		);

		// Read defaults from database and merge with $data, when $fromDatabase is set to true
		if($fromDatabase)
			$data = array_merge(
				$data,
				$customData = get_option(SlideshowPluginGeneralSettings::$defaultStyleSettings, array())
			);

		// Full definition
		if($fullDefinition){
			$data = array(
				'style' => array('type' => 'select', 'default' => $data['style'], 'description' => __('The style used for this slideshow', 'slideshow-plugin'), 'options' => SlideshowPluginGeneralSettings::getStylesheets()),
			);
		}

		// Return
		return $data;
	}

	/**
	 * Returns an HTML inputField of the input setting.
	 *
	 * This function expects the setting to be in the 'fullDefinition'
	 * format that the getDefaults() and getSettings() methods both
	 * return.
	 *
	 * @since 2.1.20
	 * @param string $settingsKey
	 * @param string $settingsName
	 * @param mixed $settings
	 * @param bool $hideDependentValues (optional, defaults to true)
	 * @return mixed $inputField
	 */
	static function getInputField($settingsKey, $settingsName, $settings, $hideDependentValues = true){

		if(!is_array($settings) || empty($settings) || empty($settingsName))
			return null;

		$inputField = '';
		$name = $settingsKey . '[' . $settingsName . ']';
		$displayValue = (!isset($settings['value']) || (empty($settings['value']) && !is_numeric($settings['value'])) ? $settings['default'] : $settings['value']);
		$class = ((isset($settings['dependsOn']) && $hideDependentValues)? 'depends-on-field-value ' . $settings['dependsOn'][0] . ' ' . $settings['dependsOn'][1] . ' ': '') . $settingsKey . '-' . $settingsName;
		switch($settings['type']){
			case 'text':
				$inputField .= '<input
					type="text"
					name="' . $name . '"
					class="' . $class . '"
					value="' . $displayValue . '"
				/>';
				break;
			case 'textarea':
				$inputField .= '<textarea
					name="' . $name . '"
					class="' . $class . '"
					rows="20"
					cols="60"
				>' . $displayValue . '</textarea>';
				break;
			case 'select':
				$inputField .= '<select name="' . $name . '" class="' . $class . '">';
				foreach($settings['options'] as $optionKey => $optionValue)
					$inputField .= '<option value="' . $optionKey . '" ' . selected($displayValue, $optionKey, false) . '>
						' . $optionValue . '
					</option>';
				$inputField .= '</select>';
				break;
			case 'radio':
				foreach($settings['options'] as $radioKey => $radioValue)
					$inputField .= '<label><input
						type="radio"
						name="' . $name . '"
						class="' . $class . '"
						value="' . $radioKey . '" ' .
						checked($displayValue, $radioKey, false) .
						' />' . $radioValue . '</label><br />';
				break;
			default:
				$inputField = null;
				break;
		};

		// Return
		return $inputField;
	}
}
