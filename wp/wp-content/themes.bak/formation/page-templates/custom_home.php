<?php
/*
 * Template Name: Custom Home Page
 * Description: A home page with featured slider and widgets.
 *
 * @package Formation
 * @since Formation 1.0
 */

get_header(); ?>
        
    <div class="flex-container">
              <div class="flexslider">
                <ul class="slides">
                <?php $the_query = new WP_Query(array(
				  'category_name' => 'featured', 'posts_per_page' => 3
				  ));
				?>
    			  <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
                  <li>
                    <?php the_post_thumbnail(); ?>
                    <div class="caption_wrap">
                    <div class="flex-caption">
                    <div class="flex-caption-title">
                    <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                    </div>
                    <p><?php echo get_slider_excerpt(); ?>
                    <a href="<?php the_permalink() ?>">...</a></p>
                    </div>
                    </div>
                  </li>
                <?php
                    endwhile;
                ?>
                </ul>
              </div>
	</div>
    <div class="featuretext_middle">
    <div class="section group animated" data-fx="fadeInUp">
    <div class="col span_1_of_3">       
    <div class="featuretext">
      <?php if ( get_theme_mod( 'header-one-file-upload' ) ) : ?>
     		<a href="<?php echo esc_url( get_theme_mod( 'header_one_url' ) ); ?>"><img src="<?php echo esc_url( get_theme_mod( 'header-one-file-upload' ) ); ?>"  alt="feature one"></a>
      <?php else : ?>
      <?php echo '<h4>' . __('Insert Image', 'Formation') . '</h4>'; ?>
      <?php endif; ?>
			 <h3><a href="<?php echo esc_url( get_theme_mod( 'header_one_url' ) ); ?>"><?php echo esc_html(get_theme_mod( 'featured_textbox_header_one' ) ); ?></a></h3>
             <p><?php echo esc_html(get_theme_mod( 'featured_textbox_text_one' ) ); ?></p>
	</div>
    </div>
    
    <div class="col span_1_of_3">         
     <div class="featuretext">
      <?php if ( get_theme_mod( 'header-two-file-upload' ) ) : ?>
     		<a href="<?php echo esc_url( get_theme_mod( 'header_two_url' ) ); ?>"><img src="<?php echo esc_url( get_theme_mod( 'header-two-file-upload' ) ); ?>"  alt="feature two"></a>
      <?php else : ?>
      <?php echo '<h4>' . __('Insert Image', 'Formation') . '</h4>'; ?>
      <?php endif; ?>
			<h3><a href="<?php echo esc_url( get_theme_mod( 'header_two_url' ) ); ?>"><?php echo esc_html(get_theme_mod( 'featured_textbox_header_two' ) ); ?></a></h3>
             <p><?php echo esc_html(get_theme_mod( 'featured_textbox_text_two' ) ); ?></p>
	</div>
    </div>
    
   <div class="col span_1_of_3">         
     <div class="featuretext">
      <?php if ( get_theme_mod( 'header-three-file-upload' ) ) : ?>
     		<a href="<?php echo esc_url( get_theme_mod( 'header_three_url' ) ); ?>"><img src="<?php echo esc_url( get_theme_mod( 'header-three-file-upload' ) ); ?>"  alt="feature three"></a>
      <?php else : ?>
      <?php echo '<h4>' . __('Insert Image', 'Formation') . '</h4>'; ?>
      <?php endif; ?>
			 <h3><a href="<?php echo esc_url( get_theme_mod( 'header_three_url' ) ); ?>"><?php echo esc_html(get_theme_mod( 'featured_textbox_header_three' ) ); ?></a></h3>
             <p><?php echo esc_html(get_theme_mod( 'featured_textbox_text_three' ) ); ?></p>
	</div>
    </div>
    </div> 
    </div> 
    
     <div class="featuretext_top animated" data-fx="fadeInUp">
			 <h3><?php echo esc_html(get_theme_mod( 'featured_textbox' ) ); ?></h3>
             <div class="featuretext_button">
            <?php if ( get_theme_mod( 'featured_button_url' ) ) : ?>
			<a href="<?php echo esc_url( get_theme_mod( 'featured_button_url' ) ); ?>" ><?php echo __('Find Out More', 'Formation'); ?></a>
			<?php endif; ?>
			</div>  
	</div> 
        
        <div id="primary_home" class="content-area">
			<div id="content" class="fullwidth" role="main">
    
     <div class="section_thumbnails group animated" data-fx="fadeInUp">
    <?php echo '<h3>' . __('Recent Posts', 'Formation') . '</h3>'; ?>
    <div class="unity-separator"></div>

  <?php $the_query = new WP_Query(array(
  'showposts' => 4,
  'post__not_in' => get_option("sticky_posts"),
  ));
 ?>
    <?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
    <div class="col span_1_of_4">
    <article class="recent">
    			<h2 class="recent_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                
                 <div class="view third-effect">
				<?php
			if ( has_post_thumbnail() ) {
    $image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'recent' );
     echo '<img alt="post" class="imagerct" src="' . $image_src[0] . '">';
}
  			?>
            <div class="mask">  
   					 <a href="<?php the_permalink(); ?>" class="info">Full Image</a>  
 			</div>
    			 </div>
				<p><?php echo get_recentposts_excerpt(); ?></p>
                <div class="thumbs-more-link"><a href="<?php the_permalink() ?>"> <?php echo __('More', 'Formation'); ?></a></div>
    </article>
    </div>	
		
	<?php endwhile; ?>

    </div>
    
    <div class="section_clients group animated" data-fx="fadeInUp">
   <div class="client">
    <?php echo '<h3>' . __('Partners', 'Formation') . '</h3>'; ?>
    <div class="unity-separator"></div>
     <div class="col span_1_of_4">
     <div class="client_recent">
			  <?php if ( get_theme_mod( 'logo-one-file-upload' ) ) : ?>
     		<a href="<?php echo esc_url( get_theme_mod( 'logo_one_url' ) ); ?>"><img src="<?php echo esc_url( get_theme_mod( 'logo-one-file-upload' ) ); ?>"  alt="logo one"></a>
      <?php else : ?>
      <?php echo '<h4>' . __('Insert Image', 'Formation') . '</h4>'; ?>
      <?php endif; ?>
     </div>
	</div>
    <div class="col span_1_of_4">
    <div class="client_recent">
			  <?php if ( get_theme_mod( 'logo-two-file-upload' ) ) : ?>
     		<a href="<?php echo esc_url( get_theme_mod( 'logo_two_url' ) ); ?>"><img src="<?php echo esc_url( get_theme_mod( 'logo-two-file-upload' ) ); ?>"  alt="logo two"></a>
      <?php else : ?>
      <?php echo '<h4>' . __('Insert Image', 'Formation') . '</h4>'; ?>
      <?php endif; ?>
	</div>
    </div>
    <div class="col span_1_of_4">
    <div class="client_recent">
			  <?php if ( get_theme_mod( 'logo-three-file-upload' ) ) : ?>
     		<a href="<?php echo esc_url( get_theme_mod( 'logo_three_url' ) ); ?>"><img src="<?php echo esc_url( get_theme_mod( 'logo-three-file-upload' ) ); ?>"  alt="logo three"></a>
      <?php else : ?>
      <?php echo '<h4>' . __('Insert Image', 'Formation') . '</h4>'; ?>
      <?php endif; ?>
	</div>
    </div>
    <div class="col span_1_of_4">
    <div class="client_recent">
			  <?php if ( get_theme_mod( 'logo-four-file-upload' ) ) : ?>
     		<a href="<?php echo esc_url( get_theme_mod( 'logo_four_url' ) ); ?>"><img src="<?php echo esc_url( get_theme_mod( 'logo-four-file-upload' ) ); ?>"  alt="logo four"></a>
      <?php else : ?>
      <?php echo '<h4>' . __('Insert Image', 'Formation') . '</h4>'; ?>
      <?php endif; ?>
	</div>
    </div>
  
	</div>
    </div>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_footer(); ?>