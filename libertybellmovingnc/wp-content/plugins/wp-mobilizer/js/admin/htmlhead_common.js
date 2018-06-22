/* ----------------------------------- */
/**
 * @package WP-Mobilizer
 * @link http://www.wp-mobilizer.com
 * @copyright Copyright &copy; 2013, Kilukru Media
 * @version: 1.0.6
 */
/* ----------------------------------- */

jQuery(document).ready(function ($) {
	'use strict';

	// Set JavaScript for Toggle Block;
	$('.postbox h3, .postbox .handlediv').click( function() {
		$($(this).parent().get(0)).toggleClass('closed');
	});

	$('#adminmenu .span_separator').parent().addClass('submenu_separator');

});