<?php
if ( !is_front_page() ) :
?>
    
    <header class="entry-header">
        
        <?php
        if ( is_home() && get_theme_mod( 'panoramic-layout-display-page-titles', customizer_library_get_default( 'panoramic-layout-display-page-titles' ) ) ) :
			echo '<h1 class="entry-title">'. get_the_title( get_option('page_for_posts', true) .'</h1>' );
		elseif ( !is_home() && get_theme_mod( 'panoramic-layout-display-page-titles', customizer_library_get_default( 'panoramic-layout-display-page-titles' ) ) ):
			the_title( '<h1 class="entry-title">', '</h1>' );
		endif;
        ?>
        
    </header><!-- .entry-header -->

<?php
endif;
?>