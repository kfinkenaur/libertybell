<?php get_header(); 
global $wdwt_front;
$grab_image = $wdwt_front->grab_image();
$date_enable = $wdwt_front->get_param('date_enable'); ?>
</header>
<div class="container clear-div">
  <?php 
	  if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
		<aside id="sidebar1">
			<div class="sidebar-container clear-div">
				<?php  dynamic_sidebar( 'sidebar-1' ); 	?>	
			</div>
		</aside>
  <?php } ?>
  <div id="blog" class="blog archive-page">

	<?php 
	   if (have_posts()) :
	    $post = $posts[0]; ?>
		
		<?php  if (is_category()) { ?>
		<h2  class="page-header"><?php _e('Archive For The ', "business-world"); ?>&ldquo;<?php single_cat_title(); ?>&rdquo; <?php _e('Category', "business-world"); ?></h2>
	 	<?php  } elseif( is_tag() ) { ?>
		<h2  class="page-header"><?php _e('Posts Tagged ', "business-world"); ?>&ldquo;<?php single_tag_title(); ?>&rdquo;</h2>
		<?php  } elseif (is_day()) { ?>
		<h2  class="page-header"><?php _e('Archive For ', "business-world"); ?><?php the_time(get_option( 'date_format' )); ?></h2>
		<?php  } elseif (is_month()) { ?>
		<h2  class="page-header"><?php _e('Archive For ', "business-world"); ?><?php the_time(get_option( 'date_format' )); ?></h2>
		<?php  } elseif (is_year()) { ?>
		<h2  class="page-header"><?php _e('Archive For ', "business-world"); ?><?php the_time(get_option( 'date_format' )); ?></h2>
		<?php  } elseif (is_author()) { ?>
		<h2  class="page-header"><?php if(isset($_GET['author'])) printf( __( 'All posts by %s', "business-world" ), '<span class="vcard">' . get_the_author_meta('user_login', $_GET['author']) . '</span>' ); ?></h2>
		<?php  } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2  class="page-header"><?php _e('Blog Archives', "business-world"); ?></h2>
	 	<?php } ?>
			
		<?php while (have_posts()) : the_post(); ?>
			
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="post">
				<h3 class="archive-header"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
				
			</div>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( ); ?>" rel="bookmark">
			<?php if(has_post_thumbnail() || (Business_world_frontend_functions::post_image_url() && $wdwt_front->blog_style() && $grab_image)) { ?>
			    <div class="archive-thumb image-thumb">
				   <?php echo Business_world_frontend_functions::fixed_thumbnail(250,230,$grab_image); ?>
				</div>   
			<?php } ?>
			</a>
			
			<?php 
     			if( $wdwt_front->blog_style() ) {
				   the_excerpt();
				}
				else {
					the_content();
				}  ?>			
		</div>
		<?php
		    if($date_enable){ ?>
				<div class="entry-meta">
					  <?php Business_world_frontend_functions::posted_on_single(); ?>
				</div>
				<?php Business_world_frontend_functions::entry_meta(); 
			 } ?>
		<?php endwhile; ?>
		<div class="page-navigation">
		     <?php posts_nav_link(' '); ?>
	    </div>
	<?php else : ?>

		<h3 class="archive-header"><?php _e('Not Found', "business-world"); ?></h3>
		<p><?php _e('There are not posts belonging to this category or tag. Try searching below:', "business-world"); ?></p>
		<div id="search-block-category"><?php get_search_form(); ?></div>
	
	<?php endif; 
	
	wp_reset_query();
	if(comments_open()) {  ?>
		<div class="comments-template">
			<?php echo comments_template();	?>
		</div>
	<?php } ?>
	</div>
	 <?php
		 if ( is_active_sidebar( 'sidebar-2' ) ) { ?>
			<aside id="sidebar2">
				<div class="sidebar-container clear-div">
				  <?php  dynamic_sidebar( 'sidebar-2' ); 	?>
				</div>
			</aside>
	<?php } ?>
</div>
	
<?php get_footer(); ?>
