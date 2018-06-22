<?php
/**
 * Global Header
 * @package Opportune
 */

  $logo_upload = get_option( 'logo_upload' );
?>


<?php 
            $headerstyle = esc_attr(get_theme_mod( 'header_style', 'default' ) );
                    
                switch ($headerstyle) {
                    
                    // Single with a right sidebar column
                    case "default" :  ?>

  
                         <header id="masthead" class="site-header container <?php echo esc_attr(get_theme_mod( 'header_style', 'default' ) ); ?>" role="banner">
                                <div class="box vertical-align-middle">
                                
                                
                                        <div class="site-branding col-sm-12  col-md-12 col-lg-4">
                                                <?php if ( $logo_upload['logo'] ) : ?>
                                                        <div class="header-image">
                                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?> 
                                                        <?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" 
                                                        rel="home"><img id="logo" src="<?php echo esc_url( $logo_upload['logo'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?>"></a>    
                                                        </div>                
                                                <?php  endif;            
                                                        // Site title 
                                                        if( esc_attr(get_theme_mod( 'show_site_title', 1 ) ) ) {  
                                                        if ( is_front_page() && is_home() ) : ?>
                                                        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                                                        <?php else : ?>
                                                        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                                                        <?php endif;
                                                        }                      
                                                ?>
                                        </div>
                                        
                                        <div class="col-sm-12 col-md-12 col-lg-8">
                                        
                                                <nav id="site-navigation" class="site-navigation primary-navigation" role="navigation">
                                                        <div class="toggle-container visible-xs visible-sm hidden-md hidden-lg">
                                                                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'opportune' ); ?></button>
                                                        </div>
                                                                      
                                                      <?php if ( has_nav_menu( 'primary' ) ) {																			
                                                                wp_nav_menu( array( 							
                                                                    'theme_location' => 'primary', 
                                                                    'menu_class' => 'nav-menu',
								    
                                                                ) ); } else {
                                                            
                                                                wp_nav_menu( array(															
                                                                    'container' => '',
                                                                    'menu_class' => '',
                                                                    'title_li' => ''	,						
                                                                    ));							
                                                               } 
                                                            ?>                    
                                                </nav>
                                                                                
                                                         <?php  if ( esc_attr(get_theme_mod( 'show_tagline', 1 ) ) ) : {
                                                                $description = get_bloginfo( 'description', 'display' );
                                                                if ( $description || is_customize_preview() ) : ?>
                                                                <p class="site-description"><?php echo $description; ?></p>
                                                                <?php endif;				 		  		  
                                                                }
                                                        endif;  ?>
                                                                                
                                        </div>
        
				</div>
                  </header>
					
                  <?php   break;		        

                    // Single with a left sidebar column
                    case "centered" :        ?>                 						


                        <header id="masthead" class="site-header container <?php echo esc_attr(get_theme_mod( 'header_style', 'default' ) ); ?>" role="banner">
                                
                                        <div class="site-branding col-lg-12">
                                                <?php if ( $logo_upload['logo'] ) : ?>
                                                        <div class="header-image ">
                                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?> 
                                                        <?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" 
                                                        rel="home"><img id="logo" src="<?php echo esc_url( $logo_upload['logo'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?>"></a>    
                                                        </div>                
                                                <?php  endif;            
                                                        // Site title 
                                                        if( esc_attr(get_theme_mod( 'show_site_title', 1 ) ) ) {  
                                                        if ( is_front_page() && is_home() ) : ?>
                                                        <h1 class="site-title text-center"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                                                        <?php else : ?>
                                                        <h1 class="site-title text-center"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                                                        <?php endif;
                                                        }                      
                                                ?>
                                        </div>
                                                         <?php  if ( esc_attr(get_theme_mod( 'show_tagline', 1 ) ) ) : {
                                                                $description = get_bloginfo( 'description', 'display' );
                                                                if ( $description || is_customize_preview() ) : ?>
                                                                <p class="site-description text-center"><?php echo $description; ?></p>
                                                                <?php endif;				 		  		  
                                                                }
                                                        endif;  ?>    
                                                                                            
                                        <div class="col-lg-12">
                                        
                                                <nav id="site-navigation" class="site-navigation primary-navigation text-center" role="navigation">
                                                        <div class="toggle-container visible-xs visible-sm hidden-md hidden-lg">
                                                                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'opportune' ); ?></button>
                                                        </div>
                                                                      
                                                      <?php if ( has_nav_menu( 'primary' ) ) {																			
                                                                wp_nav_menu( array( 							
                                                                    'theme_location' => 'primary', 
                                                                    'menu_class' => 'nav-menu',
								    
                                                                ) ); } else {
                                                            
                                                                wp_nav_menu( array(															
                                                                    'container' => '',
                                                                    'menu_class' => '',
                                                                    'title_li' => ''	,						
                                                                    ));							
                                                               } 
                                                            ?>                    
                                                </nav>
                                                                               
                                        </div>
        
                  </header>      
  
					
                 <?php   break;
				
                } 

            ?> 

            