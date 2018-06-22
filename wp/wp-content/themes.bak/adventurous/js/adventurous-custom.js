// Adventurous Custom Scripts
jQuery(document).ready(function() {	

		var jQueryheader_search = jQuery( '#header-search' );
		jQueryheader_search.click( function() {
			var jQuerythis_el = jQuery(this),
				jQueryform = jQuerythis_el.siblings( '.header-search-wrap' );

			if ( jQueryform.hasClass( 'displaynone' ) ) {
				jQueryform.css( { 'display' : 'block', 'opacity' : 0 } ).animate( { opacity : 1 }, 300 );
			} else {
				jQueryform.animate( { opacity : 0 }, 300 );
			}

			jQueryform.toggleClass( 'displaynone' );
		} );
		
		jQuery( "#main-wrapper" )
		.waypoint( function( direction ) {
			if( direction == 'down' ) {
			   jQuery('#masthead').addClass( 'fixed-header' );
			}
		})
		.waypoint( function( direction ) { // has offset on the way up
			if( direction == 'up' ) {
				jQuery('#masthead').removeClass( 'fixed-header' );
			}
		}, {offset: -1});
		
		adventurous_mobile_menu( jQuery('#header-menu ul.menu'), jQuery('#header-mobile-menu .mobile-nav'), 'header-mobile-menu-block', 'mobile-menu' );
		adventurous_mobile_menu( jQuery('#access-secondary ul.menu'), jQuery('#secondary-mobile-menu .mobile-nav'), 'secondary-mobile-menu-block', 'mobile-menu' );
		function adventurous_mobile_menu( menu, append_to, menu_id, menu_class ){
			var jQuerycloned_nav;

			menu.clone().attr('id',menu_id).removeClass().attr('class',menu_class).appendTo( append_to );
			jQuerycloned_nav = append_to.find('> ul');
			jQuerycloned_nav.find('.menu_slide').remove();
			jQuerycloned_nav.find('li:first').addClass('menu-mobile-first-item');

			append_to.click( function(){
				if ( jQuery(this).hasClass('closed') ){
					jQuery(this).removeClass( 'closed' ).addClass( 'opened' );
					jQuerycloned_nav.slideDown( 500 );
				} else {
					jQuery(this).removeClass( 'opened' ).addClass( 'closed' );
					jQuerycloned_nav.slideUp( 500 );
				}
				return false;
			} );

			append_to.find('a').click( function(event){
				event.stopPropagation();
			} );
		}		

		//Scroll Up
		jQuery("#scrollup").hide();
		jQuery(function () {
			jQuery(window).scroll(function () {
				if (jQuery(this).scrollTop() > 1000) {
					jQuery('#scrollup').fadeIn();
				} else {
					jQuery('#scrollup').fadeOut();
				}
			});
			jQuery('#scrollup').click(function () {
				jQuery('body,html').animate({
					scrollTop: 0
				}, 800);
				return false;
			});
		});
	
});		