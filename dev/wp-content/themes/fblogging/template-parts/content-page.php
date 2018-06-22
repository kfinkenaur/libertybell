<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage fBlogging
 * @author tishonator
 * @since fBlogging 1.0.0
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<h1 class="entry-title"><?php the_title(); ?></h1>
	
	<div class="page-content">
		<?php
			if ( has_post_thumbnail() ) :

				the_post_thumbnail();

			endif;
			
			the_content( __( 'Read More...', 'fblogging') );
		?>
	</div><!-- .page-content -->

	<div class="page-after-content">
		
		<?php if ( ! post_password_required() ) : ?>

			<?php if ('open' == $post->comment_status) : ?>

				<span class="comments-icon">
					<?php comments_popup_link(__( 'No Comments', 'fblogging' ), __( '1 Comment', 'fblogging' ), __( '% Comments', 'fblogging' ), '', __( 'Comments are closed.', 'fblogging' )); ?>
				</span>

			<?php endif; ?>

			<?php edit_post_link( __( 'Edit', 'fblogging' ), '<span class="edit-icon">', '</span>' ); ?>
		<?php endif; ?>

	</div><!-- .page-after-content -->
</article><!-- #post-## -->

