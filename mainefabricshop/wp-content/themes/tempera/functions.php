<?php
/*
 * Functions file
 * Calls all other required files
 * PLEASE DO NOT EDIT THIS FILE IN ANY WAY
 *
 * @package tempera
 */

// variable for theme version
define ('_CRYOUT_THEME_NAME','tempera');
define ('_CRYOUT_THEME_VERSION','1.4.8');

require_once(get_template_directory() . "/admin/main.php"); 			  // Load necessary admin files

//Loading include files
require_once(get_template_directory() . "/includes/theme-setup.php");     // Setup and init theme
require_once(get_template_directory() . "/includes/theme-styles.php");    // Register and enqeue css styles and scripts
require_once(get_template_directory() . "/includes/theme-loop.php");      // Loop functions
require_once(get_template_directory() . "/includes/theme-meta.php");      // Meta functions
require_once(get_template_directory() . "/includes/theme-frontpage.php"); // Frontpage styling
require_once(get_template_directory() . "/includes/theme-comments.php");  // Comment functions
require_once(get_template_directory() . "/includes/theme-functions.php"); // Misc functions
require_once(get_template_directory() . "/includes/theme-hooks.php");     // Hooks
require_once(get_template_directory() . "/includes/widgets.php");     	  // Theme Widgets
require_once(get_template_directory() . "/includes/ajax.php");     	      // Ajax
require_once(get_template_directory() . "/includes/tgm.php");             // TGM Plugin Activation
