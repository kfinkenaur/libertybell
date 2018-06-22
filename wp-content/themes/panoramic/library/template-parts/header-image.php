<?php
global $queried_object, $header_image_type;

$opacity_classes = array();

if ( get_theme_mod( 'panoramic-header-image-hide-text-overlay', customizer_library_get_default( 'panoramic-header-image-hide-text-overlay' ) ) ) {
	$opacity_classes[] = 'hide-text-overlay';
}

if ( get_theme_mod( 'panoramic-header-image-hide-headings', customizer_library_get_default( 'panoramic-header-image-hide-headings' ) ) ) {
	$opacity_classes[] = 'hide-headings';
}

if ( get_theme_mod( 'panoramic-header-image-hide-paragraphs', customizer_library_get_default( 'panoramic-header-image-hide-paragraphs' ) ) ) {
	$opacity_classes[] = 'hide-paragraphs';
}

if ( get_theme_mod( 'panoramic-header-image-hide-buttons', customizer_library_get_default( 'panoramic-header-image-hide-buttons' ) ) ) {
	$opacity_classes[] = 'hide-buttons';
}
?>

<div class="header-image loading <?php echo ( esc_attr ( get_theme_mod( 'panoramic-smart-header-image', customizer_library_get_default( 'panoramic-smart-header-image' ) ) ) ) ? 'smart' : ''; ?>">
<?php
if ( $header_image_type == 'theme_settings' ) :
	$attachment_id = null;

	if ( is_random_header_image() && $header_url = get_header_image() ) {
		// For a random header search for a match against all headers.
		foreach ( get_uploaded_header_images() as $header ) {
			if ( $header['url'] == $header_url ) {
				$attachment_id = $header['attachment_id'];
				break;
			}
		}

	} elseif ( $data = get_custom_header() ) {
		// For static headers
		$attachment_id = $data->attachment_id;
    }

	$alt_text = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true);
	
	$header_image_link_content = get_theme_mod( 'panoramic-header-image-link-content', customizer_library_get_default( 'panoramic-header-image-link-content' ) );

	if ( $header_image_link_content != "" ) {
		echo '<a href="' .esc_url( get_permalink( $header_image_link_content ) ). '" class="content-link">';
	}
?>

	<img src="<?php esc_url( header_image() ); ?>" alt="<?php echo $alt_text; ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" />
	
	<?php
	$translucent_navigation = get_theme_mod( 'panoramic-layout-navigation-opacity', customizer_library_get_default( 'panoramic-layout-navigation-opacity' ) ) < 1;
	
	if ( trim( get_theme_mod( 'panoramic-header-image-text', customizer_library_get_default( 'panoramic-header-image-text' ) ) ) != "" ) {
	?>
	<div class="overlay-container">
		<div class="overlay <?php echo $translucent_navigation ? 'top-padded' : ''; ?>">
			<div class="opacity <?php echo implode( ' ', $opacity_classes ); ?>">
				<?php echo wp_kses_post( get_theme_mod( 'panoramic-header-image-text', customizer_library_get_default( 'panoramic-header-image-text' ) ) ); ?>
			</div>
		</div>
	</div>
	<?php 
	}
	
	if ( $header_image_link_content != "" ) {
		echo '</a>';
	}
	?>

<?php
elseif ( $header_image_type == 'featured_image' || $header_image_type == 'custom_field' ) :

	if ( $header_image_type == 'featured_image' ) {
		$thumbnail_id = get_post_thumbnail_id( $queried_object->ID );
		$header_image = wp_get_attachment_image_src( $thumbnail_id, 'full' );
		$alt_text 	  = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true);
	
		$custom_fields = get_post_custom($queried_object->ID);
		$header_image_text = trim($custom_fields["featured_image_text"][0]);
		
	} else if ( $header_image_type == 'custom_field' ) {
		if ( !is_category() && !is_tag() ) {
			$header_image_id = get_post_meta( $queried_object->ID, 'header_image_id', true );
		} else {
			$term_meta = get_option( "taxonomy_$queried_object->term_id" );
			$header_image_id = intval( $term_meta['header_image_id'] ) ? intval( $term_meta['header_image_id'] ) : 0;
		}
		
		$header_image  = wp_get_attachment_image_src( $header_image_id, 'full' );
		$alt_text 	   = get_post_meta( $header_image_id, '_wp_attachment_image_alt', true);
		$custom_fields = get_post_custom($queried_object->ID);
		
		if ( !is_category() && !is_tag() ) {
			$header_image_text = trim($custom_fields["header_image_text"][0]);
		} else {
			$header_image_text = trim($term_meta['header_image_text']) ? trim($term_meta['header_image_text']) : '';
		}
		
	}
?>
	<img src="<?php echo esc_url( $header_image[0] ); ?>" alt="<?php echo $alt_text; ?>" width="<?php echo $header_image[1]; ?>" height="<?php echo $header_image[2]; ?>" />
	
	<?php
	$translucent_navigation = get_theme_mod( 'panoramic-layout-navigation-opacity', customizer_library_get_default( 'panoramic-layout-navigation-opacity' ) ) < 1;
	
	if ( $header_image_text != "" ) {
	?>
	<div class="overlay-container">
		<div class="overlay <?php echo $translucent_navigation ? 'top-padded' : ''; ?>">
			<div class="opacity <?php echo implode( ' ', $opacity_classes ); ?>">
				<?php echo wp_kses_post( $header_image_text ); ?>
			</div>
		</div>
	</div>	
	<?php 
	}
	?>
	
<?php 
elseif ( $header_image_type == 'customizer_field' ) :
	$header_image = get_theme_mod( 'panoramic-search-results-header-image' );
	$alt_text 	  = '';
	
	$header_image_text = trim( get_theme_mod( 'panoramic-search-results-header-image-text' ) );
?>
	<img src="<?php echo esc_url( $header_image ); ?>" alt="<?php echo $alt_text; ?>" width="" height="" />

	<?php
	$translucent_navigation = get_theme_mod( 'panoramic-layout-navigation-opacity', customizer_library_get_default( 'panoramic-layout-navigation-opacity' ) ) < 1;
	
	if ( $header_image_text != "" ) {
	?>
	<div class="overlay-container">
		<div class="overlay <?php echo $translucent_navigation ? 'top-padded' : ''; ?>">
			<div class="opacity <?php echo implode( ' ', $opacity_classes ); ?>">
				<?php echo wp_kses_post( $header_image_text ); ?>
			</div>
		</div>
	</div>	
	<?php 
	}
	?>
	
<?php
endif;
?>

</div>
