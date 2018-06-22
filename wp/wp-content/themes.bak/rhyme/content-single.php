<?php 
/**
 * @package Rhyme
 */
?>
<div id="content-box">
	<div id="post-body">
		<div <?php post_class('post-single'); ?>>
			<h1 id="post-title" <?php post_class('entry-title'); ?>><?php the_title(); ?> </h1>
			<?php if (of_get_option('post_info') == 'above') { get_template_part('post','info');}
			if (has_post_format( 'gallery' )) {
				rhyme_gallery_post();
			} else { 
				if ( has_post_thumbnail() ) { 
					if (has_post_format( 'video' )) {
					} else { 
						if (of_get_option('featured_img_post') == '1') {?>
							<div class="thumb-wrapper">
								<?php the_post_thumbnail('full'); ?>
							</div><!--thumb-wrapper-->
							<?php
						} 
					}
				} 			
			} ?>
			<div id="article">
				<?php if (has_post_format( 'quote' )) { ?> 
					<div class="post-format-wrap">
						<i class="fa fa-quote-right"></i>
						<p class="quote-text"><?php echo get_post_meta($post->ID, 'fw_quote_post', true); ?></p>
						<span class="quote-author">~ <?php echo get_post_meta($post->ID, 'fw_quote_author', true); ?> ~</span>
					</div>
				<?php } ?>
				<?php if (has_post_format( 'link' )) { ?> 
					<div class="post-format-wrap">
						<i class="fa fa-chain-broken"></i>
						<p class="link-text"><a href="<?php echo get_post_meta($post->ID, 'fw_link_post_url', true); ?>"><?php echo get_post_meta($post->ID, 'fw_link_post_description', true); ?></a></p>
					</div>
				<?php } ?>
				<?php the_content(); 
				the_tags('<p class="post-tags"><span>'.__('Tags:','rhyme').'</span> ','','</p>');
				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'rhyme' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
				
				//Displays navigation to next/previous post.
				if ( of_get_option('post_navigation') == 'below') { get_template_part('post','nav'); }
				
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template( '', true );
				} ?>
			
			</div><!--article-->
		</div><!--post-single-->
			<?php get_template_part('post','sidebar'); ?>
	</div><!--post-body-->
</div><!--content-box-->
<div class="sidebar-frame">
	<div class="sidebar">
		<?php get_sidebar(); ?>
	</div><!--sidebar-->
</div><!--sidebar-frame-->