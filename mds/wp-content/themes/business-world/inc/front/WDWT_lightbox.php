<?php

class WDWT_Lightbox {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  private $params;
  private $images;
  private $titles;
  private $descrs;

  private $current_index;
  private $theme_row = array(
      'lightbox_bg_color' => '000000',//ttt
      'lightbox_close_btn_border_radius' => '0px',
      'lightbox_close_btn_color' => 'ff0000',//ttt lightbox_ctrl_btn_color
      'lightbox_close_btn_bg_color' => '000000',//ttt lightbox_bg_color
      'lightbox_close_btn_height' => 20,
      'lightbox_close_btn_size' => 15,
      'lightbox_close_btn_border_width' => 1,
      'lightbox_close_btn_border_style' => 'none',
      'lightbox_close_btn_border_color' => '000000',
      'lightbox_close_btn_box_shadow' => 'none',
      'lightbox_close_btn_right' => 0,
      'lightbox_close_btn_top' => 0,
      'lightbox_close_btn_width' => 20,
      'lightbox_close_btn_full_color' => 'ffff00', //ttt lightbox_ctrl_btn_color
      'lightbox_close_btn_transparent' => 50,
      'lightbox_close_rl_btn_hover_color' => '00ffff', //ttt
      'lightbox_ctrl_cont_bg_color' => 'ffffff',      //ttt
      'lightbox_ctrl_btn_align' => 'center',
      'lightbox_ctrl_btn_color' => 'ff0000', //ttt 
      'lightbox_ctrl_btn_height' => 24,
      'lightbox_ctrl_btn_margin_top' => 2,
      'lightbox_ctrl_btn_transparent'=> 100,
      'lightbox_ctrl_btn_pos' => 'bottom',
      'lightbox_ctrl_cont_border_radius' => '12px',
      'lightbox_ctrl_cont_transparent' => 50,
      'lightbox_info_bg_color'=>'cccccc', //ttt lightbox_ctrl_cont_bg_color
      'lightbox_info_bg_transparent' => 30,
      'lightbox_info_align' => 'center',
      'lightbox_info_margin' => 5,
      'lightbox_info_padding' => '18px',
      'lightbox_info_pos' => 'top',
      'lightbox_info_border_width' => 1,
      'lightbox_info_border_style' => 'none',
      'lightbox_info_border_color' => '00ff33',
      'lightbox_info_border_radius' => '8px',
      'lightbox_rl_btn_bg_color'=> '666666', //ttt lightbox_ctrl_cont_bg_color
      'lightbox_rl_btn_border_radius'=> '20px',
      'lightbox_rl_btn_border_width'=>1,
      'lightbox_rl_btn_border_color'=> '0000ff',
      'lightbox_rl_btn_border_style' => 'none',
      'lightbox_rl_btn_box_shadow' => 'none',
      'lightbox_rl_btn_color' => 'fff055', //ttt lightbox_ctrl_btn_color
      'lightbox_rl_btn_height' => 40,
      'lightbox_rl_btn_width' => 40,
      'lightbox_rl_btn_size' => 18,
      'lightbox_rl_btn_transparent' => 60,
      'lightbox_title_color' => '00cccc', //ttt
      'lightbox_title_font_style' => 'sans-serif',
      'lightbox_title_font_size' => '20',
      'lightbox_title_font_weight' => 400,
      'lightbox_toggle_btn_height' => 10,
      'lightbox_toggle_btn_width' => 30,
      'lightbox_description_font_style' => 'monospace',
      'lightbox_description_font_size' => 18,
      'lightbox_description_font_weight' => 500,
    );





  private $wdwt_front;   
    
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct() {
    global $wdwt_options;
    require_once('front_params_output.php');
    $this->wdwt_front = new Business_world_front($wdwt_options);  
    /*get images and current image*/
    $images = $_POST['imgs'];
    $img_titles = $_POST['titles'];
    $img_descrs = $_POST['descrs'];
    $current = $_POST['cur'];
    $this->images = json_decode(stripcslashes ($images), true);
    $this->titles = json_decode(stripcslashes ($img_titles), true);
    $this->descrs = json_decode(stripcslashes ($img_descrs), true);
    $this->current_index = intval($current);
    

    $this->params['slideshow_interval'] = 5;
    $this->params['image_width'] = 700;
    $this->params['image_height'] = 500;
    $img_eff = array('fade');
    $this->params['image_effect'] = $img_eff[0];
    $this->params['enable_image_fullscreen'] = true;
    $this->params['open_with_fullscreen']= false;
    $this->params['enable_image_ctrl_btn'] = true;
    $this->params['open_with_autoplay'] = false;
    $this->params['image_right_click'] = false;
    $this->params['popup_enable_info'] = true;
    $this->params['popup_info_full_width'] = true;
    $this->params['popup_info_always_show'] = false;
    $this->params['popup_enable_fullsize_image'] = false;
    $this->params['preload_images'] = true;
    $this->params['preload_images_count'] = 6;
    
    $lbox_info_position = array('right-top');
    $lbox_info_position_array = explode('-', $lbox_info_position[0]);
    $lbox_info_horiz = isset($lbox_info_position_array[0]) ? $lbox_info_position_array[0] : 'right';
    $lbox_info_vert = isset($lbox_info_position_array[1]) ? $lbox_info_position_array[1] : 'top';
  
    $this->theme_row['lightbox_info_align'] = $lbox_info_horiz;
    $this->theme_row['lightbox_info_pos'] = $lbox_info_vert;
    /*colors*/
    $this->theme_row['lightbox_bg_color'] = $this->wdwt_front->get_param('[colors_active][colors][lightbox_bg_color][value]' , $meta_array = array(), $default = '#000000');
    $this->theme_row['lightbox_close_btn_bg_color'] = $this->theme_row['lightbox_bg_color'];

    $this->theme_row['lightbox_ctrl_btn_color'] = $this->wdwt_front->get_param('[colors_active][colors][lightbox_ctrl_btn_color][value]' , $meta_array = array(), $default = '#f7a900');
    $this->theme_row['lightbox_close_btn_full_color'] = $this->theme_row['lightbox_ctrl_btn_color'];
    $this->theme_row['lightbox_close_btn_color'] = $this->theme_row['lightbox_ctrl_btn_color'];
    $this->theme_row['lightbox_rl_btn_color'] = $this->theme_row['lightbox_ctrl_btn_color'];
    
    $this->theme_row['lightbox_ctrl_cont_bg_color'] = $this->wdwt_front->get_param('[colors_active][colors][lightbox_ctrl_cont_bg_color][value]' , $meta_array = array(), $default = '#cccccc');
    $this->theme_row['lightbox_info_bg_color'] = $this->theme_row['lightbox_ctrl_cont_bg_color'];
    $this->theme_row['lightbox_rl_btn_bg_color'] = $this->theme_row['lightbox_ctrl_cont_bg_color'];

    $this->theme_row['lightbox_title_color'] = $this->wdwt_front->get_param('[colors_active][colors][lightbox_title_color][value]' , $meta_array = array(), $default = '#f2c037');
    $this->theme_row['lightbox_close_rl_btn_hover_color'] = $this->wdwt_front->get_param('[colors_active][colors][lightbox_close_rl_btn_hover_color][value]' , $meta_array = array(), $default = '#6b4000');
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////


public function view() {
    extract($this->params);

    $bwg = 0;
    $current_image_id = $this->current_index;

    $theme_row = $this->theme_row;
    $image_rows = $this->images;
    $title_rows = $this->titles;
    $descr_rows = $this->descrs;

  
    $rgb_lbox_image_info_bg_color = $this->wdwt_front->hex2rgb($theme_row['lightbox_info_bg_color']);
    $rgb_lightbox_ctrl_cont_bg_color = $this->wdwt_front->hex2rgb($theme_row['lightbox_ctrl_cont_bg_color']);

    ?>
    <style>
      .spider_popup_wrap * {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
      }
      .spider_popup_wrap {
        background-color: <?php echo $theme_row['lightbox_bg_color']; ?>;
        display: inline-block;
        left: 50%;
        outline: medium none;
        position: fixed;
        text-align: center;
        top: 50%;
        z-index: 100000;
      }
      .lbox_popup_image {
        max-width: <?php echo $image_width; ?>px;
        max-height: <?php echo $image_height; ?>px;
        vertical-align: middle;
        display: inline-block;
      }
      .phone .lbox_ctrl_btn,
      .tablet .lbox_ctrl_btn {
        font-size: <?php echo $theme_row['lightbox_ctrl_btn_height']+10; ?>px;
      }
      .lbox_ctrl_btn {
        color: <?php echo $theme_row['lightbox_ctrl_btn_color']; ?>;
        font-size: <?php echo $theme_row['lightbox_ctrl_btn_height']; ?>px;
        margin: <?php echo $theme_row['lightbox_ctrl_btn_margin_top']; ?>px;
        padding: 0 5px;
        opacity: <?php echo number_format($theme_row['lightbox_ctrl_btn_transparent'] / 100, 2, ".", ""); ?>;
        filter: Alpha(opacity=<?php echo $theme_row['lightbox_ctrl_btn_transparent']; ?>);
      }
      .lbox_toggle_btn {
        color: <?php echo $theme_row['lightbox_ctrl_btn_color'] ?>;
        font-size: <?php echo $theme_row['lightbox_toggle_btn_height']; ?>px;
        margin: 0;
        opacity: <?php echo number_format($theme_row['lightbox_ctrl_btn_transparent'] / 100, 2, ".", ""); ?>;
        filter: Alpha(opacity=<?php echo $theme_row['lightbox_ctrl_btn_transparent']; ?>);
        padding: 0;
      }
      .lbox_btn_container {
        bottom: 0;
        left: 0;
        overflow: hidden;
        position: absolute;
        right: 0;
        top: 0;
      }
      .phone .lbox_ctrl_btn_container,
      .tablet .lbox_ctrl_btn_container {
        height: <?php echo $theme_row['lightbox_ctrl_btn_height'] + 2 * $theme_row['lightbox_ctrl_btn_margin_top'] + 10; ?>px;
      }

      .lbox_ctrl_btn_container {
        background-color: rgba(<?php echo $rgb_lightbox_ctrl_cont_bg_color['red']; ?>, <?php echo $rgb_lightbox_ctrl_cont_bg_color['green']; ?>, <?php echo $rgb_lightbox_ctrl_cont_bg_color['blue']; ?>, <?php echo number_format($theme_row['lightbox_ctrl_cont_transparent'] / 100, 2, ".", ""); ?>);
        /*background: none repeat scroll 0 0 #<?php echo $theme_row['lightbox_ctrl_cont_bg_color']; ?>;*/
        <?php
        if ($theme_row['lightbox_ctrl_btn_pos'] == 'top') {
          ?>
          border-bottom-left-radius: <?php echo $theme_row['lightbox_ctrl_cont_border_radius']; ?>px;
          border-bottom-right-radius: <?php echo $theme_row['lightbox_ctrl_cont_border_radius']; ?>px;
          <?php
        }
        else {
          ?>
          bottom: 0;
          border-top-left-radius: <?php echo $theme_row['lightbox_ctrl_cont_border_radius']; ?>px;
          border-top-right-radius: <?php echo $theme_row['lightbox_ctrl_cont_border_radius']; ?>px;
          <?php
        }?>
        height: <?php echo $theme_row['lightbox_ctrl_btn_height'] + 2 * $theme_row['lightbox_ctrl_btn_margin_top']; ?>px;
        /*opacity: <?php echo number_format($theme_row['lightbox_ctrl_cont_transparent'] / 100, 2, ".", ""); ?>;
        filter: Alpha(opacity=<?php echo $theme_row['lightbox_ctrl_cont_transparent']; ?>);*/
        position: absolute;
        text-align: <?php echo $theme_row['lightbox_ctrl_btn_align']; ?>;
        width: 100%;
        z-index: 10150;
      }
      .lbox_toggle_container {
        background: none repeat scroll 0 0 <?php echo $theme_row['lightbox_ctrl_cont_bg_color']; ?>;
        <?php
        if ($theme_row['lightbox_ctrl_btn_pos'] == 'top') {
          ?>
          border-bottom-left-radius: <?php echo $theme_row['lightbox_ctrl_cont_border_radius']; ?>px;
          border-bottom-right-radius: <?php echo $theme_row['lightbox_ctrl_cont_border_radius']; ?>px;
          top: <?php echo $theme_row['lightbox_ctrl_btn_height'] + 2 * $theme_row['lightbox_ctrl_btn_margin_top']; ?>px;
          <?php
        }
        else {
          ?>
          border-top-left-radius: <?php echo $theme_row['lightbox_ctrl_cont_border_radius']; ?>px;
          border-top-right-radius: <?php echo $theme_row['lightbox_ctrl_cont_border_radius']; ?>px;
          bottom: <?php echo $theme_row['lightbox_ctrl_btn_height'] + 2 * $theme_row['lightbox_ctrl_btn_margin_top']; ?>px;
          <?php
        }?>
        cursor: pointer;
        left: 50%;
        line-height: 0;
        margin-left: -<?php echo $theme_row['lightbox_toggle_btn_width'] / 2; ?>px;
        opacity: <?php echo number_format($theme_row['lightbox_ctrl_cont_transparent'] / 100, 2, ".", ""); ?>;
        filter: Alpha(opacity=<?php echo $theme_row['lightbox_ctrl_cont_transparent']; ?>);
        position: absolute;
        text-align: center;
        width: <?php echo $theme_row['lightbox_toggle_btn_width']; ?>px;
        z-index: 10150;
      }
      .lbox_close_btn {
        opacity: <?php echo number_format($theme_row['lightbox_close_btn_transparent'] / 100, 2, ".", ""); ?>;
        filter: Alpha(opacity=<?php echo $theme_row['lightbox_close_btn_transparent']; ?>);
      }
      .spider_popup_close {
        border-radius: <?php echo $theme_row['lightbox_close_btn_border_radius']; ?>;
        border: <?php echo $theme_row['lightbox_close_btn_border_width']; ?>px <?php echo $theme_row['lightbox_close_btn_border_style']; ?> <?php echo $theme_row['lightbox_close_btn_border_color']; ?>;
        box-shadow: <?php echo $theme_row['lightbox_close_btn_box_shadow']; ?>;
        color: <?php echo $theme_row['lightbox_close_btn_color']; ?>;
        height: <?php echo $theme_row['lightbox_close_btn_height']; ?>px;
        font-size: <?php echo $theme_row['lightbox_close_btn_size']; ?>px;
        right: <?php echo $theme_row['lightbox_close_btn_right']; ?>px;
        top: <?php echo $theme_row['lightbox_close_btn_top']; ?>px;
        width: <?php echo $theme_row['lightbox_close_btn_width']; ?>px;
      }
      .spider_popup_close_fullscreen {
        color: <?php echo $theme_row['lightbox_close_btn_full_color']; ?>;
        font-size: <?php echo $theme_row['lightbox_close_btn_size']; ?>px;
        right: 15px;
      }
      .spider_popup_close span,
      #spider_popup_left-ico span,
      #spider_popup_right-ico span {
        display: table-cell;
        text-align: center;
        vertical-align: middle;
      }
      #spider_popup_left-ico,
      #spider_popup_right-ico {
        background-color: <?php echo $theme_row['lightbox_rl_btn_bg_color']; ?>;
        border-radius: <?php echo $theme_row['lightbox_rl_btn_border_radius']; ?>;
        border: <?php echo $theme_row['lightbox_rl_btn_border_width']; ?>px <?php echo $theme_row['lightbox_rl_btn_border_style']; ?> <?php echo $theme_row['lightbox_rl_btn_border_color']; ?>;
        box-shadow: <?php echo $theme_row['lightbox_rl_btn_box_shadow']; ?>;
        color: <?php echo $theme_row['lightbox_rl_btn_color']; ?>;
        height: <?php echo $theme_row['lightbox_rl_btn_height']; ?>px;
        font-size: <?php echo $theme_row['lightbox_rl_btn_size']; ?>px;
        width: <?php echo $theme_row['lightbox_rl_btn_width']; ?>px;
        opacity: <?php echo number_format($theme_row['lightbox_rl_btn_transparent'] / 100, 2, ".", ""); ?>;
        filter: Alpha(opacity=<?php echo $theme_row['lightbox_rl_btn_transparent']; ?>);
      }
      .lbox_ctrl_btn:hover,
      .lbox_toggle_btn:hover,
      .spider_popup_close:hover,
      .spider_popup_close_fullscreen:hover,
      #spider_popup_left-ico:hover,
      #spider_popup_right-ico:hover {
        color: <?php echo $theme_row['lightbox_close_rl_btn_hover_color']; ?>;
        cursor: pointer;
      }
      .lbox_image_wrap {
        height: inherit;
        display: table;
        position: absolute;
        text-align: center;
        width: inherit;
      }
      .lbox_image_wrap * {
        -moz-user-select: none;
        -khtml-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      .lbox_ctrl_btn_container a,
      .lbox_ctrl_btn_container a:hover {
        text-decoration: none;
      }
      .lbox_image_container {
        display: table;
        position: absolute;
        text-align: center;
        vertical-align: middle;
        width: 100%;
      }      
      
      .lbox_none_selectable {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      .lbox_slide_container {
        display: table-cell;
        position: absolute;
        vertical-align: middle;
        width:100%;
        height:100%;
      }
      .lbox_slide_bg {
        margin: 0 auto;
        width: inherit;
        height: inherit;
      }
      .lbox_slider {
        height: inherit;
        width: inherit;
      }
      .lbox_popup_image_spun {
        height: inherit;
        display: table-cell;
        filter: Alpha(opacity=100);
        opacity: 1;
        position: absolute;
        vertical-align: middle;
        width: inherit;
        z-index: 2;
      }
      .lbox_popup_image_second_spun {
        width: inherit;
        height: inherit;
        display: table-cell;
        filter: Alpha(opacity=0);
        opacity: 0;
        position: absolute;
        vertical-align: middle;
        z-index: 1;
      }
      .lbox_grid {
        display: none;
        height: 100%;
        overflow: hidden;
        position: absolute;
        width: 100%;
      }
      .lbox_gridlet {
        opacity: 1;
        filter: Alpha(opacity=100);
        position: absolute;
      }
      .lbox_image_info_container1 {
        display: <?php echo $popup_info_always_show ? 'table-cell' : 'none'; ?>;
      }
      .lbox_image_info_spun {
        text-align: <?php echo $theme_row['lightbox_info_align']; ?>;
        vertical-align: <?php echo $theme_row['lightbox_info_pos']; ?>;
      }
      .lbox_image_info {
        background: rgba(<?php echo $rgb_lbox_image_info_bg_color['red']; ?>, <?php echo $rgb_lbox_image_info_bg_color['green']; ?>, <?php echo $rgb_lbox_image_info_bg_color['blue']; ?>, <?php echo number_format($theme_row['lightbox_info_bg_transparent'] / 100, 2, ".", ""); ?>);
        border: <?php echo $theme_row['lightbox_info_border_width']; ?>px <?php echo $theme_row['lightbox_info_border_style']; ?> <?php echo $theme_row['lightbox_info_border_color']; ?>;
        border-radius: <?php echo $theme_row['lightbox_info_border_radius']; ?>;
        <?php echo ( $theme_row['lightbox_ctrl_btn_pos'] == 'bottom' && $theme_row['lightbox_info_pos'] == 'bottom') ? 'bottom: ' . ($theme_row['lightbox_ctrl_btn_height'] + 2 * $theme_row['lightbox_ctrl_btn_margin_top']) . 'px;' : '' ?>
        <?php if($popup_info_full_width) { ?>
    width: 100%;
    <?php } else { ?>
    margin: <?php echo $theme_row['lightbox_info_margin']; ?>;
    <?php } ?>
        padding: <?php echo $theme_row['lightbox_info_padding']; ?>;
        <?php echo ($theme_row['lightbox_ctrl_btn_pos'] == 'top' && $theme_row['lightbox_info_pos'] == 'top') ? 'top: ' . ($theme_row['lightbox_ctrl_btn_height'] + 2 * $theme_row['lightbox_ctrl_btn_margin_top']) . 'px;' : '' ?>
      }
      .lbox_image_title,
      .lbox_image_title * {
        color: <?php echo $theme_row['lightbox_title_color']; ?> !important;
        font-family: <?php echo $theme_row['lightbox_title_font_style']; ?>;
        font-size: <?php echo $theme_row['lightbox_title_font_size']; ?>px;
        font-weight: <?php echo $theme_row['lightbox_title_font_weight']; ?>;
      }
      .lbox_image_description,
      .lbox_image_description * {
        font-family: <?php echo $theme_row['lightbox_description_font_style']; ?>;
        font-size: <?php echo $theme_row['lightbox_description_font_size']; ?>px;
        font-weight: <?php echo $theme_row['lightbox_description_font_weight']; ?>;
      }
      @media (max-width: 480px) {
        .lbox_image_title,
        .lbox_image_title * {
          font-size: 12px;
        }
        .lbox_image_description,
        .lbox_image_description * {
          font-size: 10px;
        }
      }
    </style>
    <script>
      var data = [];
      var event_stack = [];
      <?php
      $image_id_exist = FALSE;
      foreach ($image_rows as $key => $image_row) {
        
        if ($key == $current_image_id) {
          $current_image_alt = isset($title_rows[$key]) ? $title_rows[$key] : "" ;
          $current_image_description = isset($descr_rows[$key]) ? $descr_rows[$key] : "" ;
          $current_image_url = '';
          $current_thumb_url = '';
          $current_filetype = '';
          $image_id_exist = TRUE;
        }
        ?>
        data["<?php echo $key; ?>"] = [];
        data["<?php echo $key; ?>"]["number"] = <?php echo $key + 1; ?>;
        data["<?php echo $key; ?>"]["id"] = "";
        data["<?php echo $key; ?>"]["alt"] = "<?php echo esc_attr(isset($title_rows[$key]) ? $title_rows[$key] : '' ); ?>" ;
        data["<?php echo $key; ?>"]["description"] = "<?php echo esc_attr(isset($descr_rows[$key]) ? str_replace(array('\r\n', '\n', '\r'), esc_html('<br />'), $descr_rows[$key]) : '' ); ?>" ;
        data["<?php echo $key; ?>"]["image_url"] = "<?php echo $image_row; ?>";
        data["<?php echo $key; ?>"]["thumb_url"] = "";
        data["<?php echo $key; ?>"]["date"] = "";
        <?php
      }
      ?>
    </script>

    <?php
    if (!$image_id_exist) {
      echo '<div style="width:99%"><div class="error"><p><strong>' . __('The image has been deleted.', "business-world") . '</strong></p></div></div>';
      die();
    }
    ?>

    <div class="lbox_image_wrap">
      <?php
      if ($enable_image_ctrl_btn || $enable_image_fullscreen) {
      ?>
      <div class="lbox_btn_container">
        <div class="lbox_ctrl_btn_container">
          <?php
          if ($enable_image_ctrl_btn) {
            ?>
          <i title="<?php esc_attr_e('Play', "business-world"); ?>" class="lbox_ctrl_btn lbox_play_pause fa fa-play"></i>
          <?php
          }
          if ($enable_image_fullscreen) {
            if (!$open_with_fullscreen) {
          ?>
          <i title="<?php esc_attr_e('Maximize', "business-world"); ?>" class="lbox_ctrl_btn lbox_resize-full fa fa-resize-full "></i>
          <?php
          }
          ?>
          <i title="<?php echo esc_attr_e('Fullscreen', "business-world"); ?>" class="lbox_ctrl_btn lbox_fullscreen fa fa-fullscreen"></i>
          <?php } 
          if ($popup_enable_info) { ?>
          <i title="<?php echo esc_attr_e('Show info', "business-world"); ?>" class="lbox_ctrl_btn lbox_info fa fa-info"></i>
          <?php
          }
          if ($popup_enable_fullsize_image) {
            ?>
            <a id="lbox_fullsize_image" href="<?php echo $current_image_url; ?>" target="_blank">
              <i title="<?php echo esc_attr_e('Open image in original size.', "business-world"); ?>" class="lbox_ctrl_btn fa fa-external-link"></i>
            </a>
            <?php
          }
          ?>
        </div>
        <div class="lbox_toggle_container">
          <i class="lbox_toggle_btn fa <?php echo (($theme_row['lightbox_ctrl_btn_pos'] == 'top') ? 'fa-angle-up' : 'fa-angle-down'); ?>"></i>
        </div>
      </div>
      <?php
      }
      $current_pos = 0;
      
      ?>
      <div id="lbox_image_container" class="lbox_image_container">
        <div class="lbox_image_info_container1">
          <div class="lbox_image_info_container2">
            <span class="lbox_image_info_spun">
              <div class="lbox_image_info" <?php if(trim($current_image_alt) == '' && trim($current_image_description) == '') { echo 'style="background:none;"'; } ?>>
                <div class="lbox_image_title"><?php echo html_entity_decode($current_image_alt); ?></div>
                <div class="lbox_image_description"><?php echo html_entity_decode($current_image_description); ?></div>
              </div>
            </span>
          </div>
        </div>
        <div class="lbox_slide_container">
          <div class="lbox_slide_bg">
            <div class="lbox_slider">
          <?php
          $current_key = -6;
          foreach ($image_rows as $key => $image_row) {
            
            if ($key == $current_image_id) {
              $current_key = $key;
              ?>
              <span class="lbox_popup_image_spun" id="lbox_popup_image" image_id="<?php echo $key; ?>">
                <span class="lbox_popup_image_spun1" style="display: table; width: inherit; height: inherit;">
                  <span class="lbox_popup_image_spun2" style="display: table-cell; vertical-align: middle; text-align: center;">
                    <img class="lbox_popup_image" src="<?php echo $image_row; ?>" alt="" />
                  </span>
                </span>
              </span>
              <span class="lbox_popup_image_second_spun">                
              </span>
              <input type="hidden" id="lbox_current_image_key" value="<?php echo $key; ?>" />
              <?php
              break;
            }
          }
          ?>
            </div>
          </div>
        </div>
        <a id="spider_popup_left"><span id="spider_popup_left-ico"><span><i class="lbox_prev_btn fa fa-chevron-left"></i></span></span></a>
        <a id="spider_popup_right"><span id="spider_popup_right-ico"><span><i class="lbox_next_btn fa fa-chevron-right"></i></span></span></a>
      </div>
    </div>
    <a class="spider_popup_close" onclick="wdwt_lbox.destroypopup(1000); return false;" ontouchend="wdwt_lbox.destroypopup(1000); return false;"><span><i class="lbox_close_btn fa fa-times"></i></span></a>

    <script>
      var lbox_trans_in_progress = false;
      var lbox_transition_duration = <?php echo (($slideshow_interval < 4) && ($slideshow_interval != 0)) ? ($slideshow_interval * 1000) / 4 : 800; ?>;
      var lbox_playInterval;
      if ((jQuery("#spider_popup_wrap").width() >= jQuery(window).width()) || (jQuery("#spider_popup_wrap").height() >= jQuery(window).height())) {
        jQuery(".spider_popup_close").attr("class", "lbox_ctrl_btn spider_popup_close_fullscreen");
      }
      /* Stop autoplay.*/
      window.clearInterval(lbox_playInterval);
      
      
      var lbox_current_key = '<?php echo $current_key; ?>';
      
      function lbox_testBrowser_cssTransitions() {
        return lbox_testDom('Transition');
      }
      function lbox_testBrowser_cssTransforms3d() {
        return lbox_testDom('Perspective');
      }
      function lbox_testDom(prop) {
        /* Browser vendor CSS prefixes.*/
        var browserVendors = ['', '-webkit-', '-moz-', '-ms-', '-o-', '-khtml-'];
        /* Browser vendor DOM prefixes.*/
        var domPrefixes = ['', 'Webkit', 'Moz', 'ms', 'O', 'Khtml'];
        var i = domPrefixes.length;
        while (i--) {
          if (typeof document.body.style[domPrefixes[i] + prop] !== 'undefined') {
            return true;
          }
        }
        return false;
      }


      function lbox_cube(tz, ntx, nty, nrx, nry, wrx, wry, current_image_class, next_image_class, direction) {
        /* If browser does not support 3d transforms/CSS transitions.*/
        if (!lbox_testBrowser_cssTransitions()) {
          return lbox_fallback(current_image_class, next_image_class, direction);
        }
        if (!lbox_testBrowser_cssTransforms3d()) {
          return lbox_fallback3d(current_image_class, next_image_class, direction);
        }
        lbox_trans_in_progress = true;
        /* Set active thumbnail.*/
        jQuery(".lbox_slide_bg").css('perspective', 1000);
        jQuery(current_image_class).css({
          transform : 'translateZ(' + tz + 'px)',
          backfaceVisibility : 'hidden'
        });
        jQuery(next_image_class).css({
          opacity : 1,
          filter: 'Alpha(opacity=100)',
          backfaceVisibility : 'hidden',
          transform : 'translateY(' + nty + 'px) translateX(' + ntx + 'px) rotateY('+ nry +'deg) rotateX('+ nrx +'deg)'
        });
        jQuery(".lbox_slider").css({
          transform: 'translateZ(-' + tz + 'px)',
          transformStyle: 'preserve-3d'
        });
        /* Execution steps.*/
        setTimeout(function () {
          jQuery(".lbox_slider").css({
            transition: 'all ' + lbox_transition_duration + 'ms ease-in-out',
            transform: 'translateZ(-' + tz + 'px) rotateX('+ wrx +'deg) rotateY('+ wry +'deg)'
          });
        }, 20);
        /* After transition.*/
        jQuery(".lbox_slider").one('webkitTransitionEnd transitionend otransitionend oTransitionEnd mstransitionend', jQuery.proxy(lbox_after_trans));
        function lbox_after_trans() {
          jQuery(current_image_class).removeAttr('style');
          jQuery(next_image_class).removeAttr('style');
          jQuery(".lbox_slider").removeAttr('style');
          jQuery(current_image_class).css({'opacity' : 0, filter: 'Alpha(opacity=0)', 'z-index': 1});
          jQuery(next_image_class).css({'opacity' : 1, filter: 'Alpha(opacity=100)', 'z-index' : 2});
          
          lbox_trans_in_progress = false;
          jQuery(current_image_class).html('');   
          if (typeof event_stack !== 'undefined' && event_stack.length > 0) {
            key = event_stack[0].split("-");
            event_stack.shift();
            lbox_change_image(key[0], key[1], data, true);
          }
        }
      }
      function lbox_cubeH(current_image_class, next_image_class, direction) {
        /* Set to half of image width.*/
        var dimension = jQuery(current_image_class).width() / 2;
        if (direction == 'right') {
          lbox_cube(dimension, dimension, 0, 0, 90, 0, -90, current_image_class, next_image_class, direction);
        }
        else if (direction == 'left') {
          lbox_cube(dimension, -dimension, 0, 0, -90, 0, 90, current_image_class, next_image_class, direction);
        }
      }
      function lbox_cubeV(current_image_class, next_image_class, direction) {
        /* Set to half of image height.*/
        var dimension = jQuery(current_image_class).height() / 2;
        /* If next slide.*/
        if (direction == 'right') {
          lbox_cube(dimension, 0, -dimension, 90, 0, -90, 0, current_image_class, next_image_class, direction);
        }
        else if (direction == 'left') {
          lbox_cube(dimension, 0, dimension, -90, 0, 90, 0, current_image_class, next_image_class, direction);
        }
      }
      /* For browsers that does not support transitions.*/
      function lbox_fallback(current_image_class, next_image_class, direction) {
        lbox_fade(current_image_class, next_image_class, direction);
      }
      /* For browsers that support transitions, but not 3d transforms (only used if primary transition makes use of 3d-transforms).*/
      function lbox_fallback3d(current_image_class, next_image_class, direction) {
        lbox_sliceV(current_image_class, next_image_class, direction);
      }
      function lbox_none(current_image_class, next_image_class, direction) {
        jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
        jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
        lbox_trans_in_progress = false; 
        jQuery(current_image_class).html(''); 
      }
      function lbox_fade(current_image_class, next_image_class, direction) {
        if (lbox_testBrowser_cssTransitions()) {
          jQuery(next_image_class).css('transition', 'opacity ' + lbox_transition_duration + 'ms linear');
          jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
          jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
        }
        else {
          jQuery(current_image_class).animate({'opacity' : 0, 'z-index' : 1}, lbox_transition_duration);
          jQuery(next_image_class).animate({
              'opacity' : 1,
              'z-index': 2
            }, {
              duration: lbox_transition_duration,
              complete: function () { 

                lbox_trans_in_progress = false;  
                jQuery(current_image_class).html('');}
            });
          /* For IE.*/
          jQuery(current_image_class).fadeTo(lbox_transition_duration, 0);
          jQuery(next_image_class).fadeTo(lbox_transition_duration, 1);
        }
      }

      function lbox_grid(cols, rows, ro, tx, ty, sc, op, current_image_class, next_image_class, direction) {
        /* If browser does not support CSS transitions.*/
        if (!lbox_testBrowser_cssTransitions()) {
          return lbox_fallback(current_image_class, next_image_class, direction);
        }
        lbox_trans_in_progress = true;
        /* The time (in ms) added to/subtracted from the delay total for each new gridlet.*/
        var count = (lbox_transition_duration) / (cols + rows);
        
        /* Gridlet creator (divisions of the image grid, positioned with background-images to replicate the look of an entire slide image when assembled)*/
        function lbox_gridlet(width, height, top, img_top, left, img_left, src, imgWidth, imgHeight, c, r) {
          var delay = (c + r) * count;
          /* Return a gridlet elem with styles for specific transition.*/
          return jQuery('<div class="lbox_gridlet" />').css({
            width : width,
            height : height,
            top : top,
            left : left,
            backgroundImage : 'url("' + src + '")',
            backgroundColor: jQuery(".spider_popup_wrap").css("background-color"),
            /*backgroundColor: 'rgba(0, 0, 0, 0)',*/
            backgroundRepeat: 'no-repeat',
            backgroundPosition : img_left + 'px ' + img_top + 'px',
            backgroundSize : imgWidth + 'px ' + imgHeight + 'px',
            transition : 'all ' + lbox_transition_duration + 'ms ease-in-out ' + delay + 'ms',
            transform : 'none'
          });
        }
        /* Get the current slide's image.*/
        var cur_img = jQuery(current_image_class).find('img');
        /* Create a grid to hold the gridlets.*/
        var grid = jQuery('<div />').addClass('lbox_grid');
        /* Prepend the grid to the next slide (i.e. so it's above the slide image).*/
        jQuery(current_image_class).prepend(grid);
        /* Vars to calculate positioning/size of gridlets.*/
        var cont = jQuery(".lbox_slide_bg");
        var imgWidth = cur_img.width();
        var imgHeight = cur_img.height();
        var contWidth = cont.width(),
            contHeight = cont.height(),
            colWidth = Math.floor(contWidth / cols),
            rowHeight = Math.floor(contHeight / rows),
            colRemainder = contWidth - (cols * colWidth),
            colAdd = Math.ceil(colRemainder / cols),
            rowRemainder = contHeight - (rows * rowHeight),
            rowAdd = Math.ceil(rowRemainder / rows),
            leftDist = 0,
            img_leftDist = Math.ceil((jQuery(".lbox_slide_bg").width() - cur_img.width()) / 2);
      var imgSrc = typeof cur_img.attr('src')=='undefined' ? '' :cur_img.attr('src');
        /* tx/ty args can be passed as 'auto'/'min-auto' (meaning use slide width/height or negative slide width/height).*/
        tx = tx === 'auto' ? contWidth : tx;
        tx = tx === 'min-auto' ? - contWidth : tx;
        ty = ty === 'auto' ? contHeight : ty;
        ty = ty === 'min-auto' ? - contHeight : ty;
        /* Loop through cols.*/
        for (var i = 0; i < cols; i++) {
          var topDist = 0,
              img_topDst = Math.floor((jQuery(".lbox_slide_bg").height() - cur_img.height()) / 2),
              newColWidth = colWidth;
          /* If imgWidth (px) does not divide cleanly into the specified number of cols, adjust individual col widths to create correct total.*/
          if (colRemainder > 0) {
            var add = colRemainder >= colAdd ? colAdd : colRemainder;
            newColWidth += add;
            colRemainder -= add;
          }
          /* Nested loop to create row gridlets for each col.*/
          for (var j = 0; j < rows; j++)  {
            var newRowHeight = rowHeight,
                newRowRemainder = rowRemainder;
            /* If contHeight (px) does not divide cleanly into the specified number of rows, adjust individual row heights to create correct total.*/
            if (newRowRemainder > 0) {
              add = newRowRemainder >= rowAdd ? rowAdd : rowRemainder;
              newRowHeight += add;
              newRowRemainder -= add;
            }
            /* Create & append gridlet to grid.*/
            grid.append(lbox_gridlet(newColWidth, newRowHeight, topDist, img_topDst, leftDist, img_leftDist, imgSrc, imgWidth, imgHeight, i, j));
            topDist += newRowHeight;
            img_topDst -= newRowHeight;
          }
          img_leftDist -= newColWidth;
          leftDist += newColWidth;
        }
        /* Set event listener on last gridlet to finish transitioning.*/
        var last_gridlet = grid.children().last();
        /* Show grid & hide the image it replaces.*/
        grid.show();
        cur_img.css('opacity', 0);
        /* Add identifying classes to corner gridlets (useful if applying border radius).*/
        grid.children().first().addClass('rs-top-left');
        grid.children().last().addClass('rs-bottom-right');
        grid.children().eq(rows - 1).addClass('rs-bottom-left');
        grid.children().eq(- rows).addClass('rs-top-right');
        /* Execution steps.*/
        setTimeout(function () {
          grid.children().css({
            opacity: op,
            transform: 'rotate('+ ro +'deg) translateX('+ tx +'px) translateY('+ ty +'px) scale('+ sc +')'
          });
        }, 20);
        jQuery(next_image_class).css('opacity', 1);
        /* After transition.*/
        jQuery(last_gridlet).one('webkitTransitionEnd transitionend otransitionend oTransitionEnd mstransitionend', jQuery.proxy(lbox_after_trans));
        function lbox_after_trans() {
          jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
          jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
          cur_img.css('opacity', 1);
          grid.remove();
          lbox_trans_in_progress = false;
          jQuery(current_image_class).html('');

          if (typeof event_stack !== 'undefined' && event_stack.length > 0) {
            key = event_stack[0].split("-");
            event_stack.shift();
            lbox_change_image(key[0], key[1], data, true);
          }
        }
      }


      function lbox_sliceH(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
          var translateX = 'min-auto';
        }
        else if (direction == 'left') {
          var translateX = 'auto';
        }
        lbox_grid(1, 8, 0, translateX, 0, 1, 0, current_image_class, next_image_class, direction);
      }
      function lbox_sliceV(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
          var translateY = 'min-auto';
        }
        else if (direction == 'left') {
          var translateY = 'auto';
        }
        lbox_grid(10, 1, 0, 0, translateY, 1, 0, current_image_class, next_image_class, direction);
      }
      function lbox_slideV(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
          var translateY = 'auto';
        }
        else if (direction == 'left') {
          var translateY = 'min-auto';
        }
        lbox_grid(1, 1, 0, 0, translateY, 1, 1, current_image_class, next_image_class, direction);
      }
      function lbox_slideH(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
          var translateX = 'min-auto';
        }
        else if (direction == 'left') {
          var translateX = 'auto';
        }
        lbox_grid(1, 1, 0, translateX, 0, 1, 1, current_image_class, next_image_class, direction);
      }
      

      



      function lbox_scaleOut(current_image_class, next_image_class, direction) {
        lbox_grid(1, 1, 0, 0, 0, 1.5, 0, current_image_class, next_image_class, direction);
      }
      function lbox_scaleIn(current_image_class, next_image_class, direction) {
        lbox_grid(1, 1, 0, 0, 0, 0.5, 0, current_image_class, next_image_class, direction);
      }
      function lbox_blockScale(current_image_class, next_image_class, direction) {
        lbox_grid(8, 6, 0, 0, 0, .6, 0, current_image_class, next_image_class, direction);
      }
      function lbox_kaleidoscope(current_image_class, next_image_class, direction) {
        lbox_grid(10, 8, 0, 0, 0, 1, 0, current_image_class, next_image_class, direction);
      }
      function lbox_fan(current_image_class, next_image_class, direction) {
        if (direction == 'right') {
          var rotate = 45;
          var translateX = 100;
        }
        else if (direction == 'left') {
          var rotate = -45;
          var translateX = -100;
        }
        lbox_grid(1, 10, rotate, translateX, 0, 1, 0, current_image_class, next_image_class, direction);
      }
      function lbox_blindV(current_image_class, next_image_class, direction) {
        lbox_grid(1, 8, 0, 0, 0, .7, 0, current_image_class, next_image_class);
      }
      function lbox_blindH(current_image_class, next_image_class, direction) {
        lbox_grid(10, 1, 0, 0, 0, .7, 0, current_image_class, next_image_class);
      }
      function lbox_random(current_image_class, next_image_class, direction) {
        var anims = ['sliceH', 'sliceV', 'slideH', 'slideV', 'scaleOut', 'scaleIn', 'blockScale', 'kaleidoscope', 'fan', 'blindH', 'blindV'];
        /* Pick a random transition from the anims array.*/
        this["lbox_" + anims[Math.floor(Math.random() * anims.length)]](current_image_class, next_image_class, direction);
      }



      
      function lbox_change_image(current_key, key, data, from_effect) {
        if (typeof data[key] != 'undefined' && typeof data[current_key] != 'undefined') {
          if (jQuery('.lbox_ctrl_btn').hasClass('fa-pause')) {
            lbox_play();
          }
          if (!from_effect) {
            /* Change image key.*/
            jQuery("#lbox_current_image_key").val(key);
            /*if (current_key == '-1') {
              current_key = jQuery(".lbox_thumb_active").children("img").attr("image_key");
            }*/
          }
          if (lbox_trans_in_progress) {
            event_stack.push(current_key + '-' + key);
            return;
          }
          var direction = 'right';
          if (lbox_current_key > key) {
            var direction = 'left';
          }
          else if (lbox_current_key == key) {
            return;
          }
          jQuery("#spider_popup_left").hover().css({"display": "inline"});
          jQuery("#spider_popup_right").hover().css({"display": "inline"});
          jQuery(".lbox_image_count").html(data[key]["number"]);
          lbox_current_key = key;
          
          /* Change image id.*/
          jQuery("#lbox_popup_image").attr('image_id', data[key]["id"]);
          /* Change image title, description.*/
          jQuery(".lbox_image_title").html(jQuery('<div />').html(data[key]["alt"]).text());
          jQuery(".lbox_image_description").html(jQuery('<div />').html(data[key]["description"]).text());
          if (jQuery(".lbox_image_info_container1").css("display") != 'none') {
            jQuery(".lbox_image_info_container1").css("display", "table-cell");
          }
          else {
            jQuery(".lbox_image_info_container1").css("display", "none");
          }
          
          var current_image_class = jQuery(".lbox_popup_image_spun").css("zIndex") == 2 ? ".lbox_popup_image_spun" : ".lbox_popup_image_second_spun";
          var next_image_class = current_image_class == ".lbox_popup_image_second_spun" ? ".lbox_popup_image_spun" : ".lbox_popup_image_second_spun";
          
          var cur_height = jQuery(current_image_class).height();
          var cur_width = jQuery(current_image_class).width();
          var innhtml = '<span class="lbox_popup_image_spun1" style="display: table; width: inherit; height: inherit;"><span class="lbox_popup_image_spun2" style="display: table-cell; vertical-align: middle; text-align: center;">';
          innhtml += '<img style="max-height: ' + cur_height + 'px; max-width: ' + cur_width + 'px;" class="lbox_popup_image" src="' + jQuery('<div />').html(data[key]["image_url"]).text() + '" alt="' + data[key]["alt"] + '" />';
          innhtml += '</span></span>';
          jQuery(next_image_class).html(innhtml);
          
          function lbox_afterload() {
            <?php
            if ($preload_images) {
              echo 'lbox_preload_images(key);';
            }
            ?>
            lbox_<?php echo $image_effect; ?>(current_image_class, next_image_class, direction);
            jQuery("#lbox_fullsize_image").attr("href", data[key]['image_url']);
            jQuery("#lbox_download").attr("href", data[key]['image_url']);
            var image_arr = data[key]['image_url'].split("/");
            jQuery("#lbox_download").attr("download", image_arr[image_arr.length - 1]);
            
            jQuery(".mCSB_scrollTools").hide();
            
          }          
          
        
          var cur_img = jQuery(next_image_class).find('img');
          cur_img.one('load', function() {
            lbox_afterload();
          }).each(function() {
            if(this.complete) jQuery(this).load();
          });
          
          
        }
      }



      jQuery(document).on('keydown', function (e) {
        
        if (e.keyCode === 39) { /* Right arrow.*/
          lbox_change_image(parseInt(jQuery('#lbox_current_image_key').val()), parseInt(jQuery('#lbox_current_image_key').val()) + 1, data)
        }
        else if (e.keyCode === 37) { /* Left arrow.*/
          lbox_change_image(parseInt(jQuery('#lbox_current_image_key').val()), parseInt(jQuery('#lbox_current_image_key').val()) - 1, data)
        }
        else if (e.keyCode === 27) { /* Esc.*/
          wdwt_lbox.destroypopup(1000);
        }
        else if (e.keyCode === 32) { /* Space.*/
          jQuery(".lbox_play_pause").trigger('click');
        }
        if (e.preventDefault) {
          e.preventDefault();
        }
        else {
          e.returnValue = false;
        }
      });

      function lbox_preload_images(key) {


        count = <?php echo (int) $preload_images_count / 2; ?>;
        if (count != 0) {
          var img_number = data.length;
          //check if interval is within image numbers interval
          if(key - count >=0 ){
            for (var i = key - count; i < key; i++) {
              jQuery("<img/>").attr("src", (typeof data[i] != "undefined" ) ? jQuery('<div />').html(data[i]["image_url"]).text() : "");
            }
          }
          else{
            for (var i = 0; i < key; i++) {
              jQuery("<img/>").attr("src", (typeof data[i] != "undefined" ) ? jQuery('<div />').html(data[i]["image_url"]).text() : "");
            }
          }
          if(key + count <=img_number ){
            for (var i = key; i < key + count; i++) {
              jQuery("<img/>").attr("src", (typeof data[i] != "undefined" ) ? jQuery('<div />').html(data[i]["image_url"]).text() : "");
            }
          }
          else{
            for (var i = key; i < data.length; i++) {
              jQuery("<img/>").attr("src", (typeof data[i] != "undefined" ) ? jQuery('<div />').html(data[i]["image_url"]).text() : "");
            }
          }
          
        }
        else {
          
          for (var i = 0; i < data.length; i++) {
            
            jQuery("<img/>").attr("src", (typeof data[i] != "undefined") ? jQuery('<div />').html(data[i]["image_url"]).text() : "");
          }
          
        }

        
      }


      function lbox_popup_resize() {
        
        if (typeof jQuery().fullscreen !== 'undefined' && jQuery.isFunction(jQuery().fullscreen) && !jQuery.fullscreen.isFullScreen()) {
          jQuery(".lbox_resize-full").show();
          jQuery(".lbox_resize-full").attr("class", "lbox_ctrl_btn lbox_resize-full fa fa-resize-full");
          jQuery(".lbox_resize-full").attr("title", "<?php esc_attr_e('Maximize', "business-world"); ?>");
          jQuery(".lbox_fullscreen").attr("class", "lbox_ctrl_btn lbox_fullscreen fa fa-fullscreen");
          jQuery(".lbox_fullscreen").attr("title", "<?php esc_attr_e('Fullscreen', "business-world"); ?>");
        }

        jQuery(".spider_popup_close_fullscreen").show();


        if (jQuery(window).height() > <?php echo $image_height; ?> && <?php echo $open_with_fullscreen ? 1 : 0 ; ?> != 1 ) {
          
          jQuery("#spider_popup_wrap").css({
            height: <?php echo $image_height; ?>,
            top: '50%',
            marginTop: -<?php echo $image_height / 2; ?>,
            zIndex: 100000
          });
          jQuery(".lbox_image_container").css({height: (<?php echo $image_height; ?>)});
          
          jQuery(".lbox_popup_image").css({
            maxHeight: <?php echo $image_height ; ?>
          });
          
          lbox_popup_current_height = <?php echo $image_height; ?>;
        }
        else {
          jQuery("#spider_popup_wrap").css({
            height: jQuery(window).height(),
            top: 0,
            marginTop: 0,
            zIndex: 100000
          });
          jQuery(".lbox_image_container").css({height: (jQuery(window).height() )});
          
          jQuery(".lbox_popup_image").css({
            maxHeight: jQuery(window).height()
          });
          
          lbox_popup_current_height = jQuery(window).height();
        }

        


        if (jQuery(window).width() >= <?php echo $image_width; ?> && <?php echo $open_with_fullscreen ? 1 : 0 ; ?> != 1 ) {  
          jQuery("#spider_popup_wrap").css({
            width: <?php echo $image_width; ?>,
            left: '50%',
            marginLeft: -<?php echo $image_width / 2; ?>,
            zIndex: 100000
          });
          jQuery(".lbox_image_wrap").css({width: <?php echo $image_width; ?>});
          jQuery(".lbox_image_container").css({width: (<?php echo $image_width; ?>)});
          
          jQuery(".lbox_popup_image").css({maxWidth: <?php echo $image_width; ?>});
          
          lbox_popup_current_width = <?php echo $image_width; ?>;
        }
        else {
          jQuery("#spider_popup_wrap").css({
            width: jQuery(window).width(),
            left: 0,
            marginLeft: 0,
            zIndex: 100000
          });
          jQuery(".lbox_image_wrap").css({width: (jQuery(window).width() )});
          jQuery(".lbox_image_container").css({width: (jQuery(window).width() )});
          
          jQuery(".lbox_popup_image").css({
            maxWidth: jQuery(window).width() 
          });
          
          lbox_popup_current_width = jQuery(window).width();
          
        }
        

        if (((jQuery(window).height() > <?php echo $image_height - 2 * $theme_row['lightbox_close_btn_top']; ?>) && (jQuery(window).width() >= <?php echo $image_width - 2 * $theme_row['lightbox_close_btn_right']; ?>)) && (<?php echo $open_with_fullscreen ? 1 : 0 ; ?> != 1)) {
          jQuery(".spider_popup_close_fullscreen").attr("class", "spider_popup_close");
        }
        else {
          if ((jQuery("#spider_popup_wrap").width() < jQuery(window).width()) && (jQuery("#spider_popup_wrap").height() < jQuery(window).height())) {
            jQuery(".spider_popup_close").attr("class", "lbox_ctrl_btn spider_popup_close_fullscreen");
          }
        }

      }


      jQuery(window).resize(function() {

        if (typeof jQuery().fullscreen !== 'undefined' && jQuery.isFunction(jQuery().fullscreen) && !jQuery.fullscreen.isFullScreen()) {
          lbox_popup_resize();
        }
      });

      /* Popup current width/height.*/
      var lbox_popup_current_width = <?php echo $image_width; ?>;
      var lbox_popup_current_height = <?php echo $image_height; ?>;
      
      function lbox_reset_zoom() {
        var isMobile = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
        var viewportmeta = document.querySelector('meta[name="viewport"]');
        if (isMobile && viewportmeta) {
          viewportmeta.content = 'width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0';
        }
      }




      jQuery(document).ready(function () {
        <?php
        if ($image_right_click) {
          ?>
          /* Disable right click.*/
          jQuery(".lbox_image_wrap").bind("contextmenu", function (e) {
            return false;
          });
          <?php
        }
        ?>
        if (typeof jQuery().swiperight !== 'undefined' && jQuery.isFunction(jQuery().swiperight)) {
          jQuery('#spider_popup_wrap').swiperight(function () {
            lbox_change_image(parseInt(jQuery('#lbox_current_image_key').val()), parseInt(jQuery('#lbox_current_image_key').val()) - 1, data)
            return false;
          });
        }
        if (typeof jQuery().swipeleft !== 'undefined' && jQuery.isFunction(jQuery().swipeleft)) {
          jQuery('#spider_popup_wrap').swipeleft(function () {
            lbox_change_image(parseInt(jQuery('#lbox_current_image_key').val()), parseInt(jQuery('#lbox_current_image_key').val()) + 1, data);
            return false;
          });
        }

        lbox_reset_zoom();
        var isMobile = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
        var lbox_click = isMobile ? 'touchend' : 'click';
        jQuery("#spider_popup_left").on(lbox_click, function () {
          lbox_change_image(parseInt(jQuery('#lbox_current_image_key').val()), (parseInt(jQuery('#lbox_current_image_key').val()) + data.length - 1) % data.length, data);
          return false;
        });
        jQuery("#spider_popup_right").on(lbox_click, function () {
          lbox_change_image(parseInt(jQuery('#lbox_current_image_key').val()), (parseInt(jQuery('#lbox_current_image_key').val()) + 1) % data.length, data);
          return false;
        });
        if (navigator.appVersion.indexOf("MSIE 10") != -1 || navigator.appVersion.indexOf("MSIE 9") != -1) {
          setTimeout(function () {
            lbox_popup_resize();
          }, 20);
        }
        else {
          lbox_popup_resize();
        }
        
        /* If browser doesn't support Fullscreen API.*/
        if (typeof jQuery().fullscreen !== 'undefined' && jQuery.isFunction(jQuery().fullscreen) && !jQuery.fullscreen.isNativelySupported()) {
          jQuery(".lbox_fullscreen").hide();
        }
        /* Set image container height.*/
        jQuery(".lbox_image_container").height(jQuery(".lbox_image_wrap").height());
        jQuery(".lbox_image_container").width(jQuery(".lbox_image_wrap").width());
        
        /* Show/hide image title/description.*/
        jQuery(".lbox_info").on(lbox_click, function() {

          if (jQuery(".lbox_image_info_container1").css("display") == 'none') {
            jQuery(".lbox_image_info_container1").css("display", "table-cell");
            jQuery(".lbox_info").attr("title", "<?php echo __('Hide info', "business-world"); ?>");
          }
          else {
            jQuery(".lbox_image_info_container1").css("display", "none");
            jQuery(".lbox_info").attr("title", "<?php echo __('Show info', "business-world"); ?>");
          }
          
        });
        /* Open/close control buttons.*/
        jQuery(".lbox_toggle_container").on(lbox_click, function () {
          var lbox_open_toggle_btn_class = "<?php echo ($theme_row['lightbox_ctrl_btn_pos'] == 'top') ? 'fa-angle-up' : 'fa-angle-down'; ?>";
          var lbox_close_toggle_btn_class = "<?php echo ($theme_row['lightbox_ctrl_btn_pos'] == 'top') ? 'fa-angle-down' : 'fa-angle-up'; ?>";
          if (jQuery(".lbox_toggle_container i").hasClass(lbox_open_toggle_btn_class)) {
            // Close controll buttons.
            
            <?php
              if ($theme_row['lightbox_ctrl_btn_pos'] == 'bottom' && $theme_row['lightbox_info_pos'] == 'bottom') {
                ?>
                jQuery(".lbox_image_info").animate({bottom: 0}, 500);
                <?php
              }
              elseif ( $theme_row['lightbox_ctrl_btn_pos'] == 'top' && $theme_row['lightbox_info_pos'] == 'top') {
                ?>
                jQuery(".lbox_image_info").animate({top: 0}, 500);
                <?php
              }
            ?>

            jQuery(".lbox_ctrl_btn_container").animate({<?php echo $theme_row['lightbox_ctrl_btn_pos']; ?> : '-' + jQuery(".lbox_ctrl_btn_container").height()}, 500);
            
            jQuery(".lbox_toggle_container").animate({
                <?php echo $theme_row['lightbox_ctrl_btn_pos']; ?>: 0
              }, {
                duration: 500,
                complete: function () { jQuery(".lbox_toggle_container i").attr("class", "lbox_toggle_btn fa " + lbox_close_toggle_btn_class) }
              });

          }
          else {
            
            // Open controll buttons.
            <?php
              if ( $theme_row['lightbox_ctrl_btn_pos'] == 'bottom' && $theme_row['lightbox_info_pos'] == 'bottom') {
                ?>
                jQuery(".lbox_image_info").animate({bottom: jQuery(".lbox_ctrl_btn_container").height()}, 500);
                <?php
              }
              elseif ( $theme_row['lightbox_ctrl_btn_pos'] == 'top' && $theme_row['lightbox_info_pos'] == 'top') {
                ?>
                jQuery(".lbox_image_info").animate({top: jQuery(".lbox_ctrl_btn_container").height()}, 500);
                <?php
              }
            ?>
            jQuery(".lbox_ctrl_btn_container").animate({<?php echo $theme_row['lightbox_ctrl_btn_pos']; ?>: 0}, 500);
            jQuery(".lbox_toggle_container").animate({
                <?php echo $theme_row['lightbox_ctrl_btn_pos']; ?>: jQuery(".lbox_ctrl_btn_container").height()
              }, {
                duration: 500,
                complete: function () { jQuery(".lbox_toggle_container i").attr("class", "lbox_toggle_btn fa " + lbox_open_toggle_btn_class) }
              });

          }

        });
        // Maximize/minimize.
        jQuery(".lbox_resize-full").on(lbox_click, function () {


          if (jQuery(".lbox_resize-full").hasClass("fa-resize-small")) {
            if (jQuery(window).width() > <?php echo $image_width; ?>) {
              lbox_popup_current_width = <?php echo $image_width; ?>;
            }
            if (jQuery(window).height() > <?php echo $image_height; ?>) {
              lbox_popup_current_height = <?php echo $image_height; ?>;
            }
            // Minimize.
            jQuery("#spider_popup_wrap").animate({
              width: lbox_popup_current_width,
              height: lbox_popup_current_height,
              left: '50%',
              top: '50%',
              marginLeft: -lbox_popup_current_width / 2,
              marginTop: -lbox_popup_current_height / 2,
              zIndex: 100000
            }, 500);
            jQuery(".lbox_image_wrap").animate({width: lbox_popup_current_width }, 500);
            jQuery(".lbox_image_container").animate({height: lbox_popup_current_height , width: lbox_popup_current_width }, 500);
            
            jQuery(".lbox_popup_image").animate({
                maxWidth: lbox_popup_current_width ,
                maxHeight: lbox_popup_current_height
              }, {
                duration: 500,
                complete: function () {
                  if ((jQuery("#spider_popup_wrap").width() < jQuery(window).width()) && (jQuery("#spider_popup_wrap").height() < jQuery(window).height())) {
                    jQuery(".spider_popup_close_fullscreen").attr("class", "spider_popup_close");
                  }
                }
              });
            jQuery(".lbox_resize-full").attr("class", "lbox_ctrl_btn lbox_resize-full fa fa-resize-full");
            jQuery(".lbox_resize-full").attr("title", "<?php echo __('Maximize', "business-world"); ?>");
          }
          else {
            lbox_popup_current_width = jQuery(window).width();
            lbox_popup_current_height = jQuery(window).height();
            // Maximize.
            jQuery("#spider_popup_wrap").animate({
              width: jQuery(window).width(),
              height: jQuery(window).height(),
              left: 0,
              top: 0,
              margin: 0,
              zIndex: 100000
            }, 500);
            jQuery(".lbox_image_wrap").animate({width: (jQuery(window).width() )}, 500);
            jQuery(".lbox_image_container").animate({height: (lbox_popup_current_height ), width: lbox_popup_current_width }, 500);
            jQuery(".lbox_popup_image").animate({
                maxWidth: jQuery(window).width(),
                maxHeight: jQuery(window).height()
              }, {
                duration: 500,
                complete: function () {  }
              });
            
            jQuery(".lbox_resize-full").attr("class", "lbox_ctrl_btn lbox_resize-full fa fa-resize-small");
            jQuery(".lbox_resize-full").attr("title", "<?php echo __('Restore', "business-world"); ?>");
            jQuery(".spider_popup_close").attr("class", "lbox_ctrl_btn spider_popup_close_fullscreen");
          }
          
        });
        // Fullscreen.
        
        //Toggle with mouse click
        jQuery(".lbox_fullscreen").on(lbox_click, function () {

          
          
          function lbox_exit_fullscreen() {

            if (jQuery(window).width() > <?php echo $image_width; ?>) {
              lbox_popup_current_width = <?php echo $image_width; ?>;
            }
            if (jQuery(window).height() > <?php echo $image_height; ?>) {
              lbox_popup_current_height = <?php echo $image_height; ?>;
            }
            


            
            <?php
            if ($open_with_fullscreen) {
              ?>
            lbox_popup_current_width = jQuery(window).width();
            lbox_popup_current_height = jQuery(window).height();
              <?php
            }
            ?>
            
  
            jQuery("#spider_popup_wrap").on("fscreenclose", function() {
              jQuery("#spider_popup_wrap").css({
                width: lbox_popup_current_width,
                height: lbox_popup_current_height,
                left: '50%',
                top: '50%',
                marginLeft: -lbox_popup_current_width / 2,
                marginTop: -lbox_popup_current_height / 2,
                zIndex: 100000
              });
              jQuery(".lbox_image_wrap").css({width: lbox_popup_current_width });
              jQuery(".lbox_image_container").css({height: lbox_popup_current_height , width: lbox_popup_current_width });
              jQuery(".lbox_popup_image").css({
                maxWidth: lbox_popup_current_width ,
                maxHeight: lbox_popup_current_height
              });
              
              
              jQuery(".lbox_resize-full").show();
              jQuery(".lbox_resize-full").attr("class", "lbox_ctrl_btn lbox_resize-full fa fa-resize-full");
              jQuery(".lbox_resize-full").attr("title", "<?php echo __('Maximize', "business-world"); ?>");
              jQuery(".lbox_fullscreen").attr("class", "lbox_ctrl_btn lbox_fullscreen fa fa-fullscreen");
              jQuery(".lbox_fullscreen").attr("title", "<?php echo __('Fullscreen', "business-world"); ?>");
              if ((jQuery("#spider_popup_wrap").width() < jQuery(window).width()) && (jQuery("#spider_popup_wrap").height() < jQuery(window).height())) {
                jQuery(".spider_popup_close_fullscreen").attr("class", "spider_popup_close");
              }
            });
          }

          if (typeof jQuery().fullscreen !== 'undefined' && jQuery.isFunction(jQuery().fullscreen)) {
            if (jQuery.fullscreen.isFullScreen()) {
              
              // Exit Fullscreen.
              jQuery.fullscreen.exit();
              lbox_exit_fullscreen();
              
            }
            else {
              
              // Fullscreen.
  
              jQuery("#spider_popup_wrap").fullscreen();
                var screen_width = screen.width;
                var screen_height = screen.height;
                jQuery("#spider_popup_wrap").css({
                  width: screen_width,
                  height: screen_height,
                  left: 0,
                  top: 0,
                  margin: 0,
                  zIndex: 100000
                });
                jQuery(".lbox_image_wrap").css({width: screen_width});
                jQuery(".lbox_image_container").css({height: (screen_height ), width: screen_width  });
                jQuery(".lbox_popup_image").css({
                  maxWidth: (screen_width ),
                  maxHeight: (screen_height )
                });
                
                
                jQuery(".lbox_resize-full").hide();
                jQuery(".lbox_fullscreen").attr("class", "lbox_ctrl_btn lbox_fullscreen fa fa-resize-small");
                jQuery(".lbox_fullscreen").attr("title", "<?php esc_attr_e('Exit Fullscreen', "business-world"); ?>");
                jQuery(".spider_popup_close").attr("class", "lbox_ctrl_btn spider_popup_close_fullscreen");

            }
          }
          return false;
        });
       

        /* Play/pause.*/
        jQuery(".lbox_play_pause, .lbox_popup_image").on(lbox_click, function () {
          if (jQuery(".lbox_ctrl_btn").hasClass("fa-play")) {
            /* PLay.*/
            lbox_play();
            jQuery(".lbox_play_pause").attr("title", "<?php echo __('Pause', "business-world"); ?>");
            jQuery(".lbox_play_pause").attr("class", "lbox_ctrl_btn lbox_play_pause fa fa-pause");
          
          }
          else {
            /* Pause.*/
          
            window.clearInterval(lbox_playInterval);
            jQuery(".lbox_play_pause").attr("title", "<?php echo __('Play', "business-world"); ?>");
            jQuery(".lbox_play_pause").attr("class", "lbox_ctrl_btn lbox_play_pause fa fa-play");
          
          }
        });
        /* Open with autoplay.*/
        
        <?php

        if ($open_with_autoplay) {
          ?>
          lbox_play();
          jQuery(".lbox_play_pause").attr("title", "<?php echo __('Pause', "business-world"); ?>");
          jQuery(".lbox_play_pause").attr("class", "lbox_ctrl_btn lbox_play_pause fa fa-pause");
          <?php
        }
        ?>
        
        /* Open with fullscreen.*/
        
        <?php
        if ($open_with_fullscreen) {
          ?>
          lbox_open_with_fullscreen();
          <?php
        }
        ?>
        
        
        <?php
        if ($preload_images) {
          echo "lbox_preload_images(parseInt(jQuery('#lbox_current_image_key').val()));";
        }
        ?>
                
      });


      
      /* Open with fullscreen.*/
      function lbox_open_with_fullscreen() {
        
        lbox_popup_current_width = jQuery(window).width();
        lbox_popup_current_height = jQuery(window).height();
        jQuery("#spider_popup_wrap").css({
          width: jQuery(window).width(),
          height: jQuery(window).height(),
          left: 0,
          top: 0,
          margin: 0,
          zIndex: 100000
        });
        jQuery(".lbox_image_wrap").css({width: (jQuery(window).width())});
        jQuery(".lbox_image_container").css({height: (lbox_popup_current_height), width: lbox_popup_current_width});
        jQuery(".lbox_popup_image").css({
         maxWidth: jQuery(window).width() ,
         maxHeight: jQuery(window).height()
         });
        
        jQuery(".lbox_resize-full").attr("class", "lbox_ctrl_btn lbox_resize-full fa fa-resize-small");
        jQuery(".lbox_resize-full").attr("title", "<?php echo __('Restore', "business-world"); ?>");
        jQuery(".spider_popup_close").attr("class", "lbox_ctrl_btn spider_popup_close_fullscreen");         
      }


      function lbox_play() {
        window.clearInterval(lbox_playInterval);
        lbox_playInterval = setInterval(function () {
          if (!data[parseInt(jQuery('#lbox_current_image_key').val()) + 1]) {
            /* Wrap around.*/
            lbox_change_image(parseInt(jQuery('#lbox_current_image_key').val()), 0, data);
            return;
          }
          lbox_change_image(parseInt(jQuery('#lbox_current_image_key').val()), parseInt(jQuery('#lbox_current_image_key').val()) + 1, data)
        }, '<?php echo $slideshow_interval * 1000; ?>');
      }


      jQuery(window).focus(function() {
        /* event_stack = [];*/
        if (!jQuery(".lbox_ctrl_btn").hasClass("fa-play")) {
          lbox_play();
        }
        /*var i = 0;
        jQuery(".lbox_slider").children("span").each(function () {
          if (jQuery(this).css('opacity') == 1) {
            jQuery("#lbox_current_image_key").val(i);
          }
          i++;
        });*/
      });

      jQuery(window).blur(function() {
        event_stack = [];
        window.clearInterval(lbox_playInterval);
      });



      
      





    </script>
    

    <?php
   // die();
  }
  
  
  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}