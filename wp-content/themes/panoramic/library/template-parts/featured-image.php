<?php
global $featured_image_classes, $featured_image_style, $panoramic_blog_layout;
?>

    <div class="featured-image-wrapper <?php echo esc_attr( implode( ' ', $featured_image_classes ) ); ?>">
		<div class="featured-image-container loading <?php echo esc_attr( implode( ' ', $featured_image_classes ) ); ?>">
		
			<?php
			$thumbnail_id = get_post_thumbnail_id($post->ID);
			$thumbnail_image = wp_get_attachment_image_src( $thumbnail_id, get_theme_mod( 'panoramic-blog-featured-image-size', customizer_library_get_default( 'panoramic-blog-featured-image-size' ) ) );
		
			if ( get_theme_mod( 'panoramic-blog-featured-image-clickable', customizer_library_get_default( 'panoramic-blog-featured-image-clickable' ) ) ) {
			?>
			<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php
			}
			?>
			
			<?php
			if ( ( $featured_image_style == 'round' || $featured_image_style == 'square' ) && $panoramic_blog_layout != 'blog-post-top-layout' ) {
			?>
			<img src="<?php echo get_template_directory_uri(); ?>/library/images/transparent.gif" class="placeholder" />
			<?php
			}
			?>
			
			<img src="<?php echo $thumbnail_image[0]; ?>" width="<?php echo $thumbnail_image[1]; ?>" height="<?php echo $thumbnail_image[2]; ?>" class="featured-image hideUntilLoaded" alt="<?php echo esc_attr( $post->post_title ); ?>" />
			
			<?php
			if ( get_theme_mod( 'panoramic-blog-featured-image-clickable', customizer_library_get_default( 'panoramic-blog-featured-image-clickable' ) ) ) {
			?>
			<div class="opacity"></div>
			
			</a>
			<?php
			} else {
			?>
			<div class="opacity"></div>
			<?php 
			}
			?>

		</div>
	</div>
