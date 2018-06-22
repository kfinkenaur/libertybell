<?php
/**
 * Template Name: Landing Page
 * The template file for displaying a landing page without the menus, right sidebar and footer widget areas.
 * @package BrickYard
 * @since BrickYard 1.0.0
*/
get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="entry-content">
  <div class="entry-content-inner">
    <div class="content-headline">
      <h1 class="entry-headline"><span class="entry-headline-text"><?php the_title(); ?></span></h1>
    </div>
<?php brickyard_get_display_image_page(); ?>
<?php the_content(); ?>
<?php edit_post_link( __( 'Edit', 'brickyard' ), '<p>', '</p>' ); ?>
<?php endwhile; endif; ?> 
  </div>
</div>  
</div> <!-- end of content -->
<?php get_footer(); ?>