<?php global $woocommerce; ?>
    <div class="site-top-bar border-bottom">
        
        <div class="site-container">
            
            <div class="site-top-bar-left">
        	<?php
	        if ( panoramic_is_woocommerce_activated() && get_theme_mod( 'panoramic-header-top-bar-left', customizer_library_get_default( 'panoramic-header-top-bar-left' ) ) == 'panoramic-header-top-bar-left-shop-links' ) {
				get_template_part( 'library/template-parts/shop-links' );
	            
	        } else if ( get_theme_mod( 'panoramic-header-top-bar-left', customizer_library_get_default( 'panoramic-header-top-bar-left' ) ) == 'panoramic-header-top-bar-left-info-text' )  {
				get_template_part( 'library/template-parts/info-text' );
				
	        } else if ( get_theme_mod( 'panoramic-header-top-bar-left', customizer_library_get_default( 'panoramic-header-top-bar-left' ) ) == 'panoramic-header-top-bar-left-social-links' )  { 
				get_template_part( 'library/template-parts/social-links' );
				
	        } else if ( get_theme_mod( 'panoramic-header-top-bar-left', customizer_library_get_default( 'panoramic-header-top-bar-left' ) ) == 'panoramic-header-top-bar-left-menu' )  { 
				get_template_part( 'library/template-parts/header-menu-top-bar-left' );
				
	        } else if ( get_theme_mod( 'panoramic-header-top-bar-left', customizer_library_get_default( 'panoramic-header-top-bar-left' ) ) == 'panoramic-header-top-bar-left-nothing' )  {
			}
			?>            
            </div>
            
            <div class="site-top-bar-right">
        	<?php
	        if ( panoramic_is_woocommerce_activated() && get_theme_mod( 'panoramic-header-top-bar-right', customizer_library_get_default( 'panoramic-header-top-bar-right' ) ) == 'panoramic-header-top-bar-right-shop-links' ) {
				get_template_part( 'library/template-parts/shop-links' );
	            
	        } else if ( get_theme_mod( 'panoramic-header-top-bar-right', customizer_library_get_default( 'panoramic-header-top-bar-right' ) ) == 'panoramic-header-top-bar-right-info-text' )  {
				get_template_part( 'library/template-parts/info-text' );
				
	        } else if ( get_theme_mod( 'panoramic-header-top-bar-right', customizer_library_get_default( 'panoramic-header-top-bar-right' ) ) == 'panoramic-header-top-bar-right-social-links' )  { 
				get_template_part( 'library/template-parts/social-links' );
				
	        } else if ( get_theme_mod( 'panoramic-header-top-bar-right', customizer_library_get_default( 'panoramic-header-top-bar-right' ) ) == 'panoramic-header-top-bar-right-menu' )  {
				get_template_part( 'library/template-parts/header-menu-top-bar-right' );
				
	        } else if ( get_theme_mod( 'panoramic-header-top-bar-right', customizer_library_get_default( 'panoramic-header-top-bar-right' ) ) == 'panoramic-header-top-bar-right-nothing' )  {
			}
			?>                
            </div>
            <div class="clearboth"></div>
            
        </div>
    </div>
