<?php get_header(); ?>
<header>
		<div class="mobileNav"><span class="heavy"> <a href="<?php echo esc_url( home_url() ); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></span><span id="menuTab"><i class="fa fa-bars"></i></span></div>
<nav class="navPush cf">
					 <?php wp_nav_menu( array( 'theme_location' => 'header-menu') ); ?>
			 </nav><!--//top_navlist-->

	</header>
<div class="wrapper">
	

<div class="content">
		
		<?php if (have_posts()) :?>
				 <?php while (have_posts()) : the_post();?>

		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<?php if ( has_post_thumbnail() ) {
        the_post_thumbnail('large');
    } ?>
			 <h2>
			         <?php if( is_sticky() ) : ?>   
                   <i class="fa fa-thumb-tack"></i>&nbsp;
             <?php endif ?>
			<?php the_title(); ?></h2>
			 
				 <!--//post-->
					 
		<p class="allcaps">
         	<i class='fa fa-clock-o'></i><?php _e(" Written on ", "happenings"); ?><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'happenings'); ?> <?php the_title_attribute(); ?>"><?php the_date (); ?> </a> &nbsp;
         	<i class='fa fa-user'></i><?php _e(" By ", "happenings"); ?><span><?php the_author_posts_link (); ?> &nbsp;  </span>
        	<i class='fa fa-folder'></i><?php _e(" in ", "happenings"); ?><?php the_category(", ")?> 
        </p>

         <p><?php the_content();?><?php wp_link_pages(); ?></p>
         
        <p class="allcaps tags">
   			<?php if( has_tag() ) : ?> 
				<span class='meta meta-tag'>
				 <i class='fa fa-tag'></i> 
				<?php the_tags( '' ) ?>
				&nbsp; <?php edit_post_link( sprintf( '%s', __( '<i class="fa fa-pencil"></i> Edit', 'happenings' ) ) ); ?>
				</span>
			<?php endif ?>

		<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;?></article> 
			<article><p class="next cf"><?php previous_post_link(); ?> <span class="alignright"><?php next_post_link(); ?></span></p><!--//.entry-content--></article>
		  

		<?php endwhile; ?>
		<?php else : ?>
       <article><h2><?php _e("Can't find it!", "happenings"); ?></h2>
              <p><?php _e("Sorry, but you are looking for something that isn't here.", "happenings"); ?></p>
		<p><?php _e("Would you like to try again?", "happenings"); ?></p><br>
        <?php get_search_form() ?></article>

		<?php endif; ?>
		
	</div><!-- end content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>