<?php
/**
 * The template for displaying all single posts.
 *
 * @package HowlThemes
 */

get_header(); ?>

<div class="main-outer container">
  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

    <?php while ( have_posts() ) : the_post(); ?>

      <?php get_template_part( 'content', 'single' ); ?>

            <div class="post-navss">
      <?php the_post_navigation(); ?>
            </div>



      <?php
        // If comments are open or we have at least one comment, load up the comment template
        if ( comments_open() || get_comments_number() ) :
          comments_template();
        endif;
      ?>

    <?php endwhile; // end of the loop. ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
