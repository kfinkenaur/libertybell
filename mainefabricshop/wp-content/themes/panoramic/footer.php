<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package panoramic
 */
?>
</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
	
	<div class="site-footer-widgets <?php echo ( get_theme_mod( 'panoramic-layout-display-footer-widgets', customizer_library_get_default( 'panoramic-layout-display-footer-widgets' ) ) ) ? '' : 'hidden'; ?>">
        <div class="site-container">
            <?php if ( is_active_sidebar( 'footer' ) ) : ?>
            <ul>
                <?php dynamic_sidebar( 'footer' ); ?>
            </ul>
	        <?php else : ?>
        	<div class="notice">
        		<?php _e( 'Add widgets to the Footer at Appearance > Widgets', 'panoramic' ); ?>
        	</div>
    		<?php endif; ?>
    		
            <div class="clearboth"></div>
        </div>
    </div>
	
	<div class="site-footer-bottom-bar <?php echo get_theme_mod( 'panoramic-footer-bottom-bar-layout', customizer_library_get_default( 'panoramic-footer-bottom-bar-layout' ) ) == 'panoramic-footer-bottom-bar-layout-centered' ? 'centered' : ''; ?>">
	
		<div class="site-container">
		
			<?php
			$copyright_text = trim( get_theme_mod( 'panoramic-footer-copyright-text', customizer_library_get_default( 'panoramic-footer-copyright-text' ) ) ); 
			
			if ( !empty( $copyright_text ) ) {
			?>
			
			<div class="site-footer-bottom-bar-left">

             	<?php echo wp_kses_post( $copyright_text ); ?> 
                
			</div>
			
			<?php
			}
			?>
	        
	        <div class="site-footer-bottom-bar-right">
                
	            <?php wp_nav_menu( array( 'theme_location' => 'footer','container' => false, 'fallback_cb' => false, 'depth'  => 1 ) ); ?>
                
	        </div>
	        
	    </div>
		
        <div class="clearboth"></div>
	</div>
	
</footer><!-- #colophon -->

<?php
if ( get_theme_mod( 'panoramic-layout-site', customizer_library_get_default( 'panoramic-layout-site' ) ) == 'panoramic-layout-site-boxed' ) { ?>
</div>
<?php
} ?>

<?php wp_footer(); ?>

<?php
if ( get_theme_mod( 'panoramic-layout-back-to-top', customizer_library_get_default( 'panoramic-layout-back-to-top' ) ) ) {
?>
<div id="back-to-top" class="<?php echo get_theme_mod( 'panoramic-mobile-back-to-top', customizer_library_get_default( 'panoramic-mobile-back-to-top' ) ) ? '' : 'hide-for-mobile'; ?>">
	<i class="fa fa-angle-up"></i>
	<div class="hover"></div>
</div>
<?php
}
?>

</body>
</html>