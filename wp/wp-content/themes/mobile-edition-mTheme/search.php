<?php get_header(); ?>
<div class="fdx_topheading" style="overflow: hidden"><?php fdx_body_result_text(); ?></div>
<div class="fdx_content">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php
if ('fdx_odd' == @$odd_or_even){
  $odd_or_even = 'fdx_even';
}else{
  $odd_or_even = 'fdx_odd';
}
?>
<div id="post-<?php the_ID(); ?>" class="fdx_snippet <?php echo $odd_or_even; ?>" >
<div class="fdx_thumb">
<div class="commentbuble2"><a href="<?php the_permalink(); ?>#comments" title="<?php _e('comments', 'wp-mobile-edition') ?>"><?php $commentscount = get_comments_number(); echo $commentscount; ?></a></div>
<div class="fdx_thumb_link"><a href="<?php the_permalink() ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/spaceball.gif"  alt="" border="0" width="1" height="1"/></a></div>
<div class="fdx_thumbimg">  <?php  if ( has_post_thumbnail()) {
                echo the_post_thumbnail('cat-thumb', (array('title' => ''.esc_attr($post->post_title).'')));
                    } ?></div>
<div class="fdx_frame"></div>
</div>
<?php $title = get_the_title(); $keys= explode(" ",$s); $title = preg_replace('/('.implode('|', $keys) .')/iu', '<span class="search-excerpt">\0</span>', $title); ?>
<div class="fdx_title"><a href="<?php the_permalink() ?>"><?php echo $title; ?></a></div>
<div class="fdx_more"> <a href="<?php the_permalink() ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/spaceball.gif"  alt="" border="0" width="1" height="1"/></a></div>
</div>
<?php endwhile; ?>
<?php else : ?>
<div style="padding:10px 0 10px 18px">
<p><?php _e('Nothing found for ', 'wp-mobile-edition'); echo '<strong style="color:red">'. get_search_query();?></strong></p>
<p>&nbsp;</p>
<p><strong><?php _e('Try performing a different search', 'wp-mobile-edition') ?>. </strong></p>

</div>
<?php endif; ?>
</div>
<?php get_footer(); ?>