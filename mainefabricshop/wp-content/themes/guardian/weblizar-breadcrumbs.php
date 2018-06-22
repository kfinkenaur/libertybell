<div class="container-fluid page_title2">
	<div class="container">
		<div class="row page-br">
			<div class="col-md-9  col-sm-7 two_third">    
				<div class="title"><h1><?php  if(is_home()){ _e('Home','guardian'); }else{ the_title(); } ?></h1></div>       
				<?php weblizar_breadcrumbs(); ?>
			</div>	
			<div class="col-md-3 col-sm-5 one_third last">    
				<div class="site-search-area">        
				<?php get_search_form(); ?>
				</div><!-- end site search -->        
			</div>		
		</div>		
	</div>
</div><!-- end page title -->
<div class="clearfix"></div>