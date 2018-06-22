<?php
global $woocommerce;

$logo = '';
$logo_link_content = '';

if ( get_theme_mod( 'panoramic-logo-link-content', customizer_library_get_default( 'panoramic-logo-link-content' ) ) == "" ) {
	$logo_link_content = home_url( '/' );
} else {
	$logo_link_content = get_permalink( get_theme_mod( 'panoramic-logo-link-content' ) );
}

if ( function_exists( 'has_custom_logo' ) ) {
	if ( has_custom_logo() ) {
		$logo = get_custom_logo();
	}
} else if ( get_theme_mod( 'panoramic-logo' ) ) {
	$logo = "<a href=\"". esc_url( $logo_link_content ) ."\" title=\"". esc_attr( get_bloginfo( 'name', 'display' ) ) ."\"><img src=\"". esc_url( get_theme_mod( 'panoramic-logo' ) ) ."\" alt=\"". esc_attr( get_bloginfo( 'name' ) ) ."\" /></a>";
}
?>

<div class="site-container">

	<?php
	$logo_with_site_title = false;
	$site_title_class = '';
	
	if( get_theme_mod( 'panoramic-logo-with-site-title', customizer_library_get_default( 'panoramic-logo-with-site-title' ) ) ) {
		$logo_with_site_title = true;

		if ( get_theme_mod( 'panoramic-logo-with-site-title-position', customizer_library_get_default( 'panoramic-logo-with-site-title-position' ) ) == 'panoramic-logo-with-site-title-right' ) {
			$site_title_class = 'title-right';
		} else {
			$site_title_class = 'title-below';
		}
	}
	?>
    
    <div class="branding <?php echo $site_title_class; ?>">
        <?php
        if( $logo ) :
       		echo $logo;
        
        	if( $logo_with_site_title ) :
        ?>
				<div class="title_and_tagline">
		            <a href="<?php echo esc_url( $logo_link_content ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="title <?php echo get_theme_mod( 'panoramic-site-title-font-weight', customizer_library_get_default( 'panoramic-site-title-font-weight' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		            <div class="description"><?php bloginfo( 'description' ); ?></div>
        		</div>
        <?php
			endif;
        
        else :
        ?>
            <a href="<?php echo esc_url( $logo_link_content ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="title <?php echo get_theme_mod( 'panoramic-site-title-font-weight', customizer_library_get_default( 'panoramic-site-title-font-weight' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
            <div class="description"><?php bloginfo( 'description' ); ?></div>
        <?php
        endif;
        ?>
    </div><!-- .site-branding -->
    
    <div class="site-header-right">
        
        <div class="top">
        <?php
        if ( panoramic_is_woocommerce_activated() && get_theme_mod( 'panoramic-header-top-right', customizer_library_get_default( 'panoramic-header-top-right' ) ) == 'panoramic-header-top-right-shop-links' ) {
			get_template_part( 'library/template-parts/shop-links' );
            
        } else if ( get_theme_mod( 'panoramic-header-top-right', customizer_library_get_default( 'panoramic-header-top-right' ) ) == 'panoramic-header-top-right-info-text' )  {
			get_template_part( 'library/template-parts/info-text' );
			
        } else if ( get_theme_mod( 'panoramic-header-top-right', customizer_library_get_default( 'panoramic-header-top-right' ) ) == 'panoramic-header-top-right-social-links' )  { 
			get_template_part( 'library/template-parts/social-links' );

        } else if ( get_theme_mod( 'panoramic-header-top-right', customizer_library_get_default( 'panoramic-header-top-right' ) ) == 'panoramic-header-top-right-menu' )  { 
			get_template_part( 'library/template-parts/header-menu-top-right' );
			
        } else if ( get_theme_mod( 'panoramic-header-top-right', customizer_library_get_default( 'panoramic-header-top-right' ) ) == 'panoramic-header-top-right-nothing' )  { 
		?>
			<div class="placeholder"></div>
		<?php 
		}
        ?>
        </div>
        
        <div class="bottom">
        <?php
        if ( panoramic_is_woocommerce_activated() && get_theme_mod( 'panoramic-header-bottom-right', customizer_library_get_default( 'panoramic-header-bottom-right' ) ) == 'panoramic-header-bottom-right-shop-links' ) {
			get_template_part( 'library/template-parts/shop-links' );
            
        } else if ( get_theme_mod( 'panoramic-header-bottom-right', customizer_library_get_default( 'panoramic-header-bottom-right' ) ) == 'panoramic-header-bottom-right-info-text' )  {
			get_template_part( 'library/template-parts/info-text' );
			
        } else if ( get_theme_mod( 'panoramic-header-bottom-right', customizer_library_get_default( 'panoramic-header-bottom-right' ) ) == 'panoramic-header-bottom-right-social-links' )  { 
			get_template_part( 'library/template-parts/social-links' );
			
        } else if ( get_theme_mod( 'panoramic-header-bottom-right', customizer_library_get_default( 'panoramic-header-bottom-right' ) ) == 'panoramic-header-bottom-right-menu' )  {
			get_template_part( 'library/template-parts/header-menu-bottom-right' );
			
        } else if ( get_theme_mod( 'panoramic-header-bottom-right', customizer_library_get_default( 'panoramic-header-bottom-right' ) ) == 'panoramic-header-bottom-right-nothing' )  {
		}
		?>
		</div>
		        
    </div>
    <div class="clearboth"></div>
    
	<?php if( get_theme_mod( 'panoramic-header-search', customizer_library_get_default( 'panoramic-header-search' ) ) ) : ?>
		<div class="search-block">
			<?php get_search_form(); ?>
		</div>
	<?php endif; ?>
    
</div>

<?php
global $show_slider, $slider_shortcode, $show_header_image;
$is_translucent = get_theme_mod( 'panoramic-layout-navigation-opacity', customizer_library_get_default( 'panoramic-layout-navigation-opacity' ) ) < 1;

if ( !is_front_page() && $is_translucent && !$show_slider && !$show_header_image ) {
	$is_translucent = false;
} else if ( is_front_page() && $is_translucent && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-no-slider' && !get_header_image() && empty($slider_shortcode) ) {
	$is_translucent = false;
} else if ( is_front_page() && $is_translucent && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-plugin' && get_theme_mod( 'panoramic-slider-plugin-shortcode', customizer_library_get_default( 'panoramic-slider-plugin-shortcode' ) ) == '' && empty($slider_shortcode) ) {
	$is_translucent = false;
}
?>

<nav id="site-navigation" class="main-navigation border-bottom <?php echo ( $is_translucent ) ? 'translucent' : ''; ?>" role="navigation">
	<span class="header-menu-button"><i class="fa fa-bars"></i></span>
	<div id="main-menu" class="main-menu-container <?php echo get_theme_mod( 'panoramic-mobile-menu-color-scheme', customizer_library_get_default( 'panoramic-mobile-menu-color-scheme' ) ); ?>">
		<div class="main-menu-close"><i class="fa fa-angle-right"></i><i class="fa fa-angle-left"></i></div>
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'main-navigation-inner' ) ); ?>
	</div>
</nav><!-- #site-navigation -->
