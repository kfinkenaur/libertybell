<?php
global $queried_object, $header_image_type;
?>

<div class="header-image loading">
<?php
if ( $header_image_type == 'theme_settings' ) :
	$panoramic_header_image_link_content = get_theme_mod( 'panoramic-header-image-link-content', customizer_library_get_default( 'panoramic-header-image-link-content' ) );

	if ( $panoramic_header_image_link_content != "" ) {
		echo '<a href="' .esc_url( get_permalink( $panoramic_header_image_link_content ) ). '" class="content-link">';
	}
?>

	<img src="<?php esc_url( header_image() ); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" />
	
	<?php
	if ( get_theme_mod( 'panoramic-header-image-link-content', customizer_library_get_default( 'panoramic-header-image-link-content' ) ) != "" ) {
		echo '</a>';
	}
	
	$translucent_navigation = get_theme_mod( 'panoramic-layout-navigation-opacity', customizer_library_get_default( 'panoramic-layout-navigation-opacity' ) ) < 1;
	
	if ( trim( get_theme_mod( 'panoramic-header-image-text', customizer_library_get_default( 'panoramic-header-image-text' ) ) ) != "" ) {

		if ( $panoramic_header_image_link_content != "" ) {
			echo '<a href="' .esc_url( get_permalink( $panoramic_header_image_link_content ) ). '" class="content-link">';
		}
	?>
		<div class="overlay <?php echo $translucent_navigation ? 'top-padded' : ''; ?>">
			<div class="opacity">
				<?php echo wp_kses_post( get_theme_mod( 'panoramic-header-image-text', customizer_library_get_default( 'panoramic-header-image-text' ) ) ); ?>
			</div>
		</div>
	<?php 
		if ( get_theme_mod( 'panoramic-header-image-link-content', customizer_library_get_default( 'panoramic-header-image-link-content' ) ) != "" ) {
			echo '</a>';
		}
		
	}
	?>

<?php
elseif ( $header_image_type == 'featured_image' ) :
	$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $queried_object->ID ), 'full' );

	$custom_fields = get_post_custom($queried_object->ID);
	$featured_image_text = trim($custom_fields["featured_image_text"][0]);
?>
	<img src="<?php echo esc_url( $featured_image[0] ); ?>" width="<?php echo $featured_image[1]; ?>" height="<?php echo $featured_image[2]; ?>" />
	
	<?php
	$translucent_navigation = get_theme_mod( 'panoramic-layout-navigation-opacity', customizer_library_get_default( 'panoramic-layout-navigation-opacity' ) ) < 1;
	
	if ( $featured_image_text != "" ) {
	?>
	<div class="overlay <?php echo $translucent_navigation ? 'top-padded' : ''; ?>">
		<div class="opacity">
			<?php echo wp_kses_post( $featured_image_text ); ?>
		</div>
	</div>	
	<?php 
	}
	?>
<?php
endif;
?>

</div>
