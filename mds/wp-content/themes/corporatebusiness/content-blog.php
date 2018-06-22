<?php
/**
 * The template part for displaying results in blog.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package CorporateBusiness
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('content-box'); ?>>
	<?php if ( has_post_thumbnail() ):?> 
    <div class="featured-image">
        <a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><?php the_post_thumbnail('featured-image');?></a>
    </div><!-- .featured-image -->
    
    <div class="entry">
    <?php else:?>
    <div class="entry thumbnail">
    <?php endif;?>
        <div class="entry-title">
            <?php the_title( sprintf( '<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' ); ?>
        </div><!-- .entry-header -->
        
        <div class="entry-summary">
          <?php the_excerpt(); ?>
          	<div class="readmore">
                <a href="<?php the_permalink(); ?>" title="<?php the_title();?>">
                    <?php echo get_theme_mod ( 'readmore_text', __( 'Read more...', 'corporatebusiness' ) );?> <i class="fa fa-arrow-right"></i>
                </a>
        	</div>
        </div><!-- .entry-summary -->
	</div>
<div class="clear"></div>
</article><!-- #post-## -->
