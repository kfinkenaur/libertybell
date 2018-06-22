<?php

/* include  front end framework class */
require_once('WDWT_front_params_output.php');

class Business_world_front extends WDWT_frontend {

  
/**
 * print Layout styles
 *
 */

  public function layout(){
    global $post;
    if(is_singular() && isset($post)){
      /*get all the meta of the current theme for the post*/
      $meta = get_post_meta( $post->ID, WDWT_META, true );
    }
    else{
      $meta = array();
    }

    $default_layout = esc_html( $this->get_param('default_layout', $meta) );
    $main_column = esc_html( $this->get_param('main_column', $meta) );
    $pwa_width = esc_html( $this->get_param('pwa_width', $meta) );
  $full_width = trim(esc_html( $this->get_param('full_width', $meta) ));
  $content_area = esc_html( $this->get_param('content_area', $meta) );
    if ($full_width) {
    $them_content_are_width='99%';
    ?><script>var full_width_magazine=1</script><?php echo "\r\n";
  } else {
    $them_content_are_width=$content_area . "px;";
    ?><script> var full_width_magazine=0</script><?php echo "\r\n";
  }
    switch ($default_layout) :
      case 1:
      ?>
        <style type="text/css">
            #sidebar1,
      #sidebar2 {
        display:none;
      }
            .container{
        width:<?php echo $them_content_are_width; ?>;
            }        
            #blog,#{
        width:<?php echo $them_content_are_width; ?>;
        display:block; 
        float:left;
            }                
        </style>
        <?php
        break;
      case 2:
      ?>
        <style type="text/css">
            #sidebar2{
        display:none;
      } 
      #sidebar1 {
        display:block;
        float:right;
        width:<?php echo (100 - $main_column-1); ?>%;
      }
            .container{
        width:<?php echo $them_content_are_width; ?>
            }
            #blog{
        width:<?php echo $main_column-1 ; ?>%;
        display:block;
        float:left;
            }
        </style>
        <?php
        break;
      case 3:
      ?>
        <style type="text/css">
            #sidebar2{
        display:none;
      } 
      #sidebar1 {
        display:block;
        float:left;
        width:<?php echo (100 -  $main_column-1); ?>%;
        margin-right: 1%;
      } 
            .container{
        width:<?php echo $them_content_are_width; ?>
            }
            #blog{
        display:block;
        float:left;
        width:<?php echo $main_column ; ?>%;
            }
        </style>
        <?php
        break;
      case 4:
      ?>
        <style type="text/css">
            #sidebar2{
        display:block;
        float:right;
        width:<?php echo (100 -  $pwa_width - $main_column); ?>%;
        margin-right: 1%;
      } 
      #sidebar1 {
        display:block; 
        float:right;
        width:<?php echo $pwa_width ; ?>%;
      } 
      #blog{
        display:block;
        float:left;
        width:<?php echo ($main_column-2) ; ?>%;
      }
            .container{
        width:<?php echo $them_content_are_width; ?>
            }
        </style>
        <?php
        break;
      case 5:
      ?>
        <style type="text/css">
           #sidebar2{
        display:block;
        float:left;
        width:<?php echo (100 - $pwa_width - $main_column); ?>%;
        margin-right: 1%;
      } 
      #sidebar1 {
        display:block;
        float:left;
        width:<?php echo $pwa_width ; ?>%;
        margin-right: 1%;
      } 
      #blog{
        display:block;
        float:right;
        width:<?php echo ($main_column-2) ; ?>%;
      }
            .container{
        width:<?php echo $them_content_are_width; ?>
            }
        </style>
        <?php
        break;
      case 6:
      ?>
        <style type="text/css">
           #sidebar2{
        display:block;
        float:right;
        width:<?php echo (100 - $pwa_width - $main_column); ?>%;
      } 
      #sidebar1 {
        display:block;
        float:left; 
        width:<?php echo $pwa_width; ?>%;
        margin-right: 1%;
      } 
      #blog{
        display:block;
        float:left;
        width:<?php echo ($main_column-2); ?>%;
      }                
            .container{
        width:<?php echo $them_content_are_width; ?>
            }
        </style>
        <?php
        break;
    endswitch;
  }
  
  public function slideshow(){
    $header_img_type = $this->get_param('header_img_type');
   

    $hide_slider = $this->get_param('hide_slider');
    $imgs_url = $this->get_param('slider_head');
    $image_textarea = $this->get_param('slider_head_desc');

    $image_title = $this->get_param('slider_head_title');
    $image_height_pages = $this->get_param('image_height_pages');
    $image_height = $this->get_param('image_height');
    $title_position = $this->get_param('title_position');
    $description_position = $this->get_param('description_position');
    $imgs_href = $this->get_param('slider_head_href');

    $imgs_url = explode('||wd||',$imgs_url);
    $imgs_href = explode('||wd||',$imgs_href);
    $image_title = explode('||wd||',$image_title);
    $image_textarea = explode('||wd||',$image_textarea);
    $imgs_number = count($imgs_url);

    for($i=0;$i<count($imgs_number);$i++){
      $imgs_href[$i] = isset($imgs_href[$i]) ? trim($imgs_href[$i]) : '';
      $image_title[$i] = isset($image_title[$i]) ? trim($image_title[$i]) : '';
      $image_textarea[$i] = isset($image_textarea[$i]) ? trim($image_textarea[$i]) : '';
    }

    if( ($hide_slider[0]!="Hide Slider" && ((is_home() && $hide_slider[0]=="Only on Homepage") || (is_front_page() && $hide_slider[0]=="Only on Front Page") || $hide_slider[0]=="On all the pages and posts")) && count($imgs_url) && is_array($imgs_url)){
      if($header_img_type == "slider") {  ?>
    <script>
    var data = [];   
    var event_stack = []; 

    
    <?php

      if($imgs_url && is_array($imgs_url))
        $link_array=$imgs_url;
      else
        $link_array = array();  
      
      for($i=0;$i<count($link_array);$i++){
        echo 'data["'.$i.'"]=[];';
      }
      
      for($i=0;$i<count($link_array);$i++){
        echo 'data["'.$i.'"]["id"]="'.$i.'";';
        echo 'data["'.$i.'"]["image_url"]="'.$link_array[$i].'";';
      }
      
      if($image_textarea && is_array($image_textarea))
        $textarea_array = $image_textarea;
      else
        $textarea_array = array();

      for($i=0;$i<count($textarea_array);$i++){
          $textarea_array[$i] = str_replace(array("\n","\r"), '', $textarea_array[$i]);
        echo 'data["'.$i.'"]["description"]="'.$textarea_array[$i].'";';
      }

      if($image_title && is_array($image_title))
        $title_array = $image_title;
      else
        $title_array = array();
      
      for($i=0;$i<count($title_array);$i++){
        if($title_array[$i]!=''){
          $title_array[$i] = str_replace(array("\n","\r"), '', $title_array[$i]);
        echo 'data["'.$i.'"]["alt"]="'.$title_array[$i].'";';
         }else
        echo 'data["'.$i.'"]["alt"]="";'; 
      } ?>
      </script>
     
   <?php    
    $slideshow_title_position = explode('-', trim($title_position[0]) );
    $slideshow_description_position = explode('-', trim($description_position[0]) );
    if(is_home())
      $image_height = $image_height;
    else{
      $image_height = $image_height_pages;
    } 
   ?>
   <style>
   
    .bwg_slideshow_image_wrap {
    height:<?php echo esc_html( $image_height ); ?>px;
    width:100% !important;
    }

    .bwg_slideshow_title_span {
    text-align: <?php echo esc_html( $slideshow_title_position[0] ); ?>;
    vertical-align: <?php echo esc_html( $slideshow_title_position[1] ); ?>;
    }
    .bwg_slideshow_description_span {
    text-align: <?php echo esc_html( $slideshow_description_position[0] ); ?>;
    vertical-align: <?php echo esc_html( $slideshow_description_position[1] ); ?>;
    }
  </style>

  <!--SLIDESHOW START-->
  <div>
    <div class="bwg_slideshow_image_wrap">
        <?php 
      $current_image_id=0;
        $current_pos =0;
      $current_key=0; ?>
      <!--################# DOTS ################# -->

           <a id="spider_slideshow_left" onclick="bwg_change_image(parseInt(jQuery('#bwg_current_image_key').val()), (parseInt(jQuery('#bwg_current_image_key').val()) - iterator()) >= 0 ? (parseInt(jQuery('#bwg_current_image_key').val()) - iterator()) % data.length : data.length - 1, data); return false;"><span id="spider_slideshow_left-ico"><span><i class="bwg_slideshow_prev_btn fa"></i></span></span></a>
           <a id="spider_slideshow_right" onclick="bwg_change_image(parseInt(jQuery('#bwg_current_image_key').val()), (parseInt(jQuery('#bwg_current_image_key').val()) + iterator()) % data.length, data); return false;"><span id="spider_slideshow_right-ico"><span><i class="bwg_slideshow_next_btn fa "></i></span></span></a>
      <!--################################## -->

      <!--################ IMAGES ################## -->
        <div id="bwg_slideshow_image_container"  width="100%" class="bwg_slideshow_image_container">        
          <div class="bwg_slide_container" width="100%">
            <div class="bwg_slide_bg">
              <div class="bwg_slider">
            <?php
        if($imgs_href && is_array($imgs_href))
        $href_array = $imgs_href;
        else
        $href_array = array();  

        if($imgs_url && is_array($imgs_url))
        $image_rows = $imgs_url;
        else
        $image_rows = array();  
        $i=0;

            foreach ($image_rows as $key => $image_row) {
              if ($i == $current_image_id) {
                $current_key = $key;
                ?>
                <span class="bwg_slideshow_image_span" id="image_id_<?php echo $i; ?>">
                  <span class="bwg_slideshow_image_span1">
                    <span class="bwg_slideshow_image_span2">
              <a href="<?php if(isset($href_array[$i])) echo esc_url( $href_array[$i] ); ?>" >
               <img id="bwg_slideshow_image" class="bwg_slideshow_image" src="<?php echo esc_attr( $image_row ); ?>" image_id="<?php echo $i; ?>" />
              </a>
                    </span>
                  </span>
                </span>
                <input type="hidden" id="bwg_current_image_key" value="<?php echo $key; ?>" />
                <?php
              }
              else {
                ?>
                <span class="bwg_slideshow_image_second_span" id="image_id_<?php echo $i; ?>">
                  <span class="bwg_slideshow_image_span1">
                    <span class="bwg_slideshow_image_span2">
                      <a href="<?php if(isset($href_array[$i])) echo esc_url( $href_array[$i] ); ?>" ><img id="bwg_slideshow_image_second" class="bwg_slideshow_image" src="<?php echo esc_attr( $image_row ); ?>" /></a>
                    </span>
                  </span>
                </span>
                <?php
              }
        $i++;
            }
            ?>
              </div>
            </div>
          </div>
        </div>
    
    <!--################ TITLE ################## -->
        <div class="bwg_slideshow_image_container" style="position: absolute;">
          <div class="bwg_slideshow_title_container">
            <div style="display:table; margin:0 auto;">
              <span class="bwg_slideshow_title_span">
              <?php if(isset($title_array[0])){ ?>
          <div class="bwg_slideshow_title_text" >
            <?php echo $title_array[0]; ?>
           </div>
              <?php } ?>
              </span>
            </div>
          </div>
        </div>
      <!--################ DESCRIPTION ################## -->
        <div class="bwg_slideshow_image_container" style="position: absolute;">
          <div class="bwg_slideshow_title_container">
            <div style="display:table; margin:0 auto;">
              <span class="bwg_slideshow_description_span">
        <?php if(isset($textarea_array[0])){ ?>
                <div class="bwg_slideshow_description_text">
                  <?php echo  $textarea_array[0]; ?>        
          </div>
        <?php } ?>  
              </span>
            </div>
          </div>
        </div>
      </div>
  </div>

  <!--SLIDESHOW END-->

  <?php
  }
  else {
   $this->parallax_image();
  }
}


}

  public function parallax_image(){

    $parallax_img = $this->get_param('parallax_img');
    $parallax_desc = $this->get_param('parallax_desc');
    $parallax_img_padding = $this->get_param('parallax_img_padding');
    $parallax_effect_intensity = $this->get_param('parallax_effect_intensity', array(), 0.8);
    if((float)$parallax_effect_intensity < 0){
      $parallax_effect_intensity = 0;
    }
    if((float)$parallax_effect_intensity > 1){
      $parallax_effect_intensity = 1;
    }
    $parallax_effect_intensity = 1 - (float) $parallax_effect_intensity; // 0 - static, 1  - fixed
    
    ?>
    <style>
    .parallax_header.parallax-image .parallax-window {
      padding:<?php echo esc_html( $parallax_img_padding ); ?>px 0;
      width:100% !important;
    }
    </style>
    <div class="parallax_header home_page_item parallax-image">
      <div class="parallax-window " data-parallax="scroll" data-image-src="<?php echo esc_url($parallax_img);?>">
        <div> 
          <div class="bwg_slideshow_description_text parallax_desc">
            <?php echo $parallax_desc; ?>
          </div>
        </div>
      </div>
    </div>
    <script>
    jQuery('.parallax-window').parallax({
      imageSrc: "<?php echo esc_url($parallax_img);?>",
      speed:"<?php echo $parallax_effect_intensity; ?>",
    });
    </script>
    <?php
  }



  /**
  *    FRONT END COLOR CONTROL
  */

  public function color_control(){


    $color_scheme = esc_html($this->get_param('[colors_active][active]', $meta_array = array(), $default = 0));
    $menu_elem_back_color =esc_html( $this->get_param('[colors_active][colors][menu_elem_back_color][value]' , $meta_array = array(), $default = '#FFFFFF'));
    $slider_text_color = esc_html($this->get_param('[colors_active][colors][slider_text_color][value]', $meta_array = array(), $default = '#FFFFFF'));
    $borders_color = esc_html($this->get_param('[colors_active][colors][borders_color][value]', $meta_array = array(), $default = '#007087'));
    $sideb_background_color = esc_html($this->get_param('[colors_active][colors][sideb_background_color][value]', $meta_array = array(), $default = '#FFFFFF'));
    $content_post_bg_color = esc_html($this->get_param('[colors_active][colors][content_post_bg_color][value]', $meta_array = array(), $default = '#FAFAFA'));
    $footer_sideb_background_color = esc_html($this->get_param('[colors_active][colors][footer_sideb_background_color][value]', $meta_array = array(), $default = '#FFFFFF'));
    $footer_back_color = esc_html($this->get_param('[colors_active][colors][footer_back_color][value]', $meta_array = array(), $default = '#FFFFFF'));
    $featured_posts_color = esc_html($this->get_param('[colors_active][colors][featured_posts_color][value]', $meta_array = array(), $default = '#F9F9F9'));
    $text_headers_color = esc_html($this->get_param('[colors_active][colors][text_headers_color][value]', $meta_array = array(), $default = '#000000'));
    $primary_text_color = esc_html($this->get_param('[colors_active][colors][primary_text_color][value]', $meta_array = array(), $default = '#000000'));
    $footer_text_color = esc_html($this->get_param('[colors_active][colors][footer_text_color][value]', $meta_array = array(), $default = '#2C2C2C'));
    $primary_links_color = esc_html($this->get_param('[colors_active][colors][primary_links_color][value]', $meta_array = array(), $default = '#545454'));
    $primary_links_hover_color = esc_html($this->get_param('[colors_active][colors][primary_links_hover_color][value]', $meta_array = array(), $default = '#007087'));
    $menu_links_color = esc_html($this->get_param('[colors_active][colors][menu_links_color][value]', $meta_array = array(), $default = '#373737'));
    $menu_links_hover_color = esc_html($this->get_param('[colors_active][colors][menu_links_hover_color][value]', $meta_array = array(), $default = '#000000'));
    $hover_menu_item = esc_html($this->get_param('[colors_active][colors][hover_menu_item][value]', $meta_array = array(), $default = '#FFFFFF'));
    $selected_menu_color = esc_html($this->get_param('[colors_active][colors][selected_menu_color][value]', $meta_array = array(), $default = '#FFFFFF'));
    $logo_text_color = esc_html($this->get_param('[colors_active][colors][logo_text_color][value]', $meta_array = array(), $default = '#007087'));
    $button_background_color = esc_html($this->get_param('[colors_active][colors][button_background_color][value]', $meta_array = array(), $default = '#007087'));
    $button_text_color = esc_html($this->get_param('[colors_active][colors][button_text_color][value]', $meta_array = array(), $default = '#FFFFFF'));
    $meta_info_color = esc_html($this->get_param('[colors_active][colors][meta_info_color][value]', $meta_array = array(), $default = '#8F8F8F'));
    $pinned_post_text_color = esc_html($this->get_param('[colors_active][colors][pinned_post_text_color][value]', $meta_array = array(), $default = '#FFFFFF'));

    $lightbox_bg_color = esc_html($this->get_param('[colors_active][colors][lightbox_bg_color][value]', $meta_array = array(), $default = '#000000'));
    $lightbox_ctrl_cont_bg_color = esc_html($this->get_param('[colors_active][colors][lightbox_ctrl_cont_bg_color][value]', $meta_array = array(), $default = '#000000'));
    $lightbox_title_color = esc_html($this->get_param('[colors_active][colors][lightbox_title_color][value]', $meta_array = array(), $default = '#FFFFFF'));
    $lightbox_ctrl_btn_color = esc_html($this->get_param('[colors_active][colors][lightbox_ctrl_btn_color][value]', $meta_array = array(), $default = '#FFFFFF'));
    $lightbox_close_rl_btn_hover_color = esc_html($this->get_param('[colors_active][colors][lightbox_close_rl_btn_hover_color][value]', $meta_array = array(), $default = '#FFFFFF'));
    $background_color = get_background_color();
  $background_image=get_background_image();
    ?>
    <style type="text/css">
  ul.dotted_navigation {
     background: <?php echo $button_background_color; ?>;
  }
  li.dotted_nav_item {  
     background: <?php echo $button_text_color; ?>;
  }
  h1, h3, h4, h5, h6, h1>a, h3>a, h4>a, h5>a, h6>a,h1 > a:link, h3 > a:link, h4 > a:link, h5 > a:link, h6 > a:link,h1 > a:hover,h3 > a:hover,h4 > a:hover,h5 > a:hover,h6 > a:hover,h61> a:visited,h3 > a:visited,h4 > a:visited,h5 > a:visited,h6 > a:visited,h2, h2>a, h2 > a:link, h2 > a:hover,h2 > a:visited{
    color:<?php echo $text_headers_color; ?>;
  }

  .bwg_slideshow_description_text,.bwg_slideshow_description_text *,.bwg_slideshow_title_text *,.bwg_slideshow_title_text{
     color:<?php echo $slider_text_color; ?>;
  }
  #right_middle_pinned *{
    color:<?php echo $pinned_post_text_color; ?>;
  }

  a:link.site-title-a,a:hover.site-title-a,a:visited.site-title-a,a.site-title-a,#logo h1{
     color:<?php echo $logo_text_color;?>;
  }
   #commentform #submit,.reply,#log-out-button, .button-color,#searchsubmit, #reply-title small  {
     color:<?php echo $button_text_color;?>;
     background-color: <?php echo $button_background_color; ?>;
  }

  #blog .content-posts .content-post{
    background-color: <?php echo $content_post_bg_color; ?>;
  }

  .read_more{
     color:<?php echo $button_background_color;?> !important;
  }

  .reply a,#reply-title small a{
     color:<?php echo $button_text_color;?> !important;
  }

  #searchsubmit{
     border: 1px solid <?php echo '#'.$this->ligther($button_background_color, 20); ?>;
     outline: 1px solid <?php echo $button_background_color; ?>;
  }

   #footer-bottom {
     background-color: <?php echo $footer_back_color; ?>;
  }
  #footer{
     border-top-color:<?php echo '#'.$this->ligther($footer_sideb_background_color, 10); ?> !important;
  }

  .footer-sidbar{
     background-color:<?php echo $footer_sideb_background_color; ?>;
  }

  body{
     color: <?php echo $primary_text_color; ?>;
  }


  #footer-bottom {
     color: <?php echo $footer_text_color; ?>;
  }

  a:link, a:visited {
     text-decoration: none;
     color: <?php echo $primary_links_color; ?>;
  }

   .top-nav-list .current-menu-item{
     color: <?php echo $menu_links_hover_color; ?> !important;
     background-color: <?php echo  $selected_menu_color; ?>;
  }

  a:hover {
     color: <?php echo $primary_links_hover_color; ?>;
  }

  .entry-meta *,.entry-meta-cat *,.entry-meta a,.entry-meta-cat a{
    color: <?php echo $meta_info_color; ?>;
  }

  #menu-button-block {
     background-color: <?php echo $menu_elem_back_color; ?>;
  }

  #blog h2.page-header:before,#blog h2.page-header{
     background-image:url('<?php echo  $background_image; ?>');
     background-color:#<?php echo $background_color; ?>;
  }

  .top-nav-list li li:hover .top-nav-list a:hover, .top-nav-list .current-menu-item a:hover,.top-nav-list li:hover,.top-nav-list li a:hover{
     background-color: <?php echo $hover_menu_item; ?>;
     color:<?php echo $menu_links_hover_color; ?> !important;
  }

  .top-nav-list li.current-menu-item, .top-nav-list li.current_page_item{
     background-color: <?php echo $selected_menu_color; ?> ;
     color: <?php echo $menu_links_hover_color; ?>;
  }
  .top-nav-list li.current-menu-item a, .top-nav-list li.current_page_item a{
     color: <?php echo $menu_links_hover_color; ?> !important;
  }

  #top-nav,#header{
    background-color:<?php echo $menu_elem_back_color; ?>;
  }
  .top-nav-list> ul > li ul, .top-nav-list > li ul  {
    background:<?php echo $menu_elem_back_color; ?>;
    border-top:2px solid <?php echo $borders_color; ?>;
  }

  #footer{
    border-bottom: 7px solid <?php echo $borders_color; ?>;
  }

  aside .sidebar-container ul li:before, #about_posts .about_post li:before{
    color:<?php echo $borders_color; ?>;
  }

  .phone .phone-menu-block {
     border-left:3px solid <?php echo $borders_color; ?>;
  }

  #menu-button-block a{
    color:<?php echo $menu_links_color; ?>; 
  }

  .phone #top-nav ul{
    background:<?php echo $menu_elem_back_color; ?> !important;
  }

  .phone #top-nav{
    background:none !important;
  }

  #sidebar1, #sidebar2 {
    background-color:<?php echo $sideb_background_color; ?>;
  }
  .commentlist li {
    background-color:<?php echo $sideb_background_color; ?>;
  }
  .children .comment{
    background-color:#<?php echo $this->ligther($sideb_background_color,37); ?>;
  }

  #respond{
    background-color:#<?php echo $this->ligther($sideb_background_color,37); ?>;
  }

  #top-nav.phone  > li  > a, #top-nav.phone  > li  > a:link, #top-nav.phone  > li  > a:visited {
    color:<?php echo $menu_links_color; ?>;
    background:<?php echo $selected_menu_color; ?>;
  }

  .top-nav-list.phone  > li:hover > a ,.top-nav-list.phone  > li  > a:hover, .top-nav-list.phone  > li  > a:focus, .top-nav-list.phone  > li  > a:active {
    color:<?php echo $menu_links_hover_color; ?> !important;
    background:<?php echo $hover_menu_item; ?> !important;
  }

  #top-page{
    background-color:<?php echo $featured_posts_color; ?>;
  }

  .top-nav-list.phone   li ul li  > a, .top-nav-list.phone   li ul li  > a:link, .top-nav-list.phone   li  ul li > a:visited {
    color:<?php echo $menu_links_color ?> !important;
  }
  .top-nav-list >ul > li > a, .top-nav-list> ul > li ul > li > a,#top-nav  div  ul  li  a, #top-nav > div > ul > li > a:link, #top-nav > div > div > ul > li > a{
    color:<?php echo $menu_links_color ?>;
  }
  .top-nav-list > li:hover > a, .top-nav-list > li ul > li > a:hover{
    color:<?php echo $menu_links_hover_color ?>;
  }
  .top-nav-list.phone   li ul li:hover  > a,.top-nav-list.phone   li ul li  > a:hover, .top-nav-list.phone   li ul li  > a:focus, .top-nav-list.phone   li ul li  > a:active {
    color:<?php echo $menu_links_hover_color; ?> !important;
    background-color:<?php echo $menu_elem_back_color; ?> !important;
  }
  .top-nav-list.phone  li.has-sub >  a, .top-nav-list.phone  li.has-sub > a:link, .top-nav-list.phone  li.has-sub >  a:visited {
    background:<?php echo $menu_elem_back_color; ?>  url(<?php echo WDWT_URL; ?>/images/arrow.menu.png) right top no-repeat !important;
  }
  .top-nav-list.phone  li.has-sub:hover > a,.top-nav-list.phone  li.has-sub > a:hover, .top-nav-list.phone  li.has-sub > a:focus, .top-nav-list.phone  li.has-sub >  a:active {
    background:<?php echo $menu_elem_back_color; ?>  url(<?php echo WDWT_URL; ?>/images/arrow.menu.png) right top no-repeat !important;
  }

  .top-nav-list.phone  li ul li.has-sub > a, .top-nav-list.phone  li ul li.has-sub > a:link, .top-nav-list.phone  li ul li.has-sub > a:visited{
    background:<?php echo $menu_elem_back_color; ?>  url(<?php echo WDWT_URL; ?>/images/arrow.menu.png) right -18px no-repeat !important;
  }
  .top-nav-list.phone  li ul li.has-sub:hover > a,.top-nav-list.phone  li ul li.has-sub > a:hover, .top-nav-list.phone  li ul li.has-sub > a:focus, .top-nav-list.phone  li ul li.has-sub > a:active {
    background:<?php echo '#'.$this->ligther($menu_elem_back_color,15); ?>  url(<?php echo WDWT_URL; ?>/images/arrow.menu.png) right -18px no-repeat !important;
  }

  .top-nav-list.phone  li.current-menu-ancestor > a:hover, .top-nav-list.phone  li.current-menu-item > a:focus, .top-nav-list.phone  li.current-menu-item > a:active{
    color:<?php echo $menu_links_color ?> !important;
    background-color:<?php echo $menu_elem_back_color; ?> !important;
  }

  .top-nav-list.phone  li.current-menu-item > a,.top-nav-list.phone  li.current-menu-item > a:visited,
  {
    color:<?php echo $primary_links_hover_color ?> !important;
    background-color:<?php echo $selected_menu_color; ?> !important;
  }

  .top-nav-list >ul > li:hover:before, #top-nav > div > ul > li:hover:before, #top-nav > div > div > ul > li:hover:before{
    background: <?php echo $borders_color ?>;
  }

  .top-nav-list.phone  li.current-menu-parent > a, .top-nav-list.phone  li.current-menu-parent > a:link, .top-nav-list.phone  li.current-menu-parent > a:visited,
  .top-nav-list.phone  li.current-menu-parent > a:hover, .top-nav-list.phone  li.current-menu-parent > a:focus, .top-nav-list.phone  li.current-menu-parent > a:active,
  .top-nav-list.phone  li.has-sub.current-menu-item  > a, .top-nav-list.phone  li.has-sub.current-menu-item > a:link, .top-nav-list.phone  li.has-sub.current-menu-item > a:visited,
  .top-nav-list.phone  li.has-sub.current-menu-ancestor > a:hover, .top-nav-list.phone  li.has-sub.current-menu-item > a:focus, .top-nav-list.phone  li.has-sub.current-menu-item > a:active,
  .top-nav-list.phone  li.current-menu-ancestor > a, .top-nav-list.phone  li.current-menu-ancestor > a:link, .top-nav-list.phone  li.current-menu-ancestor > a:visited,
  .top-nav-list.phone  li.current-menu-ancestor > a:hover, .top-nav-list.phone  li.current-menu-ancestor > a:focus, .top-nav-list.phone  li.current-menu-ancestor > a:active {
    color:<?php echo $menu_links_color ?> !important;
    background:<?php echo $menu_elem_back_color; ?>  url(<?php echo WDWT_URL; ?>/images/arrow.menu.png) right bottom no-repeat !important;
  }
  .top-nav-list.phone  li ul  li.current-menu-item > a, .top-nav-list.phone  li ul  li.current-menu-item > a:link, .top-nav-list.phone  li ul  li.current-menu-item > a:visited,
  .top-nav-list.phone  li ul  li.current-menu-ancestor > a:hover, .top-nav-list.phone  li ul  li.current-menu-item > a:focus, .top-nav-list.phone  li ul  li.current-menu-item > a:active{
    color:<?php echo $menu_links_color ?> !important;
    background-color:<?php echo '#'.$this->ligther($menu_elem_back_color,15); ?> !important;
  }
  .top-nav-list.phone li ul  li.current-menu-parent > a, .top-nav-list.phone  li ul  li.current-menu-parent > a:link, .top-nav-list.phone  li ul  li.current-menu-parent > a:visited,
  .top-nav-list.phone li ul li.current-menu-parent  > a:hover, .top-nav-list.phone  li ul  li.current-menu-parent > a:focus, .top-nav-list.phone  li ul  li.current-menu-parent > a:active,
  .top-nav-list.phone  li ul  li.has-sub.current-menu-item > a, .top-nav-list.phone  li ul  li.has-sub.current-menu-item > a:link, .top-nav-list.phone  li ul  li.has-sub.current-menu-item > a:visited,
  .top-nav-list.phone  li ul  li.has-sub.current-menu-ancestor > a:hover, .top-nav-list.phone  li ul  li.has-sub.current-menu-item > a:focus, .top-nav-list.phone  li ul  li.has-sub.current-menu-item > a:active,
  .top-nav-list.phone li ul  li.current-menu-ancestor > a, .top-nav-list.phone  li ul  li.current-menu-ancestor > a:link, .top-nav-list.phone  li ul  li.current-menu-ancestor > a:visited,
  .top-nav-list.phone li ul li.current-menu-ancestor  > a:hover, .top-nav-list.phone  li ul  li.current-menu-ancestor > a:focus, .top-nav-list.phone  li ul  li.current-menu-ancestor > a:active {
    color:<?php echo $menu_links_color ?> !important;
    background:<?php echo '#'.$this->ligther($menu_elem_back_color,15); ?>  url(<?php echo WDWT_URL; ?>/images/arrow.menu.png) right -158px no-repeat !important;
  }
    </style>
    <?php
  }

/**
 * Display logo image or text
 */

  public function logo(){
    $logo_type = $this->get_param('logo_type');
    $logo_img = esc_url(trim($this->get_param('logo_img')));
    $display_tagline = $this->get_param('display_tagline');
    if($logo_type=='image' || $logo_type=='text' || $display_tagline){
      ?>
      <div id="header-middle">  
      <?php
      if($logo_type=='image'):
      ?> 
      
        <a id="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
        <img id="site-title" src="<?php echo $logo_img; ?>" alt="<?php echo esc_attr(bloginfo( 'name' )); ?>">
        </a>
      
        <?php 
      elseif($logo_type=='text'):
        ?>
      
     
        <a id="logo"  href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
        <h1><?php echo esc_html(bloginfo( 'name' )); ?></h1>
        </a>
      
        <?php 
      endif;

      if($display_tagline){
        ?>
        <h2 class="site-tagline"><?php echo esc_html( get_bloginfo ( 'description' )); ?></h2>
      <?php
      }
      ?>
      </div>
      <?php
    }
  }

  /**
  * Prints style for menu background image
  */

  public function social_links(){
    $show_facebook_icon = $this->get_param('facebook_icon_show', false);
    $facebook_url = $this->get_param('facebook_url', false);
    $show_google_icon = $this->get_param('google_icon_show', false);
    $google_url = $this->get_param('google_url', false);
    $show_rss_icon = $this->get_param('show_rss_icon', false);
    $rss_url = $this->get_param('rss_url', false);
    $show_twitter_icon = $this->get_param('twitter_icon_show', false);
    $twitter_url = $this->get_param('twitter_url', false);
    
    $show_linkedin_icon = $this->get_param('linkedin_icon_show', false);
    $linkedin_url = $this->get_param('linkedin_url', false);
    $show_youtube_icon = $this->get_param('youtube_icon_show', false);
    $youtube_url = $this->get_param('youtube_url', false);
    $show_instagram_icon = $this->get_param('instagram_icon_show', false);
    $instagram_url = $this->get_param('instagram_url', false);
    

  if(( $show_facebook_icon==true && $facebook_url != "" ) || ( $show_google_icon==true && $google_url != "" ) || ( $show_rss_icon==true && $rss_url != "" ) || ( $show_twitter_icon==true && $twitter_url != "") || ( $show_linkedin_icon==true && $linkedin_url != "") || ( $show_youtube_icon==true && $youtube_url != "") || ( $show_instagram_icon==true && $instagram_url != "")){
  ?>
  <div id="social_icons" class="clear-div">
    <div class="social" <?php if( $show_facebook_icon==false || $facebook_url == "" ){ echo "style=\"display:none;\""; } ?>>
       <a   href="<?php if( trim($facebook_url) ) { echo esc_url($facebook_url);} else { echo "javascript:;";}?>"  target="_blank" title="Facebook">
           <div id="facebook" class="socil"><i class="fa fa-facebook"></i></div>  
       </a>
     </div>
     <div class="social" <?php if( $show_google_icon==false || $google_url == "" ) { echo "style=\"display:none;\""; } ?>>
       <a   href="<?php if( trim($google_url) ) { echo esc_url($google_url);} else { echo "javascript:;";}?>" target="_blank" title="Google Plus">
        <div id="googleplus" class="socil"><i class="fa fa-google-plus"></i></div>
       </a>
     </div>
     <div class="social" <?php if( $show_rss_icon==false || $rss_url == "" ) { echo "style=\"display:none;\""; } ?>>
       <a   href="<?php if( trim($rss_url) ) { echo esc_url($rss_url);} else { echo "javascript:;";}?>" target="_blank" title="Rss">
        <div id="rss" class="socil"><i class="fa fa-rss"></i></div>
       </a>
    </div>   
    <div class="social" <?php if( $show_twitter_icon==false || $twitter_url == ""){ echo "style=\"display:none;\""; } ?>>
       <a  href="<?php if( trim($twitter_url) ){ echo esc_url($twitter_url);} else { echo "javascript:;";}?>" target="_blank" title="Twitter">
         <div id="twitter" class="socil"><i class="fa fa-twitter"></i></div>
       </a>
    </div>
    <div class="social" <?php if( $show_linkedin_icon==false || $linkedin_url == ""){ echo "style=\"display:none;\""; } ?>>
       <a  href="<?php if( trim($linkedin_url) ){ echo esc_url($linkedin_url);} else { echo "javascript:;";}?>" target="_blank" title="LinkedIn">
         <div id="linkedin" class="socil"><i class="fa fa-linkedin"></i></div>
       </a>
    </div>
    <div class="social" <?php if( $show_youtube_icon==false || $youtube_url == ""){ echo "style=\"display:none;\""; } ?>>
       <a  href="<?php if( trim($youtube_url) ){ echo esc_url($youtube_url);} else { echo "javascript:;";}?>" target="_blank" title="Youtube">
         <div id="youtube" class="socil"><i class="fa fa-youtube"></i></div>
       </a>
    </div>
    <div class="social" <?php if( $show_instagram_icon==false || $instagram_url == ""){ echo "style=\"display:none;\""; } ?>>
       <a  href="<?php if( trim($instagram_url) ){ echo esc_url($instagram_url);} else { echo "javascript:;";}?>" target="_blank" title="Instagram">
         <div id="instagram" class="socil"><i class="fa fa-instagram"></i></div>
       </a>
    </div>
    <?php do_action('business_world_more_social_links'); ?>
  </div> 
   
  <?php
  }
  }
  

function service_page($showthumb,$grab_image){
global $wdwt_front;
?>
  <div class="service_post clear-div">  
    <?php                 
        if (!isset($showthumb) || $showthumb!=true) { 
              if ( has_post_thumbnail() || (Business_world_frontend_functions::post_image_url()  && $wdwt_front->grab_image())) {   ?>
        <div class="image-block">
          <?php echo Business_world_frontend_functions::fixed_thumbnail(80,80,$wdwt_front->grab_image()); ?>
        </div>
     <?php  }       
        } ?>
    <h3>
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h3>                                       
    <p>
      <?php Business_world_frontend_functions::the_excerpt_max_charlength(30); ?>
    </p>                                
  </div>
<?php
}






} /*end of class*/


   

