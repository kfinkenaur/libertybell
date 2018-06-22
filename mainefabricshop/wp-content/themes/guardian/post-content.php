
<div class="col-md-12 blog_post">
		<div class="col-md-12 blog_postcontent">
        <?php if(has_post_thumbnail()) :?>
		<div class="image_frame">
		<a href="<?php the_permalink(); ?>">
		<?php the_post_thumbnail('small_thumbs'); ?>
		</a>
		</div>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
		<ul class="post_meta_links">
		<li><?php echo get_the_date(); ?></li>				
                <li class="post_by"><i><?php _e('by:','guardian'); ?>&nbsp;</i> <?php the_author(); ?></li>
				<?php if(get_the_tag_list() != '' ) { ?>
                <li class="post_categoty"><i><?php _e('in:','guardian'); ?>&nbsp;</i> <?php the_tags('', ' ', ''); ?></li>
				<?php } ?>
                <li class="post_comments"><i><?php _e('note:','guardian'); ?>&nbsp;</i><?php comments_number( "<strong>0</strong> ".__('Comments','guardian'), "<strong>1</strong> ".__('Comment' ,'guardian'),"<strong>%</strong>".__('Comments','guardian')); ?></li>
        </ul>
        <div class="clearfix"></div>
        <div class="margin_top1"></div>
		<?php endif; ?>            
		<?php the_content(__('Read more...','guardian')); 
		$defaults = array(
              'before'           => '<div class="pagination">' . __( 'Pages:','guardian' ),
              'after'            => '</div>',
	          'link_before'      => '',
	          'link_after'       => '',
	          'next_or_number'   => 'number',
	          'separator'        => ' ',
	          'nextpagelink'     => __( 'Next page'  ,'guardian'),
	          'previouspagelink' => __( 'Previous page' ,'guardian'),
	          'pagelink'         => '%',
	          'echo'             => 1
	          );
	          wp_link_pages( $defaults );
			  ?>
		</div>
</div>
