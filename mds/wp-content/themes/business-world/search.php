<?php 
get_header(); 

global  $wdwt_front;

$grab_image = $wdwt_front->grab_image();
$date_enable = $wdwt_front->get_param('date_enable');
?>
</header>
<div class="container">
	<?php
		if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
			<aside id="sidebar1">
				<div class="sidebar-container clear-div">
					<?php  dynamic_sidebar( 'sidebar-1' ); 	?>	
				</div>
			</aside>
	<?php }  ?>
    <div id="blog" class="blog search-page">
        <div class="single-post">
            <h2 class="page-header">
                <a href="<?php the_permalink(); ?>"><?php echo __('Search',"business-world"); ?></a>
            </h2>
        </div>
		
        <?php
        get_search_form();
         /*print page content*/ 
        if( have_posts() ) { 
            while( have_posts()){ 
                the_post(); ?>
                 <div class="search-result">
                    <h3 class="search-header">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
			       <?php if(has_post_thumbnail() || (Business_world_frontend_functions::post_image_url() && $wdwt_front->blog_style() && $grab_image)) { ?>
						<div class="archive-thumb image-thumb">
						   <?php echo Business_world_frontend_functions::fixed_thumbnail(250,230,$grab_image); ?>
						</div>   
					<?php } ?>
					</a>
                    <div class="entry">
                    <?php
					    if($wdwt_front->blog_style()) {
                           the_excerpt();
                        }
                        else {
                           the_content(__('More',"business-world"));
					    } ?>
                    </div>
					<?php 
					    if($date_enable){ ?>
							<div class="entry-meta">
								  <?php Business_world_frontend_functions::posted_on_single(); ?>
							</div>
							<?php Business_world_frontend_functions::entry_meta(); 
					    } ?>
                </div>
           <?php } ?>
		   <div class="page-navigation">
				<?php posts_nav_link(); ?>
		   </div>
     <?php }
	       else { ?>
		    <div class="search-no-result">
              <?php echo __(" Nothing was found. Please try another keyword.","business-world");  ?>
			</div>
		<?php }  ?>
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
