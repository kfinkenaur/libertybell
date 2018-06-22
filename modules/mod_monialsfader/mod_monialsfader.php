<?php
/**
* @file
* @brief    Monials Fader module for Joomla
* @author   Gauti Creator
* @version  3.0.2
* @remarks  Copyright (C) 2013 Gauti Creator
* @remarks  Licensed under GNU/GPLv3, see http://www.gnu.org/licenses/gpl-3.0.html
*/
?>
<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

if(!defined('DS')){
    define('DS',DIRECTORY_SEPARATOR);
}

// Include the helper functions only once
require_once( dirname(__FILE__).DS.'helper.php' );

//Getting Joomla Module Parameters.
$title = $params->get('titles','');
$testimonial = $params->get('testimonials','Please add testimonials in module configuration.\\It has been a game-changer for us—We didn\'t really have a way to scale the customer experience before\\This is the kind of software the internet has been crying out for.');
$author = $params->get('authors','');
$date = $params->get('dates','');
$image = $params->get('images','');
$displaylink = $params->get('displaylink',0);
$displaylinknw = $params->get('displaylinknw',0);
$link_text = $params->get('link_text','Testimonial fader for Joomla');
$link_url = $params->get('link_url','http://gauti.info/');
$callback = $params->get('callback',0);
$wait_time = $params->get('wait_time',6);
$fader_time = $params->get('fader_time',2.5);
$mod_height = $params->get('mod_height','200px');
$mod_width = $params->get('mod_width','350px');
$quoteimage = $params->get('quoteimage',0);
$quote_type = $params->get('quote_type','Red');
$own_image = $params->get('own_image');
$round_corner = $params->get('rounded_corners',0);
$background = $params->get('background');
$title_color = $params->get('title_color','#770000');
$title_font_size = $params->get('title_font_size','18px');
$title_text_align = $params->get('title_text_align','Center');
$title_font_weight = $params->get('title_font_weight','Bold');
$title_font_style = $params->get('title_font_style','Normal');
$testimonials_color = $params->get('testimonials_color','#C0C0C0');
$testimonials_font_size = $params->get('testimonials_font_size','14px');
$testimonials_text_align = $params->get('testimonials_text_align','Left');
$testimonials_font_weight = $params->get('testimonials_font_weight','Normal');
$testimonials_font_style = $params->get('testimonials_font_style','Normal');
$authors_color = $params->get('authors_color','#440000');
$authors_font_size = $params->get('authors_font_size','11px');
$authors_text_align = $params->get('authors_text_align','Right');
$authors_font_weight = $params->get('authors_font_weight','Normal');
$authors_font_style = $params->get('authors_font_style','Italic');
$link_color = $params->get('link_color','#005500');
$link_font_size = $params->get('link_font_size','10px');
$link_text_align = $params->get('link_text_align','Right');
$link_font_weight = $params->get('link_font_weight','Normal');
$link_font_style = $params->get('link_font_style','Normal');
$fade_blink = $params->get('fade_blink');
$title_font = $params->get('title_font');
$testi_font = $params->get('testi_font');
$auth_font = $params->get('auth_font');
$link_font = $params->get('link_font');
$qleft = $params->get('qleft', 0);
$qtop = $params->get('qtop', 0);
$image_s_no = $params->get('image_s_no', 1);
$style = $params->get('style', 2);
$imgwidth = $params->get('imgwidth', "80px");
$l_arr_left = $params->get('left_arrow_left', "15px");
$l_arr_top = $params->get('left_arrow_top', "120px");
$r_arr_right = $params->get('right_arrow_right', "15px");
$r_arr_top = $params->get('right_arrow_top', "120px");
$fader_image = $params->get('faderimage', 1);

//Retreving titles, testimonials and authirs from the parameter
$titles = modmonialsfaderHelper::retrievedata($title);
$testimonials = modmonialsfaderHelper::retrievedata($testimonial);
$authors = modmonialsfaderHelper::retrievedata($author);
$dates = modmonialsfaderHelper::retrievedata($date);
$images = modmonialsfaderHelper::retrievedata($image);

//Adding necessary elements to params
$wait_time *= 1000;
$fader_time *= 1000;

$monials_width = substr($mod_width, 0, -2) - 55;
$monials_width .= "px";

$monials_height = substr($mod_height, 0, -2) - 30;
$monials_height .= "px";

if($image_s_no == 0){
	$titwid = $monials_width;
	$testiwid = $monials_width;
	$authorwid = substr($monials_width, 0, -2) - 10;
	$authorwid .= "px";
}
else{
	if($style == 0 || $style == 1 || $style == 7 || $style == 6){
		$imgholwid = $monials_width;
		$imgwid = $imgwidth;
		$authorwid = substr($monials_width, 0, -2) - substr($imgwidth, 0, -2) - 10;
		$authorwid .= "px";
		$titwid = $monials_width;
		$testiwid = $monials_width;
	}
	else{
		$imgwid = $imgwidth;
		$imgholwid = substr($imgwid, 0, -2) + 10;
		$imgholwid .= "px";
		$authorwid = $imgwidth;
		$titwid = substr($monials_width, 0, -2) - substr($imgholwid, 0, -2);
		$titwid.="px";
		$testiwid = $titwid;
	}
}

$quote_link = modmonialsfaderHelper::getquote($quoteimage,$quote_type,$own_image);

$linktext = modmonialsfaderHelper::linktext($displaylink,$link_text,$link_url,$displaylinknw);
$callbacktext = modmonialsfaderHelper::callbacktext($callback);

$title_font_a = modmonialsfaderHelper::getfont($title_font);
$testi_font_a = modmonialsfaderHelper::getfont($testi_font);
$auth_font_a = modmonialsfaderHelper::getfont($auth_font);
$link_font_a = modmonialsfaderHelper::getfont($link_font);

$font_import = modmonialsfaderHelper::font_import($title_font,$testi_font,$auth_font,$link_font);


require( JModuleHelper::getLayoutPath( 'mod_monialsfader') );
