jQuery(document).ready(function() {

	/* Upsells in customizer (Documentation, Reviews and Support links */
	if( !jQuery( ".opportune-info" ).length ) {
		
		jQuery('#customize-theme-controls > ul').prepend('<li class="accordion-section opportune-info">');
	
		jQuery('.opportune-info').append('<a style="width: 80%; margin: 5px auto 5px auto; display: block; text-align: center;" href="http://www.shapedpixels.com/setup-opportune/" class="button" target="_blank">{setup}</a>'.replace('{setup}', opportuneCustomizerObject.setup));
		
		jQuery('.opportune-info').append('<a style="width: 80%; margin: 5px auto 5px auto; display: block; text-align: center;" href="https://wordpress.org/support/view/theme-reviews/opportune" class="button" target="_blank">{review}</a>'.replace('{review}', opportuneCustomizerObject.review));
		
		jQuery('.opportune-info').append('<a style="width: 80%; margin: 5px auto 5px auto; display: block; text-align: center;" href="https://wordpress.org/support/theme/opportune" class="button" target="_blank">{support}</a>'.replace('{support}', opportuneCustomizerObject.support));
		
		jQuery('.opportune-info').append('<a style="width: 80%; margin: 5px auto 5px auto; display: block; text-align: center;" href="http://www.shapedpixels.com/opportune-pro" class="button" target="_blank">{pro}</a>'.replace('{pro}',opportuneCustomizerObject.pro));

		jQuery('#customize-theme-controls > ul').prepend('</li>');
	}
	
});