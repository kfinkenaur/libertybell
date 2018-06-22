<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package panoramic
 */
?>

<li id="<?php echo $post->post_name; ?>-section" class="<?php echo ( get_theme_mod( 'panoramic-layout-zebra-stripe', customizer_library_get_default( 'panoramic-layout-zebra-stripe' ) ) && ($pageCount+1) % 2 == 0 ) ? 'even' : ''; ?>">
	<div class="container">
		<a name="<?php echo $post->post_name; ?>" class="page-marker"></a>
				
		<?php
		if ( ( get_theme_mod( 'panoramic-layout-first-page-title', customizer_library_get_default( 'panoramic-layout-first-page-title' ) ) && pageCount == 0 ) || $pageCount > 0 ) {
			the_title( '<h2 class="entry-title">', '</h2>' );
		}
		
		if ( $post->ID == get_option( 'page_for_posts' ) ) {

			$posts = get_posts( array(
				'sort_order' => 'asc',
				'posts_per_page' => get_option('posts_per_page ')
			) );
			
			foreach( $posts as $post ) : setup_postdata($post);
				get_template_part( 'library/template-parts/content', get_post_format() );
			endforeach;
			
		} else if ( $post->ID == get_option( 'woocommerce_shop_page_id' ) ) {

			echo '<div class="woocommerce">';

			do_action( 'woocommerce_before_main_content' );
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>
		
		<?php 
		
			$posts = get_posts( array(
				'post_type' => 'product',
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'posts_per_page' => get_option('posts_per_page ')
			) );

			if ( count( $posts ) > 0 ) {
				woocommerce_product_loop_start();
				
				foreach( $posts as $post ) : setup_postdata($post);
					wc_get_template_part( 'content', 'product' );
				endforeach;
				
				woocommerce_product_loop_end();
				
				if ( wp_count_posts('product')->publish > get_option('posts_per_page ') ) {
					echo '<div class="view-all-products">';
					echo '<a href="' .get_permalink( woocommerce_get_page_id( 'shop' ) ). '">'. __( 'View all products', 'panoramic' ) .'</a>';
					echo '</div>';
				}
				
			}
			
			echo '</div>'; 

		} else {
		?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content no-title">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
			
				<footer class="entry-footer">
					<?php edit_post_link( __( 'Edit', 'panoramic' ), '<span class="edit-link">', '</span>' ); ?>
				</footer><!-- .entry-footer -->
			</article><!-- #post-## -->
			
		<?php
		}
		?>
		
		<?php
		if ( get_theme_mod( 'panoramic-layout-divider', customizer_library_get_default( 'panoramic-layout-divider' ) ) && $pageCount+1 < count($orderedPages) ) {
		?>
		<hr class="divider" />
		<?php
		}
		?>
	</div>
</li>
