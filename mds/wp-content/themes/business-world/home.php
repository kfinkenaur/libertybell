<?php get_header(); 
global  $wdwt_front;

 if( 'posts' == get_option( 'show_on_front' ) ){ 
	  Business_world_frontend_functions::home_about_us();
	  Business_world_frontend_functions::location_posts();
		Business_world_frontend_functions:: horizontal_tab(); 		
	  Business_world_frontend_functions::pinned_post_section();
 } ?>
</header>

<div class="container clear-div">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
		<aside id="sidebar1" >
			<div class="sidebar-container clear-div">			
				<?php  dynamic_sidebar( 'sidebar-1' ); 	?>
			</div>
		</aside>
	<?php } ?>
	
	<?php
	if( 'posts' == get_option( 'show_on_front' ) ){
		?>
		<div id="blog" class="clear-div">
		<?php         
		Business_world_frontend_functions:: content_posts();
		Business_world_frontend_functions:: dotted_navigation();
		?>
		</div>
		<?php
	}	
	elseif('page' == get_option( 'show_on_front' )){
		Business_world_frontend_functions:: content_posts_for_home();
	}	
	?>		
	
   <?php 
	   if ( is_active_sidebar( 'sidebar-2' ) ) { ?>
		<aside id="sidebar2">
			<div class="sidebar-container clear-div">
			  <?php  dynamic_sidebar( 'sidebar-2' ); 	?>
			</div>
		</aside>
   <?php } ?>
</div>
<?php 
	$wdwt_front->social_links();
	
	get_footer(); ?>
