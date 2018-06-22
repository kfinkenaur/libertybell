<?php 
/**
 * @package Rhyme
 */

// Query featured entries

$slider_cat = of_get_option('slider_cat');

if ($slider_cat == '' ) {
	$slider_cat = get_the_category();
	$slider_cat = $slider_cat[0]->term_id;
} else {
	$slider_cat = of_get_option('slider_cat');
}

$num_of_slides = 4;
$count = 0;
		
$featured_posts = new WP_Query(
	array(
		'posts_per_page' => $num_of_slides,
		'cat' 	=> $slider_cat
	)
);

if ( of_get_option('featured_posts_on') == '1') {
	if (is_front_page() && !is_paged()) {
		?>
		<div class="featured-posts-wrapper">
		<?php while ( $featured_posts->have_posts() ): $featured_posts->the_post(); 
			$count++ ?>
			<div class="featured-post-<?php echo $count ?>">
				<?php 
				if ( has_post_thumbnail() ) { ?>
					<div class="featured-img imgLiquidFill imgLiquid">
						<?php the_post_thumbnail('full'); ?>
					</div>
				<?php 
				}else{ ?>
					<div class="featured-img imgLiquidFill imgLiquid">
						<img class="attachment-full wp-post-image rs-slide-image" width="1024" height="500" alt="slide" src="<?php echo get_template_directory_uri() ?>/images/assets/slide.jpg">
					</div>
				<?php 
				} ?>
				<div class="featured-text">
					<a class="featured-title" href="<?php the_permalink() ?>"><h3 <?php post_class('entry-title'); ?>><?php the_title(); ?></h3></a>
					<?php get_template_part( 'featuredpost', 'meta'); ?>
				</div>
			</div>
		<?php endwhile; 
		wp_reset_query();?>
		</div><!--featured-posts-wrapper-->
	<?php } 
} 