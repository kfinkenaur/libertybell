<?php
global $slider_type, $slider_shortcode;

if ( $slider_type == 'plugin' ) :
?>
	<div class="slider-container">
		<?php
		if ( get_theme_mod( 'panoramic-slider-plugin-shortcode', customizer_library_get_default( 'panoramic-slider-plugin-shortcode' ) ) != '' ) {
			echo do_shortcode( get_theme_mod( 'panoramic-slider-plugin-shortcode' ) );
		}
		?>
    </div>
<?php
elseif ( $slider_type == 'default' ) :
	$button_classes  = '';
	$overlay_classes = '';

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
			<div class="slider-container default loading">
				<div class="prev <?php echo $button_classes; ?>">
					<i class="fa fa-angle-left"></i>
				</div>
				<div class="next <?php echo $button_classes; ?>">
					<i class="fa fa-angle-right"></i>
				</div>
			
				<ul class="slider">
			                    
					<?php
					while ( $slider_query->have_posts() ) : $slider_query->the_post();
					?>
			                    
					<li class="slide">
						<?php
						if ( has_post_thumbnail() ) :
							the_post_thumbnail( 'full', array( 'class' => '' ) );
						endif;
						?>
			            
			            <?php 
			            $content = trim( get_the_content() );
			            
			            if ( !empty( $content ) ) {
			            ?>
						<div class="overlay <?php echo $overlay_classes; ?>">
							<div class="opacity">
								<?php echo $content; ?>
							</div>
						</div>
						<?php 
						}
						?>
					</li>
			                    
					<?php
					endwhile;
					?>
			                    
				</ul>
				
				<div class="pagination"></div>
				
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
        
		<div class="slider-container default loading">
			<div class="prev <?php echo $button_classes; ?>">
				<i class="fa fa-angle-left"></i>
			</div>
			<div class="next <?php echo $button_classes; ?>">
				<i class="fa fa-angle-right"></i>
			</div>
                        
            <ul class="slider">
                
                <li class="slide">
                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/demo/slider-default01.jpg" width="1500" height="445" alt="<?php esc_attr_e('Demo Slide One', 'panoramic'); ?>" />
                    <div class="overlay <?php echo $overlay_classes; ?>">
                    	<div class="opacity">
                        	<?php _e( '<h2>Beautiful. Simple. Fresh.</h2><p>Panoramic is a stunning new theme that provides an easy way for companies or web developers to spring into action online!</p>', 'panoramic' ); ?>
                        </div>
                    </div>
                </li>
                
                <li class="slide">
                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/demo/slider-default02.jpg" width="1500" height="445" alt="<?php esc_attr_e('Demo Slide Two', 'panoramic'); ?>" />
                    <div class="overlay <?php echo $overlay_classes; ?>">
                    	<div class="opacity">
                        	<?php _e( '<h2>Fully Responsive</h2><p>Panoramic is fully responsive which means it adapts seamlessly to all screen sizes, from a desktop computer to a mobile device.</p>', 'panoramic' ); ?>
                        </div>
                    </div>
                </li>
                
                <li class="slide">
                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/demo/slider-default03.jpg" width="1500" height="445" alt="<?php esc_attr_e('Demo Slide One', 'panoramic'); ?>" />
                    <div class="overlay <?php echo $overlay_classes; ?>">
                    	<div class="opacity">
                        	<?php _e( '<h2>Easy to customise</h2><p>So easy to use, even novice users can have an online presence up and running in next to no time! If you run into trouble, our legendary support is FREE!</p>', 'panoramic' ); ?>
                        </div>
                    </div>
                </li>
                
            </ul>
            
            <div class="pagination"></div>
        </div>

<?php
	}
else :
?>
	<div class="slider-container">
		<?php	
		echo do_shortcode($slider_shortcode);
		?>
	</div>
<?php
endif;
?>
