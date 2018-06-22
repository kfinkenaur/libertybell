<style type="text/css">
.slider-container.default .slider .slide .overlay .opacity {
	height: <?php echo get_theme_mod( 'panoramic-slider-text-overlay-height', customizer_library_get_default( 'panoramic-slider-text-overlay-height' ) ); ?>%;
	width: <?php echo get_theme_mod( 'panoramic-slider-text-overlay-width', customizer_library_get_default( 'panoramic-slider-text-overlay-width' ) ); ?>%;
	padding-top: <?php echo get_theme_mod( 'panoramic-slider-text-overlay-padding', customizer_library_get_default( 'panoramic-slider-text-overlay-padding' ) ); ?>%;
	padding-right: <?php echo get_theme_mod( 'panoramic-slider-text-overlay-padding', customizer_library_get_default( 'panoramic-slider-text-overlay-padding' ) ); ?>%;
	padding-bottom: <?php echo get_theme_mod( 'panoramic-slider-text-overlay-padding', customizer_library_get_default( 'panoramic-slider-text-overlay-padding' ) ); ?>%;
	padding-left: <?php echo get_theme_mod( 'panoramic-slider-text-overlay-padding', customizer_library_get_default( 'panoramic-slider-text-overlay-padding' ) ); ?>%;
}

<?php
echo '@media only screen and (max-width: ' .get_theme_mod( 'panoramic-slider-text-overlay-hide-width', customizer_library_get_default( 'panoramic-slider-text-overlay-hide-width' ) ). 'px) {';
?>
	.slider-container.default .slider .slide .overlay .opacity {
		display: none;
	}	
}
</style>
