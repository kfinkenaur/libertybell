/**
 * Panoramic Theme Custom Functionality
 *
 */
( function( $ ) {

    if (panoramicLayoutMode == 'panoramic-layout-mode-one-page') {
    	var pageMarkerName = getUrlVars()['page'];
    	var animateInitialPageScroll = true;
    }
    
    $( document ).ready( function() {
        // Add button to sub-menu parent to show nested pages on the mobile menu
        $( '.main-navigation li.page_item_has_children, .main-navigation li.menu-item-has-children' ).prepend( '<span class="menu-dropdown-btn"><i class="fa fa-angle-right"></i></span>' );
        
        // Sub-menu toggle button
        $( '.main-navigation a[href="#"], .menu-dropdown-btn' ).bind( 'click', function(e) {
        	e.preventDefault();
            $(this).parent().toggleClass( 'open-page-item' );
            $(this).find('.fa:first').toggleClass('fa-angle-right').toggleClass('fa-angle-down');
            
        });
	    
        panoramic_set_header_wrapper_height();
    	panoramic_set_slider_height();
    	
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
	        $('.site-header.sticky').waypoint('sticky', {
	            offset: 0
	        });
	        $('.main-navigation.sticky').waypoint('sticky', {
	            offset: 0
	        });
	        
        } catch(e) {
        	
        }
		
    });
    
    
    
    $(window).resize(function () {
    	panoramic_set_header_wrapper_height();
    }).resize();
    
    $(window).load(function() {
    	panoramic_home_slider();
    	panoramic_blog_list_carousel();
    	setBackToTopButtonVisibility();
    });
    
    $(window).scroll(function(e) {
		setBackToTopButtonVisibility();
		
		animateInitialPageScroll = false;
		
		var scrollTop = parseInt( $(window).scrollTop() ) + 28;
		var stickyHeaderWidthThreshold = 800;

    	if ( $('.site-header').hasClass('sticky') && panoramic_get_viewport().width > stickyHeaderWidthThreshold ) {
    		scrollTop += ( $('.site-header').height() );
    		
    		if ( $('.main-navigation').css('position') != 'relative' && $('.main-navigation').hasClass('translucent') ) {
    			scrollTop += ( $('.main-navigation').outerHeight() );
    		}
    	}
    	if ( $('.main-navigation').hasClass('sticky') && panoramic_get_viewport().width > stickyHeaderWidthThreshold ) {
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
    
    function getUrlVars() {
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
    
    function setBackToTopButtonVisibility() {
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
	    	$('.header-image').removeClass('loading');
	    	$('.header-image').css('height', 'auto');
		});
    }
    
    function panoramic_set_header_wrapper_height() {
		var wrapper = $('.sticky-wrapper');
		var wrapperHeight = $('.site-header.sticky').outerHeight(true);
		wrapper.height(wrapperHeight);
    }
    
    function panoramic_set_slider_height() {
        // Set the height of the slider to the height of the first slide's image
    	var firstSlide  = $(".slider-container.default .slider .slide:eq(0)");
    	var headerImage = $(".header-image img");
    	if ( firstSlide.length > 0 ) {
    		var firstSlideImage = firstSlide.find('img').first();
    		
    		if ( firstSlideImage.length > 0) {
    			
    			if ( firstSlideImage.attr('height') > 0 ) {
    				
    				// The height needs to be dynamically calculated with responsive in mind ie. the height of the image will obviously grow
    				var firstSlideImageWidth  = firstSlideImage.attr('width');
    				var firstSlideImageHeight = firstSlideImage.attr('height');
    				var sliderWidth = $('.slider-container').width();
    				var widthPercentage;
    				var widthRatio;
    				
    				widthRatio = sliderWidth / firstSlideImageWidth;
    				
    				$('.slider-container.loading').css('height', Math.round( widthRatio * firstSlideImageHeight ) );
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
		var stickyHeaderWidthThreshold = 800;

    	if ( $('.site-header').hasClass('sticky') && panoramic_get_viewport().width > stickyHeaderWidthThreshold ) {
    		scrollPos -= ( $('.site-header').height() );
    		
    		if ( $('.main-navigation').css('position') != 'relative' && $('.main-navigation').hasClass('translucent') ) {
    			scrollPos -= ( $('.main-navigation').outerHeight() );
    		}
    	}
    	if ( $('.main-navigation').hasClass('sticky') && panoramic_get_viewport().width > stickyHeaderWidthThreshold ) {
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
    
    function panoramic_blog_list_carousel() {
        $('.post-loop-images-carousel-wrapper').each(function(c) {
            var this_blog_carousel = $(this);
            var this_blog_carousel_id = 'post-loop-images-carousel-id-'+c;
            this_blog_carousel.attr('id', this_blog_carousel_id);
            $('#'+this_blog_carousel_id+' .post-loop-images-carousel').carouFredSel({
                responsive: true,
                circular: false,
                width: 580,
                height: "variable",
                items: {
                    visible: 1,
                    width: 580,
                    height: 'variable'
                },
                onCreate: function(items) {
                    $('#'+this_blog_carousel_id).removeClass('post-loop-images-carousel-wrapper-remove');
                    $('#'+this_blog_carousel_id+' .post-loop-images-carousel').removeClass('post-loop-images-carousel-remove');
                },
                scroll: 500,
                auto: false,
                prev: '#'+this_blog_carousel_id+' .post-loop-images-prev',
                next: '#'+this_blog_carousel_id+' .post-loop-images-next'
            });
        });
    }
    
    function panoramic_home_slider() {
        $(".slider").carouFredSel({
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
            	$('.slider-container').css('height', 'auto');
                $('.slider-container').removeClass('loading');
            },
            scroll: {
                fx: panoramicSliderTransitionEffect,
                duration: panoramicSliderTransitionSpeed
            },
            auto: panoramicSliderSpeed,
            pagination: '.pagination',
            prev: ".prev",
            next: ".next"
        });
    }
    
} )( jQuery );