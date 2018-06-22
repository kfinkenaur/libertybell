<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package CorporateBusiness

 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div class="clear"></div>
<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title"><?php echo __( 'Comments', 'corporatebusiness' );?></h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'corporatebusiness' ); ?></h2>
			<div class="nav-links">
				<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'corporatebusiness' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'corporatebusiness' ) ); ?></div>
			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'callback'      => 'corporatebusiness_theme_comment',
					'avatar_size' => 32,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'corporatebusiness' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'corporatebusiness' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'corporatebusiness' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><i class="fa fa-exclamation-circle"></i> <?php _e( 'Comments are closed.', 'corporatebusiness' ); ?></p>
	<?php endif; ?>

</div><!-- #comments -->

<?php
$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );
$fields =  array(
	'author' => '<div class="input-container"><input id="author" type="text" aria-required="true" tabindex="1" size="22" value="'.esc_attr($commenter['comment_author']).'" name="author" '.$aria_req.' autocomplete="off" /><span> <i class="fa fa-user"></i> '.__('Name', 'corporatebusiness').' '.($req?'*':'').'</span></div>',
	'email' => '<div class="input-container"><input id="email" type="text" aria-required="true" tabindex="2" size="22" value="'.esc_attr($commenter['comment_author_email']).'" name="email" '.$aria_req.' autocomplete="off" /><span> <i class="fa fa-envelope-o"></i> '.__('Email', 'corporatebusiness').' '.($req?'*':'').'</span></div>',
	'url' => '<div class="input-container"><input id="url" type="text" aria-required="true" tabindex="3" size="22" value="'.esc_url($commenter['comment_author_url']).'" name="url" autocomplete="off" /><span> <i class="fa fa-home"></i> '.__('Website', 'corporatebusiness').'</span></div>'
);

$comments_args = array( 
	'comment_notes_before'	=> '<p class="comment-notes">' . esc_attr(get_theme_mod( 'comment_rules_before' , __( 'Your email address will not be published.','corporatebusiness' ) )) . '</p>',
	'comment_notes_after'	=> '<p class="comment-notes">' . esc_attr(get_theme_mod( 'comment_rules_after' , '' )) . '</p>',
    'fields' =>  $fields,
	'comment_field'			=> '<div class="input-container-full"><textarea id="comment" tabindex="4" rows="5" cols="58" name="comment" autocomplete="off" /></textarea></div>',
	'cancel_reply_link'		=> '<i class="fa fa-close"></i> '.__( 'Cancel reply','corporatebusiness' ),
	'label_submit'			=> esc_attr(get_theme_mod( 'label_submit' , __( 'Post Comment','corporatebusiness' ) )),
);
comment_form($comments_args);
?>