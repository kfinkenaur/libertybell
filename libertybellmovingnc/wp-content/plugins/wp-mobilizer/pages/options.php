<?php

/**
 * @package WP-Mobilizer
 * @link http://www.wp-mobilizer.com
 * @copyright Copyright &copy; 2013, Kilukru Media
 * @version: 1.0.6
 */

	global $mblzr;

	if ( isset($saved) && $saved ) echo mblzr_show_essage( __('Settings saved','wp_mobilizer') );
	if ( isset($reset) && $reset ) echo mblzr_show_essage( __('Settings reset','wp_mobilizer') );

?>

<div class="wrap mblzr_wrap"><form method="post" action="admin.php?page=<?php echo MBLZR_PLUGIN_DIRNAME; ?>-options">

<h2><?php echo __('WP-Mobilizer', 'wp_mobilizer'); ?> - <?php echo __('Mobile Theme Switcher', 'wp_mobilizer'); ?></h2>
<div class="metabox-holder">
<table width="100%">
	<tr>
		<td valign="top">
			<?php settings_fields( 'mblzr-settings' ); ?>


			<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
			<?php mblzr_display_form_elements(array('type' => 'open')); ?>
				<?php
					mblzr_display_form_elements(array('type' => 'title','label' =>
						__('Theme for devices', 'wp_mobilizer')
					));
				?>
				<?php mblzr_display_form_elements(array('type' => 'open_options')); ?>
					<?php

						// Get themes
						$themes_options = array(
							'default'	=> '-- ' . __('Default theme', 'wp_mobilizer') . ' --'
						);
						$themes = wp_get_themes();
						if( $themes && is_array($themes) && count($themes) > 0 ){
							foreach( $themes as $theme_slug =>$theme){
								$themes_options[$theme_slug] = $theme->display( 'Name', FALSE );
							}
						}

						// Set default options for elements
						$default_options = array(
							'type' 						=> 'select',
							'options' 					=> $themes_options,
							'options_key_value' 		=> true,
							'std' 						=> 'default',
							'std_value' 				=> '',
							'desc' 						=> '',
						);

						mblzr_display_form_elements( array_merge($default_options, array(
							'id' 						=> 'mblzr_iphone_theme',
							'label' 					=> __('iPhone/iPod Touch', 'wp_mobilizer')
						)));

						mblzr_display_form_elements( array_merge($default_options, array(
							'id' 						=> 'mblzr_ipad_theme',
							'label' 					=> __('iPad', 'wp_mobilizer')
						)));

						mblzr_display_form_elements( array_merge($default_options, array(
							'id' 						=> 'mblzr_android_theme',
							'label' 					=> __('Android', 'wp_mobilizer')
						)));

						mblzr_display_form_elements( array_merge($default_options, array(
							'id' 						=> 'mblzr_android_tablet_theme',
							'label' 					=> __('Android Tablet', 'wp_mobilizer')
						)));

						mblzr_display_form_elements( array_merge($default_options, array(
							'id' 						=> 'mblzr_blackberry_theme',
							'label' 					=> __('Blackberry', 'wp_mobilizer')
						)));

						mblzr_display_form_elements( array_merge($default_options, array(
							'id' 						=> 'mblzr_blackberry_tablet_theme',
							'label' 					=> __('Blackberry Tablet', 'wp_mobilizer')
						)));


						mblzr_display_form_elements( array_merge($default_options, array(
							'id' 						=> 'mblzr_windowsmobile_theme',
							'label' 					=> __('Windows Mobile', 'wp_mobilizer')
						)));


						mblzr_display_form_elements( array_merge($default_options, array(
							'id' 						=> 'mblzr_smartphone_theme',
							'label' 					=> __('Other Smartphone devices', 'wp_mobilizer'),
							'desc' 						=> __('And theme for "?force_mobile" URL.', 'wp_mobilizer') . ' Ex.: http://' . $_SERVER['SERVER_NAME'] . '/?force_site=1',

						)));

						mblzr_display_form_elements( array_merge($default_options, array(
							'id' 						=> 'mblzr_tablet_theme',
							'label' 					=> __('Other Tablet devices', 'wp_mobilizer')
						)));


						mblzr_display_form_elements( array('type' => 'title_h2', 'label' => __('Special', 'wp_mobilizer') ) );


						mblzr_display_form_elements( array_merge($default_options, array(
							'id' 						=> 'mblzr_googletv_tablet_theme',
							'label' 					=> __('Google TV', 'wp_mobilizer')
						)));

						mblzr_display_form_elements( array_merge($default_options, array(
							'id' 						=> 'mblzr_gameconsole_tablet_theme',
							'label' 					=> __('Game Console', 'wp_mobilizer'),
							'desc' 						=> __('Sony Playstation, Nintendo or Microsoft Xbox', 'wp_mobilizer'),
						)));


						mblzr_display_form_elements( array('type' => 'save' ) );

					?>
				<?php mblzr_display_form_elements(array('type' => 'close_options')); ?>
			<?php mblzr_display_form_elements(array('type' => 'close')); ?>
			<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++ -->



			<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
			<?php mblzr_display_form_elements(array('type' => 'open')); ?>
				<?php
					mblzr_display_form_elements(array('type' => 'title','label' =>
						__('Settings', 'wp_mobilizer')
					));
				?>
				<?php mblzr_display_form_elements(array('type' => 'open_options')); ?>
					<?php

						if( isset($this->options) && is_array($this->options) ){
							foreach ($this->options as $value) {
								mblzr_display_form_elements( $value );
							}
						}

						mblzr_display_form_elements( array('type' => 'save' ) );

					?>
				<?php mblzr_display_form_elements(array('type' => 'close_options')); ?>
			<?php mblzr_display_form_elements(array('type' => 'close')); ?>
			<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++ -->


		</td>
		<td width="15">&nbsp;</td>
		<td width="250" valign="top">
			<?php echo $mblzr->side_modules(); ?>
		</td>
	</tr>
</table></div>

	<input name="action" type="hidden" value="save-options" />
</form></div>