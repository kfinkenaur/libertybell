<?php get_header(); ?>
<div class="container-fluid page_title2">
	<div class="container">
		<div class="row page-br">
			<div class="col-md-9  col-sm-7 two_third">    
				<div class="title">
					<h1><?php global $wp;
						echo $current_url = (add_query_arg(array(),$wp->request)); ?>
					</h1>
				</div>       
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
	<div class="container">
		<div class="content_left">
			<?php woocommerce_content(); ?>          
				<div class="clearfix divider_dashed9"></div>	
				<div class="clearfix mar_top2"></div>
		</div><!-- end content left side -->
	<?php get_sidebar(); ?>
	</div><!-- end content area -->
<div class="margin_top5"></div>	
<?php get_footer(); ?>