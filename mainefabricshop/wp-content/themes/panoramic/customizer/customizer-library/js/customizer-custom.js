/**
 * Panoramic Customizer Custom Functionality
 *
 */
( function( $ ) {
    
    $( window ).load( function() {
    	panoramic_toggle_site_identity_options();
    	
        $( '#customize-control-panoramic-logo-with-site-title input' ).on( 'change', function() {
        	panoramic_toggle_site_identity_options();
        } );
        
        function panoramic_toggle_site_identity_options() {
        	if ( $( '#customize-control-panoramic-logo-with-site-title input' ).prop('checked') ) {
        		$( '#customize-control-panoramic-logo-with-site-title-position' ).show();
        	} else {
        		$( '#customize-control-panoramic-logo-with-site-title-position' ).hide();
        	}
        }
    	
    	
    	// Show / Hide layout options
        var layoutMode = $( '#customize-control-panoramic-layout-mode select' ).val();
        panoramic_toggle_layout_options( layoutMode );
        
        $( '#customize-control-panoramic-layout-mode select' ).on( 'change', function() {
        	layoutMode = $( this ).val();
        	panoramic_toggle_layout_options( layoutMode );
        } );
        
        function panoramic_toggle_layout_options( layoutMode ) {
            if ( layoutMode == 'panoramic-layout-mode-multi-page' ) {
                $( '#customize-control-panoramic-layout-pages' ).hide();
                $( '#customize-control-panoramic-layout-zebra-stripe' ).hide();
                $( '#customize-control-panoramic-layout-zebra-stripe-even-color' ).hide();
                $( '#customize-control-panoramic-layout-highlight-first-menu-item' ).hide();
                $( '#customize-control-panoramic-layout-first-page-title' ).hide();
                $( '#customize-control-panoramic-layout-divider' ).hide();
                
            } else if ( layoutMode == 'panoramic-layout-mode-one-page' ) {
                $( '#customize-control-panoramic-layout-pages' ).show();
                $( '#customize-control-panoramic-layout-zebra-stripe' ).show();
                $( '#customize-control-panoramic-layout-zebra-stripe-even-color' ).show();
                $( '#customize-control-panoramic-layout-highlight-first-menu-item' ).show();
                $( '#customize-control-panoramic-layout-first-page-title' ).show();
                $( '#customize-control-panoramic-layout-divider' ).show();
                
            }
        }
    	
    	// Show / Hide header options
        var headerLayout = $( '#customize-control-panoramic-header-layout select' ).val();
        panoramic_toggle_header_options( headerLayout );
        
        $( '#customize-control-panoramic-header-layout select' ).on( 'change', function() {
        	headerLayout = $( this ).val();
        	panoramic_toggle_header_options( headerLayout );
        } );
        
        function panoramic_toggle_header_options( headerLayout ) {
            if ( headerLayout == 'panoramic-header-layout-standard' ) {
                $( '#customize-control-panoramic-show-header-top-bar' ).hide();
                $( '#customize-control-panoramic-header-top-bar-left' ).hide();
                $( '#customize-control-panoramic-header-top-bar-left-menu' ).hide();
                $( '#customize-control-panoramic-header-top-bar-right' ).hide();
                $( '#customize-control-panoramic-header-top-bar-right-menu' ).hide();
                $( '#customize-control-panoramic-header-top-right' ).show();
                panoramic_toggle_header_top_right_menu_select( $( '#customize-control-panoramic-header-top-right select' ).val() );
                
                $( '#customize-control-panoramic-header-bottom-right' ).show();
                panoramic_toggle_header_bottom_right_menu_select( $( '#customize-control-panoramic-header-bottom-right select' ).val() );
                
            } else if ( headerLayout == 'panoramic-header-layout-centered' ) {
                $( '#customize-control-panoramic-show-header-top-bar' ).show();
                $( '#customize-control-panoramic-header-top-bar-left' ).show();
                panoramic_toggle_header_top_bar_left_menu_select( $( '#customize-control-panoramic-header-top-bar-left select' ).val() );
                
                $( '#customize-control-panoramic-header-top-bar-right' ).show();
                panoramic_toggle_header_top_bar_right_menu_select( $( '#customize-control-panoramic-header-top-bar-right select' ).val() );
                
                $( '#customize-control-panoramic-header-top-right' ).hide();
                $( '#customize-control-panoramic-header-top-right-menu' ).hide();
                $( '#customize-control-panoramic-header-bottom-right' ).hide();
                $( '#customize-control-panoramic-header-bottom-right-menu' ).hide();
                
            }
        }
    	
    	// Show / Hide menu dropdowns
        
        // Top Right
        var headerTopRight = $( '#customize-control-panoramic-header-top-right select' );
        panoramic_toggle_header_top_right_menu_select( headerTopRight.val() );
        
        headerTopRight.on( 'change', function() {
        	panoramic_toggle_header_top_right_menu_select( $( this ).val() );
        } );
        
        function panoramic_toggle_header_top_right_menu_select( headerWidgetArea ) {
            if ( headerWidgetArea == 'panoramic-header-top-right-menu' && headerLayout == 'panoramic-header-layout-standard' ) {
                $( '#customize-control-panoramic-header-top-right-menu' ).show();
            } else {
                $( '#customize-control-panoramic-header-top-right-menu' ).hide();
            }
        }

        // Bottom Right
        var headerBottomRight = $( '#customize-control-panoramic-header-bottom-right select' );
        panoramic_toggle_header_bottom_right_menu_select( headerBottomRight.val() );
        
        headerBottomRight.on( 'change', function() {
        	panoramic_toggle_header_bottom_right_menu_select( $( this ).val() );
        } );
        
        function panoramic_toggle_header_bottom_right_menu_select( headerWidgetArea ) {
            if ( headerWidgetArea == 'panoramic-header-bottom-right-menu' && headerLayout == 'panoramic-header-layout-standard' ) {
                $( '#customize-control-panoramic-header-bottom-right-menu' ).show();
            } else {
                $( '#customize-control-panoramic-header-bottom-right-menu' ).hide();
            }
        }
        
        // Top Bar Left
        var headerTopBarLeft = $( '#customize-control-panoramic-header-top-bar-left select' );
        panoramic_toggle_header_top_bar_left_menu_select( headerTopBarLeft.val() );
        
        headerTopBarLeft.on( 'change', function() {
        	panoramic_toggle_header_top_bar_left_menu_select( $( this ).val() );
        } );
        
        function panoramic_toggle_header_top_bar_left_menu_select( headerWidgetArea ) {
            if ( headerWidgetArea == 'panoramic-header-top-bar-left-menu' && headerLayout == 'panoramic-header-layout-centered' ) {
                $( '#customize-control-panoramic-header-top-bar-left-menu' ).show();
            } else {
                $( '#customize-control-panoramic-header-top-bar-left-menu' ).hide();
            }
        }

        // Top Bar Right
        var headerTopBarRight = $( '#customize-control-panoramic-header-top-bar-right select' );
        panoramic_toggle_header_top_bar_right_menu_select( headerTopBarRight.val() );
        
        headerTopBarRight.on( 'change', function() {
        	panoramic_toggle_header_top_bar_right_menu_select( $( this ).val() );
        } );
        
        function panoramic_toggle_header_top_bar_right_menu_select( headerWidgetArea ) {
            if ( headerWidgetArea == 'panoramic-header-top-bar-right-menu' && headerLayout == 'panoramic-header-layout-centered' ) {
                $( '#customize-control-panoramic-header-top-bar-right-menu' ).show();
            } else {
                $( '#customize-control-panoramic-header-top-bar-right-menu' ).hide();
            }
        }
        
    	// Show / Hide slider options
        var sliderType = $( '#customize-control-panoramic-slider-type select' ).val();
        panoramic_toggle_slider_options( sliderType );
        
        $( '#customize-control-panoramic-slider-type select' ).on( 'change', function() {
        	sliderType = $( this ).val();
        	panoramic_toggle_slider_options( sliderType );
        } );
        
        function panoramic_toggle_slider_options( sliderType ) {
            if ( sliderType == 'panoramic-slider-default' ) {
                $( '#customize-control-panoramic-slider-categories' ).show();
                $( '#customize-control-panoramic-slider-all-pages' ).show();
                $( '#customize-control-panoramic-slider-blog-posts' ).show();
                $( '#customize-control-panoramic-slider-button-style' ).show();
                $( '#customize-control-panoramic-slider-text-overlay-background-color' ).show();
                $( '#customize-control-panoramic-slider-text-overlay-opacity' ).show();
                $( '#customize-control-panoramic-slider-transition-speed' ).show();
                $( '#customize-control-panoramic-slider-transition-effect' ).show();
                $( '#customize-control-panoramic-slider-autoscroll' ).show();
                $( '#customize-control-panoramic-slider-speed' ).show();
                $( '#customize-control-panoramic-slider-plugin-shortcode' ).hide();
                
            } else if ( sliderType == 'panoramic-slider-plugin' ) {
                $( '#customize-control-panoramic-slider-categories' ).hide();
                $( '#customize-control-panoramic-slider-all-pages' ).show();
                $( '#customize-control-panoramic-slider-blog-posts' ).show();
                $( '#customize-control-panoramic-slider-button-style' ).hide();
                $( '#customize-control-panoramic-slider-text-overlay-background-color' ).hide();
                $( '#customize-control-panoramic-slider-text-overlay-opacity' ).hide();
                $( '#customize-control-panoramic-slider-transition-speed' ).hide();
                $( '#customize-control-panoramic-slider-transition-effect' ).hide();
                $( '#customize-control-panoramic-slider-autoscroll' ).hide();
                $( '#customize-control-panoramic-slider-speed' ).hide();
                $( '#customize-control-panoramic-slider-plugin-shortcode' ).show();
                
            } else {
                $( '#customize-control-panoramic-slider-categories' ).hide();
                $( '#customize-control-panoramic-slider-all-pages' ).hide();
                $( '#customize-control-panoramic-slider-blog-posts' ).hide();
                $( '#customize-control-panoramic-slider-button-style' ).hide();
                $( '#customize-control-panoramic-slider-text-overlay-background-color' ).hide();
                $( '#customize-control-panoramic-slider-text-overlay-opacity' ).hide();
                $( '#customize-control-panoramic-slider-transition-speed' ).hide();
                $( '#customize-control-panoramic-slider-transition-effect' ).hide();
                $( '#customize-control-panoramic-slider-autoscroll' ).hide();
                $( '#customize-control-panoramic-slider-speed' ).hide();
                $( '#customize-control-panoramic-slider-plugin-shortcode' ).hide();
                
            }
        }
        
    	// Show / Hide blog options
        var blogArchiveLayout = $( '#customize-control-panoramic-blog-archive-layout select' ).val();
        panoramic_toggle_blog_options( blogArchiveLayout );
        
        $( '#customize-control-panoramic-blog-archive-layout select' ).on( 'change', function() {
        	blogArchiveLayout = $( this ).val();
        	panoramic_toggle_blog_options( blogArchiveLayout );
        } );
        
        function panoramic_toggle_blog_options( blogArchiveLayout ) {
            if ( blogArchiveLayout == 'panoramic-blog-archive-layout-full' ) {
                $( '#customize-control-panoramic-blog-excerpt-length' ).hide();
                $( '#customize-control-panoramic-blog-read-more-text' ).hide();
                
            } else if ( blogArchiveLayout == 'panoramic-blog-archive-layout-excerpt' ) {
                $( '#customize-control-panoramic-blog-excerpt-length' ).show();
                $( '#customize-control-panoramic-blog-read-more-text' ).show();
                
            }
        }            
        
    } );
    
} )( jQuery );