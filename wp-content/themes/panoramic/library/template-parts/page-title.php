<?php
//if ( get_theme_mod( 'panoramic-layout-display-page-titles', customizer_library_get_default( 'panoramic-layout-display-page-titles' ) ) && ( !is_front_page() || is_front_page() && get_theme_mod( 'panoramic-layout-display-homepage-page-title', customizer_library_get_default( 'panoramic-layout-display-homepage-page-title' ) ) ) ) :
if ( !is_front_page() && get_theme_mod( 'panoramic-layout-display-page-titles', customizer_library_get_default( 'panoramic-layout-display-page-titles' ) ) ) :
?>

    <header class="entry-header">
        
        <?php
        if ( is_home() ) :
			echo '<h1 class="entry-title">'. get_the_title( get_option('page_for_posts', true) .'</h1>' );
		//else:
		elseif ( !is_home() ):
			the_title( '<h1 class="entry-title">', '</h1>' );
		endif;
        ?>
        
    </header><!-- .entry-header -->

<?php
endif;
?>