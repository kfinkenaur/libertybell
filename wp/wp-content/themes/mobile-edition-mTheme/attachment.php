<?php get_header(); ?>
<div class="fdx_article_pagination" style="padding-left:7px;">
<?php previous_post_link( '%link', '<span class="fdx_prev">&lsaquo; '.__('return', 'wp-mobile-edition').'</span>' ); ?>	<?php the_title(); ?>

</div>
<div class="fdx_content fdx_page">
<div class="fdx_article"><div align="center">
<?php echo wp_get_attachment_image( $post->ID, 'full' ); ?></div>
</div>
<div class="fdx_clear"></div>
<div align="center" style="margin-bottom: 2px; margin-top: 5px">
<?php
previous_image_link(false, '<span class="icoprev"></span>'); ?>
<?php include (TEMPLATEPATH . '/inc/share.php'); ?>
<?php next_image_link(false, '<span class="iconext"></span>'); ?>
</div>
</div>
<?php get_footer(); ?>