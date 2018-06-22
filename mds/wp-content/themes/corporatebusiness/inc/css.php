<?php
/**
 * Hooks the Custom Internal CSS to head section
 * Eventually, some of the functionality here could be replaced by core features.
 * @package CorporateBusiness
 */

function corporatebusiness_custom_css() {
	$css = '';
	// 
	// Custom CSS texarea
	$css .= esc_html(get_theme_mod('custom_css'));
	
	// Other CSS
	$primary_color = esc_attr( get_theme_mod( 'primary_color', '#13C0DF' ) );	
	if( $primary_color != '#13C0DF' ) {
		$css .= '
		.widget-area .widget{box-shadow: 0px -5px 0px 0px '.$primary_color.';}
		blockquote{border-left:2px solid '.$primary_color.';}
		.page-content ul li:before,
		.entry-content ul li:before,
		.entry-summary ul li:before,
		.page-content h1:before,
		.entry-content h1:before,
		.page-content h2:before,
		.entry-content h2:before,
		.page-content h3:before,
		.entry-content h3:before
		{color:'.$primary_color.';}
		pre{border-left:2px solid '.$primary_color.';}
		button,input[type="button"],input[type="reset"],input[type="submit"]{background:'.$primary_color.';}
		a:hover,a:focus,a:active{color:'.$primary_color.';}
		.pagination .nav-links a:hover{color:'.$primary_color.';}
		.pagination .current{color:'.$primary_color.';}
		.entry-content a{color:'.$primary_color.';}
		.wp-pagenavi span.current{color:'.$primary_color.';}
		.entry-title, .entry-title a, .widget-area .widget-title{color:'.$primary_color.';}
		#next-slide,#prev-slide{color:'.$primary_color.';}
		#controllers a:hover, #controllers a.active{color:'.$primary_color.';}
		#controllers a:hover, #controllers a.active{background-color:'.$primary_color.';}
		#slider-title a{background:'.$primary_color.';}
		.comments-title, .comment-reply-title {color:'.$primary_color.';}
		.content-box .featured-image {border-color:'.$primary_color.';}
		.content-box .readmore i {color:'.$primary_color.';}
		';
	}
	// WooCommerce Colors
		$css .= '
		.woocommerce a.button, .woocommerce button.button,
		.woocommerce input.button, .woocommerce #respond input#submit.alt,
		.woocommerce a.button, .woocommerce button.button,
		.woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,
		.woocommerce #respond input#submit
		{
			background-color:'.$primary_color.';border-color:'.$primary_color.';
		}';
	// Contact details color
	if( get_theme_mod( 'contact_color' ) )
		$css .= '.site-description,.site-description a{color:'.get_theme_mod( 'contact_color' ).';}';
	if( get_theme_mod( 'contact_color_hover' ) )
		$css .= '.site-description span:hover {
				color:'.get_theme_mod( 'contact_color_hover' ).';
				border-color:'.get_theme_mod( 'contact_color_hover' ).';}
				.header-search .search-field:hover {border-color:'.get_theme_mod( 'contact_color_hover' ).';}';
				
				
				
	// Header Image
	$header_image = get_header_image();
	if( $header_image == '' or $header_image === false ) $css .= 'header.site-header{background-image:none;}';
		else $css .= 'header.site-header{background-image:url('.$header_image.');}';
	// Posts
	if( get_theme_mod( 'post_text_color' ) )
		$css .= '.page-content, .entry-content{color:'.get_theme_mod( 'post_text_color' ).';}';
	if( get_theme_mod( 'post_meta_color' ) )
		$css .= '.entry-meta, .entry-meta span a,
				 .entry-footer, .entry-footer span a {color:'.get_theme_mod( 'post_meta_color' ).';}';
	// Main Menu styke
	if( get_theme_mod( 'menu_bg' ) )
		$css .= '.main-navigation{background-image:url('.get_theme_mod( 'menu_bg' ).');}';
	if( get_theme_mod( 'menu_color' ) )
		$css .= '.main-navigation li a{color:'.get_theme_mod( 'menu_color' ).';}';
	if( get_theme_mod( 'menu_color_hover' ) )
		$css .= '.main-navigation li a:hover{
			color:'.get_theme_mod( 'menu_color_hover' ).';
			border-color:'.get_theme_mod( 'menu_color_hover' ).';}';
	// CTA
	if( get_theme_mod( 'enable_cta', 1 ) ):
		if( get_theme_mod( 'cta_bg', get_template_directory_uri() . "/images/cta.jpg" ) ) $css .= '#cta{background-image:url('. get_theme_mod( 'cta_bg', get_template_directory_uri() . "/images/cta.jpg" ) .');}';
		if( get_theme_mod( 'cta_text_color' ) ) $css .= '#cta .text{color:'.get_theme_mod( 'cta_text_color' ).';}';
		if( get_theme_mod( 'cta_button_bg' ) ) $css .= '#cta .button a{background-color:'. get_theme_mod('cta_button_bg') .';}';
	endif;
	// Print css
	if( !empty( $css ) ) {
		?>
		<style type="text/css"><?php echo $css; ?></style>
		<?php
	}
}
add_action('wp_head', 'corporatebusiness_custom_css');

?>