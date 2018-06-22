<?php
global $featured_image_style;

$featured_image_classes = array();

$featured_image_style = get_theme_mod( 'panoramic-featured-image-style', customizer_library_get_default( 'panoramic-featured-image-style' ) );

if ( 
	$panoramic_blog_layout != 'blog-post-top-layout' && ( $featured_image_style == 'round' || $featured_image_style == 'square' )
) {
	if ( get_theme_mod( 'panoramic-featured-image-constrain', customizer_library_get_default( 'panoramic-featured-image-constrain' ) ) ) {
		$featured_image_classes[] = 'constrain';
	}

	if ( get_theme_mod( 'panoramic-featured-image-disable-style-for-mobile', customizer_library_get_default( 'panoramic-featured-image-disable-style-for-mobile' ) ) ) {
		$featured_image_classes[] = 'disable-style-for-mobile';
	}
}

if ( $panoramic_blog_layout != 'blog-post-top-layout' ) {
	$featured_image_classes[] = $featured_image_style;
}

if ( get_theme_mod( 'panoramic-blog-layout', customizer_library_get_default( 'panoramic-blog-layout' ) ) == 'blog-post-side-layout' ) {
	$featured_image_alignment = get_theme_mod( 'panoramic-featured-image-alignment-side-layout', customizer_library_get_default( 'panoramic-featured-image-alignment-side-layout' ) );
} else if ( get_theme_mod( 'panoramic-blog-layout', customizer_library_get_default( 'panoramic-blog-layout' ) ) == 'blog-post-top-layout' ) {
	$featured_image_height = get_theme_mod( 'panoramic-featured-image-height', customizer_library_get_default( 'panoramic-featured-image-height' ) );

	if ( $featured_image_height == 'full' && get_theme_mod( 'panoramic-featured-image-full-width', customizer_library_get_default( 'panoramic-featured-image-full-width' ) ) ) {
		$featured_image_classes[] = 'full-width';
	}
	
	$featured_image_classes[] = $featured_image_height;
	$featured_image_alignment = get_theme_mod( 'panoramic-featured-image-alignment-top-layout', customizer_library_get_default( 'panoramic-featured-image-alignment-top-layout' ) );
}

if ( $panoramic_blog_layout != 'blog-post-masonry-grid-layout' && !( $panoramic_blog_layout == 'blog-post-top-layout' && $featured_image_height != 'full' ) ) {
	if ( $featured_image_alignment == 'left-aligned' ) {
		$post_classes[] = 'left-aligned';
	} else if ( $featured_image_alignment == 'right-aligned' ) {
		$post_classes[] = 'right-aligned';
	} else if ( $featured_image_alignment == 'alternate-aligned' && ($wp_query->current_post+1) % 2 == 0 ) {
		$post_classes[] = 'right-aligned';
	} else if ( $featured_image_alignment == 'centered' ) {
		$post_classes[] = 'centered';
	}
}

$featured_image_classes[] = get_theme_mod( 'panoramic-featured-image-rollover-effect', customizer_library_get_default( 'panoramic-featured-image-rollover-effect' ) );	
?>