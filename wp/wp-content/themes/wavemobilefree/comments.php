<?php if ( have_comments() ) : ?>  
<h4><?php printf( _n( 'One Comment', '%1$s Comments', get_comments_number() ),number_format_i18n( get_comments_number() ) );  
?></h4>  
  
<?php foreach ($comments as $comment) { ?>  
<div class="comment">  
    <a name="comment-<?php comment_ID(); ?>"></a>  
    <?php echo get_avatar( $comment->comment_author_email, $size = '40'); ?>  
    <div class="comment-right">  
        <span class="comment-author"><a href="<?php comment_author_url(); ?>"><?php comment_author(); ?></a></span> <span class="comment-date">on <?php comment_date(); ?></span>  
        <p><?php echo $comment->comment_content; ?></p>  
    </div>  
    <div class="spacer"></div>  
</div><!-- comment -->  
<?php } ?> 
  
<?php else: ?>  
<h4>No comments</h4>  
<?php endif; ?>

<?php if ( ! comments_open() ) : ?>  
    <h4>Comments are closed.</h4>  
<?php else: ?>  
  
<h4 id="respond">Leave a Comment</h4>   
<a name="comments"></a>
<div id="msg"></div>  
<div id="comment-form">
            <form action="<?php bloginfo('url'); ?>/wp-comments-post.php" method="post" id="commentform" onsubmit="return validate(this);">   
                <input type='hidden' name='comment_post_ID' value='<?php echo $post->ID; ?>' id='comment_post_ID' />

                <label>Name / Alias (required)</label>
                <div class="input">
                <input type="text" required="required" value="Name" name="author" placeholder="Name" onfocus="if(this.value == this.defaultValue) this.value = ''">
    			</div>
 
                <label>Email Address (required, not shown)</label> 
                <div class="input">
                <input type="email" required="required" value="Email" name="email" placeholder="Email" onfocus="if(this.value == this.defaultValue) this.value = ''">
                </div>

                <label>Website (optional)</label><br /> 
                <div class="input">
                <input type="text" value="" name="url">
                </div>
				<div class="input">
                <textarea rows="7" cols="60" required="required" name="comment"></textarea><br /> 
                </div>  
                <input type="submit" value="Add Your Comment" />   
            </form>  
</div>
  
<?php endif; ?>