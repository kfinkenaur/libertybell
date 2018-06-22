<?php
/**
 * Footer Template
 *
 *
 * @file           footer.php
 * @package        DK Responsive
 * @author         Dipali Dhole
 * @copyright      2014 Zenant
 * @license        license.txt
 * @version        Release: 1.0
 */
?>
		</div><!-- #content -->
	</div>
</div>
<div class="footer">
    	<div class="container">
		<?php
		    $col_setting = dk_get_option('footer_col');
			if(empty($col_setting)) $col_setting=3;
			
			if($col_setting==3){
			  $col = '4';
			}else{
			  $col = '3';
			}
		?>
		
		<div class="col-lg-<?php echo esc_attr($col);?>">
        <?php if ( is_active_sidebar( 'footer-sidebar1' ) ) :
			dynamic_sidebar( 'footer-sidebar1' ); 
               else:
			  ?>
                <div class="widget-wrapper widget_text" >
                <div class="widget-title">
                <h3><?php _e('Footer Widget 1','dk-responsive'); ?></h3>
                </div>			
                <div class="textwidget">
               <p><?php _e('This is first footer widget box. To edit please go to Appearance > Widgets and choose Footer Widget Area 1.','dk-responsive'); ?></p>
               
                </div>
                </div>
              <?php
			   endif; ?>	
		</div>	
       
        
       
       <div class="col-lg-<?php echo esc_attr($col);?>">
        <?php if ( is_active_sidebar( 'footer-sidebar2' ) ) :
			dynamic_sidebar( 'footer-sidebar2' ); 
               else:
			  ?>
                <div class="widget-wrapper widget_text" >
                <div class="widget-title">
                <h3><?php _e('Footer Widget 2','dk-responsive'); ?></h3>
                </div>			
                <div class="textwidget">
                <p><?php _e('This is second footer widget box. To edit please go to Appearance > Widgets and choose Footer Widget Area 2','dk-responsive');  ?></p>  
                </div>
                </div>
              <?php
			   endif; ?>	
		</div>
        
		 <div class="col-lg-<?php echo esc_attr($col);?>">
        <?php if ( is_active_sidebar( 'footer-sidebar3' ) ) :
			dynamic_sidebar( 'footer-sidebar3' ); 
               else:
			  ?>
                <div class="widget-wrapper widget_text" >
                <div class="widget-title">
                <h3><?php _e('Footer Widget 3','dk-responsive'); ?></h3>
                </div>			
                <div class="textwidget">
                 <p><?php _e(' This is third footer widget box. To edit please go to Appearance > Widgets and choose Footer Widget Area 3','dk-responsive');  ?></p> 
                 </div>
                </div>
              <?php
			   endif; ?>	
		</div>
        
		<?php if($col_setting==4):	 ?>				
			 <div class="col-lg-<?php echo esc_attr($col);?>">
        <?php if ( is_active_sidebar( 'footer-sidebar4' ) ) :
			dynamic_sidebar( 'footer-sidebar4' ); 
               else:			   
			  ?>
                <div class="widget-wrapper widget_text" >
                <div class="widget-title">
                <h3><?php _e('Footer Widget 4','dk-responsive'); ?></h3>
                </div>			
                <div class="textwidget">
                <p><?php _e('This is fourth footer widget box. To edit please go to Appearance > Widgets and choose Footer Widget Area 4.','dk-responsive'); ?></p>
                </div>
                </div>
              <?php
			   endif; ?>	
		</div>
			<?php	endif;
			?>
        </div>
</div>
 <div class="footerBottom">
        <div class="container">
            <div class="row">
            	<div class="col-md-4 footerMenu footerrow">
                	<nav>
						<?php 					
                        wp_nav_menu( array(
                        'container'      => '',
                        'fallback_cb'    => false,
                        'menu_class'     => 'footer-menu',
                        'theme_location' => 'footer'
                        ) );                     
						?>
                    </nav>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-4 copyRight footerrow">
                	<div class="clearfix"></div>
                    <p>
					<?php 
                        $copyright = dk_get_option('copyright');
						if(!empty($copyright)) {
						  echo esc_html( $copyright );
						} else {
						  echo 	 __( 'Designed and Developed by <a href="https://profiles.wordpress.org/dipalidhole27gmailcom" target="_blank">Dipali Dhole</a>', 'dk-responsive' );
						}
                     ?>
                    </p>
                </div>
                <div class="col-md-4 socialIcons footerrow">
                	<div class="pull-right">
					<?php
					 $facebook = dk_get_option('facebook');
					 $twitter = dk_get_option('twitter');
					 $google = dk_get_option('google');
					 $youTube = dk_get_option('youtube');
					 ?>
					<?php if(!empty($facebook)) { ?>
                    <a href="<?php echo esc_url($facebook); ?>"  target="_blank" class="facebook"></a>
					<?php } ?>
					<?php if(!empty($twitter)) { ?>
                    <a href="<?php echo esc_url($twitter); ?>" target="_blank" class="twitter"></a>
					<?php } ?>
					<?php if(!empty($google)) { ?>
                    <a href="<?php echo esc_url($google); ?>" target="_blank" class="gplus"></a>
					<?php } ?>
					<?php if(!empty($youTube)) { ?>
                    <a href="<?php echo esc_url($youTube); ?>" target="_blank" class="youTube"></a>
					<?php } ?>
                    </div>
                </div>
            </div>
        </div>
  </div>
<?php wp_footer(); ?>
</body>
</html>
