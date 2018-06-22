/**
 * Panoramic Theme Custom Functionality
 *
 */
( function( $ ) {

	//var smartSlider = !!parseInt(variables.smartSlider);
	var sliderParagraphMargin = parseFloat( variables.sliderParagraphMargin );
	var sliderButtonMargin = parseFloat( variables.sliderButtonMargin );
	var headerImageParagraphMargin = parseFloat( variables.headerImageParagraphMargin );
	var headerImageButtonMargin = parseFloat( variables.headerImageButtonMargin );

    if (panoramicLayoutMode == 'panoramic-layout-mode-one-page') {
    	var pageMarkerName = panoramic_get_url_vars()['page'];
    	var animateInitialPageScroll = true;
    }
    
    $( document ).ready( function() {
    	panoramic_image_has_loaded();
    	
	    $('img.hideUntilLoaded').one("load", function() {
	    }).each(function() {
	    	if (this.complete) {
	    		$(this).load();
	    	}
	    });
    	
        // Add button to sub-menu parent to show nested pages on the mobile menu
        $( '.main-navigation li.page_item_has_children, .main-navigation li.menu-item-has-children' ).prepend( '<span class="menu-dropdown-btn"><i class="fa fa-angle-right"></i></span>' );
        
        // Sub-menu toggle button
        $( '.main-navigation a[href="#"], .menu-dropdown-btn' ).bind( 'click', function(e) {
        	e.preventDefault();
            $(this).parent().toggleClass( 'open-page-item' );
            $(this).find('.fa:first').toggleClass('fa-angle-right').toggleClass('fa-angle-down');
            
        });
	    
    	panoramic_set_slider_height();
    	panoramic_set_slider_elements_spacing();
    	panoramic_pad_text_overlay_container();    	
    	
        // Fittext gives trouble if run immediately so delay it by 0.1 seconds with setTimeout
        if ( $('.panoramic-slider-container.default.smart').length > 0 || $('.header-image.smart').length > 0 ) {
			setTimeout(function() {
				//initFittext(); // Perhaps this be moved to the onload code for the slider / header image
				//initFitbutton();
			}, 500);
        }
    	
    	// Wrap the SiteOrigin Layout Slider widget navigation controls in a container div for styling purposes
    	$('.sow-slide-nav.sow-slide-nav-next, .sow-slide-nav.sow-slide-nav-prev').wrapAll('<div class="otb-sow-slide-nav-wrapper"></div');
    	
        if (panoramicLayoutMode == 'panoramic-layout-mode-one-page') {
        	
        	if ( pageMarkerName ) {
        		panoramic_unhighlight_menu();
        		$('.main-navigation li').removeClass('no-highlight');
        		
        		var menuItem = panoramic_get_menu_item_by_slug( pageMarkerName );
        		menuItem.addClass('current-menu-item current_page_item');
        	} else {
        		if ( $("body.home.panoramic-one-page-mode").length > 0 ) {
        			panoramic_unhighlight_menu();
        		}
        		
        		$('.main-navigation li').removeClass('no-highlight');
        		
        		if ( panoramicLayoutHighlightFirstMenuItem ) {
        			$('.main-navigation li:eq(0)').addClass('current-menu-item current_page_item');
        		}
        	}
        	
	        $( '.main-navigation a' ).bind( 'click', function(e) {
	        	if ( $(this).parents('li').hasClass('scroll-link') ) {
		        	var url  = $(this).attr( 'href' );
		        	var slug = '';
		        	
		        	if( url.charAt( url.length-1 ) != '/' ) {
		        		url += "/";
		        	}
		        	if( site_url.charAt( site_url.length-1 ) != '/' ) {
		        		site_url += "/";
		        	}
		        	
		        	if ( url == site_url ) {
		        		slug = page_on_front;
		        			
		        	} else {
		        		url = url.substring( 0, url.length-1 );
			        	
			        	slug = url.substring( url.lastIndexOf('/')+1 );
		        	}
		        	
		        	if ( $("body.home").length > 0 ) {
		        		if ( panoramic_verify_page_marker(slug) ) {
			        		e.preventDefault();
			        		
			        		panoramic_set_selected_menu_item( $(this).parents('li') );
			        		panoramic_scroll_to_page_marker(slug);
		        		}
		        	} else {
		        		e.preventDefault();
		        		
	        			redirect_url = site_url + "?page=" + slug;
		        		
		        		window.location.href = redirect_url;
		        	}
	        	}
	        });
	        
	        setTimeout( function(){ 
	    		if ( pageMarkerName && animateInitialPageScroll ) {
	    			var menuItem = panoramic_get_menu_item_by_slug( pageMarkerName );
	    			menuItem.find('a').click();
	    		}
	        }  , 1200 )    
	        
        }
        
        // Mobile menu toggle button
        $( '.header-menu-button' ).click( function(e){
            $( 'body' ).toggleClass( 'show-main-menu' );
        });
        $( '.main-menu-close' ).click( function(e){
            $( '.header-menu-button' ).click();
        });
    	
        // Show / Hide Search
        $(".search-btn").toggle(function(){
            $("header .search-block").stop().animate( { top: '+=50' }, 150 );
            $("header .search-block .search-field").focus();
        },function(){
            $("header .search-block").stop().animate( { top: '-=50' }, 150 );
        });
        
        // Don't search if no keywords have been entered
        $(".search-submit").bind('click', function(event) {
        	if ( $(this).parents(".search-form").find(".search-field").val() == "") event.preventDefault();
        });
        
        // Back to Top Button Functionality
    	$('#back-to-top').bind('click', function() {
    		if ( $("body.home.panoramic-one-page-mode").length > 0 && panoramicLayoutHighlightFirstMenuItem ) {
    			panoramic_set_selected_menu_item( $('.main-navigation li:eq(0)') );
    		} else if ( $("body.home.panoramic-one-page-mode").length > 0 && !panoramicLayoutHighlightFirstMenuItem ) {
    			panoramic_unhighlight_menu();
    		}
    		
    		$('body').addClass('animating');
    		$('html, body').stop().animate({
    			scrollTop:0
    		},
    		'slow',
    		function () {
    			$('body').removeClass('animating');
    		});
    		return false;
    	});
    	
    	$('body.home.panoramic-one-page-mode .site-header .branding .title, body.home.panoramic-one-page-mode .site-header .branding .custom-logo-link').bind('click', function(e) {
    		e.preventDefault();
    		
    		if ( $("body.home.panoramic-one-page-mode").length > 0 && panoramicLayoutHighlightFirstMenuItem ) {
    			panoramic_set_selected_menu_item( $('.main-navigation li:eq(0)') );
    		} else if ( $("body.home.panoramic-one-page-mode").length > 0 && !panoramicLayoutHighlightFirstMenuItem ) {
    			panoramic_unhighlight_menu();
    		}
    		
    		$('body').addClass('animating');
    		$('html, body').stop().animate({
    			scrollTop:0
    		},
    		'slow',
    		function () {
    			$('body').removeClass('animating');
    		});
    		return false;
    	});
        
        try {
        	
        	if ( $('.site-header').hasClass('sticky') ) {
        		stickyHeaderWaypoint = new Waypoint.Sticky({
        			element: $('.site-header'),
		            offset: 0,
		            enabled: true,
		            handler: function() {
		            	panoramic_set_sticky_wrapper_height();
		            }
		        });
        	}        	

        	if ( $('.main-navigation').hasClass('sticky') ) {
        		stickyNavigationWaypoint = new Waypoint.Sticky({
        			element: $('.main-navigation'),
		            offset: 0,
		            enabled: true,
		            handler: function() {
		            	panoramic_set_sticky_wrapper_height();
		            }
		        });
        	}        	
        	
	        panoramic_set_sticky_wrapper_height();
	        
        } catch(e) {
        	
        }
        
        try {
        	$('.site-content').fitVids();
        } catch(e) {
        	
        }
        	
    });
    
    $(window).resize(function () {
    	if ( $('.panoramic-slider-container.default.smart').length > 0 || $('.header-image.smart').length > 0 ) {
			initFittext();
			initFitbutton();
    	}
    	panoramic_set_sticky_wrapper_height();
    	panoramic_pad_text_overlay_container();
    	panoramic_set_search_block_position();
    	panoramic_set_slider_elements_spacing();
    }).resize();
    
    $(window).on('load', function() {
    	panoramic_home_slider();
    	panoramic_set_back_to_top_button_visibility();
    	panoramic_set_search_block_position();
    	panoramic_init_masonry_grid();
    });
    
    $(window).scroll(function(e) {
    	if ( e.target == window ) return;
    	
    	panoramic_set_back_to_top_button_visibility();
		
		animateInitialPageScroll = false;
		
		var scrollTop = parseInt( $(window).scrollTop() ) + 28;

    	if ( $('.site-header').hasClass('sticky') && panoramic_get_viewport().width > panoramicStickyHeaderDeactivationBreakpoint ) {
    		scrollTop += ( $('.site-header').height() );
    		
    		if ( $('.main-navigation').css('position') != 'relative' && $('.main-navigation').hasClass('translucent') ) {
    			scrollTop += ( $('.main-navigation').outerHeight() );
    		}
    	}
    	if ( $('.main-navigation').hasClass('sticky') && panoramic_get_viewport().width > panoramicStickyHeaderDeactivationBreakpoint ) {
    		//if ( $('.main-navigation').css('position') != 'relative' && $('.main-navigation').hasClass('translucent') ) {
    			scrollTop += ( $('.main-navigation').outerHeight() );
    		//}
    	}
    	
		if ( !$('body').hasClass('animating') ) {
			var pageMarkerCount = $('a.page-marker').filter(function() {
				return scrollTop > $(this).offset().top;
			}).length;
			
			if (pageMarkerCount > 0) {
				var pageMarker = $("a.page-marker:eq(" + parseInt(pageMarkerCount-1) + ")");
				
				panoramic_set_selected_menu_item( panoramic_get_menu_item_by_slug( pageMarker.attr('name') ) );
			} else if ( $("body.home.panoramic-one-page-mode").length > 0 ) {
				if (panoramicLayoutHighlightFirstMenuItem) {
					panoramic_set_selected_menu_item( $('.main-navigation li:eq(0)') );
				} else {
					panoramic_unhighlight_menu();
				}
			}
		}
    });
    
    
    /*
    TODO: Implement scaling of the logo on scroll
    if ( $( '.site-header' ).hasClass( 'scale-logo' ) ) {
		var scaleLogo = function () {
			var $header = $( '.site-header' );
			var pageTop = $( '.page' ).offset().top;
			var top = window.pageYOffset || document.documentElement.scrollTop;
			top -= pageTop;
			
			var headerPadding = {
				top: parseInt( $header.find('.branding').css( 'padding-top' ) ),
				bottom: parseInt( $header.find('.branding').css( 'padding-bottom' ) )
			};			

			var $logo = $header.find( '.branding img' ),
				$branding = $header.find( '.branding > *' );

			if ( top > 0 ) {
				// Scale down
				var scale = 0.775 + (
					Math.max( 0, 40 - top ) / 40 * (
						1 - 0.775
					)
				);

				if ( $logo.length ) {
					$logo.css( {
						width: $logo.attr( 'width' ) * scale,
						height: $logo.attr( 'height' ) * scale
					} );
				}
				else {
					//$branding.css( 'transform', 'scale(' + scale + ')' );
				}

				$header.find('.branding').css( {
					'padding-top': headerPadding.top * scale,
					'padding-bottom': headerPadding.bottom * scale
				} ).addClass( 'floating' );
			}
			else {
				// Scale up
				var scale = 0.775 + (
					Math.max( 0, 40 + top ) / 40 * (
						1 - 0.775
					)
				);
				
				if ( $logo.length ) {
					$logo.css( {
						width: $logo.attr( 'width' ),
						height: $logo.attr( 'height' )
					} );
				}
				else {
					//$branding.css( 'transform', 'scale(1)' );
				}

				$header.find('.branding').css( {
					'padding-top': headerPadding.top * scale,
					'padding-bottom': headerPadding.bottom * scale
				} ).removeClass( 'floating' );
			}
		};
		
		scaleLogo();
		
		$( window ).scroll( scaleLogo );
    }
    */
    
    function panoramic_get_url_vars() {
        var vars = [];
        var hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++) {
        	hash = hashes[i].split('=');
        	vars.push(hash[0]);
        	vars[hash[0]] = hash[1];
        }
        return vars;
    }
    
    function panoramic_init_masonry_grid() {
    	
    	if ( $( '.masonry-grid-container' ).length > 0 ) {
    		// Initialize the Masonry plugin
			var grid = $( '.masonry-grid-container' ).masonry({
		        columnWidth: 'article',
		        itemSelector: 'article',
		        horizontalOrder: panoramicMasonryGridHorizontalOrder,
		        percentPosition: true
		    });
    		
			// Once all images within the grid have loaded lay out the grid
			//$( '.masonry-grid-container' ).imagesLoaded( function() {
				$(window).resize();
				grid.masonry('layout');
	    	//});
	    	
			// Once the layout is complete hide the loader 
	        grid.one( 'layoutComplete', function() {
				$( '.masonry-grid-container' ).removeClass( 'loading' );
				
				// Triggering the window resize event and calling the Masonry layout function again fixes a spacing issue on the grid
				$(window).resize();
				grid.masonry('layout');
	        } );
    		
    	}
    	
    }
    
    function panoramic_set_back_to_top_button_visibility() {
    	if ($(window).scrollTop() > $(window).height() / 2 ) {
    		$("#back-to-top").removeClass('gone');
    		$("#back-to-top").addClass('visible');
    	} else {
    		$("#back-to-top").removeClass('visible');
    		$("#back-to-top").addClass('gone');
    	}
    }
    
    if ( $(".header-image img").length > 0 ) {
	    var img = $('<img/>');
	    img.attr("src", $(".header-image img").attr("src") ); 
		
	    img.on('load', function() {
			initFittext();
			initFitbutton();
	    	
	    	$('.header-image').removeClass('loading');
	    	$('.header-image').css('height', 'auto');
		});
    }
    
    // Initalise fittext
    function initFittext() {
	    $('.panoramic-slider-container.default.smart .slider .slide .overlay-container .overlay h1, .panoramic-slider-container.default.smart .slider .slide .overlay-container .overlay h2').fitText(2, { minFontSize: '17px', maxFontSize: '37px', lineHeightPadding: '3px' });
	    $('.panoramic-slider-container.default.smart .slider .slide .overlay-container .overlay .opacity').fitText(3.7, { minFontSize: '14px', maxFontSize: '18px', lineHeightPadding: '3px' });
	    $('.header-image.smart .overlay-container .overlay h1, .header-image.smart .overlay-container .overlay h2').fitText(2, { minFontSize: '17px', maxFontSize: '37px', lineHeightPadding: '3px' });
	    $('.header-image.smart .overlay-container .overlay .opacity').fitText(3.7, { minFontSize: '14px', maxFontSize: '18px', lineHeightPadding: '3px' });
    }

    // Initalise fitbutton
    function initFitbutton() {
		$('.panoramic-slider-container.default.smart .slider .slide .overlay-container .overlay').fitButton(4.5, { minFontSize: '10px', maxFontSize: '14px', minHorizontalPadding: '10px', maxHorizontalPadding: '25px', minVerticalPadding: '8px', maxVerticalPadding: '10px' });
		$('.header-image.smart .overlay-container .overlay').fitButton(4.5, { minFontSize: '10px', maxFontSize: '14px', minHorizontalPadding: '10px', maxHorizontalPadding: '25px', minVerticalPadding: '8px', maxVerticalPadding: '10px' });
    }
    
    function panoramic_set_search_block_position() {
    	if ( $('.site-header.full-width-logo .search-block').length > 0 ) {
			if ( $( document ).width() > 780 ) {
				$('.site-header.full-width-logo .search-block').css('right', ( ( $( document ).width() - $('.site-top-bar .site-container').width() ) / 2 ) );
			} else {
				$('.site-header.full-width-logo .search-block').css('right', 20 );	
			}
    	}
    }
    
    function panoramic_set_sticky_wrapper_height() {
		var wrapper = $('.sticky-wrapper');
		var wrapperHeight = $('.site-header.sticky').height();
		wrapper.height(wrapperHeight);
    }
    
    function panoramic_set_slider_height() {
        // Set the height of the slider to the height of the first slide's image
    	var firstSlide  = $(".panoramic-slider-container.default .slider .slide:eq(0)");
    	var headerImage = $(".header-image img");
    	if ( firstSlide.length > 0 ) {
    		var firstSlideImage = firstSlide.find('img').first();
    		
    		if ( firstSlideImage.length > 0) {
    			
    			if ( firstSlideImage.attr('height') > 0 ) {
    				
    				// The height needs to be dynamically calculated with responsive in mind ie. the height of the image will obviously grow
    				var firstSlideImageWidth  = firstSlideImage.attr('width');
    				var firstSlideImageHeight = firstSlideImage.attr('height');
    				var sliderWidth = $('.panoramic-slider-container').width();
    				var widthPercentage;
    				var widthRatio;
    				
    				widthRatio = sliderWidth / firstSlideImageWidth;
    				
    				$('.panoramic-slider-container.loading').css('height', Math.round( widthRatio * firstSlideImageHeight ) );
    			}
    		}
    	} else if ( headerImage.length > 0 ) {
    		
    		if ( headerImage.attr('height') > 0 ) {

				// The height needs to be dynamically calculated with responsive in mind ie. the height of the image will obviously grow
				var headerImageWidth  = headerImage.attr('width');
				var headerImageHeight = headerImage.attr('height');
				var headerImageContainerWidth = $('.header-image').width();
				var widthPercentage;
				var widthRatio;
				
				widthRatio = headerImageContainerWidth / headerImageWidth;
				
				$('.header-image.loading').css('height', Math.round( widthRatio * headerImageHeight ) );
    		}
    	}
    }
    
    function panoramic_set_slider_elements_spacing() {
		// Remove the bottom border of a button nested inside a paragraph if it's the last element on a slide
		$('.panoramic-slider-container.default.smart .slider .slide .overlay .opacity p:last-child > a.button, .panoramic-slider-container.default.smart .slider .slide .overlay .opacity p:last-child > button').addClass('no-bottom-margin');

    	if ( panoramic_get_viewport().width <= 960 ) {
	    	$('.panoramic-slider-container.default.smart .opacity a.button:hidden, .panoramic-slider-container.default.smart .opacity button:hidden').parent('p').css('display', 'none');
	    	
	    	$('.panoramic-slider-container.default.smart .slide').each( function() {
	    		$(this).find('.opacity *:visible:first').css('margin-top', 0);
	    		$(this).find('.opacity *:visible:last').css('margin-bottom', 0);
	    	});
    	} else {
    		$('.panoramic-slider-container.default.smart .opacity p').css({ 'margin-top' : sliderParagraphMargin + 'em', 'margin-bottom' : sliderParagraphMargin + 'em' });
    		$('.panoramic-slider-container.default.smart .opacity a.button, .panoramic-slider-container.default.smart .opacity button').css({ 'margin-top' : sliderButtonMargin + 'em', 'margin-bottom' : sliderButtonMargin + 'em' });
    		
    		$('.panoramic-slider-container.default.smart .opacity a.button:hidden, .panoramic-slider-container.default.smart .opacity button:hidden').parent('p').css('display', 'block');
    	}
    }    
    
    function panoramic_pad_text_overlay_container() {
    	var textOverlayOffset;
    	var sliderControlsOffset = 0;
		var main_navigation_parent_item;
		
		if ( $('.main-navigation .menu > li').length > 0 ) {
			main_navigation_parent_item = $('.main-navigation .menu > li');
		} else {
			main_navigation_parent_item = $('.main-navigation .menu > ul > li');
		}

		if ( $('.main-navigation.translucent').length > 0 || $('.main-navigation.transparent').length > 0 ) {
    		textOverlayOffset = $('.main-navigation').outerHeight(true);
    		sliderControlsOffset = $('.main-navigation').outerHeight(true);
    	}
    	
    	if ( textOverlayOffset ) {
			// If the default slider is being used and there's a text overlay then set the top padding 
			if ( $('.panoramic-slider-container.default.smart .slider .slide .overlay-container').length > 0 ) {
				$('.panoramic-slider-container.default .slider .slide .overlay-container').css('paddingTop', textOverlayOffset);
				$('.panoramic-slider-container.default .controls-container').css('marginTop', sliderControlsOffset);
				
			// If there's a header image text overlay then set the top padding
			} else if ( $('.header-image.smart .overlay-container').length > 0 ) {
				// You need to include the height of the top bar as the overlay container has an absolute position and doesn't obey the padding set in panoramic_set_top_bar_offset
				$('.header-image .overlay-container').css('paddingTop', textOverlayOffset);
			}
    	}
	}    
    
    function panoramic_get_menu_item_by_slug( slug ) {
    	var pageMarker = panoramic_get_page_marker( slug );
    	
    	var menuItem = $(".main-navigation li a[href$='" + slug + "/']");
    	
    	if ( pageMarker.length > 0 && menuItem.length == 0 ) {
        	if( site_url.charAt( site_url.length-1 ) != '/' ) {
        		site_url += "/";
        	}
    		
    		menuItem = $(".main-navigation li a[href='" + site_url + "']");
    	}
    	
    	menuItem = menuItem.parents('li');
    	
    	return menuItem;
    }
    
    function panoramic_verify_page_marker( name ) {
    	var pageMarker = $("a[name='" + name + "'].page-marker");
    	
    	if ( pageMarker.length > 0 ) {
    		return true;
    	} else {
    		return false;
    	}
    }
    
    function panoramic_get_page_marker( name ) {
    	var pageMarker = $("a[name='" + name + "'].page-marker");
    	
		return pageMarker;
    }
    
    function panoramic_set_selected_menu_item( menuItem ) {
    	$('.main-navigation li').removeClass('current-menu-item current_page_item');
    	menuItem.addClass('current-menu-item current_page_item');
    }
    
    function panoramic_unhighlight_menu() {
    	$('.main-navigation li').removeClass('current-menu-item current_page_item');
    }
    
    function panoramic_scroll_to_page_marker( name ) {
    	var pageMarker = $("a[name='" + name + "'].page-marker");
    	var pageMarkerOffsetPadding = 0;
		
    	$('body').addClass('animating');
    	
    	if ( $( 'a.page-marker' ).index( pageMarker ) > 0 ) {
    	} else {
    		pageMarkerOffsetPadding = $('.site-content').css('marginTop').replace('px', '');
    	}
    	
    	var scrollPos = pageMarker.offset().top - parseInt( pageMarkerOffsetPadding );

    	if ( $('.site-header').hasClass('sticky') && panoramic_get_viewport().width > panoramicStickyHeaderDeactivationBreakpoint ) {
    		scrollPos -= ( $('.site-header').height() );
    		
    		if ( $('.main-navigation').css('position') != 'relative' && $('.main-navigation').hasClass('translucent') ) {
    			scrollPos -= ( $('.main-navigation').outerHeight() );
    		}
    	}
    	if ( $('.main-navigation').hasClass('sticky') && panoramic_get_viewport().width > panoramicStickyHeaderDeactivationBreakpoint ) {
    		//if ( $('.main-navigation').css('position') != 'relative' && $('.main-navigation').hasClass('translucent') ) {
    			scrollPos -= ( $('.main-navigation').outerHeight() );
    		//}
    	}
    	
        $('html:not(:animated), body:not(:animated)').stop().animate({ scrollTop: scrollPos }, 'slow');
        
    	$( 'html, body' ).promise().done(function() {
    		$('body').removeClass('animating');
    	});    	
    }
    
    function panoramic_get_viewport() {
        var e = window;
        var a = 'inner';
        
        if ( !('innerWidth' in window ) ) {
            a = 'client';
            e = document.documentElement || document.body;
        }
    	
        return {
        	width: e[ a + 'Width' ],
        	height: e[ a + 'Height' ]
        };
    }
    
    function panoramic_image_has_loaded() {
    	var container;

	    $('img.hideUntilLoaded').on('load',function(){
	    	container = $(this).parents('.featured-image-container');
	    	
	    	if ( ( container.hasClass('round') || container.hasClass('square') || container.hasClass('tall') || container.hasClass('medium') || container.hasClass('short') ) ) {
	    		container.css('background-image', 'url("' + $(this).attr('src') + '")' );
		    	
	    		if ( !container.hasClass('disable-style-for-mobile') ) {
	    			$(this).remove();
	    		}
	    	}
	    	
	    	container.removeClass('loading');
	    	
	    	(function(container){ 
	    	    setTimeout(function() { 
	    	    	container.addClass('transition');
	    	    }, 50);
	    	})(container);	    	
	    });
	}
    
    function panoramic_home_slider() {
    	if ( $('.panoramic-slider-container.default .slider').length ) {
    		
	        $(".panoramic-slider-container.default .slider").carouFredSel({
	            responsive: true,
	            circular: true,
	            infinite: false,
	            width: 1200,
	            height: 'variable',
	            items: {
	                visible: 1,
	                width: 1200,
	                height: 'variable'
	            },
	            onCreate: function(items) {
	    			initFittext();
	    			initFitbutton();
	            	
	            	$('.panoramic-slider-container.default').css('height', 'auto');
	                $('.panoramic-slider-container.default').removeClass('loading');
	            },
	            scroll: {
	                fx: panoramicSliderTransitionEffect,
	                duration: panoramicSliderTransitionSpeed
	            },
	            auto: panoramicSliderSpeed,
	            pagination: '.pagination',
	            prev: ".prev",
	            next: ".next",
	            swipe: {
	            	onTouch: true
	            }
	        });
	        
	        //$('.slider').swipe({
	        //	excludedElements: "button, input, select, textarea, .noSwipe"
	        //});

    	}
    }
    
} )( jQuery );