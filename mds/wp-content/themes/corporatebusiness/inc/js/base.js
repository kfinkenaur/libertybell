(function($){
	jQuery(document).ready(function($){
		// Responsive Menu //
		$( "#primary-menu" ).clone().prependTo( "#responsive-menu" );
		// Current Item
		var current = $("#site-navigation .current-menu-item > a").text();
		if (current) $(".responsive-menu-bar span").text( current );
		// Responsive Menu Expand/Collapse
		$(".open-responsive-menu").click(function () {
			$content = $('#responsive-menu');
			$content.slideToggle(500, function () {
				// do
			});
		});
		//
		$( '<a id="header-search-link" href="#"><i class="fa fa-search"></i></a>' ).insertAfter( "header .search-submit" );
		$( 'header form.search-form' ).attr('id', 'header-search-form');
		$('#header-search-link').click(function() {
			var formID = $(this).closest("form").attr('id');
			$('#'+formID).submit();
		});
		// testimonial slider
		$('.testimonials-slider').bxSlider({
                 mode: 'vertical',
                 slideMargin: 3,
                 auto:true,
				 });
			// vertical align
			$('.testimonials-slider .content').each (function () {
				$(this).css("margin-top",($(this).parent().height() - $(this).height())/2 + 'px' );
			});
		// customers slider
		$('.customers-slider').bxSlider({
                 minSlides: 6,
				 maxSlides: 6,
				 moveSlides: 1,
				 slideWidth: 175,
				 slideMargin: 20,
                 auto: true,
				 pager: false,
				 });
				 
$('.customer-logo').BlackAndWhite({
    hoverEffect : true, // default true
    // set the path to BnWWorker.js for a superfast implementation
    webworkerPath : false,
    // to invert the hover effect
    invertHoverEffect: false,
    // this option works only on the modern browsers ( on IE lower than 9 it remains always 1)
    intensity:1,
    speed: { //this property could also be just speed: value for both fadeIn and fadeOut
        fadeIn: 200, // 200ms for fadeIn animations
        fadeOut: 800 // 800ms for fadeOut animations
    },
    onImageReady:function(img) {
        // this callback gets executed anytime an image is converted
    }
});
		// back to top
		jQuery('#back_top').click(function(){
			jQuery('html, body').animate({scrollTop:0}, 'normal');return false;
		});	
		jQuery(window).scroll(function(){
			if(jQuery(this).scrollTop() !== 0){jQuery('#back_top').fadeIn();}else{jQuery('#back_top').fadeOut();}
		});
		if(jQuery(window).scrollTop() !== 0){jQuery('#back_top').show();}else{jQuery('#back_top').hide();}

	});
})(jQuery);