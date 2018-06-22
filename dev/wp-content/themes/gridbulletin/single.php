<?php
/*
 * The template for displaying single post.
 */
?>

<?php get_header(); ?>
<div id="content">

	<?php while (have_posts()) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>> 
			<h1 class="post-title-single"><?php the_title(); ?></h1>

			<?php get_template_part( 'postmeta' ); ?>

			<?php if (has_post_format('status') ) {?>
				<?php printf( '<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), get_avatar( get_the_author_meta( 'ID' ), 96 )  ); ?>
			<?php } ?>

			<?php the_content(); ?>

			<?php if ( $multipage ) { ?>
				<div class="pagelink"><?php wp_link_pages(); ?></div>
			<?php } ?> 

			<?php get_template_part( 'postmeta-single' ); ?>
		</div>

		<?php comments_template(); ?>

	<?php endwhile; ?>

	<?php edit_post_link( __( 'Edit', 'gridbulletin' ), '<div class="edit-link">', '</div>' ); ?>

</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>