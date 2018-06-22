<?php get_header(); ?>
<div class="page_title2">
<div class="container">
    <div class="col-md-12 two_third">    
    	<div class="title"><h1>
		<?php if ( is_day() ) :
						printf( __( 'Daily Archives: %s', 'guardian' ), '<span>' . get_the_date() . '</span>' );
					elseif ( is_month() ) :
						printf( __( 'Monthly Archives: %s', 'guardian' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'guardian') ) . '</span>' );
					elseif ( is_year() ) :
						printf( __( 'Yearly Archives: %s', 'guardian' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'guardian' ) ) . '</span>' );
					else :
						_e( 'Archives', 'guardian' );
					endif; ?>		
		</h1></div>       
        <?php weblizar_breadcrumbs(); ?>
    </div>       
</div>
</div><!-- end page title -->
<div class="clearfix"></div>		
<div class="container">	
	<div class="col-md-9 content_left">	
	<?php 
	if ( have_posts()): 
	while ( have_posts() ): the_post();
	get_template_part('loop'); ?>		
	<?php endwhile; 
	endif; 
	weblizar_navigation(); ?>	
	<div class="clearfix divider_dashed9"></div>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>	