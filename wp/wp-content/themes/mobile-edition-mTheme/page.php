<?php get_header(); ?>
<div class="fdx_article_pagination" style="padding-left:7px;">
<?php the_title(); ?>
</div>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="fdx_article fdx_page">
<?php the_content();?>
<?php wp_link_pages('before=<strong>'.__('pages', 'wp-mobile-edition').':&after=</strong>&next_or_number=number&pagelink= %'); ?>
</div>
<?php endwhile; endif; ?>
<?php get_footer(); ?>