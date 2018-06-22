<?php
/*
 * The footer for displaying footer widgets and site-info.
 */
?>

<div id="footer">

<?php if ( is_active_sidebar( 'footer-right' ) || is_active_sidebar( 'footer-middle' ) || is_active_sidebar( 'footer-left' ) ) { ?>
<div id="footer-widgets">

	<div class="footer-left"> 
		<?php if ( is_active_sidebar( 'footer-left' ) ) : ?>
		<?php dynamic_sidebar( 'footer-left' ); ?>

		<?php else : ?> 
		<?php endif; ?> 
	</div>

	<div class="footer-middle"> 

		<?php if ( is_active_sidebar( 'footer-middle' ) ) : ?>
		<?php dynamic_sidebar( 'footer-middle' ); ?>

		<?php else : ?> 
		<?php endif; ?> 
	</div>


	<div class="footer-right"> 
		<?php if ( is_active_sidebar( 'footer-right' ) ) : ?>
		<?php dynamic_sidebar( 'footer-right' ); ?>

		<?php else : ?> 
		<?php endif; ?> 
	</div>
		
</div>
<?php } ?> 

	<div class="site-info">
		<?php _e('Copyright', 'gridbulletin'); ?> <?php echo date('Y'); ?>  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a> - 
		<a href="http://wordpress.org" title="<?php _e('WordPress Blog Platform', 'gridbulletin'); ?>"><?php _e('Proudly powered by WordPress', 'gridbulletin'); ?></a>
	</div>

</div>

</div><!-- #container -->

<?php
   /* Always have wp_footer() just before the closing </body>
    * tag of your theme, or you will break many plugins, which
    * generally use this hook to reference JavaScript files.
    */
    wp_footer();
?>
</body>
</html>