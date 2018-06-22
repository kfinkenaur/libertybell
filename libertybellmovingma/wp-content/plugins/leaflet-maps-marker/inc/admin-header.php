<?php
/*
    Admin Header - Leaflet Maps Marker Plugin
*/
//info prevent file from being accessed directly
if (basename($_SERVER['SCRIPT_FILENAME']) == 'admin-header.php') { die ("Please do not access this file directly. Thanks!<br/><a href='http://www.mapsmarker.com/go'>www.mapsmarker.com</a>"); }
require_once(ABSPATH . WPINC . DIRECTORY_SEPARATOR . "pluggable.php");
$lmm_options = get_option( 'leafletmapsmarker_options' ); //info: required for bing maps api key check

//info: make to menu buttons active depended on page you´re on
$page = (isset($_GET['page']) ? $_GET['page'] : '');
$oid = isset($_POST['id']) ? intval($_POST['id']) : (isset($_GET['id']) ? intval($_GET['id']) : '');
if ($page == 'leafletmapsmarker_markers') {
	$buttonclass1 = 'button-primary lmm-nav-primary';
	$buttonclass2 = 'button-secondary lmm-nav-secondary';
	$buttonclass3 = 'button-secondary lmm-nav-secondary';
	$buttonclass4 = 'button-secondary lmm-nav-secondary';
	$buttonclass5 = 'button-secondary lmm-nav-secondary';
	$buttonclass6 = 'button-secondary lmm-nav-secondary';
	$buttonclass7 = 'button-secondary lmm-nav-secondary';
} else if ($page == 'leafletmapsmarker_marker') {
	$buttonclass1 = 'button-secondary lmm-nav-secondary';
	$buttonclass2 = 'button-primary lmm-nav-primary';
	$buttonclass3 = 'button-secondary lmm-nav-secondary';
	$buttonclass4 = 'button-secondary lmm-nav-secondary';
	$buttonclass5 = 'button-secondary lmm-nav-secondary';
	$buttonclass6 = 'button-secondary lmm-nav-secondary';
	$buttonclass7 = 'button-secondary lmm-nav-secondary';
} else if ($page == 'leafletmapsmarker_layers') {
	$buttonclass1 = 'button-secondary lmm-nav-secondary';
	$buttonclass2 = 'button-secondary lmm-nav-secondary';
	$buttonclass3 = 'button-primary lmm-nav-primary';
	$buttonclass4 = 'button-secondary lmm-nav-secondary';
	$buttonclass5 = 'button-secondary lmm-nav-secondary';
	$buttonclass6 = 'button-secondary lmm-nav-secondary';
	$buttonclass7 = 'button-secondary lmm-nav-secondary';
} else if ($page == 'leafletmapsmarker_layer') {
	$buttonclass1 = 'button-secondary lmm-nav-secondary';
	$buttonclass2 = 'button-secondary lmm-nav-secondary';
	$buttonclass3 = 'button-secondary lmm-nav-secondary';
	$buttonclass4 = 'button-primary lmm-nav-primary';
	$buttonclass5 = 'button-secondary lmm-nav-secondary';
	$buttonclass6 = 'button-secondary lmm-nav-secondary';
	$buttonclass7 = 'button-secondary lmm-nav-secondary';
} else if ($page == 'leafletmapsmarker_tools') {
	$buttonclass1 = 'button-secondary lmm-nav-secondary';
	$buttonclass2 = 'button-secondary lmm-nav-secondary';
	$buttonclass3 = 'button-secondary lmm-nav-secondary';
	$buttonclass4 = 'button-secondary lmm-nav-secondary';
	$buttonclass5 = 'button-primary lmm-nav-primary';
	$buttonclass6 = 'button-secondary lmm-nav-secondary';
	$buttonclass7 = 'button-secondary lmm-nav-secondary';
} else if ($page == 'leafletmapsmarker_settings') {
	$buttonclass1 = 'button-secondary lmm-nav-secondary';
	$buttonclass2 = 'button-secondary lmm-nav-secondary';
	$buttonclass3 = 'button-secondary lmm-nav-secondary';
	$buttonclass4 = 'button-secondary lmm-nav-secondary';
	$buttonclass5 = 'button-secondary lmm-nav-secondary';
	$buttonclass6 = 'button-primary lmm-nav-primary';
	$buttonclass7 = 'button-secondary lmm-nav-secondary';
} else if ($page == 'leafletmapsmarker_help') {
	$buttonclass1 = 'button-secondary lmm-nav-secondary';
	$buttonclass2 = 'button-secondary lmm-nav-secondary';
	$buttonclass3 = 'button-secondary lmm-nav-secondary';
	$buttonclass4 = 'button-secondary lmm-nav-secondary';
	$buttonclass5 = 'button-secondary lmm-nav-secondary';
	$buttonclass6 = 'button-secondary lmm-nav-secondary';
	$buttonclass7 = 'button-primary lmm-nav-primary';
}
$admin_quicklink_tools_buttons = ( current_user_can( "activate_plugins" ) ) ? "<a class='" . $buttonclass5 ."' href='" . LEAFLET_WP_ADMIN_URL . "admin.php?page=leafletmapsmarker_tools'><img src='" . LEAFLET_PLUGIN_URL . "inc/img/icon-menu-tools.png'> ".__('Tools','lmm')."</a>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;" : "";
$admin_quicklink_settings_buttons = ( current_user_can( "activate_plugins" ) ) ? "<a class='" . $buttonclass6 ."' href='" . LEAFLET_WP_ADMIN_URL . "admin.php?page=leafletmapsmarker_settings'><img src='" . LEAFLET_PLUGIN_URL . "inc/img/icon-menu-settings.png'> ".__('Settings','lmm')."</a>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;" : "";

//////////////////////////////////////////////////////
// info: admin notices which only show on LMM pages //
//////////////////////////////////////////////////////
if ( isset($lmm_options['misc_global_admin_notices']) && ($lmm_options['misc_global_admin_notices'] == 'show') ){
	//info: check if custom shadow image exists
	function checkUrlExists($url) {
		$loaded_extensions = get_loaded_extensions();
		$loaded_extensions = array_flip($loaded_extensions);
		$ret = false;
		if ( isset($loaded_extensions['curl']) ) {
			$curl = curl_init($url);
			$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
			curl_setopt($curl, CURLOPT_USERAGENT, $agent);
			curl_setopt($curl, CURLOPT_NOBODY, true);
			$result = curl_exec($curl);
			if ($result !== false) {
				$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  
				if ($statusCode == 200) {
					$ret = true;   
				}
			}
			curl_close($curl);
		} else {
			$ret = true;
		}
		return $ret;
	}
	if ( $lmm_options['defaults_marker_icon_shadow_url_status'] == 'custom') {
		$custom_shadow_icon_url = $lmm_options['defaults_marker_icon_shadow_url'];
		$custom_shadow_icon_url_exists = checkUrlExists($custom_shadow_icon_url);
		if ( ($custom_shadow_icon_url != NULL) && (!$custom_shadow_icon_url_exists) ) {
			echo '<div class="error" style="padding:10px;"><strong>' . sprintf(__('Leaflet Maps Marker Warning: the setting for the marker shadow url (%1s) seems to be invalid. This can happen when you moved your WordPress installation from one server to another one.<br/>Please navigate to <a href="%2s">Settings / Map Defaults / "Default values for marker icons"</a> and update the option "Shadow URL". If you do not know which values to enter, please <a href="%3s">reset all plugins options to their defaults</a>', 'lmm'), $shadow_icon_url, LEAFLET_WP_ADMIN_URL . 'admin.php?page=leafletmapsmarker_settings#mapdefaults-section5', LEAFLET_WP_ADMIN_URL . 'admin.php?page=leafletmapsmarker_settings#reset') . '</strong></div>';
		} 
	} 
	//info: plugin WordPress Ultra Simple Paypal Shopping Cart
	if (is_plugin_active('wp-ultra-simple-paypal-shopping-cart/wp_ultra_simple_shopping_cart.php') ) {
		echo '<p><div class="error" style="padding:10px;"><strong>' . __('Warning: you are using the plugin WordPress Ultra Simple Paypal Shopping Cart which is causing the Leaflet Maps Marker settings page to break! Please temporarily deactivate this plugin if you want change the settings. The plugin developer has already been contacted and will hopefully release a fix soon.','lmm') . '</strong></div></p>';
	}
}//info: end misc_global_admin_notices check
//info: check if newer plugin version is available
$plugin_updates = get_site_transient( 'update_plugins' );
if (isset($plugin_updates->response['leaflet-maps-marker/leaflet-maps-marker.php']->new_version)) { 
	$plugin_updates_lmm_installed = get_option("leafletmapsmarker_version");
	$plugin_updates_lmm_new_version = $plugin_updates->response['leaflet-maps-marker/leaflet-maps-marker.php']->new_version;
	echo '<p><div class="updated" style="padding:5px;"><strong>' . __('Leaflet Maps Marker - plugin update available!','lmm') . '</strong><br/>' . sprintf(__('You are currently using v%1s and the plugin author highly recommends updating to v%2s for new features, bugfixes and updated translations (please see <a href="http://mapsmarker.com/v%3s" target="_blank">this blog post</a> for more details about the latest release).','lmm'), $plugin_updates_lmm_installed, $plugin_updates_lmm_new_version, $plugin_updates_lmm_new_version) . '<br/>';
	if ( current_user_can( 'update_plugins' ) ) { 
		echo sprintf(__('Update instruction: please start the update from the <a href="%1s">Updates-page</a>.','lmm'), get_admin_url() . 'update-core.php' ) . '</div></p>'; 
	} else {
		echo sprintf(__('Update instruction: as your user does not have the right to update plugins, please contact your <a href="mailto:%1s?subject=Please update plugin -Leaflet Maps Marker- on %2s">administrator</a>','lmm'), get_settings('admin_email'), site_url() ) . '</div></p>'; 
	}
}
?>
<table cellpadding="5" cellspacing="0" class="widefat fixed">
  <tr>
    <td><div style="float:left;margin:2px 10px 0 0;"><a href="http://www.mapsmarker.com/go" target="_blank" title="www.mapsmarker.com"><img src="<?php echo LEAFLET_PLUGIN_URL ?>inc/img/logo-mapsmarker.png" width="65" height="65" alt="Leaflet Maps Marker Plugin Logo by Julia Loew, www.weiderand.net" /></a></div>

<div style="font-size:1.5em;margin-bottom:5px;padding:2px 0 0 0;"><span style="font-weight:bold;">Maps Marker<sup style="font-size:75%;">&reg;</sup> v<?php echo get_option("leafletmapsmarker_version") ?> - <?php _e('Free Edition','lmm'); ?></span></div>
  <p style="margin:1.4em 0 0 0;">
  <a class="<?php echo $buttonclass1; ?>" href="<?php echo LEAFLET_WP_ADMIN_URL ?>admin.php?page=leafletmapsmarker_markers"><img src="<?php echo LEAFLET_PLUGIN_URL ?>inc/img/icon-menu-list.png"> <?php _e("List all markers", "lmm") ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <a class="<?php echo $buttonclass2; ?>" href="<?php echo LEAFLET_WP_ADMIN_URL ?>admin.php?page=leafletmapsmarker_marker"><img src="<?php echo LEAFLET_PLUGIN_URL ?>inc/img/icon-menu-add.png"> 
    <?php 
  if ( ($oid == NULL) && ($page == 'leafletmapsmarker_marker') ) { 
  		_e("Add new marker", "lmm"); 
  } else if ( ($oid != NULL) && ($page == 'leafletmapsmarker_marker') ) { 
		_e("Edit marker", "lmm"); 
  } else {
  		_e("Add new marker", "lmm"); 
  }?>
  </a>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
  <a class="<?php echo $buttonclass3; ?>" href="<?php echo LEAFLET_WP_ADMIN_URL ?>admin.php?page=leafletmapsmarker_layers"><img src="<?php echo LEAFLET_PLUGIN_URL ?>inc/img/icon-menu-list.png"> <?php _e("List all layers", "lmm") ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <a class="<?php echo $buttonclass4; ?>" href="<?php echo LEAFLET_WP_ADMIN_URL ?>admin.php?page=leafletmapsmarker_layer"><img src="<?php echo LEAFLET_PLUGIN_URL ?>inc/img/icon-menu-add.png"> 
  <?php 
  if ( ($oid == NULL) && ($page == 'leafletmapsmarker_layer') ) { 
  		_e("Add new layer", "lmm"); 
  } else if ( ($oid != NULL) && ($page == 'leafletmapsmarker_layer') ) { 
		_e("Edit layer", "lmm"); 
  } else {
  		_e("Add new layer", "lmm"); 
  }?>
  </a>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
  <?php echo $admin_quicklink_tools_buttons ?>
  <?php echo $admin_quicklink_settings_buttons ?>
  <a class="<?php echo $buttonclass7; ?>" href="<?php echo LEAFLET_WP_ADMIN_URL ?>admin.php?page=leafletmapsmarker_help"><img src="<?php echo LEAFLET_PLUGIN_URL ?>inc/img/icon-menu-help.png"> <?php _e("Help", "lmm") ?></a>
  </p>
</td></tr></table>

<?php
//info: display update info with current release notes
$update_info_action = isset($_POST['update_info_action']) ? $_POST['update_info_action'] : ''; 
//info: dont display on new installs
$new_install = (isset($_GET['display']) ? 'true' : 'false'); 
if ( ($update_info_action == 'hide') && ($new_install == 'false') ) {
	update_option('leafletmapsmarker_update_info', 'hide');
}
if (get_option('leafletmapsmarker_update_info') == 'show') {
	$lmm_version_old = get_option( 'leafletmapsmarker_version_before_update' );
	$lmm_version_new = get_option( 'leafletmapsmarker_version' );
	$lmm_changelog_new_version = '<a href="http://www.mapsmarker.com/v' . $lmm_version_new . '" target="_blank" style="text-decoration:none;">http://www.mapsmarker.com/v' . $lmm_version_new . '</a>';
	$lmm_full_changelog = '<a href="http://www.mapsmarker.com/changelog" target="_blank" style="text-decoration:none;">http://www.mapsmarker.com/changelog</a>';

	echo '<div style="border-radius:3px;border-color:#E6DB55;background-color:#FFFFE0;margin:10px 0 5px;padding:0 0.6em;border-style:solid;border-width:1px;">';
	if ($lmm_version_old == 0) {
		echo '<p><span style="font-weight:bold;font-size:125%;">' . sprintf(__('Leaflet Maps Marker has been successfully updated to version %1s!','lmm'), $lmm_version_new) . '</span></p>';
	} else {
		echo '<p><span style="font-weight:bold;font-size:125%;">' . sprintf(__('Leaflet Maps Marker has been successfully updated from version %1s to %2s!','lmm'), $lmm_version_old, $lmm_version_new) . '</span></p>';
	}
	echo '<p>' . sprintf(__('For more details about version %1s, please visit %2s','lmm'), $lmm_version_new, $lmm_changelog_new_version) . '</p>'.PHP_EOL;
	echo '<iframe name="changelog" src="' . LEAFLET_PLUGIN_URL . 'inc/changelog.php" width="98%" height="285" marginwidth="0" marginheight="0" style="border:thin dashed #E6DB55;"></iframe>'.PHP_EOL;

	echo '<p>' . __('If you like using the plugin, please consider <a href="http://www.mapsmarker.com/donations" target="_blank" style="text-decoration:none;">making a donation</a> and <a href="http://wordpress.org/support/view/plugin-reviews/leaflet-maps-marker" target="_blank" style="text-decoration:none;">review the plugin on wordpress.org</a> - thanks!','lmm') . '</p>'.PHP_EOL;
	echo '<form method="post" style="padding:2px 0 6px 0;">
		<input type="hidden" name="update_info_action" value="hide" />
		<input class="button-secondary" type="submit" value="' . __('remove message', 'lmm') . '"/></form></div>';
}
?>
