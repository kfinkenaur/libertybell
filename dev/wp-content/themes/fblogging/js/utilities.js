jQuery( document ).ready(function() {

	// add submenu icons class in main menu (only for large resolution)
	if (fblogging_IsLargeResolution()) {
	
		jQuery('#navmain > div > ul > li:has("ul")').addClass('level-one-sub-menu');
		jQuery('#navmain > div > ul li ul li:has("ul")').addClass('level-two-sub-menu');										
	}

	jQuery('#header-spacer').height(jQuery('#header-main-fixed').height());

	jQuery('#navmain > div').on('click', function(e) {

		e.stopPropagation();

		// toggle main menu
		if (fblogging_IsSmallResolution() || fblogging_IsMediumResolution()) {

			var parentOffset = jQuery(this).parent().offset(); 
			
			var relY = e.pageY - parentOffset.top;
		
			if (relY < 36) {
			
				jQuery('ul:first-child', this).toggle(400);
			}
		}
	});

	jQuery("#navmain > div > ul li").mouseleave( function() {
		if (fblogging_IsLargeResolution()) {
			jQuery(this).children("ul").stop(true, true).css('display', 'block').slideUp(300);
		}
	});
	
	jQuery("#navmain > div > ul li").mouseenter( function() {
		if (fblogging_IsLargeResolution()) {

			var curMenuLi = jQuery(this);
			jQuery("#navmain > div > ul > ul:not(:contains('#" + curMenuLi.attr('id') + "')) ul").hide();
		
			jQuery(this).children("ul").stop(true, true).css('display','none').slideDown(400);
		}
	});
});

function fblogging_IsSmallResolution() {

	return (jQuery(window).width() <= 360);
}

function fblogging_IsMediumResolution() {
	
	var browserWidth = jQuery(window).width();

	return (browserWidth > 360 && browserWidth < 800);
}

function fblogging_IsLargeResolution() {

	return (jQuery(window).width() >= 800);
}

jQuery(document).ready(function () {

  jQuery(window).scroll(function () {
	  if (jQuery(this).scrollTop() > 100) {
		  jQuery('.scrollup').fadeIn();
	  } else {
		  jQuery('.scrollup').fadeOut();
	  }
  });

  jQuery('.scrollup').click(function () {
	  jQuery("html, body").animate({
		  scrollTop: 0
	  }, 600);
	  return false;
  });

});

jQuery(function(){
		
	var Page = (function() {

			var $navArrows = jQuery( '#nav-arrows' ).hide(),
				$navDots = jQuery( '#nav-dots' ).hide(),
				$nav = $navDots.children( 'span' ),
				$shadow = jQuery( '#shadow' ).hide(),
				slicebox = jQuery( '#sb-slider' ).slicebox( {
					onReady : function() {

						$navArrows.show();
						$navDots.show();
						$shadow.show();

					},
					onBeforeChange : function( pos ) {

						$nav.removeClass( 'nav-dot-current' );
						$nav.eq( pos ).addClass( 'nav-dot-current' );

					}
				} ),
				
				init = function() {

					initEvents();
					
				},
				initEvents = function() {

					// add navigation events
					$navArrows.children( ':first' ).on( 'click', function() {

						slicebox.next();
						return false;

					} );

					$navArrows.children( ':last' ).on( 'click', function() {
						
						slicebox.previous();
						return false;

					} );

					$nav.each( function( i ) {
					
						jQuery( this ).on( 'click', function( event ) {
							
							var $dot = jQuery( this );
							
							if( !slicebox.isActive() ) {

								$nav.removeClass( 'nav-dot-current' );
								$dot.addClass( 'nav-dot-current' );
							
							}
							
							slicebox.jump( i + 1 );
							return false;
						
						} );
						
					} );

				};

				return { init : init };

		})();

		Page.init();
});
