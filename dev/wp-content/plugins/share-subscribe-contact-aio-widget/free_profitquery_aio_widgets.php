<?php
/* 
* +--------------------------------------------------------------------------+
* | Copyright (c) ShemOtechnik Profitquery Team shemotechnik@profitquery.com |
* +--------------------------------------------------------------------------+
* | This program is free software; you can redistribute it and/or modify     |
* | it under the terms of the GNU General Public License as published by     |
* | the Free Software Foundation; either version 2 of the License, or        |
* | (at your option) any later version.                                      |
* |                                                                          |
* | This program is distributed in the hope that it will be useful,          |
* | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
* | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            |
* | GNU General Public License for more details.                             |
* |                                                                          |
* | You should have received a copy of the GNU General Public License        |
* | along with this program; if not, write to the Free Software              |
* | Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA |
* +--------------------------------------------------------------------------+
*/
/**
* Plugin Name: 24 of the Best Free Marketing Tools
* Plugin URI: http://profitquery.com/?utm_campaign=aio_widgets_wp
* Description: 24 free marketing tools for any WordPress websites. Growth website traffic, emails, subscription, feedbacks, phone numbers, shares, referrals, followers
* Version: 5.1.0
*
* Author: Profitquery Team <support@profitquery.com>
* Author URI: http://profitquery.com/?utm_campaign=aio_widgets_wp
*/

//update_option('profitquery', array());
$profitquery = get_option('profitquery');


//rename aio_widgets_loaded
if(!isset($profitquery['pq_aio_widgets_loaded']) && isset($profitquery['aio_widgets_loaded'])){
	$profitquery['pq_aio_widgets_loaded'] = $profitquery['aio_widgets_loaded'];
	update_option('profitquery', $profitquery);
}

//rename contactus popup
if(isset($profitquery['contactUsPopup'])){
	$profitquery['contactFormPopup'] = $profitquery['contactUsPopup'];
	unset($profitquery['contactUsPopup']);
	update_option('profitquery', $profitquery);
}

//not isset later click
if(!isset($profitquery['settings']['pq_aio_later_click_time'])){
	$profitquery['settings']['pq_aio_later_click_time'] = time()+60*60*1;
	update_option('profitquery', $profitquery);
}

//not isset pq_aio_later_update_click_time
if(!isset($profitquery['settings']['pq_aio_later_update_click_time'])){
	$profitquery['settings']['pq_aio_later_update_click_time'] = time()+60*60*7;
	update_option('profitquery', $profitquery);
}





if (!defined('PQ_AIO_PLUGIN_NAME'))
	define('PQ_AIO_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('PQ_AIO_PAGE_NAME'))
	define('PQ_AIO_PAGE_NAME', 'free_profitquery_aio_widgets');

if (!defined('PQ_AIO_ADMIN_CSS_PATH'))
	define('PQ_AIO_ADMIN_CSS_PATH', 'css/');

if (!defined('PQ_AIO_ADMIN_JS_PATH'))
	define('PQ_AIO_ADMIN_JS_PATH', 'js/');

if (!defined('PQ_AIO_ADMIN_IMG_PATH'))
	define('PQ_AIO_ADMIN_IMG_PATH', 'images/');

if (!defined('PQ_AIO_ADMIN_IMG_PREVIEW_PATH'))
	define('PQ_AIO_ADMIN_IMG_PREVIEW_PATH', 'preview/');

$pathParts = pathinfo(__FILE__);
$path = $pathParts['dirname'];

if (!defined('PQ_AIO_FILENAME'))
	define('PQ_AIO_FILENAME', $path.'/free_profitquery_aio_widgets.php');


require_once 'free_profitquery_aio_widgets_class.php';
$PQ_AIO_Class = new PQ_AIO_Class();


add_action('init', 'PQ_AIO_init');


function PQ_AIO_init(){
	global $profitquery;
	global $PQ_AIO_Class;	
	if ( !is_admin()){		
		add_action('wp_head', 'PQ_AIO_code_injection');		
	}else{
		add_action('admin_head', 'PQ_AIO_RateUs');
	}
}

function PQ_AIO_RateUs(){
	global $profitquery;
	global $PQ_AIO_Class;
	
	$PQ_AIO_show_message = 0;	
	if(strstr($_SERVER[REQUEST_URI], 'wp-admin/plugins.php')){
		if((int)$profitquery[settings][pq_aio_click_review] == 0 && (int)$profitquery[settings][pq_aio_later_click_time] < time()) $PQ_AIO_show_message = 1;
		if($PQ_AIO_Class->getArrayAllFreeTools() && (int)$profitquery[settings][pq_aio_later_update_click_time] < time()) $PQ_AIO_show_message = 1;
	}	
	
	
	if($PQ_AIO_show_message){
		$PQ_AIO_Class->getDictionary();
	?>
	<div class="updated" id="PQPluginMessage" style="padding: 0; margin: 0; border: none; background: none;">	
	<style type="text/css">
	 
	.pq_activate{min-width:825px;padding:5px;margin:15px 0;background:lightgrey; -moz-border-radius:3px;border-radius:3px;-webkit-border-radius:3px;position:relative;overflow:hidden}
	.pq_activate .aa_a{position:absolute;top:-5px;right:10px;font-size:140px;color:#769F33;font-family:Georgia, "Times New Roman", Times, serif;z-index:1}
	.pq_activate .aa_button{font-weight:bold;border:1px solid red;font-size:15px;text-align:center;padding:9px 0 8px 0;color:#FFF;background:red;-moz-border-radius:2px;border-radius:2px;-webkit-border-radius:2px;opacity:.8;}
	.pq_activate .aa_button:hover{opacity:1;}
	.pq_activate .aa_button_border{border:1px solid transparent;-moz-border-radius:2px;border-radius:2px;-webkit-border-radius:2px;}
	.pq_activate .aa_button_container{cursor:pointer;display:inline-block;padding:5px;-moz-border-radius:2px;border-radius:2px;-webkit-border-radius:2px;width:266px; float: right;  margin-right: 25px;}
	.pq_activate .aa_description{position:absolute;top:22px;margin-left:25px;color:rgb(63, 63, 63);font-size:15px;z-index:1000}

	</style>
				
		<form name="pq_activate" action="<?php echo admin_url("options-general.php?page=" . PQ_AIO_PAGE_NAME);?>" method="POST"> 			
			<div class="pq_activate">  
				
				<div class="aa_button_container" onclick="document.pq_activate.submit();">  
					<div class="aa_button_border">          
						<div class="aa_button"><?php echo $PQ_AIO_Class->_dictionary[new_message][button];?></div>  
					</div>  
				</div>  
				<div class="aa_description"><?php echo $PQ_AIO_Class->_dictionary[new_message][title];?></div>  
			</div>  
		</form>  
	</div>	
	<?php
	}
}

/* Adding action links on plugin list*/
function PQ_AIO_admin_link($links, $file) {
    static $this_plugin;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    if ($file == $this_plugin) {
        $settings_link = '<a href="options-general.php?page='.PQ_AIO_PAGE_NAME.'">Settings</a>';
        array_unshift($links, $settings_link);
    }

    return $links;
}

function PQ_AIO_colorToHex($val){		
	$colorArray = array("indianred"=>"#cd5c5c","crimson"=>"#dc143c","lightpink"=>"#ffb6c1","pink"=>"#ffc0cb","palevioletred"=>"#D87093","hotpink"=>"#ff69b4","mediumvioletred"=>"#c71585","orchid"=>"#da70d6","plum"=>"#dda0dd","violet"=>"#ee82ee","magenta"=>"#ff00ff","purple"=>"#800080","mediumorchid"=>"#ba55d3","darkviolet"=>"#9400d3","darkorchid"=>"#9932cc","indigo"=>"#4b0082","blviolet"=>"#8a2be2","mediumpurple"=>"#9370db","darkslateblue"=>"#483d8b","mediumslateblue"=>"#7b68ee","slateblue"=>"#6a5acd","blue"=>"#0000ff","navy"=>"#000080","midnightblue"=>"#191970","royalblue"=>"#4169e1","cornflowerblue"=>"#6495ed","steelblue"=>"#4682b4","lightskyblue"=>"#87cefa","skyblue"=>"#87ceeb","deepskyblue"=>"#00bfff","lightblue"=>"#add8e6","powderblue"=>"#b0e0e6","darkturquoise"=>"#00ced1","cadetblue"=>"#5f9ea0","cyan"=>"#00ffff","teal"=>"#008080","mediumturquoise"=>"#48d1cc","lightseagreen"=>"#20b2aa","paleturquoise"=>"#afeeee","mediumspringgreen"=>"#00fa9a","springgreen"=>"#00ff7f","darkseagreen"=>"#8fbc8f","palegreen"=>"#98fb98","lmgreen"=>"#32cd32","forestgreen"=>"#228b22","darkgreen"=>"#006400","lawngreen"=>"#7cfc00","grnyellow"=>"#adff2f","darkolivegreen"=>"#556b2f","olvdrab"=>"#6b8e23","yellow"=>"#ffff00","olive"=>"#808000","darkkhaki"=>"#bdb76b","khaki"=>"#f0e68c","gold"=>"#ffd700","gldenrod"=>"#daa520","orange"=>"#ffa500","wheat"=>"#f5deb3","navajowhite"=>"#ffdead","burlywood"=>"#deb887","darkorange"=>"#ff8c00","sienna"=>"#a0522d","orngred"=>"#ff4500","tomato"=>"#ff6347","salmon"=>"#fa8072","brown"=>"#a52a2a","red"=>"#ff0000","black"=>"#000000","darkgrey"=>"#a9a9a9","dimgrey"=>"#696969","lightgrey"=>"#d3d3d3","slategrey"=>"#708090","lightslategrey"=>"#778899","silver"=>"#c0c0c0","whtsmoke"=>"#f5f5f5","white"=>"#ffffff");
	foreach((array)$colorArray as $k => $v){			
		if(strstr(trim($val), '_'.$k)){				
			return $v;
		}
	}
	return $val;
	
}

function PQ_AIO_getNormalColorStructure($name, $val){
	$array = array(
		'background_button_block' => 'pq_btngbg_bgcolor_btngroup_PQCC',
		'background_text_block' => 'pq_bgtxt_bgcolor_bgtxt_PQCC',
		'background_form_block' => 'pq_formbg_bgcolor_formbg_PQCC',
		'background_soc_block' => 'pq_bgsocblock_bgcolor_bgsocblock_PQCC',
		'overlay' => 'pq_over_bgcolor_PQCC',
		'button_text_color' => 'pq_btn_color_btngroupbtn_PQCC',
		'button_color' => 'pq_btn_bg_bgcolor_btngroupbtn_PQCC',
		'head_color' => 'pq_h_color_h1_PQCC',
		'text_color' => 'pq_text_color_block_PQCC',
		'border_color' => 'pq_bd_bordercolor_PQCC',
		'bookmark_text_color' => 'pq_text_color_block_PQCC',
		'bookmark_background_color' => 'pq_bg_bgcolor_PQCC',
		'close_icon_color' => 'pq_x_color_pqclose_PQCC',
		'gallery_background_color' => 'pq_bg_bgcolor_PQCC',
		'gallery_button_text_color' => 'pq_btn_color_btngroupbtn_PQCC',
		'gallery_button_color' => 'pq_btn_bg_bgcolor_btngroupbtn_PQCC',		
		'gallery_head_color' => 'pq_h_color_h1_PQCC',
		'tblock_text_font_color' => 'pq_bgtxt_color_bgtxtp_PQCC',
		'background_mobile_block' => 'pq_mblock_bgcolor_bgmobblock_PQCC',
		'mblock_text_font_color' => 'pq_mblock_color_bgmobblockp_PQCC',
		'formbar_background_color' => 'pq_formbar_bg_bgcolor_PQCC',
		'formbar_border_color' => 'pq_formbar_bd_bordercolor_PQCC',
		'formbar_head_color' => 'pq_formbar_h_color_p_PQCC',
		'formbar_close_icon_color' => 'pq_formbar_x_color_fbclose_PQCC'
	);
	$ret = '';
	if(trim($val)){
		if(strstr(trim($val), '#')){
			$ret = $array[$name].str_replace('#','',trim($val));
		}else{
			$ret = $array[$name].str_replace('#','',trim(PQ_AIO_colorToHex($val)));
		}
	}
	return $ret;
}

function PQ_AIO_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

function PQ_AIO_getBackgroundColor($bg, $opacity){
	$ret = '';
	if((int)$opacity == 0) $opacity = 10;
	if($bg && $opacity){		
		$rgb = PQ_AIO_hex2rgb(str_replace('#','',trim(PQ_AIO_colorToHex($bg))));		
		$ret = 'pq_bg_bgcolor_PQRGBA_'.(int)$rgb[0].'_'.(int)$rgb[1].'_'.(int)$rgb[2].'_'.$opacity;		
	}
	return $ret;
}

function PQ_AIO_getThankCode($data){
	$data = PQ_AIO_checkIssetValue($data);
	$return = array();
	//enable
	if((string)$data['enable'] == 'on' || (int)$data['enable'] == 1) $return['enable'] = 1; else $return['enable'] = 0;
	//animation
	if($data['animation']) $return['animation'] = 'pq_animated '.$data['animation'];	
	
	//closeIconOption
	$return['closeIconOption']['animation'] = stripslashes($data['close_icon']['animation']);
	$return['closeIconOption']['button_text'] = htmlspecialchars(stripslashes($data['close_icon']['button_text']));
	
	
	//designOptions	
	$return['designOptions'] = $data['typeWindow'].' '.$return['animation'].' '.$data['popup_form'].' '.PQ_AIO_getBackgroundColor($data['background_color'], $data['background_opacity']).' '.$data['head_font'];
	$return['designOptions'] .= ' '.$data['head_size'].' '.PQ_AIO_getNormalColorStructure('head_color', $data['head_color']).' '.$data['text_font'].' '.$data['font_size'].' '.PQ_AIO_getNormalColorStructure('text_color', $data['text_color']);    
	$return['designOptions'] .= ' '.PQ_AIO_getNormalColorStructure('border_color', $data['border_color']).' '.$data['button_font'].' '.PQ_AIO_getNormalColorStructure('button_text_color', $data['button_text_color']).' '.PQ_AIO_getNormalColorStructure('button_color', $data['button_color']);
	$return['designOptions'] .= ' '.$data['close_icon']['form'].' '.PQ_AIO_getNormalColorStructure('close_icon_color', $data['close_icon']['color']).' '.$data['button_font_size'];
	$return['designOptions'] .= ' '.PQ_AIO_getNormalColorStructure('background_button_block', $data['background_button_block']).' '.PQ_AIO_getNormalColorStructure('background_soc_block', $data['background_soc_block']);
		
	$return['designOptions'] .= ' '.$data['header_img_type'].' '.$data['close_text_font'];
	$return['designOptions'] .= ' '.$data['form_block_padding'].' '.$data['button_block_padding'];
	$return['designOptions'] .= ' '.$data['text_block_padding'].' '.$data['icon_block_padding'];
	$return['designOptions'] .= ' '.$data['button_form'].' '.$data['input_type'].' '.$data['button_type'];
	$return['designOptions'] .= ' '.$data['showup_animation'];
	
	//img
	$return['header_image_src'] = stripslashes($data['header_image_src']);	
	$return['background_image_src'] = stripslashes($data['background_image_src']);	
	
	
	//txt
	$return['title'] = htmlspecialchars(stripslashes($data['title']));
	$return['sub_title'] = htmlspecialchars(stripslashes($data['sub_title']));	
	
	if($data['socnet_block_type'] == 'follow' || $data['socnet_block_type'] == 'share'){		
		$return['designOptions'] .= ' '.$data['icon']['design'].' '.$data['icon']['form'].' '.$data['icon']['size'].' '.$data['icon']['space'];
		$return['socnetBlockType'] = $data['socnet_block_type'];
		$return['hoverAnimation'] = $data['icon']['animation'];		
		
		if($data['socnet_block_type'] == 'share'){
			foreach((array)$data['socnet_with_pos'] as $k => $v){
				if($v){
					$return['socnetShareBlock'][$v]['exactPageShare'] = 1;
				}
			}
		}
		//		
		if($data['socnet_block_type'] == 'follow'){
			foreach((array)$data['socnetIconsBlock'] as $k => $v){
				if($k && $v){
					if($k == 'FB' || $k == 'facebook') {
						$v = str_replace('https://facebook.com','',$v);
						$v = str_replace('http://facebook.com','',$v);
						$return['socnetFollowBlock']['facebook'] = stripslashes('https://facebook.com/'.$v);
					}
					if($k == 'TW' || $k == 'twitter') {
						$v = str_replace('https://twitter.com','',$v);
						$v = str_replace('http://twitter.com','',$v);
						$return['socnetFollowBlock']['twitter'] = stripslashes('https://twitter.com/'.$v);
					}
					if($k == 'GP' || $k == 'google-plus') {
						$v = str_replace('https://plus.google.com','',$v);
						$v = str_replace('http://plus.google.com','',$v);						
						$return['socnetFollowBlock']['google-plus'] = stripslashes('https://plus.google.com/'.$v);
					}
					if($k == 'PI' || $k == 'pinterest') {
						$v = str_replace('https://pinterest.com','',$v);
						$v = str_replace('http://pinterest.com','',$v);
						$return['socnetFollowBlock']['pinterest'] = stripslashes('https://pinterest.com/'.$v);
					}
					if($k == 'VK' || $k == 'vk') {
						$v = str_replace('https://vk.com/','',$v);
						$v = str_replace('http://vk.com/','',$v);
						$return['socnetFollowBlock']['vk'] = stripslashes('http://vk.com/'.$v);
					}
					if($k == 'YT' || $k == 'youtube') {
						$v = str_replace('https://www.youtube.com/channel/','',$v);
						$v = str_replace('http://www.youtube.com/channel/','',$v);
						$return['socnetFollowBlock']['youtube'] = stripslashes('https://www.youtube.com/channel/'.$v);
					}
					if($k == 'RSS') {
						$return['socnetFollowBlock']['RSS'] = stripslashes($v);
					}
					if($k == 'IG' || $k == 'instagram') {
						$v = str_replace('https://instagram.com','',$v);
						$v = str_replace('http://instagram.com','',$v);
						$return['socnetFollowBlock']['instagram'] = stripslashes('http://instagram.com/'.$v);
					}
					if($k == 'OD' || $k == 'odnoklassniki') {
						$v = str_replace('https://ok.ru','',$v);
						$v = str_replace('http://ok.ru','',$v);
						$return['socnetFollowBlock']['odnoklassniki'] = stripslashes('http://ok.ru/'.$v);
					}
					if($k == 'LI' || $k == 'linkedin') {
						$v = str_replace('https://www.linkedin.com/','',$v);
						$v = str_replace('http://www.linkedin.com/','',$v);
						$return['socnetFollowBlock']['linkedin'] = stripslashes('https://www.linkedin.com/'.$v);
					}
				}
			}
		}
	}
	if(isset($data['buttonBlock']['type'])){
		if($data['buttonBlock']['type'] == 'redirect'){
			$return['buttonActionBlock']['type'] = 'redirect';
			$return['buttonActionBlock']['redirect_url'] = stripslashes($data['buttonBlock']['url']);
			$return['buttonActionBlock']['button_text'] = htmlspecialchars(stripslashes($data['buttonBlock']['button_text']));
		}
	}
		
	
	
	if($data['overlay']){
		$return['blackoutOption']['enable'] = 1;
		$return['blackoutOption']['style'] = PQ_AIO_getNormalColorStructure('overlay', $data['overlay']).' '.$data['overlay_opacity'];
	}
	
	if($data['overlay_image_src']){
		$return['blackoutOption']['enable'] = 1;
		$return['blackoutOption']['background_image_src'] = $data['overlay_image_src'];
	}
	
	return $return;
}

function PQ_AIO_checkIssetValue($array){
	$array['enable'] = (isset($array['enable']))?$array['enable']:'';
	$array['overlay_opacity'] = (isset($array['overlay_opacity']))?$array['overlay_opacity']:'';
	$array['overlay'] = (isset($array['overlay']))?$array['overlay']:'';
	$array['background_color'] = (isset($array['background_color']))?$array['background_color']:'';
	$array['icon']['animation'] = (isset($array['icon']['animation']))?$array['icon']['animation']:'';
	$array['close_icon']['animation'] = (isset($array['close_icon']['animation']))?$array['close_icon']['animation']:'';
	$array['close_icon']['button_text'] = (isset($array['close_icon']['button_text']))?$array['close_icon']['button_text']:'';
	$array['position'] = (isset($array['position']))?$array['position']:'';
	$array['animation'] = (isset($array['animation']))?$array['animation']:'';
	$array['typeWindow'] = (isset($array['typeWindow']))?$array['typeWindow']:'';
	$array['bookmark_background'] = (isset($array['bookmark_background']))?$array['bookmark_background']:'';
	$array['bookmark_text_color'] = (isset($array['bookmark_text_color']))?$array['bookmark_text_color']:'';
	$array['bookmark_text_font'] = (isset($array['bookmark_text_font']))?$array['bookmark_text_font']:'';
	$array['bookmark_text_size'] = (isset($array['bookmark_text_size']))?$array['bookmark_text_size']:'';
	$array['themeClass'] = (isset($array['themeClass']))?$array['themeClass']:'';
	$array['icon']['design'] = (isset($array['icon']['design']))?$array['icon']['design']:'';
	$array['icon']['form'] = (isset($array['icon']['form']))?$array['icon']['form']:'';
	$array['icon']['size'] = (isset($array['icon']['size']))?$array['icon']['size']:'';
	$array['icon']['space'] = (isset($array['icon']['space']))?$array['icon']['space']:'';
	$array['icon']['shadow'] = (isset($array['icon']['shadow']))?$array['icon']['shadow']:'';
	$array['mobile_type'] = (isset($array['mobile_type']))?$array['mobile_type']:'';
	$array['mobile_position'] = (isset($array['mobile_position']))?$array['mobile_position']:'';
	$array['background_mobile_block'] = (isset($array['background_mobile_block']))?$array['background_mobile_block']:'';
	$array['mblock_text_font'] = (isset($array['mblock_text_font']))?$array['mblock_text_font']:'';
	$array['mblock_text_font_color'] = (isset($array['mblock_text_font_color']))?$array['mblock_text_font_color']:'';
	$array['mblock_text_font_size'] = (isset($array['mblock_text_font_size']))?$array['mblock_text_font_size']:'';
	$array['background_opacity'] = (isset($array['background_opacity']))?$array['background_opacity']:'';
	$array['text_font'] = (isset($array['text_font']))?$array['text_font']:'';
	$array['font_size'] = (isset($array['font_size']))?$array['font_size']:'';
	$array['text_color'] = (isset($array['text_color']))?$array['text_color']:'';
	$array['button_font'] = (isset($array['button_font']))?$array['button_font']:'';
	$array['button_text_color'] = (isset($array['button_text_color']))?$array['button_text_color']:'';
	$array['button_color'] = (isset($array['button_color']))?$array['button_color']:'';
	$array['button_font_size'] = (isset($array['button_font_size']))?$array['button_font_size']:'';
	$array['border_color'] = (isset($array['border_color']))?$array['border_color']:'';
	$array['popup_form'] = (isset($array['popup_form']))?$array['popup_form']:'';
	$array['head_font'] = (isset($array['head_font']))?$array['head_font']:'';
	$array['head_size'] = (isset($array['head_size']))?$array['head_size']:'';
	$array['head_color'] = (isset($array['head_color']))?$array['head_color']:'';
	$array['close_icon']['form'] = (isset($array['close_icon']['form']))?$array['close_icon']['form']:'';
	$array['close_icon']['color'] = (isset($array['close_icon']['color']))?$array['close_icon']['color']:'';
	$array['header_img_type'] = (isset($array['header_img_type']))?$array['header_img_type']:'';
	$array['close_text_font'] = (isset($array['close_text_font']))?$array['close_text_font']:'';
	$array['form_block_padding'] = (isset($array['form_block_padding']))?$array['form_block_padding']:'';
	$array['button_block_padding'] = (isset($array['button_block_padding']))?$array['button_block_padding']:'';
	$array['text_block_padding'] = (isset($array['text_block_padding']))?$array['text_block_padding']:'';
	$array['icon_block_padding'] = (isset($array['icon_block_padding']))?$array['icon_block_padding']:'';
	$array['button_form'] = (isset($array['button_form']))?$array['button_form']:'';
	$array['input_type'] = (isset($array['input_type']))?$array['input_type']:'';
	$array['button_type'] = (isset($array['button_type']))?$array['button_type']:'';
	$array['showup_animation'] = (isset($array['showup_animation']))?$array['showup_animation']:'';
	$array['background_button_block'] = (isset($array['background_button_block']))?$array['background_button_block']:'';
	$array['background_text_block'] = (isset($array['background_text_block']))?$array['background_text_block']:'';
	$array['background_form_block'] = (isset($array['background_form_block']))?$array['background_form_block']:'';
	$array['background_soc_block'] = (isset($array['background_soc_block']))?$array['background_soc_block']:'';
	$array['tblock_text_font_color'] = (isset($array['tblock_text_font_color']))?$array['tblock_text_font_color']:'';
	$array['icon']['position'] = (isset($array['icon']['position']))?$array['icon']['position']:'';
	$array['formbar_border_type'] = (isset($array['formbar_border_type']))?$array['formbar_border_type']:'';
	$array['formbar_border_depth'] = (isset($array['formbar_border_depth']))?$array['formbar_border_depth']:'';
	$array['formbar_animation'] = (isset($array['formbar_animation']))?$array['formbar_animation']:'';
	$array['formbar_head_font'] = (isset($array['formbar_head_font']))?$array['formbar_head_font']:'';
	$array['formbar_head_font_size'] = (isset($array['formbar_head_font_size']))?$array['formbar_head_font_size']:'';
	$array['formbar_close_icon_animation'] = (isset($array['formbar_close_icon_animation']))?$array['formbar_close_icon_animation']:'';
	$array['formbar_roll_icon_animation'] = (isset($array['formbar_roll_icon_animation']))?$array['formbar_roll_icon_animation']:'';
	$array['formbar_close_icon']['form'] = (isset($array['formbar_close_icon']['form']))?$array['formbar_close_icon']['form']:'';
	$array['formbar_close_icon']['color'] = (isset($array['formbar_close_icon']['color']))?$array['formbar_close_icon']['color']:'';
	$array['formbar_background_color'] = (isset($array['formbar_background_color']))?$array['formbar_background_color']:'';
	$array['formbar_border_color'] = (isset($array['formbar_border_color']))?$array['formbar_border_color']:'';
	$array['formbar_head_color'] = (isset($array['formbar_head_color']))?$array['formbar_head_color']:'';
	$array['formbar_close_icon']['color'] = (isset($array['formbar_close_icon']['color']))?$array['formbar_close_icon']['color']:'';
	$array['showup_animation'] = (isset($array['showup_animation']))?$array['showup_animation']:'';
	$array['formbar_header_img_type'] = (isset($array['formbar_header_img_type']))?$array['formbar_header_img_type']:'';
	$array['formbar_close_text_font'] = (isset($array['formbar_close_text_font']))?$array['formbar_close_text_font']:'';
	$array['formbar_title'] = (isset($array['formbar_title']))?$array['formbar_title']:'';
	$array['formbar_header_image_src'] = (isset($array['formbar_header_image_src']))?$array['formbar_header_image_src']:'';
	$array['formBarOptions']['rollIconOption']['animation'] = (isset($array['formBarOptions']['rollIconOption']['animation']))?$array['formBarOptions']['rollIconOption']['animation']:'';
	$array['formbar_close_icon']['animation'] = (isset($array['formbar_close_icon']['animation']))?$array['formbar_close_icon']['animation']:'';
	$array['formbar_close_icon']['button_text'] = (isset($array['formbar_close_icon']['button_text']))?$array['formbar_close_icon']['button_text']:'';
	$array['galleryOption']['head_font'] = (isset($array['galleryOption']['head_font']))?$array['galleryOption']['head_font']:'';
	$array['galleryOption']['head_size'] = (isset($array['galleryOption']['head_size']))?$array['galleryOption']['head_size']:'';
	$array['galleryOption']['button_font'] = (isset($array['galleryOption']['button_font']))?$array['galleryOption']['button_font']:'';
	$array['galleryOption']['button_font_size'] = (isset($array['galleryOption']['button_font_size']))?$array['galleryOption']['button_font_size']:'';
	$array['galleryOption']['button_text_color'] = (isset($array['galleryOption']['button_text_color']))?$array['galleryOption']['button_text_color']:'';
	$array['galleryOption']['button_color'] = (isset($array['galleryOption']['button_color']))?$array['galleryOption']['button_color']:'';
	$array['galleryOption']['background_color'] = (isset($array['galleryOption']['background_color']))?$array['galleryOption']['background_color']:'';
	$array['galleryOption']['head_color'] = (isset($array['galleryOption']['head_color']))?$array['galleryOption']['head_color']:'';
	$array['galleryOption']['title'] = (isset($array['galleryOption']['title']))?$array['galleryOption']['title']:'';
	$array['galleryOption']['button_text'] = (isset($array['galleryOption']['button_text']))?$array['galleryOption']['button_text']:'';
	$array['galleryOption']['minWidth'] = (isset($array['galleryOption']['minWidth']))?$array['galleryOption']['minWidth']:'';
	$array['displayRules']['allowedExtensions'] = (isset($array['displayRules']['allowedExtensions']))?$array['displayRules']['allowedExtensions']:'';
	$array['displayRules']['display_on_main_page'] = (isset($array['displayRules']['display_on_main_page']))?$array['displayRules']['display_on_main_page']:'';
	$array['displayRules']['work_on_mobile'] = (isset($array['displayRules']['work_on_mobile']))?$array['displayRules']['work_on_mobile']:'';
	$array['displayRules']['allowedImageAddress'] = (isset($array['displayRules']['allowedImageAddress']))?$array['displayRules']['allowedImageAddress']:'';
	$array['galleryOption']['enable'] = (isset($array['galleryOption']['enable']))?$array['galleryOption']['enable']:'';
	$array['socnetOption'] = (isset($array['socnetOption']))?$array['socnetOption']:array();
	
	//rxr
	$array['title'] = (isset($array['title']))?$array['title']:'';
	$array['formbar_title'] = (isset($array['formbar_title']))?$array['formbar_title']:'';
	$array['tblock_text'] = (isset($array['tblock_text']))?$array['tblock_text']:'';
	$array['sub_title'] = (isset($array['sub_title']))?$array['sub_title']:'';
	$array['mobile_title'] = (isset($array['mobile_title']))?$array['mobile_title']:'';
	$array['galleryOption']['title'] = (isset($array['galleryOption']['title']))?$array['galleryOption']['title']:'';
	$array['galleryOption']['button_text'] = (isset($array['galleryOption']['button_text']))?$array['galleryOption']['button_text']:'';
	$array['enter_email_text'] = (isset($array['enter_email_text']))?$array['enter_email_text']:'';
	$array['enter_name_text'] = (isset($array['enter_name_text']))?$array['enter_name_text']:'';
	$array['enter_phone_text'] = (isset($array['enter_phone_text']))?$array['enter_phone_text']:'';
	$array['enter_message_text'] = (isset($array['enter_message_text']))?$array['enter_message_text']:'';
	$array['enter_subject_text'] = (isset($array['enter_subject_text']))?$array['enter_subject_text']:'';
	$array['loader_text'] = (isset($array['loader_text']))?$array['loader_text']:'';
	$array['button_text'] = (isset($array['button_text']))?$array['button_text']:'';
	$array['close_icon']['button_text'] = (isset($array['close_icon']['button_text']))?$array['close_icon']['button_text']:'';
	$array['formbar_close_icon']['button_text'] = (isset($array['formbar_close_icon']['button_text']))?$array['formbar_close_icon']['button_text']:'';
	$array['background_image_src'] = (isset($array['background_image_src']))?$array['background_image_src']:'';
	$array['header_image_src'] = (isset($array['header_image_src']))?$array['header_image_src']:'';
	$array['formbar_header_image_src'] = (isset($array['formbar_header_image_src']))?$array['formbar_header_image_src']:'';
	$array['url'] = (isset($array['url']))?$array['url']:'';
	$array['iframe_src'] = (isset($array['iframe_src']))?$array['iframe_src']:'';
	$array['overlay_image_src'] = (isset($array['overlay_image_src']))?$array['overlay_image_src']:'';
	$array['mail_subject'] = (isset($array['mail_subject']))?$array['mail_subject']:'';
	return $array;
}

//Prepare output sctructure
function PQ_AIO_prepareCode($data, $bookmark = 0, $formBar = 0){	
	$return = $data = PQ_AIO_checkIssetValue($data);
	
	
	
	//enable
	if(isset($data['enable']) && (string)$data['enable'] == 'on' || (int)$data['enable'] == 1) $return['enable'] = 1; else $return['enable'] = 0;
	
	//hoverAnimation
	$return['hoverAnimation'] = $return['icon']['animation'];
	
	//closeIconOption
	
	$return['closeIconOption']['animation'] = stripslashes($data['close_icon']['animation']);
	$return['closeIconOption']['button_text'] = htmlspecialchars(stripslashes($data['close_icon']['button_text']));
/************************************************GENERATE TYPE WINDOW********************************************************************************/
	//position
	if($data['position'] == 'BAR_TOP') $return['position'] = 'pq_top';
	if($data['position'] == 'BAR_BOTTOM') $return['position'] = 'pq_bottom';
	if($data['position'] == 'SIDE_LEFT_TOP') $return['position'] = 'pq_left pq_top';
	if($data['position'] == 'SIDE_LEFT_MIDDLE') $return['position'] = 'pq_left pq_middle';
	if($data['position'] == 'SIDE_LEFT_BOTTOM') $return['position'] = 'pq_left pq_bottom';
	if($data['position'] == 'SIDE_RIGHT_TOP') $return['position'] = 'pq_right pq_top';
	if($data['position'] == 'SIDE_RIGHT_MIDDLE') $return['position'] = 'pq_right pq_middle';
	if($data['position'] == 'SIDE_RIGHT_BOTTOM') $return['position'] = 'pq_right pq_bottom';
	if($data['position'] == 'CENTER') $return['position'] = '';
	if($data['position'] == 'FLOATING_LEFT_TOP') $return['position'] = 'pq_fixed pq_left pq_top';
	if($data['position'] == 'FLOATING_LEFT_BOTTOM') $return['position'] = 'pq_fixed pq_left pq_bottom';
	if($data['position'] == 'FLOATING_RIGHT_TOP') $return['position'] = 'pq_fixed pq_right pq_top';
	if($data['position'] == 'FLOATING_RIGHT_BOTTOM') $return['position'] = 'pq_fixed pq_right pq_bottom';
	
	//animation
	if($data['animation']) $return['animation'] = 'pq_animated '.$data['animation'];	
	
	if((int)$bookmark == 1){
		$return['designOptions'] = $return['typeWindow'];
		$return['typeBookmarkWindow'] = $return['position'].' '.PQ_AIO_getNormalColorStructure('bookmark_background_color', $data['bookmark_background']).' '.PQ_AIO_getNormalColorStructure('bookmark_text_color',$return['bookmark_text_color']).' '.$return['bookmark_text_font'].' '.$return['bookmark_text_size'];
	}else{
		if((int)$formBar == 1){
			$return['designOptions'] = $return['typeWindow'];
		}else{
			$return['designOptions'] = $return['typeWindow'].' '.$return['position'];
		}
		
	}
	
	$return['designOptions'] .=' '.$return['themeClass'].' '.$return['icon']['design'].' '.$return['icon']['form'].' '.$return['icon']['size'].' '.$return['icon']['space'].' '.$return['icon']['shadow'];
	$return['designOptions'] .=' '.$return['animation'].' '.$return['mobile_type'].' '.$return['mobile_position'];
	//new mobile
	$return['designOptions'] .=' '.PQ_AIO_getNormalColorStructure('background_mobile_block',$return['background_mobile_block']).' '.$return['mblock_text_font'].' '.PQ_AIO_getNormalColorStructure('mblock_text_font_color',$return['mblock_text_font_color']).' '.$return['mblock_text_font_size'];	
	$return['designOptions'] .=' '.PQ_AIO_getBackgroundColor($data['background_color'], $data['background_opacity']).' '.$return['text_font'].' '.$return['font_size'].' '.PQ_AIO_getNormalColorStructure('text_color',$return['text_color']).' '.$return['button_font'];
	$return['designOptions'] .=' '.PQ_AIO_getNormalColorStructure('button_text_color',$return['button_text_color']).' '.PQ_AIO_getNormalColorStructure('button_color',$return['button_color']).' '.$return['button_font_size'];
	$return['designOptions'] .=' '.PQ_AIO_getNormalColorStructure('border_color',$return['border_color']).' '.$return['popup_form'].' '.$return['head_font'];
	$return['designOptions'] .=' '.$return['head_size'].' '.PQ_AIO_getNormalColorStructure('head_color',$return['head_color']);	
	$return['designOptions'] .= ' '.$data['close_icon']['form'].' '.PQ_AIO_getNormalColorStructure('close_icon_color', $data['close_icon']['color']);
	$return['designOptions'] .= ' '.$data['header_img_type'].' '.$data['close_text_font'];
	$return['designOptions'] .= ' '.$data['form_block_padding'].' '.$data['button_block_padding'];
	$return['designOptions'] .= ' '.$data['text_block_padding'].' '.$data['icon_block_padding'];
	$return['designOptions'] .= ' '.$data['button_form'].' '.$data['input_type'].' '.$data['button_type'];
	$return['designOptions'] .= ' '.$data['showup_animation'];
		
	
	//new
	$return['designOptions'] .= ' '.PQ_AIO_getNormalColorStructure('background_button_block', $data['background_button_block']).' '.PQ_AIO_getNormalColorStructure('background_text_block', $data['background_text_block']).' '.PQ_AIO_getNormalColorStructure('background_form_block', $data['background_form_block']).' '.PQ_AIO_getNormalColorStructure('background_soc_block', $data['background_soc_block']).' '.PQ_AIO_getNormalColorStructure('tblock_text_font_color', $data['tblock_text_font_color']);
	
	$return['designOptions'] = str_replace('  ', ' ',$return['designOptions']);
	$return['designOptions'] = str_replace('  ', ' ',$return['designOptions']);
	
	//type Design
	$return['typeDesign'] = $return['themeClass'].' '.$return['icon']['form'].' '.$return['icon']['size'].' '.$return['icon']['space'].' '.$return['icon']['shadow'].' '.$return['icon']['position'];
	
	//formBar
	$return['formBarOptions']['designOptions'] = $return['themeClass'].' '.$return['position'];
	$return['formBarOptions']['designOptions'] .= ' '.$return['formbar_border_type'].' '.$return['formbar_border_depth'].' '.$return['formbar_border_depth'].' pq_animated '.$return['formbar_animation'];
	$return['formBarOptions']['designOptions'] .= ' '.$return['formbar_head_font'].' '.$return['formbar_head_font_size'].' '.$return['formbar_close_icon_animation'].' '.$return['formbar_roll_icon_animation'];
	$return['formBarOptions']['designOptions'] .= ' '.$return['formbar_close_icon']['form'];
	$return['formBarOptions']['designOptions'] .= ' '.$return['formbar_close_icon']['color'];
	$return['formBarOptions']['designOptions'] .= ' '.PQ_AIO_getNormalColorStructure('formbar_background_color',$return['formbar_background_color']);
	$return['formBarOptions']['designOptions'] .= ' '.PQ_AIO_getNormalColorStructure('formbar_border_color',$return['formbar_border_color']);
	$return['formBarOptions']['designOptions'] .= ' '.PQ_AIO_getNormalColorStructure('formbar_head_color',$return['formbar_head_color']);
	$return['formBarOptions']['designOptions'] .= ' '.PQ_AIO_getNormalColorStructure('formbar_close_icon_color',$return['formbar_close_icon']['color']);
	$return['formBarOptions']['designOptions'] .= ' '.$data['showup_animation'];
	$return['formBarOptions']['designOptions'] .= ' '.$data['formbar_header_img_type'];
	$return['formBarOptions']['designOptions'] .= ' '.$data['formbar_close_text_font'];
	
	$return['formBarOptions']['title'] = stripslashes($data['formbar_title']);
	$return['formBarOptions']['header_image_src'] = stripslashes($data['formbar_header_image_src']);	
	$return['formBarOptions']['closeIconOption']['animation'] = $return['formBarOptions']['rollIconOption']['animation'] = $data['formbar_close_icon']['animation'];	
	$return['formBarOptions']['closeIconOption']['button_text'] = $return['formbar_close_icon']['button_text'];	
/*************************************************************************************************************************************************/	

	if(isset($data['displayRules'])){
		unset($return['displayRules']);
		if(isset($data['displayRules']['pageMask'])){
			foreach((array)$data['displayRules']['pageMask'] as $k => $v){
				if($v){
					if($data['displayRules']['pageMaskType'][$k] == 'enable'){
						$return['displayRules']['enableOnPage'][] = $v;
					}else{
						$return['displayRules']['disableOnPage'][] = $v;
					}
				}
			}
		}
		
		$return['displayRules']['display_on_main_page'] = ($data['displayRules']['display_on_main_page'] == 'on')?1:0;
		$return['displayRules']['work_on_mobile'] = ($data['displayRules']['work_on_mobile'] == 'on')?1:0;
		$return['displayRules']['allowedExtensions'] = $data['displayRules']['allowedExtensions'];
		$return['displayRules']['allowedImageAddress'] = $data['displayRules']['allowedImageAddress'];
		
	}else{
		$return['displayRules'] = array();
	}
	if(isset($data['thank'])){
		$return['thank'] = PQ_AIO_getThankCode($data['thank']);
	}else{
		$return['thank'] = array();
	}
	
	

	if(isset($data['overlay']) && $data['overlay']){
		$return['blackoutOption']['enable'] = 1;
		$return['blackoutOption']['style'] = PQ_AIO_getNormalColorStructure('overlay',$data['overlay']).' '.$data['overlay_opacity'];
	}
	
	if(isset($data['overlay_image_src']) && $data['overlay_image_src']){
		$return['blackoutOption']['enable'] = 1;
		$return['blackoutOption']['background_image_src'] = $data['overlay_image_src'];
	}
	
	
	
	
	if(isset($data['url'])){
		$return['buttonBlock']['action'] = 'redirect';		
		$return['buttonBlock']['redirect_url'] = $data['url'];
		$return['buttonBlock']['button_text'] = $data['button_text'];
	}
	
	
	//galerryOptions
	if((string)$data['galleryOption']['enable'] == 'on' || (int)$data['galleryOption']['enable'] == 1){
		unset($return['galleryOption']);
		$return['galleryOption']['enable'] = 1;
		$return['galleryOption']['designOptions'] = $data['galleryOption']['head_font'].' '.$data['galleryOption']['head_size'].' '.$data['galleryOption']['button_font'].' '.$data['galleryOption']['button_font_size'].' '. PQ_AIO_getNormalColorStructure('gallery_button_text_color',$data['galleryOption']['button_text_color']).' '.PQ_AIO_getNormalColorStructure('gallery_button_color',$data['galleryOption']['button_color']).' '.PQ_AIO_getNormalColorStructure('gallery_background_color',$data['galleryOption']['background_color']).' '.PQ_AIO_getNormalColorStructure('gallery_head_color',$data['galleryOption']['head_color']);
		$return['galleryOption']['title'] = htmlspecialchars(stripslashes($data['galleryOption']['title']));
		$return['galleryOption']['button_text'] = htmlspecialchars(stripslashes($data['galleryOption']['button_text']));		
		$return['galleryOption']['minWidth'] = (int)$data['galleryOption']['minWidth'];		
	}
	
	//Image Sharer socnet
	if(isset($data['socnet'])){
		unset($return['socnet']);
		foreach((array)$data['socnet'] as $k => $v){
			if($v){
				$return['socnet'][$k] = (isset($data['socnetOption'][$k]))?$data['socnetOption'][$k]:'';
				if(isset($data['socnetOption'][$v])){
					if($data['socnetOption'][$k]['type'] == 'pq'){
						$return['socnet'][$k]['exactPageShare'] = 0;
					} else {
						$return['socnet'][$k]['exactPageShare'] = 1;
					}
				}else{
					$return['socnet'][$k]['exactPageShare'] = 1;
				}
			}
		}
		
	}
		
	//socnet_with_pos
	if(isset($data['socnet_with_pos'])){
		unset($return['socnet']);
		foreach((array)$data['socnet_with_pos'] as $k => $v){
			if($v){
				$return['shareSocnet'][$v] = (isset($data['socnetOption'][$v]))?$data['socnetOption'][$v]:'';
				if(isset($data['socnetOption'][$v])){
					if($data['socnetOption'][$v]['type'] == 'pq'){
						$return['shareSocnet'][$v]['exactPageShare'] = 0;
					} else {
						$return['shareSocnet'][$v]['exactPageShare'] = 1;
					}
				}else{
					$return['shareSocnet'][$v]['exactPageShare'] = 1;
				}
			}
		}		
	}
	
	
	//followSocnet
	if(isset($data['socnetIconsBlock'])){
		foreach((array)$data['socnetIconsBlock'] as $k => $v){
			if($k && $v){
				if($k == 'FB' || $k == 'facebook') {
					$v = str_replace('https://facebook.com','',$v);
					$v = str_replace('http://facebook.com','',$v);
					$return['socnetFollowBlock']['facebook'] = stripslashes('https://facebook.com/'.$v);
				}
				if($k == 'TW' || $k == 'twitter') {
					$v = str_replace('https://twitter.com','',$v);
					$v = str_replace('http://twitter.com','',$v);
					$return['socnetFollowBlock']['twitter'] = stripslashes('https://twitter.com/'.$v);
				}
				if($k == 'GP' || $k == 'google-plus') {
					$v = str_replace('https://plus.google.com','',$v);
					$v = str_replace('http://plus.google.com','',$v);						
					$return['socnetFollowBlock']['google-plus'] = stripslashes('https://plus.google.com/'.$v);
				}
				if($k == 'PI' || $k == 'pinterest') {
					$v = str_replace('https://pinterest.com','',$v);
					$v = str_replace('http://pinterest.com','',$v);
					$return['socnetFollowBlock']['pinterest'] = stripslashes('https://pinterest.com/'.$v);
				}
				if($k == 'VK' || $k == 'vk') {
					$v = str_replace('https://vk.com/','',$v);
					$v = str_replace('http://vk.com/','',$v);
					$return['socnetFollowBlock']['vk'] = stripslashes('http://vk.com/'.$v);
				}
				if($k == 'YT' || $k == 'youtube') {
					$v = str_replace('https://www.youtube.com/channel/','',$v);
					$v = str_replace('http://www.youtube.com/channel/','',$v);
					$return['socnetFollowBlock']['youtube'] = stripslashes('https://www.youtube.com/channel/'.$v);
				}
				if($k == 'RSS') {
					$return['socnetFollowBlock']['RSS'] = stripslashes($v);
				}
				if($k == 'IG' || $k == 'instagram') {
					$v = str_replace('https://instagram.com','',$v);
					$v = str_replace('http://instagram.com','',$v);
					$return['socnetFollowBlock']['instagram'] = stripslashes('http://instagram.com/'.$v);
				}
				if($k == 'OD' || $k == 'odnoklassniki') {
					$v = str_replace('https://ok.ru','',$v);
					$v = str_replace('http://ok.ru','',$v);
					$return['socnetFollowBlock']['odnoklassniki'] = stripslashes('http://ok.ru/'.$v);
				}
				if($k == 'LI' || $k == 'linkedin') {
					$v = str_replace('https://www.linkedin.com/','',$v);
					$v = str_replace('http://www.linkedin.com/','',$v);
					$return['socnetFollowBlock']['linkedin'] = stripslashes('https://www.linkedin.com/'.$v);
				}
			}
		}		
	}	
	
	if(!isset($return['blackoutOption'])) $return['blackoutOption'] = array();
	if(!isset($return['eventHandler'])) $return['eventHandler'] = array();
	if(!isset($return['withCounter'])) $return['withCounter'] = '';
	if(!isset($return['provider'])) $return['provider'] = '';
	if(!isset($return['lockedMechanism'])) $return['lockedMechanism'] = array();
	if(!isset($return['providerOption'])) $return['providerOption'] = array();
	
	return $return;
}
function PQ_AIO_code_injection(){
	global $profitquery;		
	$PQ_AIO_code = array();
	if((int)$profitquery['pq_aio_widgets_loaded'] == 1)
	{
	//sharingSidebar
	$preparedObject = PQ_AIO_prepareCode($profitquery['sharingSidebar'], 0);
	$sendMailWindow = PQ_AIO_prepareCode($profitquery['sharingSidebar']['sendMailWindow'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];	
	//printr($preparedObject);
	//printr($sendMailWindow);	
	$PQ_AIO_code['sharingSideBarOptions'] = array(
		'designOptions'=>'pq_icons '.$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],
		'socnetIconsBlock'=>$preparedObject['shareSocnet'],
		'withCounters'=>$preparedObject['withCounter'],
		'mobile_title'=>htmlspecialchars(stripslashes($preparedObject['mobile_title'])),		
		'hoverAnimation'=>stripslashes($preparedObject['hoverAnimation']),		
		'eventHandler'=>$preparedObject['eventHandler'],
		'galleryOption'=>$preparedObject['galleryOption'],
		'displayRules'=>$preparedObject['displayRules'],		
		'sendMailWindow'=>$sendMailWindow,
		'thankPopup'=>$preparedObject['thank']
	);	
	//imageSharer
	$preparedObject = PQ_AIO_prepareCode($profitquery['imageSharer'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];
	$sendMailWindow = PQ_AIO_prepareCode($profitquery['imageSharer']['sendMailWindow'], 0);
	$PQ_AIO_code['imageSharer'] = array(
		'typeDesign'=>$preparedObject['typeDesign'],		
		'enable'=>(int)$preparedObject['enable'],
		'hoverAnimation'=>stripslashes($preparedObject['hoverAnimation']),
		'minWidth'=>(int)$preparedObject['minWidth'],		
		'minHeight'=>(int)$preparedObject['minHeight'],		
		'activeSocnet'=>$preparedObject['socnet'],
		'sendMailWindow'=>$sendMailWindow,
		'displayRules'=>$preparedObject['displayRules'],	
		'thankPopup'=>$preparedObject['thank']
	);
	
	//emailListBuilderBar
	$preparedObject = PQ_AIO_prepareCode($profitquery['emailListBuilderBar'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];	
	$PQ_AIO_code['subscribeBarOptions'] = array(
		'designOptions'=>'pq_bar '.$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),
		'mobile_title'=>stripslashes($preparedObject['mobile_title']),
		'closeIconOption'=>$preparedObject['closeIconOption'],
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'enter_email_text'=>stripslashes($preparedObject['enter_email_text']),
		'enter_name_text'=>stripslashes($preparedObject['enter_name_text']),
		'button_text'=>stripslashes($preparedObject['button_text']),		
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],
		'subscribeProvider'=>stripslashes($preparedObject['provider']),
		'subscribeProviderOption'=>$preparedObject['providerOption'],
		'thankPopup'=>$preparedObject['thank']
	);
	
	//emailListBuilderFormBar
	$preparedObject = PQ_AIO_prepareCode($profitquery['emailListBuilderFormBar'], 0, 1);		
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];	
	$PQ_AIO_code['subscribeFormBarOptions'] = array(
		'formBarOptions'=>$preparedObject['formBarOptions'],
		'designOptions'=>$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),		
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),
		'closeIconOption'=>$preparedObject['closeIconOption'],
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'enter_email_text'=>stripslashes($preparedObject['enter_email_text']),
		'enter_name_text'=>stripslashes($preparedObject['enter_name_text']),		
		'button_text'=>stripslashes($preparedObject['button_text']),
		'blackoutOption'=>$preparedObject['blackoutOption'],
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],
		'subscribeProvider'=>stripslashes($preparedObject['provider']),
		'subscribeProviderOption'=>$preparedObject['providerOption'],
		'thankPopup'=>$preparedObject['thank']
	);
	
	//emailListBuilderPopup
	$preparedObject = PQ_AIO_prepareCode($profitquery['emailListBuilderPopup'], 0);		
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];	
	$PQ_AIO_code['subscribePopupOptions'] = array(
		'designOptions'=>$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),		
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),
		'closeIconOption'=>$preparedObject['closeIconOption'],
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'enter_email_text'=>stripslashes($preparedObject['enter_email_text']),
		'enter_name_text'=>stripslashes($preparedObject['enter_name_text']),		
		'button_text'=>stripslashes($preparedObject['button_text']),
		'blackoutOption'=>$preparedObject['blackoutOption'],
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],
		'subscribeProvider'=>stripslashes($preparedObject['provider']),
		'subscribeProviderOption'=>$preparedObject['providerOption'],
		'thankPopup'=>$preparedObject['thank']
	);
	
	//emailListBuilderFloating
	$preparedObject = PQ_AIO_prepareCode($profitquery['emailListBuilderFloating'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];	
	$PQ_AIO_code['subscribeFloatingOptions'] = array(
		'designOptions'=>'pq_fixed '.$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),		
		'closeIconOption'=>$preparedObject['closeIconOption'],
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'enter_email_text'=>stripslashes($preparedObject['enter_email_text']),
		'enter_name_text'=>stripslashes($preparedObject['enter_name_text']),		
		'button_text'=>stripslashes($preparedObject['button_text']),		
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],
		'subscribeProvider'=>stripslashes($preparedObject['provider']),
		'subscribeProviderOption'=>$preparedObject['providerOption'],
		'thankPopup'=>$preparedObject['thank']
	);
	
	//sharingPopup	
	$preparedObject = PQ_AIO_prepareCode($profitquery['sharingPopup'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];		
	
	$PQ_AIO_code['sharingPopup'] = array(
		'designOptions'=>$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),		
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),
		'closeIconOption'=>$preparedObject['closeIconOption'],
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'shareSocnet'=>$preparedObject['shareSocnet'],
		'blackoutOption'=>$preparedObject['blackoutOption'],
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);	
	
	//sharingBar
	$preparedObject = PQ_AIO_prepareCode($profitquery['sharingBar'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];		
	$PQ_AIO_code['sharingBar'] = array(
		'designOptions'=>'pq_bar '.$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),		
		'closeIconOption'=>$preparedObject['closeIconOption'],
		'mobile_title'=>htmlspecialchars(stripslashes($preparedObject['mobile_title'])),	
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'shareSocnet'=>$preparedObject['shareSocnet'],		
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);
	
	//sharingFloating
	$preparedObject = PQ_AIO_prepareCode($profitquery['sharingFloating'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];	
	$PQ_AIO_code['sharingFloating'] = array(
		'designOptions'=>'pq_fixed '.$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),		
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),
		'closeIconOption'=>$preparedObject['closeIconOption'],
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'shareSocnet'=>$preparedObject['shareSocnet'],
		'blackoutOption'=>$preparedObject['blackoutOption'],
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);
	
	//promoteFormBar
	$preparedObject = PQ_AIO_prepareCode($profitquery['promoteFormBar'], 0, 1);		
//	pq_printr($preparedObject);
//	die();
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];	
	$PQ_AIO_code['promoteFormBar'] = array(
		'formBarOptions'=>$preparedObject['formBarOptions'],
		'designOptions'=>$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),		
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),
		'closeIconOption'=>$preparedObject['closeIconOption'],		
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'buttonBlock'=>$preparedObject['buttonBlock'],
		'blackoutOption'=>$preparedObject['blackoutOption'],
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);
	//pq_printr($PQ_AIO_code['promoteFormBar']);
	//die();
	
	//promotePopup
	$preparedObject = PQ_AIO_prepareCode($profitquery['promotePopup'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];	
	$PQ_AIO_code['promotePopup'] = array(
		'designOptions'=>$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),		
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),
		'closeIconOption'=>$preparedObject['closeIconOption'],		
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'buttonBlock'=>$preparedObject['buttonBlock'],
		'blackoutOption'=>$preparedObject['blackoutOption'],
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);
	
	//promoteBar
	$preparedObject = PQ_AIO_prepareCode($profitquery['promoteBar'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];		
	$PQ_AIO_code['promoteBar'] = array(
		'designOptions'=>'pq_bar '.$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),		
		'closeIconOption'=>$preparedObject['closeIconOption'],		
		'mobile_title'=>htmlspecialchars(stripslashes($preparedObject['mobile_title'])),	
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'buttonBlock'=>$preparedObject['buttonBlock'],		
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);
	
	//promoteFloating
	$preparedObject = PQ_AIO_prepareCode($profitquery['promoteFloating'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];	
	$PQ_AIO_code['promoteFloating'] = array(
		'designOptions'=>'pq_fixed '.$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),		
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),
		'closeIconOption'=>$preparedObject['closeIconOption'],		
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'buttonBlock'=>$preparedObject['buttonBlock'],
		'blackoutOption'=>$preparedObject['blackoutOption'],
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);
	
	
	//followPopup
	$preparedObject = PQ_AIO_prepareCode($profitquery['followPopup'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];		
	$PQ_AIO_code['followPopup'] = array(
		'designOptions'=>$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),		
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),
		'closeIconOption'=>$preparedObject['closeIconOption'],		
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'buttonBlock'=>$preparedObject['buttonBlock'],
		'blackoutOption'=>$preparedObject['blackoutOption'],
		'followSocnet'=>$preparedObject['socnetFollowBlock'],
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);	
	
	//followBar
	$preparedObject = PQ_AIO_prepareCode($profitquery['followBar'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];		
	$PQ_AIO_code['followBar'] = array(
		'designOptions'=>'pq_bar '.$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),		
		'closeIconOption'=>$preparedObject['closeIconOption'],		
		'mobile_title'=>htmlspecialchars(stripslashes($preparedObject['mobile_title'])),	
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'buttonBlock'=>$preparedObject['buttonBlock'],		
		'followSocnet'=>$preparedObject['socnetFollowBlock'],
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);
	
	//followFloating
	$preparedObject = PQ_AIO_prepareCode($profitquery['followFloating'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];		
	$PQ_AIO_code['followFloating'] = array(
		'designOptions'=>'pq_fixed '.$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),		
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),
		'closeIconOption'=>$preparedObject['closeIconOption'],		
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'buttonBlock'=>$preparedObject['buttonBlock'],
		'blackoutOption'=>$preparedObject['blackoutOption'],
		'followSocnet'=>$preparedObject['socnetFollowBlock'],
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);
	
	//callMePopup (bookmark)
	$preparedObject = PQ_AIO_prepareCode($profitquery['callMePopup'], 1);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];	
	$preparedObject['to_email'] = $profitquery['settings']['email'];		
	$PQ_AIO_code['callMePopup'] = array(
		'typeBookmarkWindow'=>'pq_stick pq_call '.$preparedObject['typeBookmarkWindow'],
		'designOptions'=>$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'to_email'=>stripslashes($preparedObject['to_email']),
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),
		'button_text'=>stripslashes($preparedObject['button_text']),		
		'enter_name_text'=>stripslashes($preparedObject['enter_name_text']),		
		'enter_phone_text'=>stripslashes($preparedObject['enter_phone_text']),		
		'closeIconOption'=>$preparedObject['closeIconOption'],
		'mail_subject'=>stripslashes($preparedObject['mail_subject']),		
		'bookmark_text'=>stripslashes($preparedObject['loader_text']),		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),				
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'buttonBlock'=>$preparedObject['buttonBlock'],
		'blackoutOption'=>$preparedObject['blackoutOption'],		
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);	
	
	//callMeFloating
	$preparedObject = PQ_AIO_prepareCode($profitquery['callMeFloating'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];	
	$preparedObject['to_email'] = $profitquery['settings']['email'];		
	$PQ_AIO_code['callMeFloating'] = array(		
		'designOptions'=>'pq_fixed '.$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'to_email'=>stripslashes($preparedObject['to_email']),
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),
		'button_text'=>stripslashes($preparedObject['button_text']),		
		'enter_name_text'=>stripslashes($preparedObject['enter_name_text']),		
		'enter_phone_text'=>stripslashes($preparedObject['enter_phone_text']),		
		'mail_subject'=>stripslashes($preparedObject['mail_subject']),		
		'closeIconOption'=>$preparedObject['closeIconOption'],
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),				
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'buttonBlock'=>$preparedObject['buttonBlock'],
		'blackoutOption'=>$preparedObject['blackoutOption'],		
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);
	
	//ContactFormPopup (bookmark)
	$preparedObject = PQ_AIO_prepareCode($profitquery['contactFormPopup'], 1);	
	//close_icon
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];	
	$preparedObject['to_email'] = $profitquery['settings']['email'];		
	$PQ_AIO_code['contactFormPopup'] = array(
		'typeBookmarkWindow'=>'pq_stick pq_contact '.$preparedObject['typeBookmarkWindow'],
		'designOptions'=>$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'to_email'=>stripslashes($preparedObject['to_email']),
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),
		'button_text'=>stripslashes($preparedObject['button_text']),		
		'enter_name_text'=>stripslashes($preparedObject['enter_name_text']),		
		'enter_email_text'=>stripslashes($preparedObject['enter_email_text']),		
		'enter_message_text'=>stripslashes($preparedObject['enter_message_text']),		
		'mail_subject'=>stripslashes($preparedObject['mail_subject']),		
		'bookmark_text'=>stripslashes($preparedObject['loader_text']),		
		'title'=>stripslashes($preparedObject['title']),		
		'closeIconOption'=>$preparedObject['closeIconOption'],
		'sub_title'=>stripslashes($preparedObject['sub_title']),				
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'buttonBlock'=>$preparedObject['buttonBlock'],
		'blackoutOption'=>$preparedObject['blackoutOption'],		
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);
	
	//contactFormFloating
	$preparedObject = PQ_AIO_prepareCode($profitquery['contactFormFloating'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];	
	$preparedObject['to_email'] = $profitquery['settings']['email'];		
	
	$PQ_AIO_code['contactFormFloating'] = array(		
		'designOptions'=>'pq_fixed '.$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'to_email'=>stripslashes($preparedObject['to_email']),
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),
		'button_text'=>stripslashes($preparedObject['button_text']),		
		'enter_name_text'=>stripslashes($preparedObject['enter_name_text']),		
		'enter_email_text'=>stripslashes($preparedObject['enter_email_text']),		
		'enter_message_text'=>stripslashes($preparedObject['enter_message_text']),		
		'mail_subject'=>stripslashes($preparedObject['mail_subject']),		
		'title'=>stripslashes($preparedObject['title']),		
		'closeIconOption'=>$preparedObject['closeIconOption'],
		'sub_title'=>stripslashes($preparedObject['sub_title']),				
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'buttonBlock'=>$preparedObject['buttonBlock'],
		'blackoutOption'=>$preparedObject['blackoutOption'],		
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);
	
	//youtubePopup
	$preparedObject = PQ_AIO_prepareCode($profitquery['youtubePopup'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];	
	$PQ_AIO_code['youtubePopup'] = array(
		'designOptions'=>$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),		
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),
		'closeIconOption'=>$preparedObject['closeIconOption'],		
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'iframe_src'=>stripslashes($preparedObject['iframe_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'buttonBlock'=>$preparedObject['buttonBlock'],
		'blackoutOption'=>$preparedObject['blackoutOption'],
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);

	//youtubeFloating
	$preparedObject = PQ_AIO_prepareCode($profitquery['youtubeFloating'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];	
	$PQ_AIO_code['youtubeFloating'] = array(
		'designOptions'=>'pq_fixed '.$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),		
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),
		'closeIconOption'=>$preparedObject['closeIconOption'],		
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'iframe_src'=>stripslashes($preparedObject['iframe_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'buttonBlock'=>$preparedObject['buttonBlock'],		
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);
	
	//iframePopup
	$preparedObject = PQ_AIO_prepareCode($profitquery['iframePopup'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];	
	$PQ_AIO_code['iframePopup'] = array(
		'designOptions'=>$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),		
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),
		'closeIconOption'=>$preparedObject['closeIconOption'],		
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'external_iframe_src'=>stripslashes($preparedObject['iframe_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'buttonBlock'=>$preparedObject['buttonBlock'],
		'blackoutOption'=>$preparedObject['blackoutOption'],
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);
	
	//iframeFloating
	$preparedObject = PQ_AIO_prepareCode($profitquery['iframeFloating'], 0);	
	$preparedObject['displayRules']['main_page'] = $profitquery['settings']['mainPage'];	
	$PQ_AIO_code['iframeFloating'] = array(
		'designOptions'=>'pq_fixed '.$preparedObject['designOptions'],
		'enable'=>(int)$preparedObject['enable'],		
		'title'=>stripslashes($preparedObject['title']),		
		'sub_title'=>stripslashes($preparedObject['sub_title']),		
		'text_with_background'=>stripslashes($preparedObject['tblock_text']),
		'closeIconOption'=>$preparedObject['closeIconOption'],		
		'header_image_src'=>stripslashes($preparedObject['header_image_src']),
		'iframe_src'=>stripslashes($preparedObject['iframe_src']),
		'background_image_src'=>stripslashes($preparedObject['background_image_src']),
		'buttonBlock'=>$preparedObject['buttonBlock'],		
		'lockedMechanism'=>$preparedObject['lockedMechanism'],		
		'displayRules'=>$preparedObject['displayRules'],
		'eventHandler'=>$preparedObject['eventHandler'],		
		'thankPopup'=>$preparedObject['thank']
	);
	
	$additionalOptionText = '';
	if(isset($profitquery['settings'])){
		if(isset($profitquery['settings']['enableGA']) && (string)$profitquery['settings']['enableGA'] != 'on'){
			$additionalOptionText = 'profitquery.productOptions.disableGA = 1;';
		}
		if(isset($profitquery['settings']['from_right_to_left']) && $profitquery['settings']['from_right_to_left'] == 'on'){
			$additionalOptionText .= 'profitquery.productOptions.RTL = 1;';
		}
	}
	
	
	if($profitquery['settings']['apiKey']){		
		print "
		<script>
		(function () {			
				var PQ_AIO_Init = function(){
					profitquery.loadFunc.callAfterPQInit(function(){					
						profitquery.loadFunc.callAfterPluginsInit(						
							function(){									
								PQ_AIO_LoadTools();
							}							
							, ['//profitquery-a.akamaihd.net/lib/plugins/aio.plugin.profitquery.v5.min.js']							
						);
					});
				};
				var s = document.createElement('script');
				var _isPQLibraryLoaded = false;
				s.type = 'text/javascript';
				s.async = true;			
				s.profitqueryAPIKey = '".stripslashes($profitquery['settings']['apiKey'])."';
				s.profitqueryPROLoader = '".stripslashes($profitquery['settings']['pro_loader_filename'])."';				
				s.profitqueryLang = 'en';
				s.src = '//profitquery-a.akamaihd.net/lib/profitquery.v5.min.js';
				s.onload = function(){
					if ( !_isPQLibraryLoaded )
					{					
					  _isPQLibraryLoaded = true;				  
					  PQ_AIO_Init();
					}
				}
				s.onreadystatechange = function() {								
					if ( !_isPQLibraryLoaded && (this.readyState == 'complete' || this.readyState == 'loaded') )
					{					
					  _isPQLibraryLoaded = true;				    
						
						PQ_AIO_Init();					
					}
				};
				var x = document.getElementsByTagName('script')[0];						
				x.parentNode.insertBefore(s, x);			
			})();
			
			function PQ_AIO_LoadTools(){
				profitquery.loadFunc.callAfterPQInit(function(){
							".$additionalOptionText."
							var profitqueryPluginCode = ".json_encode($PQ_AIO_code).";							
							profitquery.widgets.smartWidgetsBox.init(profitqueryPluginCode);	
						});
			}
		</script>	
		";		
	}
	}
}


add_filter('plugin_action_links', 'PQ_AIO_admin_link', 10, 2);