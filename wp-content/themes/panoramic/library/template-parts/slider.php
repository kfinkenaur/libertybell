<?php
global $slider_type, $slider_shortcode;

if ( $slider_type == 'plugin' ) :
?>
	<div class="panoramic-slider-container">
		<?php
		if ( get_theme_mod( 'panoramic-slider-plugin-shortcode', customizer_library_get_default( 'panoramic-slider-plugin-shortcode' ) ) != '' ) {
			echo do_shortcode( sanitize_text_field( get_theme_mod( 'panoramic-slider-plugin-shortcode' ) ) );
		}
		?>
    </div>
<?php
elseif ( $slider_type == 'default' ) :
	$button_classes  = '';
	$overlay_classes = '';
	$opacity_classes = array();
	
	if ( get_theme_mod( 'panoramic-slider-hide-text-overlay', customizer_library_get_default( 'panoramic-slider-hide-text-overlay' ) ) ) {
		$opacity_classes[] = 'hide-text-overlay';
	}
	
	if ( get_theme_mod( 'panoramic-slider-hide-headings', customizer_library_get_default( 'panoramic-slider-hide-headings' ) ) ) {
		$opacity_classes[] = 'hide-headings';
	}

	if ( get_theme_mod( 'panoramic-slider-hide-paragraphs', customizer_library_get_default( 'panoramic-slider-hide-paragraphs' ) ) ) {
		$opacity_classes[] = 'hide-paragraphs';
	}
	
	if ( get_theme_mod( 'panoramic-slider-hide-buttons', customizer_library_get_default( 'panoramic-slider-hide-buttons' ) ) ) {
		$opacity_classes[] = 'hide-buttons';
	}	

	$translucent_navigation = get_theme_mod( 'panoramic-layout-navigation-opacity', customizer_library_get_default( 'panoramic-layout-navigation-opacity' ) ) < 1;	
	
	// Set button classes
	if ( get_theme_mod( 'panoramic-slider-button-style', customizer_library_get_default( 'panoramic-slider-button-style' ) ) == 'panoramic-slider-button-style-round' ) {
		$button_classes = 'round ';
	}
	if ( $translucent_navigation ) {
		$button_classes .= 'top-padded';
	}
	
	// Set overlay classes
	if ( $translucent_navigation ) {
		$overlay_classes = 'top-padded';
	}

	$slider_categories = get_theme_mod( 'panoramic-slider-categories' );
	
	if ( $slider_categories ) {
        
		$slider_query = new WP_Query( 'cat=' . implode(',', $slider_categories) . '&posts_per_page=-1&orderby=date&order=DESC&id=slider' );
	        
		if ( $slider_query->have_posts() ) :
?>	
			<div class="panoramic-slider-container default loading <?php echo ( esc_attr ( get_theme_mod( 'panoramic-smart-slider', customizer_library_get_default( 'panoramic-smart-slider' ) ) ) ) ? 'smart' : ''; ?>">
				<?php
				if ( get_theme_mod( 'panoramic-slider-display-directional-buttons', customizer_library_get_default( 'panoramic-slider-display-directional-buttons' ) ) ) {
				?>
				<div class="controls-container">
					<div class="controls">
						<div class="prev <?php echo $button_classes; ?>">
							<i class="fa fa-angle-left"></i>
						</div>
						<div class="next <?php echo $button_classes; ?>">
							<i class="fa fa-angle-right"></i>
						</div>
					</div>
				</div>
				<?php
				}
				?>

				<ul class="slider">
			                    
					<?php
					while ( $slider_query->have_posts() ) : $slider_query->the_post();
					?>
			                    
					<li class="slide">
						<?php
						$custom_fields = get_post_custom();
						$slider_link_content = 0;
						$slider_link_url = '';

					 	if ( isset( $custom_fields["slider_link_content"][0] ) ) {
					 		$slider_link_content = $custom_fields["slider_link_content"][0];
					 	}
						
 						$slider_link_custom = '';
					 	if ( isset( $custom_fields["slider_link_custom"][0] ) ) {
					 		$slider_link_custom = $custom_fields["slider_link_custom"][0];
					 	}

 						$slider_link_target = '_blank';
					 	if ( isset( $custom_fields["slider_link_target"][0] ) ) {
					 		$slider_link_target = $custom_fields["slider_link_target"][0];
					 	}
					 	
						if ( $slider_link_content != 'custom' && intval( $slider_link_content ) > 0 ) {
							$slider_link_content = intval( $slider_link_content );
							$slider_link_url = get_permalink( $slider_link_content );
						} else if ( $slider_link_content == 'custom' ) {
							$slider_link_url = esc_url( $slider_link_custom );
						}
						
						if ( !empty( $slider_link_url ) ) {
							echo '<a href="' .$slider_link_url. '" ';
							
							if ( $slider_link_target == 'new' ) {
								echo 'target="_blank" ';
							}
							
							echo 'class="slide-link">';
						}
						
						if ( has_post_thumbnail() ) :
							the_post_thumbnail( 'full', array( 'class' => '' ) );
						endif;
						?>
			            
			            <?php 
			            $content = trim( get_the_content() );
			            
			            if ( !empty( $content ) ) {
			            ?>
						<div class="overlay-container">			            
							<div class="overlay <?php echo $overlay_classes; ?>">
								<div class="opacity <?php echo implode( ' ', $opacity_classes ); ?>">
									<?php echo $content; ?>
								</div>
							</div>
						</div>
						<?php 
						}

						if ( !empty( $slider_link_url ) ) {
							echo '</a>';
						}
						?>
					</li>
			                    
					<?php
					endwhile;
					?>
			                    
				</ul>
				
				<?php
				if ( get_theme_mod( 'panoramic-slider-display-pagination', customizer_library_get_default( 'panoramic-slider-display-pagination' ) ) ) {
				?>
				<div class="pagination"></div>
				<?php 
				}
				?>
			</div>
	
<?php
		elseif ( $translucent_navigation ) :
?>
			<div class="slider-placeholder"></div>
<?php
		endif;
		wp_reset_query();
	
	} else {
?>

		<div class="panoramic-slider-container default loading <?php echo ( esc_attr ( get_theme_mod( 'panoramic-smart-slider', customizer_library_get_default( 'panoramic-smart-slider' ) ) ) ) ? 'smart' : ''; ?>">
			<?php
			if ( get_theme_mod( 'panoramic-slider-display-directional-buttons', customizer_library_get_default( 'panoramic-slider-display-directional-buttons' ) ) ) {
			?>
			<div class="controls-container">
				<div class="controls">
					<div class="prev <?php echo $button_classes; ?>">
						<i class="fa fa-angle-left"></i>
					</div>
					<div class="next <?php echo $button_classes; ?>">
						<i class="fa fa-angle-right"></i>
					</div>
				</div>
			</div>
			<?php
			}
			?>

            <ul class="slider">
				<li class="slide">
                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/demo/slider-default01.jpg" width="1500" height="445" alt="<?php esc_attr_e('Demo Slide One', 'panoramic'); ?>" />
					<div class="overlay-container">
	                    <div class="overlay <?php echo $overlay_classes; ?>">
	                    	<div class="opacity <?php echo implode( ' ', $opacity_classes ); ?>">
	                        	<?php _e( '<h2>Beautiful. Simple. Fresh.</h2><p>Panoramic is a stunning new theme that provides an easy way for companies or web developers to spring into action online!</p>', 'panoramic' ); ?>
	                        </div>
	                    </div>
					</div>
                </li>
                
                <li class="slide">
                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/demo/slider-default02.jpg" width="1500" height="445" alt="<?php esc_attr_e('Demo Slide Two', 'panoramic'); ?>" />
					<div class="overlay-container">
	                    <div class="overlay <?php echo $overlay_classes; ?>">
	                    	<div class="opacity <?php echo implode( ' ', $opacity_classes ); ?>">
	                        	<?php _e( '<h2>Fully Responsive</h2><p>Panoramic is fully responsive which means it adapts seamlessly to all screen sizes, from a desktop computer to a mobile device.</p>', 'panoramic' ); ?>
	                        </div>
	                    </div>
					</div>
                </li>
                
                <li class="slide">
                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/demo/slider-default03.jpg" width="1500" height="445" alt="<?php esc_attr_e('Demo Slide One', 'panoramic'); ?>" />
					<div class="overlay-container">
	                    <div class="overlay <?php echo $overlay_classes; ?>">
	                    	<div class="opacity <?php echo implode( ' ', $opacity_classes ); ?>">
	                        	<?php _e( '<h2>Easy to customise</h2><p>So easy to use, even novice users can have an online presence up and running in next to no time! If you run into trouble, our legendary support is FREE!</p>', 'panoramic' ); ?>
	                        </div>
	                    </div>
					</div>
				</li>
            </ul>
            
			<?php
			if ( get_theme_mod( 'panoramic-slider-display-pagination', customizer_library_get_default( 'panoramic-slider-display-pagination' ) ) ) {
			?>
            <div class="pagination"></div>
            <?php
            }
            ?>
        </div>

<?php
	}
else :
?>
	<div class="panoramic-slider-container">
		<?php
		echo do_shortcode( sanitize_text_field( $slider_shortcode ) );
		?>
	</div>
<?php
endif;
?>
