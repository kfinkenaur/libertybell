<?php
/**
 * monaco Theme Customizer
 *
 * @package monaco
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function monaco_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	//start text colors section
	$wp_customize->add_section('monaco_colors', array(
		'title'	=> __('Text Colors', 'monaco'),
		'description' => 'Modify Font Colors',
		'priority'    => 20
	));
	$wp_customize->add_setting('blogtitle_color', array(
		'default'	=> '#4b4b4d'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blogtitle_color', array(
		'label'	=> __('Edit Blog title color', 'monaco'),
		'section' => 'monaco_colors',
		'settings' => 'blogtitle_color'
	) ));

	$wp_customize->add_setting('blogdescription_color', array(
		'default'	=> '#898989'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'blogdescription_color', array(
		'label'	=> __('Edit Blog description color', 'monaco'),
		'section' => 'monaco_colors',
		'settings' => 'blogdescription_color'
	) ));
	//start logo upload section
	$wp_customize->add_section( 'uploadlogo_section' , array(
	    'title'       => __( 'Logo', 'monaco' ),
	    'description' => 'Upload a logo to replace the default site name and description in the header',
	    'priority'    => 30
	) );
	$wp_customize->add_setting( 'monaco_uploadlogo' );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'monaco_uploadlogo', array(
	    'label'    => __( 'Logo', 'themeslug' ),
	    'section'  => 'uploadlogo_section',
	    'settings' => 'monaco_uploadlogo'
	) ) );
}

function monaco_css_customizer() {
	?>
		<style type="text/css">
			.site-branding h1 a {color: <?php echo get_theme_mod('blogtitle_color'); ?>;}
			h2.site-description {color:<?php echo get_theme_mod('blogdescription_color'); ?>;}
		</style>
	<?php
}

add_action( 'wp_head', 'monaco_css_customizer' );
add_action( 'customize_register', 'monaco_customize_register' );



/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function monaco_customize_preview_js() {
	wp_enqueue_script( 'monaco_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'monaco_customize_preview_js' );
