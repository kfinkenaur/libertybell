<?php
/**
 * Functions for users wanting to upgrade to premium
 *
 * @package Panoramic
 */

/**
 * Display the upgrade to Premium page & load styles.
 */
function panoramic_premium_admin_menu() {
    global $panoramic_upgrade_page;
    $panoramic_upgrade_page = add_theme_page(
    	__( 'Panoramic Premium', 'panoramic' ),
    	'<span class="premium-link" style="color: #f18500;">' . __( 'Panoramic Premium', 'panoramic' ) . '</span>',
    	'edit_theme_options',
    	'premium_upgrade',
    	'panoramic_render_upgrade_page'
	);
}
add_action( 'admin_menu', 'panoramic_premium_admin_menu' );

/**
 * Enqueue admin stylesheet only on upgrade page.
 */
function panoramic_load_upgrade_page_scripts( $hook ) {
    global $panoramic_upgrade_page;
    if ( $hook != $panoramic_upgrade_page )
        return;
    
    wp_enqueue_style( 'panoramic-premium', get_template_directory_uri() . '/premium/library/css/premium.css' );
}
add_action( 'admin_enqueue_scripts', 'panoramic_load_upgrade_page_scripts' );

/**
 * Render the premium upgraded page
 */
function panoramic_render_upgrade_page() {
	get_template_part( 'premium/library/template-parts/content', 'premium' );
}
