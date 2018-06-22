<?php get_header(); ?>
<header>
		<div class="mobileNav"><span class="heavy"> <a href="<?php echo esc_url( home_url() ); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></span><span id="menuTab"><i class="fa fa-bars"></i></span></div>
<nav class="navPush cf">
           <?php wp_nav_menu( array( 'theme_location' => 'header-menu') ); ?>
       </nav><!--//top_navlist-->

	</header>
<div class="wrapper">

<div class="content">
	<h1 class="title"><?php _e("Search Results", "happenings"); ?></h1>
		
<?php if ( has_post_thumbnail() ) {
         the_post_thumbnail('large');
} ?>
		<?php if (have_posts()) :?>
         <?php while (have_posts()) : the_post();?>

		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			 <h2><a href="<?php the_permalink(); ?>"rel="bookmark" title="<?php _e('Permanent Link to', 'happenings'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
       <p class="allcaps">
        <i class='fa fa-user'></i> <?php the_author_posts_link(); ?>
	        <?php if( has_category() ) : ?> 
				<span class='meta meta-category'>&nbsp;
					<i class='fa fa-folder'></i>
					<?php the_category( ', ' ) ?>
				</span>
			<?php endif ?>
			<?php if( has_tag() ) : ?> 
				<span class='meta meta-tag'>&nbsp;
				 <i class='fa fa-tag'></i> 
				<?php the_tags( '' ) ?>
				</span>
			<?php endif ?></p>
         <p><!--//post-->
            <?php the_content();?>
         </p><!--//.entry-content-->
        
		</article>
		<?php endwhile; ?>

		<?php else : ?>
          <article><h2><?php _e("Can't find it!", "happenings"); ?></h2>
              <p><?php _e("Sorry, but you are looking for something that isn't here.", "happenings"); ?></p>
		<p><?php _e("Would you like to try again?", "happenings"); ?></p>
        <?php get_search_form() ?></article>

		<?php endif; ?>
		
	</div><!-- end content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>