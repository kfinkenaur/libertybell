<?php

/* include  fornt end framework class */
require_once('WDWT_front_functions.php');

class Business_world_frontend_functions extends WDWT_frontend_functions{


  public static function posted_on() {
  printf( __( '<span class="sep date"></span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>', "business-world" ),
    esc_url( get_permalink() ),
    esc_attr( get_the_time() ),
    esc_attr( get_the_date( 'c' ) ),
    esc_html( get_the_date() )
  );
  } 

  public static function posted_on_single() {
  printf( __( '<span class="sep date"></span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep author"></span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', "business-world" ),
    esc_url( get_permalink() ),
    esc_attr( get_the_time() ),
    esc_attr( get_the_date( 'c' ) ),
    esc_html( get_the_date() ),
    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
    esc_attr( sprintf( __( 'View all posts by %s', "business-world" ), get_the_author() ) ),
    get_the_author()
  );
 }


  
public static function home_about_us() {

global $wdwt_front;

$hide_about_us = $wdwt_front->get_param('home_middle_description_post_enable');
$home_abaut_us_post = $wdwt_front->get_param('home_middle_description_post');

if(isset($home_abaut_us_post[0]))
   $abaut_us_post=get_post($home_abaut_us_post[0]);

if($abaut_us_post!=NULL)
   $abaut_us_meta_date = get_post_meta($abaut_us_post->ID,WDWT_META,TRUE);
   if($hide_about_us==true && $abaut_us_post!=NULL) 
   { ?>
    <div id="top-page" class="home_section">
      <div class="container">
        <div class="featured-content clear-div">
          <?php
          if($home_abaut_us_post) {           
            $attr_thumb = array(
              'class' => "abaut_us_post",
            );
            if(has_post_thumbnail() || (self::post_image_url() && $wdwt_front->blog_style() && $wdwt_front->grab_image())) { ?>
              <div class="home_about_us-thumb image-thumb">
                 <?php echo self::fixed_thumbnail(300,250,$wdwt_front->grab_image(),$abaut_us_post->ID); ?>
              </div>   
            <?php } ?>
            <h2><a href="<?php echo get_permalink($abaut_us_post->ID) ?>"><?php echo $abaut_us_post->post_title ?></a></h2>
            <p>
               <?php self::the_excerpt_max_charlength(400,$abaut_us_post->post_content);          ?>
            </p>
          <?php } ?>
        </div>      
      </div>
    </div>
  <?php }
}


public static function location_posts( $location_posts = array() ){

global $wdwt_front;
$hide_top_posts = $wdwt_front->get_param('hide_top_posts');
$top_post_categories = $wdwt_front->get_param('top_post_categories', array(), array(''));
$top_post_categories = isset($top_post_categories[0]) && empty($top_post_categories[0]) ? array() : $top_post_categories;

$top_post_cat_name = $wdwt_front->get_param('top_post_cat_name');
$top_post_desc = $wdwt_front->get_param('top_post_desc');
if(!empty($location_posts)) {
  $hide_top_posts = $location_posts["hide"];
  $top_post_categories = $location_posts["categories"];
  $top_post_cat_name = $location_posts["name"];
  $top_post_desc = $location_posts["desc"];
}

$categories = $top_post_categories;

 if ($hide_top_posts == true) {
?>    
    <div id="top-posts" class="home_section">
    <?php 
       $args = array(
          'posts_per_page'=> '4',
          'orderby' => 'date',
          'order' => 'DESC',
          'tax_query' => array(
              'relation' => 'OR',
              array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $categories,
                'operator' => empty($categories) ? 'EXISTS': 'IN',
              ),
              array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $categories,
                'operator' => empty($categories) ? 'EXISTS': 'IN',
              ),
           ),
        );
        $wp_query = new WP_Query($args);

        $curent_query_posts=$wp_query->get_posts();
        if(!isset($curent_query_posts[0]))
          $curent_query_posts[0]='';
        
        unset($curent_query_posts);
         ?>
      <div class="">
        <h2><?php echo esc_html($top_post_cat_name); ?></h2>
        <p class="top-desc"><?php echo $top_post_desc ?></p>
        <div id="top-posts-scroll">
          
    
          <div class="top-posts-wrapper">
            <div class="top-posts-block">
              <ul id="top-posts-list">
                
                <?php if($wp_query->have_posts()) {
                  
                    $i = 0;
                  while ($wp_query->have_posts()) {
                    $i++;
                    $wp_query->the_post();
                    

                    if(has_post_thumbnail() || self::post_image_url() ){


                      $url = self::get_post_thumb();
                  ?>
                <li style="background-image:url(<?php echo $url;?>);" id="top_post_<?php echo $i; ?>">
                  
                    <div class="top-post-img"></div>
                    <div class="top-post-caption">
                       <div class="caption-content">
                      <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                      <p><?php self::the_excerpt_max_charlength(100); ?></p>
                      <a href="<?php the_permalink(); ?>"><p class="caption-more"><?php echo __("more info","business-world"); ?></p></a>
                     </div> 
                    </div>                        
                  
                  
                  
                </li>
                <?php }

                } } ?>
                
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php }
}



  public static function horizontal_tab(){
    global $post,$wdwt_front;
    $enable_hotizontal_tabs = $wdwt_front->get_param('hide_horizontal_tab_posts');
    $horizontal_tab_categories = $wdwt_front->get_param('horizontal_tab_categories', array(), array(''));
    $horizontal_tab_categories = isset($horizontal_tab_categories[0]) && empty($horizontal_tab_categories[0]) ? array() : $horizontal_tab_categories;
    $grab_image = $wdwt_front->grab_image();


     if ($enable_hotizontal_tabs){

      $args = array(
          'posts_per_page'=> '100',
          'tax_query' => array(
              'relation' => 'OR',
              array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $horizontal_tab_categories,
                'operator' => empty($horizontal_tab_categories) ? 'EXISTS': 'IN',
              ),
              array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $horizontal_tab_categories,
                'operator' => empty($horizontal_tab_categories) ? 'EXISTS': 'IN',
              ),
           ),
        );
        $h_tab_wp_query = new WP_Query($args);

      ?>
    <div id="wd-horizontal-tabs" class="container home_section">
        <div id="main_img">
            <img src="">
      </div>
      <div class="cont_horizontal_tab">    
         <ul class="content">
        <?php 
        
        $i=0;
        while ($h_tab_wp_query->have_posts()) : $h_tab_wp_query->the_post();
          $i++; ?>
          <li  <?php if($i==1) echo "class='active'"; ?> id="horizontal-tabs-content-<?php echo $post->ID; ?>">
            <a href="<?php echo get_permalink(); ?>"><?php echo self::the_excerpt_max_charlength(300); ?></a>
            
          </li>
        <?php endwhile; ?>
        </ul>
      </div>
      <div id="tabs_div">
        <div id="tabs_left_arrow" class="tabs_arrow"><
        </div>
        <div id="tabs_content">
          <ul class="tabs clear-div">
          <?php
            while ($h_tab_wp_query->have_posts()) : $h_tab_wp_query->the_post();    ?>
              <li  id="horizontal-tab-<?php echo $post->ID; ?>" class="image-thumb">
                <a href="#<?php echo $post->ID; ?>">
                  <?php echo self::fixed_thumbnail(250,230,true); ?>
                </a>
              </li>
            <?php endwhile; ?>
          </ul>
        </div>
        <div id="tabs_right_arrow" class="tabs_arrow">>
        </div>
      </div>  
    </div>
    <?php
    }

  }

public static function content_posts_for_home() {
global $post,$wp_query,$wdwt_front;
$grab_image = $wdwt_front->grab_image();
if(is_home()){    
?><div id="blog" class="blog content-inner-block blog-posts-page">
    
    <div class="blog-post content-posts clear-div">
<?php
   if(have_posts()) { 
      while (have_posts()) {
        the_post();
        $business_world_meta_date = get_post_meta($post->ID,WDWT_META,TRUE); ?>
        
        <div class='content-post'>
            <?php if(has_post_thumbnail() || (self::post_image_url() && $grab_image)) { ?>
            <div class="content-thumb image-thumb">
               <?php echo self::fixed_thumbnail(70,70,$grab_image); ?>
            </div>   
          <?php
            $thumb_class="thumb-class";
          }else{
            $thumb_class="";
          } ?>
          <span class="date <?php echo $thumb_class; ?>"><?php echo get_the_date(); ?></span>
          <h3><a href="<?php echo get_permalink() ?>"><?php the_title(); ?></a></h3>
          <p> 
            <?php self::the_excerpt_max_charlength(200);  ?>
          </p>
          <a class="read_more" href="<?php echo get_permalink(); ?>"><?php echo __('More info',"business-world");?></a>
        </div>
        <?php 
        }
        if( $wp_query->max_num_pages > 1 ){ ?>
          <div class="page-navigation">
            <?php posts_nav_link(); ?>
          </div>     
        <?php }
        
        }
        wp_reset_query(); ?>      
      </div>
    </div>  
 <?php }else{ ?>
         <div>
        <?php  if(have_posts()) : while(have_posts()) : the_post(); ?>
      <div class="single-post">
       <h2  class="page-header"><?php the_title(); ?></h2>
       <div class="entry"><?php the_content(); ?></div>
      </div>
    <?php endwhile; ?>
       <div class="navigation">
        <?php posts_nav_link(" "); ?>
       </div>

    <?php endif;  ?>
     <div class="clear"></div>
     <?php
        if(comments_open())
        {  ?>
          <div class="comments-template">
            <?php echo comments_template(); ?>
          </div>
      
      <?php }  ?> 
       </div>
 
 <?php 
 }
      
}     
      
public static function pinned_post_section(){
  global $wdwt_front;
  $pinned_post = $wdwt_front->get_param('pinned_post');

  $pinned_post_enable = $wdwt_front->get_param('pinned_post_enable');
  $pinned_bg_img = $wdwt_front->get_param('pinned_bg_img');
  $blog_style = $wdwt_front->blog_style();

  $featured_post=get_post($pinned_post[0]); /// ttttt fix
  if(is_null($featured_post)){
    $featured_post=get_posts();
    $featured_post=$featured_post[0];
  }


  if ($pinned_post_enable){  ?>
  <div id="image_list_top5" class="pinned_post home_page_item home_section">
    <div class="pinned_post_bg" style="background-image: url(<?php echo esc_url($pinned_bg_img);?>)">
      <div class="container">
          <?php echo get_the_post_thumbnail( $featured_post->ID,array(260,220)); ?>
        <div id="right_middle_pinned">   
          <a href="<?php echo get_permalink($featured_post->ID); ?>">
            <h2> <?php echo $featured_post->post_title; ?> </h2>
          </a>
          <?php 
          if($blog_style)
              the_excerpt();
          else 
            echo $featured_post->post_content; ?>
          <div class="clear"></div>
        </div>
      </div>
    </div>
  </div>
  <?php } 

}     
      
      
public static function content_posts() {

global $post,$wdwt_front;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$content_posts_enable = $wdwt_front->get_param('content_posts_enable', array(), true); 
$cat_checked = $wdwt_front->get_param('content_post_categories', array(), array(''));         
$cat_checked = isset($cat_checked[0]) && empty($cat_checked[0]) ? array() : $cat_checked;
       
$grab_image = $wdwt_front->grab_image();        
$content_post_cat_name = $wdwt_front->get_param('content_post_cat_name');        
$content_post_desc = $wdwt_front->get_param('content_post_desc');        

$n_of_home_post=get_option( 'posts_per_page', 3 ); 
$args = array(
      'posts_per_page'=>$n_of_home_post,
      'paged' => $paged,
      'order' => 'DESC',
      'tax_query' => array(
          'relation' => 'OR',
          array(
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => $cat_checked,
            'operator' => empty($cat_checked) ? 'EXISTS': 'IN',
          ),
          array(
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => $cat_checked,
            'operator' => empty($cat_checked) ? 'EXISTS': 'IN',
          ),
       ),
    );

    $wp_query = new WP_Query($args);


if($content_posts_enable && $wp_query->have_posts()) { ?>
  
    <div class="content-inner-block home-page clear-div home_section">
      <div class="blog-post content-posts">
        <h2 class="align-center"><?php echo esc_html($content_post_cat_name); ?></h2>
        <p class="align-center"><?php echo esc_html($content_post_desc); ?></p>
        <div class="content-posts-container clear-div">
      <?php 
         if($wp_query->have_posts()) { 
          while ($wp_query->have_posts()) {
            $wp_query->the_post();
            $business_world_meta_date = get_post_meta($post->ID,WDWT_META,TRUE);    ?>        
          <div class='content-post'>
            <?php if(has_post_thumbnail() || (self::post_image_url() && $grab_image)) { ?>
              <div class="content-thumb image-thumb">
                 <?php echo self::fixed_thumbnail(70,70,$grab_image); ?>
              </div>   
            <?php
            $thumb_class="thumb-class";
            }else{
              $thumb_class="";
            } ?>
            <span class="date <?php echo $thumb_class; ?>"><?php echo get_the_date(); ?></span>
            <h3><a href="<?php echo get_permalink() ?>"><?php the_title(); ?></a></h3>
            <p> 
              <?php self::the_excerpt_max_charlength(200);  ?>
            </p>
            <a class="read_more" href="<?php echo get_permalink(); ?>"><?php echo __('More info',"business-world");?></a>
          </div>
          <?php } }?>
        </div>
      </div>
     <?php  if( $wp_query->max_num_pages > 1 ){ ?>
        <div class="gallery-page-navigation page-navigation clear-div">
          <div class="navigation-previous">
          <?php previous_posts_link( __('Previous Page',"business-world") , $wp_query->max_num_pages ); ?>
          </div>
          <div class="navigation-next">
          <?php  next_posts_link( __('Next Page',"business-world") , $wp_query->max_num_pages ); ?>
          </div>
        </div>
      <?php }  ?>
     <div class="clear"></div>
    </div>
    <?php 
    
 }   
    wp_reset_postdata(); 
      
}    


public static function dotted_navigation() {

  global $wdwt_front;
  $enable_dotted_navigation = $wdwt_front->get_param('enable_dotted_navigation',array(),false);
  if($enable_dotted_navigation) {
    ?>
    <ul class="dotted_navigation">
    </ul>
  <?php   
  } 
}   




  

  public static function entry_meta() {
  $categories_list = get_the_category_list(', ' );
  echo '<div class="entry-meta-cat">';
  if ( $categories_list ) {
    echo '<span class="categories-links"><span class="sep category"></span> ' . $categories_list . '</span>';
  }
  $tag_list = get_the_tag_list( '', ' , ' );
  if ( $tag_list ) {
    echo '<span class="tags-links"><span class="sep tag"></span>' . $tag_list . '</span>';
  }
  echo '</div>';
  }


  

  


  

}



