<?php
/**
 * Sidebar functions
 *
 *
 * @file           function-sidebar.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

function dk_widgets_init() {	
	register_sidebar( array(
					  'name'          => __( 'Left Sidebar', 'dk-responsive' ),
					  'description'   => __( 'Area 1 - sidebar-left.php - Displays on Sidebar/Content page templates', 'dk-responsive' ),
					  'id'            => 'left-sidebar',
					  'before_title'  => '<div class="widget-title"><h3>',
					  'after_title'   => '</h3></div>',
					  'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
					  'after_widget'  => '</div>'
	) );
	register_sidebar( array(
					  'name'          => __( 'Right Sidebar', 'dk-responsive' ),
					  'description'   => __( 'Area 2 - sidebar-right.php - Displays on Content/Sidebar page templates', 'dk-responsive' ),
					  'id'            => 'right-sidebar',
					  'before_title'  => '<div class="widget-title"><h3>',
					  'after_title'   => '</h3></div>',
					  'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
					  'after_widget'  => '</div>'
	) );
}
add_action( 'widgets_init', 'dk_widgets_init' );

// Added footer section as theme settings 
add_action( 'widgets_init', 'dk_footer_widgets' );

function dk_footer_widgets () { 
  $footer_columns= esc_html(dk_get_option('footer_col'));
  if(empty($footer_columns)) {
  	$footer_columns=3;
  }
  for ($i=1; $i<=$footer_columns; $i++) {    
	register_sidebar( array(
					  'name'          => __( 'Footer Widget Area ', 'dk-responsive' ).$i,
					  'description'   => __( 'Area- Displays in footer section of page templates', 'dk-responsive' ),
					  'id'            => 'footer-sidebar'.$i,
					  'before_title'  => '<div class="widget-title"><h3>',
					  'after_title'   => '</h3></div>',
					  'before_widget' => '<div id="%1$s" class="widget-wrapper %2$s">',
					  'after_widget'  => '</div>'
	) );
	
  }
}

?>