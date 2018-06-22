<?php
$video_url = get_header_video_url();
$parts 	   = parse_url($video_url);
?>

<div class="header-video loading">
	<div class="video-container <?php echo ( $parts['host'] == 'youtube.com' || $parts['host'] == 'www.youtube.com'  || $parts['host'] == 'youtu.be' ) ? 'youtube' : ''; ?>">
		<div id="wp-custom-header" class="wp-custom-header"></div>
		<?php
	    if ( is_header_video_active() && ( has_header_video() || is_customize_preview() ) ) {
			wp_enqueue_script( 'wp-custom-header' );
			wp_localize_script( 'wp-custom-header', '_wpCustomHeaderSettings', get_header_video_settings() );
	    }
		?>
	</div>
</div>
