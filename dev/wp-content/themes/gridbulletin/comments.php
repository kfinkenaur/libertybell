<?php
/*
 * The template for displaying comments.
 */
?>

<?php 
if ( post_password_required() )
	return;
?>

<div id="comments">

	<?php if ( have_comments() ) : ?>
		<h4 class="comments-title">
			<?php printf( _n( '1 comment on %2$s', '%1$s comments on %2$s', get_comments_number(), 'gridbulletin' ), number_format_i18n( get_comments_number() ), get_the_title() ); ?>
		</h4>

		<ol class="comment-list">
			<?php wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 32,
			) ); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<div class="comment-nav">
				<?php previous_comments_link(); ?>
				<?php next_comments_link(); ?>
			</div>
		<?php endif; ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
			<h4 class="no-comments"><?php _e( 'Comments are closed.', 'gridbulletin' ); ?></h4>
		<?php endif; ?>

	<?php endif; ?>

	<?php comment_form(); ?>

</div>