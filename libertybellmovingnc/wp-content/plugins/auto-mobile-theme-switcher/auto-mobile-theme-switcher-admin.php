<?php

add_action('admin_menu', 'auto_mobile_theme_switcher_menu');

function auto_mobile_theme_switcher_menu() {
	add_options_page('Auto Mobile Theme Switcher', 'Auto Mobile Theme Switcher', 'manage_options', __FILE__, 'auto_mobile_theme_switcher_setting_page');
	add_action('admin_init', 'auto_mobile_theme_switcher_init');
}

function auto_mobile_theme_switcher_init() {
	register_setting('wpamts_settings_fields', 'wpamts_options');
}

function auto_mobile_theme_switcher_setting_page() {
    $themes = get_themes();	
	$wpamts_options = get_option('wpamts_options');
?>
<style>
textarea,input[type="text"],input[type="password"],select {
	margin: 1px 0px 10px 0px;
	padding: 3px;
	border: 1px solid #ccc;
	font-family: arial;
	font-size: 1.1em;
}
label {
	padding-top: 12px;
	line-height: 2;
}
.postbox{
	margin: 15px 0px; 
	font-size: 1.1em;
	width: 60%;
}
.h10 {
	overflow: hidden;
	height: 8px;
}
</style>
<div class="wrap">
<div class="metabox-holder">

	<h2>Auto Mobile Theme Switcher</h2>
	
    <div class="postbox">
     	<h3>Settings</h3>
     	<div class="inside">
		<form method="post" action="options.php">
		    <?php settings_fields('wpamts_settings_fields'); ?>
		      		
			<h4>Tablet Theme:</h4>				
			<select id="tablet_theme" name="wpamts_options[tablet_theme]">
				<option></option>
				<?php 
					foreach ($themes as $theme) {
						$theme_name = $theme['Name'];
						if ($theme_name == $wpamts_options['tablet_theme']) {
							echo '<option value="' . $theme_name . '" selected="selected">' . htmlspecialchars($theme_name) . '</option>';
						} else {
							echo '<option value="' . $theme_name . '">' . htmlspecialchars($theme_name) . '</option>';
						}
					}
			?>
			</select>
			
			<h4>Mobile Theme:</h4>				
			<select id="mobile_theme" name="wpamts_options[mobile_theme]">
				<option></option>
				<?php 
					foreach ($themes as $theme) {
						$theme_name = $theme['Name'];
						if ($theme_name == $wpamts_options['mobile_theme']) {
							echo '<option value="' . $theme_name . '" selected="selected">' . htmlspecialchars($theme_name) . '</option>';
						} else {
							echo '<option value="' . $theme_name . '">' . htmlspecialchars($theme_name) . '</option>';
						}
					}
			?>
			</select>
			<div class="h10"></div>
			<br />				
		
			<input type="submit" class="button-primary"	value="<?php _e('Save Changes') ?>" /> <br />
			<br />
		</form>
		</div>
	</div>


       <div>
		<h4>For more infomation</h4>
		Plugin URI: <a href="http://wpextends.sinaapp.com/plugins/auto-mobile-theme-switcher.html" target="_blank">http://wpextends.sinaapp.com/plugins/auto-mobile-theme-switcher.html</a><br/>
		Our Website:<a href="http://wpextends.sinaapp.com" target="_blank">http://wpextends.sinaapp.com</a><br/>
        <div class="h10"></div>
        Please contact us at <a href="mailto:support@wordpressextends.com">support@wordpressextends.com</a> whenever you have any questions and comments.
       </div>
       <div class="h10"></div>   	
       
       <div>
         	<h4>Like this plugin? We need your help to make it better:</h4>
         	<ul>
       		<li>Write a positive review.</li>
       		<li>Tell us some improvements.</li>
         		<li>If you’d like to donate...</li>
         	</ul>
         	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_donations">
			<input type="hidden" name="business" value="market@wordpressextends.com">
			<input type="hidden" name="item_name" value="Auto Mobile Theme Switcher plugin for Wordpress">
			<input type="hidden" name="currency_code" value="USD">
			<!-- <input type="hidden" name="notify_url" value="link to IPN script"> -->				
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
		</form>
		<p>Your support shows that what we’re doing really matters and help this plugin to move forward! Thank you.</p>
       </div>
       <div class="h10"></div>          
</div>   

</div>
<?php } ?>