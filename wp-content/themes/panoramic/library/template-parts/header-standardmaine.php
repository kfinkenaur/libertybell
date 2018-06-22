<?php
global $woocommerce;

$logo = '';
$mobile_logo = '';
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
	$logo = "<a href=\"". esc_url( $logo_link_content ) ."\" title=\"". esc_attr( get_bloginfo( 'name', 'display' ) ) ."\" class=\"custom-logo-link\"><img src=\"". esc_url( get_theme_mod( 'panoramic-logo' ) ) ."\" alt=\"". esc_attr( get_bloginfo( 'name' ) ) ."\" class=\"custom-logo\" /></a>";
}

if ( get_theme_mod( 'panoramic-mobile-logo' ) ) {
	$mobile_logo = "<a href=\"". esc_url( $logo_link_content ) ."\" title=\"". esc_attr( get_bloginfo( 'name', 'display' ) ) ."\" class=\"mobile-logo-link\"><img src=\"". esc_url( get_theme_mod( 'panoramic-mobile-logo' ) ) ."\" alt=\"". esc_attr( get_bloginfo( 'name' ) ) ."\" class=\"mobile-logo\" /></a>";
}
?>

<div class="site-container <?php echo get_theme_mod( 'panoramic-header-bound', customizer_library_get_default( 'panoramic-header-bound' ) ) == 'panoramic-header-bound-full-width' ? 'full-width' : ''; ?>">

	<?php
	$logo_with_site_title = false;
	$site_title_class = '';
	
	if( $logo && get_theme_mod( 'panoramic-logo-with-site-title', customizer_library_get_default( 'panoramic-logo-with-site-title' ) ) && !get_theme_mod( 'panoramic-full-width-logo', customizer_library_get_default( 'panoramic-full-width-logo' ) ) ) {
		$logo_with_site_title = true;

		if ( get_theme_mod( 'panoramic-logo-with-site-title-position', customizer_library_get_default( 'panoramic-logo-with-site-title-position' ) ) == 'panoramic-logo-with-site-title-right' ) {
			$site_title_class = 'title-right';
		} else {
			$site_title_class = 'title-below';
		}
	}
	
	$mobile_logo_with_site_title = false;
	
	if ( get_theme_mod( 'panoramic-mobile-logo-with-site-title', customizer_library_get_default( 'panoramic-mobile-logo-with-site-title' ) ) && !get_theme_mod( 'panoramic-full-width-mobile-logo', customizer_library_get_default( 'panoramic-full-width-mobile-logo' ) ) ) {
		$mobile_logo_with_site_title = true;
	}
	?>
    
    <div class="branding <?php echo $site_title_class; ?> <?php echo $mobile_logo_with_site_title ? 'mobile-logo-with-site-title' : ''; ?> <?php echo $mobile_logo ? 'has-mobile-logo' : ''; ?>">
        <?php
        if( $logo ) {
       		echo $logo;
        
	        if ( $mobile_logo ) {
				echo $mobile_logo;
			}
        
        	if( $logo_with_site_title || $mobile_logo_with_site_title ) {
        ?>
				<div class="title_and_tagline <?php echo $logo_with_site_title ? 'desktop' : 'hide-for-desktop'; ?> <?php echo $mobile_logo_with_site_title ? 'mobile' : 'hide-for-mobile'; ?>">
		            <a href="<?php echo esc_url( $logo_link_content ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="title <?php echo get_theme_mod( 'panoramic-site-title-font-weight', customizer_library_get_default( 'panoramic-site-title-font-weight' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		            <div class="description"><?php bloginfo( 'description' ); ?></div>
        		</div>
        <?php
			}
        
        } else {

	        if ( $mobile_logo ) {
				echo $mobile_logo;
			}

        	if ( $mobile_logo_with_site_title ) {
        ?>
				<div class="title_and_tagline mobile">
		<?php
			}
		?>
					<a href="<?php echo esc_url( $logo_link_content ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="title <?php echo $mobile_logo && !$mobile_logo_with_site_title ? 'hide-for-mobile' : ''; ?> <?php echo get_theme_mod( 'panoramic-site-title-font-weight', customizer_library_get_default( 'panoramic-site-title-font-weight' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
					<div class="description <?php echo $mobile_logo && !$mobile_logo_with_site_title ? 'hide-for-mobile' : ''; ?>"><?php bloginfo( 'description' ); ?></div>
        <?php
        	if ( $mobile_logo_with_site_title ) {
        ?>
        		</div>
        <?php
			}
        }
        ?>
	</div>
	
	<?php
	$top_right = '';
        
	if ( panoramic_is_woocommerce_activated() && get_theme_mod( 'panoramic-header-top-right', customizer_library_get_default( 'panoramic-header-top-right' ) ) == 'panoramic-header-top-right-shop-links' ) {
		$top_right = 'shop_links';
	} else if ( get_theme_mod( 'panoramic-header-top-right', customizer_library_get_default( 'panoramic-header-top-right' ) ) == 'panoramic-header-top-right-info-text' )  {
		$top_right = 'info_text';
	} else if ( get_theme_mod( 'panoramic-header-top-right', customizer_library_get_default( 'panoramic-header-top-right' ) ) == 'panoramic-header-top-right-social-links' )  { 
		$top_right = 'social_links';
	} else if ( get_theme_mod( 'panoramic-header-top-right', customizer_library_get_default( 'panoramic-header-top-right' ) ) == 'panoramic-header-top-right-menu' && get_theme_mod( 'panoramic-header-top-right-menu' ) )  { 
		$top_right = 'menu';
	}
	
	$bottom_right = '';
	
	if ( panoramic_is_woocommerce_activated() && get_theme_mod( 'panoramic-header-bottom-right', customizer_library_get_default( 'panoramic-header-bottom-right' ) ) == 'panoramic-header-bottom-right-shop-links' ) {
		$bottom_right = 'shop_links';
	} else if ( get_theme_mod( 'panoramic-header-bottom-right', customizer_library_get_default( 'panoramic-header-bottom-right' ) ) == 'panoramic-header-bottom-right-info-text' )  {
		$bottom_right = 'info_text';
	} else if ( get_theme_mod( 'panoramic-header-bottom-right', customizer_library_get_default( 'panoramic-header-bottom-right' ) ) == 'panoramic-header-bottom-right-social-links' )  { 
		$bottom_right = 'social_links';
	} else if ( get_theme_mod( 'panoramic-header-bottom-right', customizer_library_get_default( 'panoramic-header-bottom-right' ) ) == 'panoramic-header-bottom-right-menu' && get_theme_mod( 'panoramic-header-bottom-right-menu' ) )  {
		$bottom_right = 'menu';
	}
	?>
    
    <div class="site-header-right <?php echo $top_right == '' ? 'top-empty' : ''; ?> <?php echo $bottom_right == '' ? 'bottom-empty' : ''; ?>">
        
        <div class="top <?php echo $top_right == '' ? 'empty' : ''; ?>">
	        <?php
	        switch ($top_right) {
	    		case 'shop_links':
	    			get_template_part( 'library/template-parts/shop-links' );
	    			break;
	    			
	    		case 'info_text':
	    			get_template_part( 'library/template-parts/info-textmaine' );
	    			break;
	    			
	    		case 'social_links':
	    			get_template_part( 'library/template-parts/social-links' );
	    			break;
	    			
	    		case 'menu':
					if ( get_theme_mod( 'panoramic-header-top-right-menu' ) ) {
						wp_nav_menu( array( menu => get_theme_mod( 'panoramic-header-top-right-menu' ) ) );
					}    			
	    			break;
	    			
	    		default:
	    			echo '<div class="placeholder"></div>';
	    	}
	    	?>
        </div>
        
        <div class="bottom <?php echo $bottom_right == '' ? 'empty' : ''; ?>">
	        <?php
	        switch ($bottom_right) {
	    		case 'shop_links':
	    			get_template_part( 'library/template-parts/shop-links' );
	    			break;
	    			
	    		case 'info_text':
	    			get_template_part( 'library/template-parts/info-textmaine' );
	    			break;
	    			
	    		case 'social_links':
	    			get_template_part( 'library/template-parts/social-links' );
	    			break;
	    			
	    		case 'menu':
					if ( get_theme_mod( 'panoramic-header-bottom-right-menu' ) ) {
						wp_nav_menu( array( menu => get_theme_mod( 'panoramic-header-bottom-right-menu' ) ) );
					}    			
	    			break;
	    	}
	    	?>
		</div>
		        
    </div>
    <div class="clearboth"></div>
    
	<?php
	if( get_theme_mod( 'panoramic-header-search', customizer_library_get_default( 'panoramic-header-search' ) ) ) {
	?>
		<div class="search-block">
			<?php get_search_form(); ?>
		</div>
	<?php
	}
	?>
    
</div>

<?php
global $show_slider, $show_header_image, $show_header_video;
$is_translucent = get_theme_mod( 'panoramic-layout-navigation-opacity', customizer_library_get_default( 'panoramic-layout-navigation-opacity' ) ) < 1;

if ( $is_translucent && !$show_slider && !$show_header_image && !$show_header_video ) {
	$is_translucent = false;
}

/*
if ( !is_front_page() && $is_translucent && !$show_slider && !$show_header_image ) {
	$is_translucent = false;
} else if ( is_front_page() && $is_translucent && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-no-slider' && !get_header_image() ) {
	$is_translucent = false;
} else if ( is_front_page() && $is_translucent && get_theme_mod( 'panoramic-slider-type', customizer_library_get_default( 'panoramic-slider-type' ) ) == 'panoramic-slider-plugin' && get_theme_mod( 'panoramic-slider-plugin-shortcode', customizer_library_get_default( 'panoramic-slider-plugin-shortcode' ) ) == '' ) {
	$is_translucent = false;
}
*/
?>

<nav id="site-navigation" class="main-navigation border-bottom <?php echo esc_attr( ( $is_translucent ) ? 'translucent' : '' ); ?> <?php echo esc_attr( ( get_theme_mod( 'panoramic-animated-submenus', customizer_library_get_default( 'panoramic-animated-submenus' ) ) ) ? 'animated-submenus' : '' ); ?>" role="navigation">
	<span class="header-menu-button"><i class="fa fa-bars"></i></span>
	<div id="main-menu" class="main-menu-container <?php echo esc_attr( get_theme_mod( 'panoramic-mobile-menu-color-scheme', customizer_library_get_default( 'panoramic-mobile-menu-color-scheme' ) ) ); ?>">
		<div class="main-menu-close"><i class="fa fa-angle-right"></i><i class="fa fa-angle-left"></i></div>
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'main-navigation-inner' ) ); ?>
	</div>
</nav><!-- #site-navigation -->
