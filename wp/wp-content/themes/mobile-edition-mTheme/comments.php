<?php  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die ('Please do not load this page directly. Thanks!');
?>
<a name="comments" id="comments"></a>
<?php if ( post_password_required() ) : ?>
 <div class="fdx_comments_container">
 <strong><?php _e( 'This post is password protected. Enter the password to view any comments.', 'wp-mobile-edition' ); ?>  </strong>
 </div>
<?php
return;
		endif;
?>

<?php if ( have_comments() ) : ?>
<div class="rack1"></div>
<div class="fdx_comments_respond">
<?php comments_number('No', '"1" Comment', '"%" Comments');?>

<?php if ( ! comments_open()) : ?> <div style="float: right; margin-top: 5px; margin-right: 5px"><a href="#fdx_reply"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/comment-no.png" width="20" height="20" border="0" alt="" /></a></div>
<?php else: ?>
<div style="float: right; margin-top: 5px; margin-right: 5px"><a href="#fdx_reply"><img src="<?php echo get_template_directory_uri(); ?>/images/icons/comment-yes.png" width="20" height="20" border="0" alt="" /></a></div>
<?php endif; ?>
</div>

<div id="respond">
<div class="fdx_comments_container" style="padding: 0; border: 0">
<div class="fdx_comments" id="comments">
<ol>
<?php wp_list_comments( array( 'callback' => 'fdx_comment' ) );?>
</ol>
</div>





       </div>
      </div>

<?php endif; // have_comments() ?>

<?php if ( ! comments_open()) : ?>
 <div class="rack1"></div>
 <a id="fdx_reply" name="fdx_reply"></a>
   <div class="fdx_comments_respond" style="overflow: auto">	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
            <div style="float: left" class="navcomen"><?php previous_comments_link( __( '&larr; Older Comments', 'wp-mobile-edition' ) ); ?></div>
			<div style="float: right; margin-right: 10px" class="navcomen"><?php next_comments_link( __( 'Newer Comments &rarr;', 'wp-mobile-edition' ) ); ?></div>
    		<?php endif; // check for comment navigation ?></div>
            <div class="fdx_comments_container">
                 <div align="center"><blockquote><strong><?php _e( 'Comments are closed', 'wp-mobile-edition' ); ?>   </strong></blockquote></div>
            </div>
<?php else: ?>
    <div class="rack1"></div>
 <a id="fdx_reply" name="fdx_reply"></a>

<div class="fdx_comments_respond" style="overflow: auto">	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
            <div style="float: left" class="navcomen"><?php previous_comments_link( __( '&larr; Older Comments', 'wp-mobile-edition' ) ); ?></div>
			<div style="float: right; margin-right: 10px" class="navcomen"><?php next_comments_link( __( 'Newer Comments &rarr;', 'wp-mobile-edition' ) ); ?></div>
    		<?php endif; // check for comment navigation ?></div>

<div class="fdx_comments_container">



<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
<p><?php _e( 'You must be', 'wp-mobile-edition' ); ?> <a href="<?php echo wp_login_url( get_permalink() ); ?>"><strong><?php _e( 'logged in', 'wp-mobile-edition' ); ?></strong></a> <?php _e( 'to post a comment', 'wp-mobile-edition' ); ?>.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/<?php if( FDXMOBILE_TEXT <> '' ) { echo FDXMOBILE_TEXT . '/'; } ?>wp-comments-post.php" method="post" id="commentform" class="form-post">
<?php if ( is_user_logged_in() ) : ?>

<fieldset style="width: 275px"><legend><a href="<?php echo wp_logout_url( get_permalink() ); ?>"><?php _e( 'Logout', 'wp-mobile-edition' ); ?></a></legend> <?php _e( 'Welcome', 'wp-mobile-edition' ); ?>: <a href="<?php echo admin_url('profile.php'); ?>"><?php echo $user_identity; ?></a></fieldset>

<!-- log --> <div  align="center"><?php cancel_comment_reply_link(); ?></div> <fieldset style="width: 275px"><legend><?php comment_form_title(); ?></legend>
<?php else : ?>
<!-- no-log --><div  align="center"><?php cancel_comment_reply_link(); ?></div> <fieldset style="width: 275px"><legend><?php comment_form_title(); ?></legend>

<p><?php _e( 'Name', 'wp-mobile-edition' ); ?><?php if ($req) { ?>*<?php } ?>:<br /><input type="text" name="author" id="author" class="fdx_commentform_input" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1"  /> </p>
<p><?php _e( 'Email', 'wp-mobile-edition' ); ?><?php if ($req) { ?>*<?php } ?>:<br /><input type="text" name="email" id="email" class="fdx_commentform_input" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" /></p>
<p><?php _e( 'Website', 'wp-mobile-edition' ); ?>:<br /><input type="text" name="url" id="url" class="fdx_commentform_input" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3"/> </p>

<?php endif; ?>

<?php _e( 'Comment', 'wp-mobile-edition' ); ?>: <br /><textarea name="comment" id="comment" cols="58" rows="10" tabindex="4" class="fdx_commentform_textarea"></textarea>
<div align="center" style=" margin-top: 5px">
<input type="submit" id="searchsubmit" id="submit" value="<?php _e( 'Post Comment', 'wp-mobile-edition' ); ?>" tabindex="5" />
</div>

<?php comment_id_fields(); ?>
</fieldset>
</form>

<?php endif; ?>

</div>

 <?php endif; ?>
