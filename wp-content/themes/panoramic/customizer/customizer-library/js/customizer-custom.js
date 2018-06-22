/**
 * Panoramic Customizer Custom Functionality
 *
 */
( function( $ ) {
	
	function panoramic_set_option( id, value ) {
		var api = wp.customize;
		
		var control = api.control.instance( id );
	    control.setting.set( value );
	    return;
	}		
    
    $( window ).on('load', function() {
    	
    	// Set the color scheme
        //var scheme = $( '#customize-control-panoramic-color-scheme select' ).val();
        //panoramic_set_color_scheme();
        
        $( '#customize-control-panoramic-color-scheme select' ).on( 'change', function() {
            //var scheme = $( '#customize-control-panoramic-color-scheme select' ).val();
            
            //if ( font_pairing[0].length > 0 ) {
            	//panoramic_set_color_scheme();
            //}
        } );
        
        /*
        function panoramic_set_color_scheme() {
        	var scheme = $( '#customize-control-panoramic-color-scheme select' ).val();
        	
        	switch( scheme ) {
		        case 'dark-blue':
		        	panoramic_set_option( 'panoramic-primary-color', '#006489');
		        	panoramic_set_option( 'panoramic-secondary-color', '#3f84a4');
		        	panoramic_set_option( 'panoramic-heading-font-color', '#006489');
		        	panoramic_set_option( 'panoramic-footer-color', '#EAF1F7');
		            break;
	            case 'brown':
	            	panoramic_set_option( 'panoramic-primary-color', '#976A42');
	            	panoramic_set_option( 'panoramic-secondary-color', '#705137');
	            	panoramic_set_option( 'panoramic-heading-font-color', '#976A42');
	            	panoramic_set_option( 'panoramic-footer-color', '#F3F0F0');
	                break;
	            case 'rasberry-red':
	            	panoramic_set_option( 'panoramic-primary-color', '#E63338');
	            	panoramic_set_option( 'panoramic-secondary-color', '#BB122A');
	            	panoramic_set_option( 'panoramic-heading-font-color', '#E63338');
	            	panoramic_set_option( 'panoramic-footer-color', '#F3F0F0');
	                break;
	            case 'olive-green':
	            	panoramic_set_option( 'panoramic-primary-color', '#918e26');
	            	panoramic_set_option( 'panoramic-secondary-color', '#696C2C');
	            	panoramic_set_option( 'panoramic-heading-font-color', '#918e26');
	            	panoramic_set_option( 'panoramic-footer-color', '#E8E8E5');
	                break;
	            case 'burnt-orange':
	            	panoramic_set_option( 'panoramic-primary-color', '#ED6608');
	            	panoramic_set_option( 'panoramic-secondary-color', '#C25822');
	            	panoramic_set_option( 'panoramic-heading-font-color', '#ED6608');
	            	panoramic_set_option( 'panoramic-footer-color', '#F3F0F0');
	                break;
	            case 'green':
	            	panoramic_set_option( 'panoramic-primary-color', '#51AE32');
	            	panoramic_set_option( 'panoramic-secondary-color', '#438E39');
	            	panoramic_set_option( 'panoramic-heading-font-color', '#51AE32');
	            	panoramic_set_option( 'panoramic-footer-color', '#F0F1E7');
	                break;
	            case 'charcoal':
	            	panoramic_set_option( 'panoramic-primary-color', '#282F29');
	            	panoramic_set_option( 'panoramic-secondary-color', '#0A0F0D');
	            	panoramic_set_option( 'panoramic-heading-font-color', '#282F29');
	            	panoramic_set_option( 'panoramic-footer-color', '#E8E8E5');
	                break;
	            case 'pink':
	            	panoramic_set_option( 'panoramic-primary-color', '#EF7BA7');
	            	panoramic_set_option( 'panoramic-secondary-color', '#E05781');
	            	panoramic_set_option( 'panoramic-heading-font-color', '#EF7BA7');
	            	panoramic_set_option( 'panoramic-footer-color', '#F7EEED');
	                break;
	            case 'sky-blue':
	            	panoramic_set_option( 'panoramic-primary-color', '#00B2CD');
	            	panoramic_set_option( 'panoramic-secondary-color', '#009AA9');
	            	panoramic_set_option( 'panoramic-heading-font-color', '#00B2CD');
	            	panoramic_set_option( 'panoramic-footer-color', '#E2F0F5');
	                break;
	            case 'blue':
	            	panoramic_set_option( 'panoramic-primary-color', '#0073AE');
	            	panoramic_set_option( 'panoramic-secondary-color', '#00547F');
	            	panoramic_set_option( 'panoramic-heading-font-color', '#0073AE');
	            	panoramic_set_option( 'panoramic-footer-color', '#F2F4F6');
	                break;
	            case 'gray':
	            	panoramic_set_option( 'panoramic-primary-color', '#63686C');
	            	panoramic_set_option( 'panoramic-secondary-color', '#414749');
	            	panoramic_set_option( 'panoramic-heading-font-color', '#63686C');
	            	panoramic_set_option( 'panoramic-footer-color', '#F2F4F6');
	                break;
	            case 'purple':
	            	panoramic_set_option( 'panoramic-primary-color', '#804688');
	            	panoramic_set_option( 'panoramic-secondary-color', '#5B315B');
	            	panoramic_set_option( 'panoramic-heading-font-color', '#804688');
	            	panoramic_set_option( 'panoramic-footer-color', '#DEE1EA');
	                break;
	                
        	}
    	}
    	*/
        
    	/*
    	// Set the Font Pairing
        var font_pairing = $( '#customize-control-panoramic-google-font-pairing select' ).val().split(',');
        
        if ( font_pairing[0].length > 0 ) {
        	panoramic_set_font_pairing( font_pairing[0], font_pairing[1] );
        }
        
        $( '#customize-control-panoramic-google-font-pairing select' ).on( 'change', function() {
            var font_pairing = $( '#customize-control-panoramic-google-font-pairing select' ).val().split(',');
            
            if ( font_pairing[0].length > 0 ) {
            	panoramic_set_font_pairing( font_pairing[0], font_pairing[1] );
            }
        } );
        
        function panoramic_set_font_pairing( font1, font2 ) {
        	panoramic_set_option( 'panoramic-heading-font', font1 );
        	panoramic_set_option( 'panoramic-body-font', font2 );
        }
    	*/
        
    	// Show / hide site identity options
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
    	
    	// Show / hide site layout options
        var siteLayout = $( '#customize-control-panoramic-layout-site select' ).val();
        panoramic_toggle_site_layout_options( siteLayout );
        
        $( '#customize-control-panoramic-layout-site select' ).on( 'change', function() {
        	siteLayout = $( this ).val();
        	panoramic_toggle_site_layout_options( siteLayout );
        } );
        
        function panoramic_toggle_site_layout_options( siteLayout ) {
            if ( siteLayout == 'panoramic-layout-site-full-width' ) {
                $( '#customize-control-panoramic-page-content-background-color' ).hide();
                
            } else if ( siteLayout == 'panoramic-layout-site-boxed' ) {
                $( '#customize-control-panoramic-page-content-background-color' ).show();
                
            }
        }            

    	// Show / hide mode options
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
                //$( '#customize-control-panoramic-layout-display-page-titles').show();
                
                panoramic_toggle_layout_page_title_settings();
                
                $( '#customize-control-panoramic-blog-archive-display-post-titles').show();
                $( '#customize-control-panoramic-layout-featured-image-page-headers').show();
                
            } else if ( layoutMode == 'panoramic-layout-mode-one-page' ) {
                $( '#customize-control-panoramic-layout-pages' ).show();
                $( '#customize-control-panoramic-layout-zebra-stripe' ).show();
                $( '#customize-control-panoramic-layout-zebra-stripe-even-color' ).show();
                $( '#customize-control-panoramic-layout-highlight-first-menu-item' ).show();
                //$( '#customize-control-panoramic-layout-first-page-title' ).show();
                $( '#customize-control-panoramic-layout-divider' ).show();
                //$( '#customize-control-panoramic-layout-display-page-titles').show();
                
                panoramic_toggle_layout_page_title_settings();
                
                $( '#customize-control-panoramic-layout-display-homepage-page-title' ).hide();
                $( '#customize-control-panoramic-blog-archive-display-post-titles').hide();
                $( '#customize-control-panoramic-layout-featured-image-page-headers').hide();
            }
        }
        
        // Show / hide slider min width
        $( '#customize-control-panoramic-layout-display-page-titles input' ).on( 'change', function() {
        	panoramic_toggle_layout_page_title_settings();
        } );
        
        function panoramic_toggle_layout_page_title_settings() {
        	if ( $( '#customize-control-panoramic-layout-display-page-titles input' ).prop('checked') && layoutMode == 'panoramic-layout-mode-multi-page' ) {
        		$( '#customize-control-panoramic-layout-display-homepage-page-title' ).show();
        		//$( '#customize-control-panoramic-layout-first-page-title' ).hide();
        		
        	} else if ( $( '#customize-control-panoramic-layout-display-page-titles input' ).prop('checked') && layoutMode == 'panoramic-layout-mode-one-page' ) {
        		//$( '#customize-control-panoramic-layout-display-homepage-page-title' ).hide();
        		$( '#customize-control-panoramic-layout-first-page-title' ).show();
        		
        	} else {
        		$( '#customize-control-panoramic-layout-display-homepage-page-title' ).hide();
        		$( '#customize-control-panoramic-layout-first-page-title' ).hide();
        	}
        }
    	
    	// Show / hide header options
        var headerLayout = $( '#customize-control-panoramic-header-layout select' ).val();
        panoramic_toggle_header_options( headerLayout );
        
        $( '#customize-control-panoramic-header-layout select' ).on( 'change', function() {
        	headerLayout = $( this ).val();
        	panoramic_toggle_header_options( headerLayout );
        } );
        
        function panoramic_toggle_header_options( headerLayout ) {
            if ( headerLayout == 'panoramic-header-layout-standard' ) {
            	$( '#customize-control-panoramic-header-bound' ).show();
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
            	$( '#customize-control-panoramic-header-bound' ).hide();
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
    	
    	// Show / hide menu dropdowns
        
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
        
    	// Show / hide sticky header options
        panoramic_toggle_sticky_header_options();
    	
        $( '#customize-control-panoramic-header-sticky input' ).on( 'change', function() {
        	panoramic_toggle_sticky_header_options();
        } );
        
        function panoramic_toggle_sticky_header_options() {
        	if ( $( '#customize-control-panoramic-header-sticky input' ).prop('checked') ) {
        		$( '#customize-control-panoramic-header-deactivate-sticky-on-mobile' ).show();
        		$( '#customize-control-panoramic-header-sticky-has-min-width' ).show();
        		
        		panoramic_toggle_sticky_header_deactivation_width();
        	} else {
        		$( '#customize-control-panoramic-header-deactivate-sticky-on-mobile' ).hide();
        		$( '#customize-control-panoramic-header-sticky-has-min-width' ).hide();
        		$( '#customize-control-panoramic-header-sticky-deactivation-breakpoint' ).hide();
        	}
        }        

    	// Show / hide sticky header deactivation width
        panoramic_toggle_sticky_header_deactivation_width();
    	
        $( '#customize-control-panoramic-header-sticky-has-min-width input' ).on( 'change', function() {
        	panoramic_toggle_sticky_header_deactivation_width();
        } );
        
        function panoramic_toggle_sticky_header_deactivation_width() {
        	if ( $( '#customize-control-panoramic-header-sticky-has-min-width input' ).prop('checked') ) {
        		$( '#customize-control-panoramic-header-sticky-deactivation-breakpoint' ).show();
        	} else {
        		$( '#customize-control-panoramic-header-sticky-deactivation-breakpoint' ).hide();
        	}
        }        
        
        
    	// Show / hide mobile menu options
    	panoramic_toggle_mobile_menu_options();
    	
        $( '#customize-control-panoramic-mobile-menu input' ).on( 'change', function() {
        	panoramic_toggle_mobile_menu_options();
        } );
        
        function panoramic_toggle_mobile_menu_options() {
        	if ( $( '#customize-control-panoramic-mobile-menu input' ).prop('checked') ) {
        		$( '#customize-control-panoramic-mobile-menu-activate-on-mobile' ).show();
        		$( '#customize-control-panoramic-mobile-menu-button-color' ).show();
        		$( '#customize-control-panoramic-mobile-menu-color-scheme' ).show();
        		$( '#customize-control-panoramic-mobile-menu-breakpoint' ).show();
        	} else {
        		$( '#customize-control-panoramic-mobile-menu-activate-on-mobile' ).hide();
        		$( '#customize-control-panoramic-mobile-menu-button-color' ).hide();
        		$( '#customize-control-panoramic-mobile-menu-color-scheme' ).hide();
        		$( '#customize-control-panoramic-mobile-menu-breakpoint' ).hide();
        	}
        }        

        
    	// Show / hide slider options
        var sliderType = $( '#customize-control-panoramic-slider-type select' ).val();
        panoramic_toggle_slider_options( sliderType );
        
        $( '#customize-control-panoramic-slider-type select' ).on( 'change', function() {
        	sliderType = $( this ).val();
        	panoramic_toggle_slider_options( sliderType );
        } );
        
        function panoramic_toggle_slider_options( sliderType ) {
            if ( sliderType == 'panoramic-slider-default' ) {
                $( '#customize-control-panoramic-slider-categories' ).show();
                $( '#customize-control-panoramic-smart-slider' ).show();
                $( '#customize-control-panoramic-slider-all-pages' ).show();
                $( '#customize-control-panoramic-slider-blog-posts' ).show();
                $( '#customize-control-panoramic-slider-display-directional-buttons' ).show();
                $( '#customize-control-panoramic-slider-display-pagination' ).show();
                $( '#customize-control-panoramic-slider-button-style' ).show();
                $( '#customize-control-panoramic-slider-text-overlay-background-color' ).show();
                $( '#customize-control-panoramic-slider-text-overlay-opacity' ).show();
                
                // Responsive settings
                $( '#customize-control-panoramic-slider-responsive-heading' ).show();
                $( '#customize-control-panoramic-slider-hide-text-overlay' ).show();
                $( '#customize-control-panoramic-slider-hide-headings' ).show();
                $( '#customize-control-panoramic-slider-hide-paragraphs' ).show();
                $( '#customize-control-panoramic-slider-hide-buttons' ).show();
                $( '#customize-control-panoramic-slider-has-min-width' ).show();

                panoramic_toggle_slider_min_width();

                // Slideshow settings
                $( '#customize-control-panoramic-slider-transition-speed' ).show();
                $( '#customize-control-panoramic-slider-transition-effect' ).show();
                $( '#customize-control-panoramic-slider-autoscroll' ).show();
                
                panoramic_toggle_slider_autoscroll_settings();
                
                $( '.divider.default-slider' ).parent('li').show();
                
                $( '#customize-control-panoramic-slider-plugin-shortcode' ).hide();
                
                // Header image visibility warning
                $( '#customize-control-panoramic-slider-enabled-warning' ).show();
                
            } else if ( sliderType == 'panoramic-slider-plugin' ) {
                $( '#customize-control-panoramic-slider-categories' ).hide();
                $( '#customize-control-panoramic-smart-slider' ).hide();
                $( '#customize-control-panoramic-slider-all-pages' ).show();
                $( '#customize-control-panoramic-slider-blog-posts' ).show();
                $( '#customize-control-panoramic-slider-display-directional-buttons' ).hide();
                $( '#customize-control-panoramic-slider-display-pagination' ).hide();
                
                $( '#customize-control-panoramic-slider-has-min-width' ).hide();
                $( '#customize-control-panoramic-slider-min-width' ).hide();
                $( '#customize-control-panoramic-slider-button-style' ).hide();
                $( '#customize-control-panoramic-slider-text-overlay-background-color' ).hide();
                $( '#customize-control-panoramic-slider-text-overlay-opacity' ).hide();
                
                // Responsive settings
                $( '#customize-control-panoramic-slider-responsive-heading' ).hide();
                $( '#customize-control-panoramic-slider-hide-text-overlay' ).hide();
                $( '#customize-control-panoramic-slider-hide-headings' ).hide();
                $( '#customize-control-panoramic-slider-hide-paragraphs' ).hide();
                $( '#customize-control-panoramic-slider-hide-buttons' ).hide();
                $( '#customize-control-panoramic-slider-has-min-width' ).hide();
                $( '#customize-control-panoramic-slider-min-width' ).hide();
                
                // Slideshow settings
                $( '#customize-control-panoramic-slider-transition-speed' ).hide();
                $( '#customize-control-panoramic-slider-transition-effect' ).hide();
                $( '#customize-control-panoramic-slider-autoscroll' ).hide();
                $( '#customize-control-panoramic-slider-speed' ).hide();
                
                $( '.divider.default-slider' ).parent('li').hide();
                
                $( '#customize-control-panoramic-slider-plugin-shortcode' ).show();

                // Header image visibility warning
                $( '#customize-control-panoramic-slider-enabled-warning' ).show();
                
            } else {
                $( '#customize-control-panoramic-slider-categories' ).hide();
                $( '#customize-control-panoramic-smart-slider' ).hide();
                $( '#customize-control-panoramic-slider-all-pages' ).hide();
                $( '#customize-control-panoramic-slider-blog-posts' ).hide();
                $( '#customize-control-panoramic-slider-display-directional-buttons' ).hide();
                $( '#customize-control-panoramic-slider-display-pagination' ).hide();

                $( '#customize-control-panoramic-slider-has-min-width' ).hide();
                $( '#customize-control-panoramic-slider-min-width' ).hide();
                $( '#customize-control-panoramic-slider-button-style' ).hide();
                $( '#customize-control-panoramic-slider-text-overlay-background-color' ).hide();
                $( '#customize-control-panoramic-slider-text-overlay-opacity' ).hide();
                
                // Responsive settings
                $( '#customize-control-panoramic-slider-responsive-heading' ).hide();
                $( '#customize-control-panoramic-slider-hide-text-overlay' ).hide();
                $( '#customize-control-panoramic-slider-hide-headings' ).hide();
                $( '#customize-control-panoramic-slider-hide-paragraphs' ).hide();
                $( '#customize-control-panoramic-slider-hide-buttons' ).hide();
                $( '#customize-control-panoramic-slider-has-min-width' ).hide();
                $( '#customize-control-panoramic-slider-min-width' ).hide();                
                
                // Slideshow settings
                $( '#customize-control-panoramic-slider-transition-speed' ).hide();
                $( '#customize-control-panoramic-slider-transition-effect' ).hide();
                $( '#customize-control-panoramic-slider-autoscroll' ).hide();
                $( '#customize-control-panoramic-slider-speed' ).hide();
                
                $( '.divider.default-slider' ).parent('li').hide();
                
                $( '#customize-control-panoramic-slider-plugin-shortcode' ).hide();

                // Header image visibility warning
                $( '#customize-control-panoramic-slider-enabled-warning:not(:has(.dont-hide))' ).hide();
            }
        }
        
        // Show / hide slider min width
        $( '#customize-control-panoramic-slider-has-min-width input' ).on( 'change', function() {
        	panoramic_toggle_slider_min_width();
        } );
        
        function panoramic_toggle_slider_min_width() {
        	if ( $( '#customize-control-panoramic-slider-has-min-width input' ).prop('checked') && $( '#customize-control-panoramic-slider-has-min-width input' ).is(':visible') ) {
        		$( '#customize-control-panoramic-slider-min-width' ).show();
        	} else {
        		$( '#customize-control-panoramic-slider-min-width' ).hide();
        	}
        }
        
    	// Show / Hide Slider autoscroll settings
        $( '#customize-control-panoramic-slider-autoscroll input' ).on( 'change', function() {
        	panoramic_toggle_slider_autoscroll_settings();
        } );
        
        function panoramic_toggle_slider_autoscroll_settings() {
        	if ( $( '#customize-control-panoramic-slider-autoscroll input' ).prop('checked') ) {
        		$( '#customize-control-panoramic-slider-speed' ).show();
        	} else {
        		$( '#customize-control-panoramic-slider-speed' ).hide();
        	}
        }
        
        // Show / hide header image min width
        panoramic_toggle_header_image_min_width();
        
        $( '#customize-control-panoramic-header-image-has-min-width input' ).on( 'change', function() {
        	panoramic_toggle_header_image_min_width();
        } );
        
        function panoramic_toggle_header_image_min_width() {
        	if ( $( '#customize-control-panoramic-header-image-has-min-width input' ).prop('checked') && $( '#customize-control-panoramic-header-image-has-min-width input' ).is(':visible') ) {
        		$( '#customize-control-panoramic-header-image-min-width' ).show();
        	} else {
        		$( '#customize-control-panoramic-header-image-min-width' ).hide();
        	}
        }
        
    	// Show / hide woocommerce sidebar alignment
        /*
        panoramic_toggle_shop_sidebar_alignment();
    	
        $( '#customize-control-panoramic-layout-woocommerce-shop-full-width input' ).on( 'change', function() {
        	panoramic_toggle_shop_sidebar_alignment();
        } );
        
        function panoramic_toggle_shop_sidebar_alignment() {
        	if ( $( '#customize-control-panoramic-layout-woocommerce-shop-full-width input' ).prop('checked') ) {
        		$( '#customize-control-panoramic-woocommerce-shop-sidebar-alignment' ).hide();
        	} else {
        		$( '#customize-control-panoramic-woocommerce-shop-sidebar-alignment' ).show();
        	}
        }
		*/
        
    	// Show / hide woocommerce sidebar alignment
        panoramic_toggle_shop_sidebar_alignment();
    	
        $( '#customize-control-panoramic-layout-woocommerce-shop-full-width input' ).on( 'change', function() {
        	panoramic_toggle_shop_sidebar_alignment();
        } );
        
        function panoramic_toggle_shop_sidebar_alignment() {
        	if ( $( '#customize-control-panoramic-layout-woocommerce-shop-full-width input' ).prop('checked') ) {
        		$( '#customize-control-panoramic-woocommerce-shop-sidebar-alignment' ).hide();
        	} else {
        		$( '#customize-control-panoramic-woocommerce-shop-sidebar-alignment' ).show();
        	}
        }        
        
        // Show / hide blog post options
        var blogPostLayout = $( '#customize-control-panoramic-blog-layout select' ).val();
        panoramic_toggle_blog_featured_image_options( blogPostLayout );
        panoramic_toggle_blog_masonry_grid_options( blogPostLayout );
        
        $( '#customize-control-panoramic-blog-layout select' ).on( 'change', function() {
        	blogPostLayout = $( this ).val();
        	panoramic_toggle_blog_featured_image_options( blogPostLayout );
        	panoramic_toggle_blog_masonry_grid_options( blogPostLayout );
        } );
        
        function panoramic_toggle_blog_featured_image_options( blogPostLayout ) {
            if ( blogPostLayout == 'blog-post-side-layout' ) {
            	$( '#customize-control-panoramic-featured-image-height' ).hide();
                $( '#customize-control-panoramic-featured-image-alignment-side-layout' ).show();
                $( '#customize-control-panoramic-featured-image-alignment-top-layout' ).hide();
                $( '#customize-control-panoramic-featured-image-style' ).show();
                $( '#customize-control-panoramic-featured-image-disable-style-for-mobile' ).show();
                
                panoramic_toggle_shaped_featured_image_options();
                
                $( '#customize-control-panoramic-featured-image-full-width' ).hide();
                
            } else if ( blogPostLayout == 'blog-post-top-layout' ) {
            	$( '#customize-control-panoramic-featured-image-height' ).show();
                $( '#customize-control-panoramic-featured-image-alignment-side-layout' ).hide();
                $( '#customize-control-panoramic-featured-image-alignment-top-layout' ).show();
                
                panoramic_toggle_full_width_top_layout_featured_image_settings();
                
                $( '#customize-control-panoramic-featured-image-style' ).hide();
                $( '#customize-control-panoramic-featured-image-disable-style-for-mobile' ).hide();
                $( '#customize-control-panoramic-featured-image-constrain' ).hide();
                
                panoramic_toggle_full_height_featured_image_options();
                
            } else if ( blogPostLayout == 'blog-post-masonry-grid-layout' ) {
            	$( '#customize-control-panoramic-featured-image-height' ).hide();
                $( '#customize-control-panoramic-featured-image-alignment-side-layout' ).hide();
                $( '#customize-control-panoramic-featured-image-alignment-top-layout' ).hide();
                $( '#customize-control-panoramic-featured-image-style' ).show();
                $( '#customize-control-panoramic-featured-image-disable-style-for-mobile' ).show();
                
                panoramic_toggle_shaped_featured_image_options();
                
                $( '#customize-control-panoramic-featured-image-full-width' ).hide();
                
            }
        }
        
        function panoramic_toggle_blog_masonry_grid_options( blogPostLayout ) {
            if ( blogPostLayout == 'blog-post-masonry-grid-layout' ) {
                $( '#customize-control-panoramic-blog-masonry-grid-columns' ).show();
                $( '#customize-control-panoramic-blog-masonry-grid-horizontal-order' ).show();
                $( '#customize-control-panoramic-blog-masonry-grid-border' ).show();
                $( '#customize-control-panoramic-blog-masonry-grid-gutter' ).show();
                
            } else {
                $( '#customize-control-panoramic-blog-masonry-grid-columns' ).hide();
                $( '#customize-control-panoramic-blog-masonry-grid-horizontal-order' ).hide();
                $( '#customize-control-panoramic-blog-masonry-grid-border' ).hide();
                $( '#customize-control-panoramic-blog-masonry-grid-gutter' ).hide();
            }
        }
        
    	// Show / hide shaped featured image options
        panoramic_toggle_shaped_featured_image_options();
        
        $( '#customize-control-panoramic-featured-image-style select' ).on( 'change', function() {
        	panoramic_toggle_shaped_featured_image_options();
        } );
        
        function panoramic_toggle_shaped_featured_image_options() {
            var featuredImageShape = $( '#customize-control-panoramic-featured-image-style select' ).val();
        	
            if ( ( featuredImageShape == 'square' || featuredImageShape == 'round' ) && ( blogPostLayout == 'blog-post-side-layout' || blogPostLayout == 'blog-post-masonry-grid-layout' ) ) {
            	$( '#customize-control-panoramic-featured-image-constrain' ).show();
            } else {
            	$( '#customize-control-panoramic-featured-image-constrain' ).hide();
            }
        }
        
    	// Show / hide full height featured image options
        panoramic_toggle_full_height_featured_image_options();
        
        $( '#customize-control-panoramic-featured-image-height select' ).on( 'change', function() {
	    	panoramic_toggle_full_height_featured_image_options();
        } );
        
        function panoramic_toggle_full_height_featured_image_options() {
            var featuredImageHeight = $( '#customize-control-panoramic-featured-image-height select' ).val();
        	
            if ( featuredImageHeight == 'full' && blogPostLayout == 'blog-post-top-layout' ) {
            	$( '#customize-control-panoramic-featured-image-full-width' ).show();
            	//$( '#customize-control-panoramic-featured-image-alignment-top-layout' ).show();
            	
            	panoramic_toggle_full_width_top_layout_featured_image_settings();
            	
            } else if ( featuredImageHeight != 'full' && blogPostLayout == 'blog-post-top-layout' ) {
            	$( '#customize-control-panoramic-featured-image-full-width' ).hide();
            	$( '#customize-control-panoramic-featured-image-alignment-top-layout' ).hide();
            } else {
            	$( '#customize-control-panoramic-featured-image-full-width' ).hide();
            }
        }
        
    	// Show / hide featured image rollover effect options
        panoramic_toggle_featured_image_rollover_effect_options();
        
        $( '#customize-control-panoramic-featured-image-rollover-effect select' ).on( 'change', function() {
        	panoramic_toggle_featured_image_rollover_effect_options();
        } );
        
        function panoramic_toggle_featured_image_rollover_effect_options() {
            var rolloverEffect = $( '#customize-control-panoramic-featured-image-rollover-effect select' ).val();
        	
            if ( rolloverEffect == 'opacity-rollover' ) {
            	$( '#customize-control-panoramic-featured-image-rollover-effect-opacity' ).show();
            } else {
            	$( '#customize-control-panoramic-featured-image-rollover-effect-opacity' ).hide();
            }
        }
        
        // Show / hide full width top layout featured image options
        $( '#customize-control-panoramic-featured-image-full-width input' ).on( 'change', function() {
        	panoramic_toggle_full_width_top_layout_featured_image_settings();
        } );
        
        function panoramic_toggle_full_width_top_layout_featured_image_settings() {
        	if ( $( '#customize-control-panoramic-featured-image-full-width input' ).prop('checked') ) {
        		$( '#customize-control-panoramic-featured-image-alignment-top-layout' ).hide();
        	} else {
        		$( '#customize-control-panoramic-featured-image-alignment-top-layout' ).show();
        	}
        }
        
        
    	// Show / hide blog archive options
        var blogArchiveLayout = $( '#customize-control-panoramic-blog-archive-layout select' ).val();
        panoramic_toggle_blog_archive_options( blogArchiveLayout );
        
        $( '#customize-control-panoramic-blog-archive-layout select' ).on( 'change', function() {
        	blogArchiveLayout = $( this ).val();
        	panoramic_toggle_blog_archive_options( blogArchiveLayout );
        } );
        
        function panoramic_toggle_blog_archive_options( blogArchiveLayout ) {
            if ( blogArchiveLayout == 'panoramic-blog-archive-layout-full' ) {
                $( '#customize-control-panoramic-blog-excerpt-length' ).hide();
                $( '#customize-control-panoramic-blog-read-more' ).hide();
        		$( '#customize-control-panoramic-blog-read-more-text' ).hide();
        		$( '#customize-control-panoramic-blog-read-more-position' ).hide();
                
            } else if ( blogArchiveLayout == 'panoramic-blog-archive-layout-excerpt' ) {
                $( '#customize-control-panoramic-blog-excerpt-length' ).show();
                $( '#customize-control-panoramic-blog-read-more' ).show();
                
                panoramic_toggle_blog_read_more_settings();
                
            }
            
        }   
        
    	// Show / Hide Blog Read More settings
        $( '#customize-control-panoramic-blog-read-more input' ).on( 'change', function() {
        	panoramic_toggle_blog_read_more_settings();
        } );
        
        function panoramic_toggle_blog_read_more_settings() {
        	if ( $( '#customize-control-panoramic-blog-read-more input' ).prop('checked') ) {
        		$( '#customize-control-panoramic-blog-read-more-text' ).show();
        		$( '#customize-control-panoramic-blog-read-more-position' ).show();
        	} else {
        		$( '#customize-control-panoramic-blog-read-more-text' ).hide();
        		$( '#customize-control-panoramic-blog-read-more-position' ).hide();
        	}
        }
        
    } );
    
} )( jQuery );