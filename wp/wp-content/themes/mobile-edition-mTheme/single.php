<?php get_header(); ?>
<div class="fdx_article_pagination">
<div class="fdx_date_link"><?php
$arc_year = get_the_time('Y');
$arc_month = get_the_time('m');
$arc_day = get_the_time('d');
?><a href="<?php echo get_day_link($arc_year, $arc_month, $arc_day); ?>"><?php the_time( get_option('date_format') ); ?></a></div> <?php next_post_link( '%link', '<span class="fdx_next">'.__('next', 'wp-mobile-edition').' &rsaquo;</span>' ); ?> <?php previous_post_link( '%link', '<span class="fdx_prev">&lsaquo; '.__('prev', 'wp-mobile-edition').'</span>' ); ?>
</div>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="fdx_content fdx_page">
<div class="fdx_article_intro">

<div class="fdx_thumb">
<div class="commentbuble2"><a href="<?php the_permalink(); ?>#comments" title="<?php _e('comments', 'wp-mobile-edition') ?>"><?php $commentscount = get_comments_number(); echo $commentscount; ?></a></div>
<div class="fdx_thumb_link"><a href="<?php the_permalink(); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/spaceball.gif" border="0"  alt="" width="1" height="1"/></a></div>
<div class="fdx_thumbimg">  <?php  if ( has_post_thumbnail()) {
                echo the_post_thumbnail('cat-thumb', (array('title' => ''.esc_attr($post->post_title).'')));
                    } ?></div>
<div class="fdx_frame"></div>
</div>
<div class="fdx_article_heading">
<div class="fdx_article_title_text"><?php the_title(); ?></div>
<div class="fdx_article_data"><?php the_author_posts_link(); ?>  <?php $category = get_the_category(); if ($category) { echo '<a href="' . get_category_link( $category[0]->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a> ';}?> </div>
</div>
<div class="fdx_clear"></div>
</div>

<div class="fdx_article">
<?php the_content();?>
<?php the_tags( '<span class="tags">', '</span><span class="tags">', '</span>'); ?>
<div class="fdx_clear"></div>
</div>

<div align="center" class="sharenav">
<?php $prevPost = get_previous_post(); if ($prevPost) { ?>
<a href="<?php $prevPost = get_previous_post(false); $prevURL = get_permalink($prevPost->ID); echo $prevURL; ?>" title="<?php _e('prev', 'wp-mobile-edition') ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/prev.png" width="24" height="24" border="0" alt="&laquo;" /></a>
<?php }
include (TEMPLATEPATH . '/inc/share.php');
$nextPost = get_next_post(); if ($nextPost) { ?>
<a href="<?php $nextPost = get_next_post(false); $nextURL = get_permalink($nextPost->ID); echo $nextURL; ?>" title="<?php _e('next', 'wp-mobile-edition') ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/icons/next.png" width="24" height="24" border="0" alt="&raquo;" /></a>
<?php } ?>
</div>

</div>
<?php if(function_exists('dsq_options')) { ?>
<div class="rack1"></div> 
<div class="fdx_comments_respond"><?php _e('comments', 'wp-mobile-edition') ?></div>
<div class="fdx_comments_container">
<?php comments_template('',true); ?>
</div>
<?php } else { comments_template('',true); } ?>

<?php endwhile; endif; ?>
<?php get_footer(); ?>