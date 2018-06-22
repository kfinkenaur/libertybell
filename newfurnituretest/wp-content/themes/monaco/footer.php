<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Monaco
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div id="widget-footer">
			<div class="one_third">
				<?php if (!dynamic_sidebar('Footer Area One')) : ?>
				<aside id="%1$s" class="widget %2$s">
				<h3><?php _e('An optional widget area for your site footer', 'toolbox');?></h3>
				<?php _e('some text ', 'Monaco'); ?>
				</aside>
				<?php endif; ?>
			</div>
			<div class="one_third">
				<?php if (!dynamic_sidebar('Footer Area Two')) : ?>
				<aside id="%1$s" class="widget %2$s">
				<h3><?php _e('An optional widget area for your site footer', 'toolbox');?></h3>
				<?php _e('some text ', 'Monaco'); ?>
				<?php endif; ?>
			</div>
			<div class="one_third last">
				<?php if (!dynamic_sidebar('Footer Area Three')) : ?>
				<aside id="%1$s" class="widget %2$s">
				<h3><?php _e('An optional widget area for your site footer', 'toolbox');?></h3>
				<?php _e('some text ', 'Monaco'); ?>
				<?php endif; ?>
			</div>
		</div><!-- #widget-footer -->

		<div class="site-info">
			<?php do_action( 'monaco_credits' ); ?>
			<a href="http://wordpress.org/"><?php printf( __( 'Proudly powered by %s', 'Monaco' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'Monaco' ), 'Monaco', '<a href="http://andreasviklund.com/" rel="designer">Veselka Dobreva</a>' ); ?>
			<?php
				$my_theme = wp_get_theme();
				echo $my_theme->get( 'AuthorURI' );
			?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>