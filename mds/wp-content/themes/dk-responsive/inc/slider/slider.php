<?php
 /** 
 * Display Slider
 *
 *
 * @file           slider.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
 */  
if ( ! defined( 'WPINC' ) ) {
		die;
}    
	function dk_slider_scripts() {		
				wp_enqueue_style( 'full-slider-style', get_template_directory_uri() . '/inc/slider/css/full-slider.css' );
	}
	add_action( 'wp_enqueue_scripts', 'dk_slider_scripts' );
	
    // Initialize Slider
	function dk_slider_initialize() { 
	
	$slider_interval = esc_html( dk_get_option('slider_interval'));
	$slider_pause = esc_html( dk_get_option('slider_pause'));
	
	?>
	<script type="text/javascript">
		    jQuery(function(){
				jQuery('.carousel').carousel({
				interval: <?php echo (!empty($slider_interval))? "'".$slider_interval."'" : '5000'; ?>,//changes the speed
				pause: <?php echo (!empty($slider_pause))? "'".$slider_pause."'" : "'hover'"; ?> //changes the speed
				});
			
			});
	</script>
	<?php }
	add_action( 'wp_head', 'dk_slider_initialize' );	
	// Create Slider	
	function dk_slider_template() {		
		// Query Arguments
		$args = array(
					'post_type' => 'post',
					'posts_per_page'	=> 5,
					'post__not_in' => get_option( 'sticky_posts' ),
				'meta_query' => array(
					array(
						'key'     => 'dk_slieron',
						'value'   => 'Y',
						'compare' => '=',
					),
				)
			);	
			
		// The Query
		$the_query = new WP_Query( $args );
		
		
		// Check if the Query returns any posts
		if ( $the_query->have_posts() ) {
		
		// Start the Slider ?>
	 <div id="dkCarousel" class="carousel slide">
	   
        <!-- Indicators -->
        <ol class="carousel-indicators">
		  
		  <?php 
		    $i=0;
		   while ( $the_query->have_posts() ) : $the_query->the_post();		   
           $class_active = ($i==0)? "active" : "";
		   ?>
		   
		     <li data-target="#dkCarousel" class="<?php echo $class_active; ?>" data-slide-to="<?php echo $i; ?>" ></li>
		  <?php $i++; endwhile; ?>
         </ol>
        <!-- Wrapper for Slides -->
			<div class="carousel-inner">
				<?php		
				// The Loop
				 $i=0;
				while ( $the_query->have_posts() ) : $the_query->the_post(); 
				$class_active = ($i==0)? "active" : "";				
				?>					
				<div class="item <?php echo $class_active; ?>">
					<!-- Set the first background image using inline CSS below. -->
					<?php // Check if there's a Slide URL given and if so let's a link to it
					if ( get_post_meta( get_the_id(), 'dk_slideurl', true) != '' ) { ?>
						<a href="<?php echo esc_url(get_permalink(get_the_id())); ?>">
					<?php }
                    $url = wp_get_attachment_url( get_post_thumbnail_id(get_the_id()) );
					?>
					<div class="fill" style="background-image:url('<?php echo esc_url($url); ?>');"></div>
					<?php if ( get_post_meta( get_the_id(), 'dk_slideurl', true) != '' ) { ?>
						</a>
					<?php } ?>
					<div class="carousel-caption">
					<?php $slideTitle=get_post_meta( get_the_id(), 'dk_slideTitle', true ); ?>
					<?php $slideCaption=get_post_meta( get_the_id(), 'dk_slidecaption', true ); ?>
						<h2> <?php echo ((!empty($slideTitle))? $slideTitle : get_the_title()); ?></h2>
						<p><?php echo ((!empty($slideCaption))? $slideCaption : the_excerpt()); ?></p>						
						<a href="<?php echo esc_url(get_permalink(get_the_id())); ?>">Read More &raquo;</a>
						
					</div>
				</div>	
				
				<?php  $i++;  endwhile; ?>
		
		</div>

        <!-- Controls -->
        <a class="left carousel-control" href="#dkCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#dkCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>

    </div>		
		<?php }
		// Reset Post Data
		wp_reset_postdata();
}