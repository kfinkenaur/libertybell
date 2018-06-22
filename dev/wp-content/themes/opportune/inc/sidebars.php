<?php 
/**
 * Theme Widget positions
 * @package Opportune 
 
 */

 
/**
 * Registers our main widget area and the front page widget areas.
 */
 
function opportune_widgets_init() {

	register_sidebar( array(
		'name' => esc_html__( 'Blog Right Sidebar', 'opportune' ),
		'id' => 'blogright',
		'description' => esc_html__( 'Right sidebar for the blog', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Blog Left Sidebar', 'opportune' ),
		'id' => 'blogleft',
		'description' => esc_html__( 'Left sidebar for the blog', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	register_sidebar( array(
		'name' => esc_html__( 'Page Right Sidebar', 'opportune' ),
		'id' => 'pageright',
		'description' => esc_html__( 'Right sidebar for pages', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	register_sidebar( array(
		'name' => esc_html__( 'Page Left Sidebar', 'opportune' ),
		'id' => 'pageleft',
		'description' => esc_html__( 'Left sidebar for pages', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	
	register_sidebar( array(
		'name' => esc_html__( 'Top 1', 'opportune' ),
		'id' => 'top1',
		'description' => esc_html__( 'Top 1 position', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	register_sidebar( array(
		'name' => esc_html__( 'Top 2', 'opportune' ),
		'id' => 'top2',
		'description' => esc_html__( 'Top 2 position', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Top 3', 'opportune' ),
		'id' => 'top3',
		'description' => esc_html__( 'Top 3 position', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Top 4', 'opportune' ),
		'id' => 'top4',
		'description' => esc_html__( 'Top 4 position', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	register_sidebar( array(
		'name' => esc_html__( 'Inset Top', 'opportune' ),
		'id' => 'insettop',
		'description' => esc_html__( 'This is an Inset Top position just above the main content and between the left and right column sidebars', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Inset Bottom', 'opportune' ),
		'id' => 'insetbottom',
		'description' => esc_html__( 'This is an Inset Bottom position just below the main content and between the left and right column sidebars', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );		
	register_sidebar( array(
		'name' => esc_html__( 'Bottom 1', 'opportune' ),
		'id' => 'bottom1',
		'description' => esc_html__( 'Bottom 1 position', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Bottom 2', 'opportune' ),
		'id' => 'bottom2',
		'description' => esc_html__( 'Bottom 2 position', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Bottom 3', 'opportune' ),
		'id' => 'bottom3',
		'description' => esc_html__( 'Bottom 3 position', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Bottom 4', 'opportune' ),
		'id' => 'bottom4',
		'description' => esc_html__( 'Bottom 4 position', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );		
	register_sidebar( array(
		'name' => esc_html__( 'Banner', 'opportune' ),
		'id' => 'banner',
		'description' => esc_html__( 'For Images and Sliders.', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );	
	register_sidebar( array(
		'name' => esc_html__( 'Bottom Showcase', 'opportune' ),
		'id' => 'bottom-showcase',
		'description' => esc_html__( 'For full width  Images, galleries, and Sliders for the bottom of the page.', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );	
	register_sidebar( array(
		'name' => esc_html__( 'Call to Action', 'opportune' ),
		'id' => 'cta',
		'description' => esc_html__( 'This is a call to action below the banner area', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h1 class="cta-title">',
		'after_title' => '</h1>',
	) );
	
	register_sidebar( array(
		'name' => esc_html__( 'Breadcrumbs', 'opportune' ),
		'id' => 'breadcrumbs',
		'description' => esc_html__( 'This is breadcrumbs position but can be used for other things', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Footer', 'opportune' ),
		'id' => 'footer',
		'description' => esc_html__( 'This is a sidebar position that sits above the footer menu and copyright', 'opportune' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	) );

}
add_action( 'widgets_init', 'opportune_widgets_init' );

/**
 * Count the number of widgets to enable resizable widgets
 * in the top group.
 */

function opportune_top() {
	$count = 0;
	if ( is_active_sidebar( 'top1' ) )
		$count++;
	if ( is_active_sidebar( 'top2' ) )
		$count++;
	if ( is_active_sidebar( 'top3' ) )
		$count++;		
	if ( is_active_sidebar( 'top4' ) )
		$count++;
	$class = '';
	switch ( $count ) {
		case '1':
			$class = 'col-lg-12';
			break;
		case '2':
			$class = 'col-sm-6 col-md-6';
			break;
		case '3':
			$class = 'col-sm-6 col-md-4';
			break;
		case '4':
			$class = 'col-sm-6 col-md-3';
			break;
	}
	if ( $class )
		echo 'class="' . $class . '"';
}

/**
 * Count the number of widgets to enable resizable widgets
 * in the bottom group.
 */

function opportune_bottom() {
	$count = 0;
	if ( is_active_sidebar( 'bottom1' ) )
		$count++;
	if ( is_active_sidebar( 'bottom2' ) )
		$count++;
	if ( is_active_sidebar( 'bottom3' ) )
		$count++;		
	if ( is_active_sidebar( 'bottom4' ) )
		$count++;
	$class = '';
	switch ( $count ) {
		case '1':
			$class = 'col-lg-12';
			break;
		case '2':
			$class = 'col-sm-6 col-lg-6';
			break;
		case '3':
			$class = 'col-sm-6 col-lg-4';
			break;
		case '4':
			$class = 'col-sm-6 col-lg-3';
			break;
	}
	if ( $class )
		echo 'class="' . $class . '"';
}
