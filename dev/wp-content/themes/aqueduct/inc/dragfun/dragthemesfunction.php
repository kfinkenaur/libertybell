<?php


/*---------------------------------------------------
Copyright DragThemes
----------------------------------------------------*/
/**
 * Catching First Image of Post
 */
function howlthemes_catch_that_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  if(preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches)){
  $first_img = $matches [1] [0];
  }
  return $first_img;
}

 
function howlthemes_foot(){?>
<footer id="colophon" class="site-footer" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
  <div class="container">
    <div class="three-column-footer">
        <?php dynamic_sidebar( 'footer-1' ); ?>

      </div>
      </div><!-- .site-info -->
  </footer><!-- #colophon -->
   <div class="copyright">
   <div class="container">
   <div class="copyright-text">
  <?php _e('Designed By', 'aqueduct'); ?> <a href="http://www.howlthemes.com" target="blank" style="color:#efefef;text-decoration:none;">HowlThemes</a>
   </div>
   <div class="back-top">
   <a href="#" id="back-to-top" title="Back to top"><?php _e('Back To Top', 'aqueduct'); ?><i class="fa fa-arrow-circle-o-up"></i></a>
   </div>
   </div>
   </div>
</div><!-- #page -->
<?php }

/*-----------------
*CUSTOMIZER
*-----------------*/
function howlthemes_customizer( $wp_customize ) {

/*------------------------------------------------------
*Custom Class 
*-----------------------------------------------*/
/**
* for Image Radio Button
*/
class aqueduct_radio_image extends WP_Customize_Control {
    public $type = 'imageradio';
 
    public function render_content() {
        ?>
            <label>
                <input type="text" class="headertype" <?php $this->link(); ?> />

                <div class="imgradio_hldr">
                <img 
                src='<?php echo esc_url( get_template_directory_uri() ) . "/img/default.jpg"; ?> ' class="default_header">
                </div>
                <div class="imgradio_hldr">
                <img 
                src='<?php echo esc_url( get_template_directory_uri() ) . "/img/centered.jpg"; ?> ' class="center_header">
                </div>
                <div class="imgradio_hldr">
                <img 
                src='<?php echo esc_url( get_template_directory_uri() ) . "/img/nobraking.jpg"; ?> ' class="best_header">
                </div>
                <style>.imgradio_hldr img{ opacity:.5; } .imgradio_hldr img:hover{ opacity:.9; } .selected_radio{ opacity:1 !important; } input.headertype {display: none;}.imgradio_hldr { margin-bottom: 10px; }</style>
                <script>
                jQuery(document).ready(function(){
                jQuery('.<?php echo get_theme_mod("imageradio") ?>_header').addClass('selected_radio');
    
                jQuery('.default_header').click(function(){
                  jQuery('.headertype').val('default').change();
                });
                jQuery('.center_header').click(function(){
                  jQuery('.headertype').val('center').change();
                });
                jQuery('.best_header').click(function(){
                  jQuery('.headertype').val('best').change();
                });

                jQuery('.imgradio_hldr img').each(function() {
                jQuery(this).on("click", function(){
                jQuery('.imgradio_hldr img').removeClass('selected_radio');
                jQuery(this).addClass('selected_radio');
                });
                });

                });
                </script>
            </label>
        <?php
    }
}

/**
* for Home Builder
*/

class aqueduct_homebuilder_Control extends WP_Customize_Control {
    public $type = 'homebuilder';
 
    public function render_content() {
        ?>
        <label>
        <input type="text" class="homebuilderin" <?php $this->link(); ?> />
        </label>
        
        <ul class="sortable-builder">
        <?php if(get_theme_mod("homebuilder") && get_theme_mod("category_remember")){
        $totalslide =  explode(', ', get_theme_mod("homebuilder"));
        $slidecount = count($totalslide) -1;
        $totalcat = explode(', ', get_theme_mod("category_remember"));
    }else{
        $totalslide = array(1,2,3,4,5);
        $slidecount = 4;
        $totalcat = array('none', 'none', 'none', 'none', 'none');
    }
        for($i =0; $i <= $slidecount; $i++){
           if(str_replace(',', '', $totalslide[$i]) == 1){?>
        <li class="howl_slider" id="1">
        <label><?php _e( 'Slider', 'aqueduct') ?></label>
        <?php } elseif (str_replace(',', '', $totalslide[$i]) == 2) {?>
        <li class="howl_carousel" id="2">
        <label><?php _e( 'Carousel', 'aqueduct') ?></label>
        <?php } elseif (str_replace(',', '', $totalslide[$i]) == 3) {?>
        <li class="howl_Grid_one" id="3">
        <label><?php _e( 'Grid 1', 'aqueduct') ?></label>
        <?php } elseif (str_replace(',', '', $totalslide[$i]) == 4) {?>
        <li class="howl_Grid_two" id="4">
        <label><?php _e( 'Grid 2', 'aqueduct') ?></label>
        <?php } elseif (str_replace(',', '', $totalslide[$i]) == 5) {?>
        <li class="howl_blogpost" id="5">
        <label><?php _e( 'Blog Style', 'aqueduct') ?></label>
        <?php } ?>

        <select class="idcatcon">
        <option value"none">Select a Category</option>
        <?php
        $categories = get_categories('hide_empty=0&orderby=name');
        foreach ($categories as $category_item ) {
        if(str_replace(',', '', $totalcat[$i]) == $category_item->cat_ID){
        echo '<option selected="selected" value="'. $category_item->cat_ID .'">'. $category_item->cat_name .'</option>';
        }
        else{
        echo '<option value="'. $category_item->cat_ID .'">'. $category_item->cat_name .'</option>';
        }
        }

        ?>
        </select>
        </li>
                <?php }?>
        </ul>
        <div class="addmorenewsbox button-secondary"><?php _e( 'Add Category Box', 'aqueduct') ?></div>
        <div class="typebtnhldr">
        <div class="addgridone hiddenbuttons"><?php _e( 'Grid 1', 'aqueduct') ?></div>
        <div class="addgridtwo hiddenbuttons"><?php _e( 'Grid 2', 'aqueduct') ?></div>
        <div class="addblogstyle hiddenbuttons"><?php _e( 'Blog Style', 'aqueduct') ?></div>
        </div>
        <div class="resetcatboc"><?php _e( 'Reset', 'aqueduct') ?></div>
<script>
        /*
        * This Code Make Category Box Dragable
        */
        jQuery(document).ready(function(){
        jQuery( ".sortable-builder" )
        .sortable({
        stop: function( event, ui ) {
        howl_saveli();
        howl_savecat();
        }
        });
        function howl_saveli(){
            var liarrangement = '';
            jQuery(".sortable-builder li").each(function(){
                liarrangement = liarrangement +jQuery(this).attr('id')+', ';
            });
            jQuery('.homebuilderin').val(liarrangement).change();
        }
        function howl_savecat(){
           var catarrangement = '';
            jQuery(".sortable-builder li").each(function(){
                var currentcatid = jQuery(this).find(".idcatcon option:selected").val();
                if(currentcatid == 'Select a Category'){
                    currentcatid = 'none';
                }
                catarrangement = catarrangement + currentcatid+', ';
            });
            jQuery('#customize-control-category_remember input').val(catarrangement).change(); 
        }
        function selectonchange(){
        jQuery('.idcatcon').on('change', function() {
        howl_saveli();
        howl_savecat();
        });
        }
        selectonchange();
        jQuery('.addmorenewsbox').click(function(){
        jQuery('.typebtnhldr').toggle();
        });
        jQuery('.resetcatboc').click(function(){
        jQuery('#customize-control-category_remember input').val('none, none, none, none, none, ').change();
        jQuery('.homebuilderin').val('1, 2, 3, 4, 5, ').change();
        });
        jQuery(".addgridone").click(function(){
        var alloptions = jQuery(".idcatcon").html();
        jQuery(".sortable-builder").append('<li class="howl_Grid_one ui-sortable-handle" id="3"><label>Grid 1</label><select class="idcatcon">'+ alloptions +'</select></li>');
        jQuery(".sortable-builder li:last-child .idcatcon option").prop("selected", false);
        selectonchange();
        });
        jQuery(".addgridtwo").click(function(){
        var alloptions = jQuery(".idcatcon").html();
        jQuery(".sortable-builder").append('<li class="howl_Grid_two ui-sortable-handle" id="4"><label>Grid 2</label><select class="idcatcon">'+ alloptions +'</select></li>');
        jQuery(".sortable-builder li:last-child .idcatcon option").prop("selected", false);
        selectonchange();
        });
        jQuery(".addblogstyle").click(function(){
        var alloptions = jQuery(".idcatcon").html();
        jQuery(".sortable-builder").append('<li class="howl_blogpost ui-sortable-handle" id="5"><label>Blog Style</label><select class="idcatcon">'+ alloptions +'</select></li>');
        jQuery(".sortable-builder li:last-child .idcatcon option").prop("selected", false);
        selectonchange();
        });
        });
        </script>
        <style>.homebuilderin, #customize-control-category_remember input{display:none;}.sortable-builder li { background: #fff; padding: 5px; border-radius: 3px; margin-bottom: 10px;padding-bottom: 10px;}.sortable-builder li label { background: #D23F50; display: block; padding: 5px; padding-left: 10px; color: #fff; text-transform: uppercase; margin: -5px; margin-bottom: 10px; -webkit-border-top-left-radius: 3px; -webkit-border-top-right-radius: 3px; -moz-border-radius-topleft: 3px; -moz-border-radius-topright: 3px; border-top-left-radius: 3px; border-top-right-radius: 3px; cursor: move; }
        .hiddenbuttons { background: #00a0d2; color: #fff; font-size: 16px; font-weight: 700; padding: 10px; margin-top: 10px; width: 110px; text-align: center; border-radius: 3px; cursor:pointer;} .hiddenbuttons:hover { background: #007FA7; } .typebtnhldr{display:none;}
        .resetcatboc { color: #0073aa; font-size: 14px; padding: 6px; border: 1px solid; margin-top: 10px; width: 114px; text-align: center; border-radius: 3px; cursor: pointer; } .resetcatboc:hover{background:#0073aa;color:#fff;}
        </style>


        
        <?php
    }
}


/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */

 $wp_customize->add_section(
        'headersection',
        array(
            'title' => __( 'Header', 'aqueduct' ),
            'description' => __( 'Choose style for header', 'aqueduct' ),
            'priority' => 30,
        )
    );


$wp_customize->add_setting( 
  'imageradio',
    array(
        'default' => 'default',
        'sanitize_callback' => 'sanitize_text_field',
    )
  );
 
$wp_customize->add_control(
    new aqueduct_radio_image(
        $wp_customize,
        'imageradio',
        array(
            'section' => 'headersection',
            'settings' => 'imageradio'
        )
    )
);








// Styling Panel
$wp_customize->add_panel( 'styling', array(
  'title' => __( 'Styling', 'aqueduct'),
  'priority' => 60, // Mixed with top-level-section hierarchy.
) );

//Theme Layout

$wp_customize->add_section( 'howl-themes_layout_section' , array(
    'title'       => __( 'Choose layout', 'aqueduct' ),
    'priority'    => 30,
    'panel' => 'styling',

) );

$wp_customize->add_setting(
    'layout_placement',
    array(
        'default' => 'full',
        'sanitize_callback' => 'sanitize_key',
    )
);
 
$wp_customize->add_control(
    'layout_placement',
    array(
        'type' => 'radio',
        'label' => __('Theme Layout', 'aqueduct' ),
        'section' => 'howl-themes_layout_section',
        'choices' => array(
            'full' => 'Full Width',
            'boxed' => 'Boxed',
        ),
    )
);

//Background Image
  $wp_customize->add_section( 'howl-themes_bg_img' , array(
    'title'       => __( 'Background Image', 'aqueduct' ),
    'priority'    => 30,
    'description' => __('It will work only if theme layout is Boxed', 'aqueduct' ),
        'panel' => 'styling',
) );

  $wp_customize->add_setting( 'howl-themes_bgimg',
    array ( 'default' => '',
    'sanitize_callback' => 'esc_url_raw'
    ));

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'howl-themes_bgimg', array(
    'section'  => 'howl-themes_bg_img',
    'settings' => 'howl-themes_bgimg',
) ) );

// Home Panel
$wp_customize->add_panel( 'frontpage', array(
  'title' => __( 'Home Page Setting', 'aqueduct'),
  'priority' => 40, // Mixed with top-level-section hierarchy.
) );

//Home Page Display

$wp_customize->add_section( 'howl-themes_magazine' , array(
    'title'       => __( 'Front Page', 'aqueduct' ),
    'priority'    => 30,
    'panel' => 'frontpage',

) );

$wp_customize->add_setting(
    'home_display',
    array(
        'default' => 'blog',
        'sanitize_callback' => 'sanitize_key',
    )
);
 
$wp_customize->add_control(
    'home_display',
    array(
        'type' => 'radio',
        'label' =>  __( 'Home Page Display', 'aqueduct' ),
        'section' => 'howl-themes_magazine',
        'choices' => array(
            'blog' =>  __( 'Latest posts - Blog Layout', 'aqueduct' ),
            'magazine' => __( 'News Boxes - use Home Builder', 'aqueduct' ),
        ),
    )
);

//Slider
$wp_customize->add_section( 'howl-themes_newsbox_one' , array(
    'title'       => __( 'News Boxes', 'aqueduct' ),
    'priority'    => 30,
    'panel' => 'frontpage',
) );


$wp_customize->add_setting( 
  'homebuilder',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
  );

$wp_customize->add_control(
    new aqueduct_homebuilder_Control(
        $wp_customize,
        'homebuilder',
        array(
            'section' => 'howl-themes_newsbox_one',
            'settings' => 'homebuilder'
        )
    )
);

 $wp_customize->add_setting(
    'category_remember',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(
    'category_remember',
    array(
        'section' => 'howl-themes_newsbox_one',
        'type' => 'text',
    )
);


//Theme color
$wp_customize->add_section( 'howl-themes_theme_color' , array(
    'title'       => __( 'Theme Color', 'aqueduct' ),
    'priority'    => 30,
    'panel' => 'styling',
) );

$wp_customize->add_setting(
    'color-setting',
    array(
        'default' => '#d23f50',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'color-setting',
        array(
            'label' => __('Choose Color', 'aqueduct' ),
            'section' => 'howl-themes_theme_color',
            'settings' => 'color-setting',
        )
    )
);
//Link color
$wp_customize->add_section( 'howl-themes_link_color' , array(
    'title'       => __( 'Link Color', 'aqueduct' ),
    'priority'    => 30,
    'panel' => 'styling',

) );

$wp_customize->add_setting(
    'linkcolor-setting',
    array(
        'default' => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'linkcolor-setting',
        array(
            'label' => __( 'Link Color', 'aqueduct' ),
            'section' => 'howl-themes_link_color',
            'settings' => 'linkcolor-setting',
        )
    )
);
$wp_customize->add_setting(
    'linkcolorhover-setting',
    array(
        'default' => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'linkcolorhover-setting',
        array(
            'label' => __( 'Link Hover Color', 'aqueduct' ),
            'section' => 'howl-themes_link_color',
            'settings' => 'linkcolorhover-setting',
        )
    )
);

//Typography

$wp_customize->add_panel( 'typo', array(
  'title' => __( 'Typography', 'aqueduct'),
  'priority' => 80, // Mixed with top-level-section hierarchy.
) );
$wp_customize->add_section( 'howl-themes_typography' , array(
    'title'       => __( 'Choose Font', 'aqueduct' ),
    'priority'    => 30,
    'panel' => 'typo',
) );
$wp_customize->add_setting(
   'typography-setting',
    array(
        'default' => 'Titillium Web',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
     'typography-setting',
    array(
        'type' => 'select',
        'section' => 'howl-themes_typography',
        'choices' => array(

'Playfair Display' => 'Playfair Display',
'Work Sans' => 'Work Sans',
'Alegreya' => 'Alegreya',
'Alegreya Sans' => 'Alegreya Sans',
'Inconsolata' => 'Inconsolata',
'Source Sans Pro' => 'Source Sans Pro',
'Source Serif Pro' => 'Source Serif Pro',
'Neuton' => 'Neuton',
'Poppins' => 'Poppins',
'Crimson Text' => 'Crimson Text',
'Archivo Narrow' => 'Archivo Narrow',
'Libre Baskerville' => 'Libre Baskerville',
'Roboto' => 'Roboto',
'Karla' => 'Karla',
'Lora' => 'Lora',
'Chivo' => 'Chivo',
'Domine' => 'Domine',
'Old Standard TT' => 'Old Standard TT',
'Varela Round' => 'Varela Round',
'Open Sans' => 'Open Sans',
'Raleway' => 'Raleway',
'Josefin Sans' => 'Josefin Sans',
'Oswald' => 'Oswald',
'PT Sans' => 'PT Sans',
'Merriweather' => 'Merriweather',
'Lato' => 'Lato',
'Ubuntu' => 'Ubuntu',
'Bitter' => 'Bitter',
'Cardo' => 'Cardo',
'Arvo' => 'Arvo',
'Montserrat' => 'Montserrat',
'Rajdhani' => 'Rajdhani',
'Droid Sans' => 'Droid Sans',
'PT Serif' => 'PT Serif',
'Dosis' => 'Dosis',
'Titillium Web' => 'Titillium Web',
'Cabin' => 'Cabin',
'Hind' => 'Hind',
'Catamaran' => 'Catamaran',
'Signika' => 'Signika',
'Exo' => 'Exo',
        ),
    )
);

$wp_customize->add_section( 'howl-themes_fontcolor' , array(
    'title'       => __( 'Font color', 'aqueduct' ),
    'priority'    => 30,
    'panel' => 'typo',
) );
$wp_customize->add_setting(
    'fontcolor-setting',
    array(
        'default' => '#000000',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'fontcolor-setting',
        array(
            'label' => __( 'Font Color', 'aqueduct' ),
            'section' => 'howl-themes_fontcolor',
            'settings' => 'fontcolor-setting',
        )
    )
);

/**
 * Adds input number support to the theme customizer
 */
class aqueduct_Customize_Textarea_Control extends WP_Customize_Control {
    public $type = 'fontsize';
 
    public function render_content() {
        ?>
            <label>
                <input type="number" min="1" <?php $this->link(); ?> />
            </label>
        <?php
    }
}

$wp_customize->add_section( 'howl-themes_fontsize' , array(
    'title'       => __( 'Font size', 'aqueduct' ),
    'priority'    => 30,
    'panel' => 'typo',
) );
$wp_customize->add_setting( 
  'fontsize',
    array(
        'default' => '18',
        'sanitize_callback' => 'sanitize_text_field',
    )
  );
 
$wp_customize->add_control(
    new aqueduct_Customize_Textarea_Control(
        $wp_customize,
        'fontsize',
        array(
            'section' => 'howl-themes_fontsize',
            'settings' => 'fontsize'
        )
    )
);

//Social

  $wp_customize->add_section(
        'social_icons',
        array(
            'title' => 'Social',
            'description' => __( 'Add URLs', 'aqueduct' ),
            'priority' => 60,
        )
    );
    $wp_customize->add_setting(
    'fsocial_url',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(
    'fsocial_url',
    array(
        'label' => __( 'Facebook', 'aqueduct' ),
        'section' => 'social_icons',
        'type' => 'text',
    )
);
     $wp_customize->add_setting(
    'tsocial_url',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control(
    'tsocial_url',
    array(
        'label' => __( 'Twitter', 'aqueduct' ),
        'section' => 'social_icons',
        'type' => 'text',
    )
);
  $wp_customize->add_setting(
    'gsocial_url',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(
    'gsocial_url',
    array(
        'label' => __( 'Google+', 'aqueduct' ),
        'section' => 'social_icons',
        'type' => 'text',
    )
);
  $wp_customize->add_setting(
    'psocial_url',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(
    'psocial_url',
    array(
        'label' => __( 'Pinterest', 'aqueduct' ),
        'section' => 'social_icons',
        'type' => 'text',
    )
);
  $wp_customize->add_setting(
    'isocial_url',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(
    'isocial_url',
    array(
        'label' => __( 'Instagram', 'aqueduct' ),
        'section' => 'social_icons',
        'type' => 'text',
    )
);
  $wp_customize->add_setting(
    'lsocial_url',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(
    'lsocial_url',
    array(
        'label' => __( 'Linkedin', 'aqueduct' ),
        'section' => 'social_icons',
        'type' => 'text',
    )
);
  $wp_customize->add_setting(
    'ysocial_url',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(
    'ysocial_url',
    array(
        'label' =>  __( 'Youtube', 'aqueduct' ),
        'section' => 'social_icons',
        'type' => 'text',
    )
);
  $wp_customize->add_setting(
    'rsocial_url',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(
    'rsocial_url',
    array(
        'label' =>  __( 'RSS', 'aqueduct' ),
        'section' => 'social_icons',
        'type' => 'text',
    )
);


$wp_customize->remove_section('static_front_page');
}
add_action( 'customize_register', 'howlthemes_customizer' );


/**
 * Enqueue script for custom customize control.
 */
function custom_customize_enqueue() {
       wp_enqueue_script( 'jqueryui-customize', '//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js', array( 'jquery', 'customize-controls' ), true );
       wp_enqueue_script( 'customjs-customize', get_template_directory_uri() . '/js/customizer.js', array( 'jquery', 'customize-controls' ), true );
}
add_action( 'customize_controls_enqueue_scripts', 'custom_customize_enqueue' );