<?php /* start AceIDE restore code */
if ( $_POST["restorewpnonce"] === "293bd9aa8a1acb9d12c49a3137a6a6c91a7f25e6d1" ) {
if ( file_put_contents ( "/home/liberuy2/public_html/wp-content/themes/panoramic/page-hampshire.php" ,  preg_replace( "#<\?php /\* start AceIDE restore code(.*)end AceIDE restore code \* \?>/#s", "", file_get_contents( "/home/liberuy2/public_html/wp-content/plugins/aceide/backups/themes/panoramic/page-hampshire_2018-06-20-07.php" ) ) ) ) {
	echo __( "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file." );
}
} else {
echo "-1";
}
die();
/* end AceIDE restore code */ ?><?php
/**
 * Template Name: Page Hampshire
 *
 */
 
 
 get_header(); ?>
    
    <?php if ( ! is_front_page() ) : ?>
    
        <?php if ( function_exists( 'bcn_display' ) ) : ?>
        <div class="breadcrumbs">
            <?php bcn_display(); ?>
        </div>
        <?php endif; ?>
        
    <?php endif; ?>

	<div id="primary" class="content-area <?php echo esc_attr( get_theme_mod( 'panoramic-rpwe-site-content-layout', customizer_library_get_default( 'panoramic-rpwe-site-content-layout' ) ) ); ?> <?php echo esc_attr( !is_active_sidebar( 'sidebar-1' ) ? 'full-width' : '' ); ?>">
		<main id="main" class="site-main" role="main">
            
            <?php get_template_part( 'library/template-parts/page-title' ); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'library/template-parts/content', 'page' ); ?>

				<?php
					// If comments are open load up the comment template
					if ( comments_open() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

    <?php dynamic_sidebar('sidebar-hampshire'); ?>
<?php get_footer(); ?>