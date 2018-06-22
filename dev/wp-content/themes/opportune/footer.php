
<?php
/**
 * The template for displaying the footer
 * Contains the closing of the "site-content" div and all content after.
 * @package Opportune
 */
?>

  
    
</div><!-- #content -->

<div id="site-content-bottom">
 <?php get_sidebar( 'bottom-showcase' ); ?> 
 </div>
 
<div id="bottom-sidebars">       
	<?php get_sidebar( 'bottom' ); ?>   
</div>

</div><!-- #page -->

 <a class="back-to-top"><span class="fa fa-angle-up"></span></a>
 
<footer id="colophon" class="site-footer" role="contentinfo">

        <div id="footer-sidebar">       
                <?php get_sidebar( 'footer' ); ?>   
        </div>


<?php  // Social links
                  if ( has_nav_menu( 'social' ) ) :
                        echo '<nav class="social-menu" role="navigation">';
                            
                        wp_nav_menu( array(
                            'theme_location' => 'social',
                            'depth'          => 1,
                            'container' => false,
                            'menu_class'         => 'social',
                            'link_before'    => '<span class="screen-reader-text">',
                            'link_after'     => '</span>',
                        ) );
                            
                        echo '</nav>';
                    endif;          
                ?>


        <nav id="footer-nav" role="navigation">
            <?php wp_nav_menu( array( 
                    'theme_location' => 'footer', 
                    'fallback_cb' => false, 
                    'depth' => 1,
                    'container' => false, 
                    'menu_id' => 'footer-menu', 
                ) ); 
            ?>
        </nav>
        
        <div id="copyright">
          <?php esc_html_e('Copyright &copy;', 'opportune'); ?> 
          <?php echo date('Y'); ?> <?php echo esc_html(get_theme_mod( 'copyright', 'Your Name' )); ?>.&nbsp;<?php esc_html_e('All rights reserved.', 'opportune'); ?>
        </div> 
        
</footer>
<?php wp_footer(); ?>

</body>
</html>