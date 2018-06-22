<div class="col-md-12 blog_postcontent">
	<div id="post-<?php the_ID(); ?>" <?php post_class('blog_post'); ?>>
        <?php if(has_post_thumbnail()) :?>
		<div class="image_frame">
		<a href="<?php the_permalink(); ?>">
		<?php the_post_thumbnail('small_thumbs'); ?>
		</a>
		</div>
		<?php endif; ?>		
        <h3><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
            <ul class="post_meta_links">
            	<li><?php echo get_the_date(); ?></li>
                <li class="post_by"><i><?php _e('by:','guardian'); ?></i>&nbsp;&nbsp;<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a>&nbsp;</li>
				<?php if(get_the_tag_list() != '' ) { ?>
                <li class="post_categoty"><i><?php _e('in:','guardian'); ?></i>&nbsp;&nbsp;<?php the_tags('', ' ', ''); ?>&nbsp;</li>
				<?php } ?>
				<li class="post_comments"><i><?php _e('note:','guardian'); ?>&nbsp;</i><?php comments_number( "<strong>0</strong> ".__('Comments','guardian'), "<strong>1</strong> ".__('Comment' ,'guardian'),"<strong>%</strong>".__('Comments','guardian')); ?></li>

            </ul>
        <div class="clearfix"></div>
        <div class="margin_top1"></div>
		<?php the_content(__('Read more...','guardian')); ?>
		</div>
</div><!-- /# end post -->   
<div class="clearfix divider_dashed9"></div>