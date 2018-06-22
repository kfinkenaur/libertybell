<?php
/**
 * Custom comments style
 * @package Opportune
 */


 
if (!function_exists('opportune_comment')) {
function opportune_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>

<li>                        
	<div class="comment">
		<div class="avatar"> <?php echo get_avatar($comment, 60); ?> </div>
		<div class="comment-text">
			<div class="comment-info">
				<h3 class="name"><?php echo get_comment_author_link(); ?></h3>
				<span class="comment_date">
				<?php comment_time(get_option('date_format')); ?> <?php esc_html_e('at', 'opportune'); ?> <?php comment_time(get_option('time_format')); ?></span>
				<?php comment_reply_link( array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']) ) ); ?>
			</div>
			<div id="comment-<?php echo comment_ID(); ?>">
				<?php comment_text(); ?>
			</div>
		</div>
	</div>                          
                
<?php if ($comment->comment_approved == '0') : ?>
<p><em><?php esc_html_e('Your comment is awaiting moderation.', 'opportune'); ?></em></p>
<?php endif; ?>
<?php 
}
}
