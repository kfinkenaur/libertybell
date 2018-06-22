<?php
/**
 * @package Monaco
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
			the_post_thumbnail();
		}
	?>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<div class="entry-meta">
			<?php monaco_posted_on(); ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$category_list = get_the_category_list( __( ', ', 'Monaco' ) );

				/* translators: used between list items, there is a space after the comma */
				$tag_list = get_the_tag_list( '', __( ', ', 'Monaco' ) );

				if ( ! monaco_categorized_blog() ) {

				} else {
					
						$meta_text = __( '/ Posted in %1$s', 'Monaco' );

				} // end check for categories on this blog

				printf(
					$meta_text,
					$category_list,
					$tag_list,
					get_permalink()
				);
			?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'Monaco' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'Monaco' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'Monaco' ) );

			if ( ! monaco_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				$meta_text = __( '<a href="%3$s" rel="bookmark" class="bookmark">Bookmark this</a>', 'Monaco' );
			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( '<a href="%3$s" rel="bookmark" class="bookmark">Bookmark this</a> Tags: %2$s', 'Monaco' );
				} else {
					$meta_text = __( '<a href="%3$s" rel="bookmark" class="bookmark">Bookmark this</a>', 'Monaco' );
				}
			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink()
			);
		?>

		<?php edit_post_link( __( 'Edit', 'Monaco' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
