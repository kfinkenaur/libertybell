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
defined('_JEXEC') or die('Restricted access');

class modmonialsfaderHelper
{
	public static function retrievedata($data){
		$pieces = explode("\\", $data);
		return $pieces;
	}
	
	public static function getquote($quoteimage, $quote_type, $own_image){
		if($quoteimage == 2){
			$data = "";
			$data .= '<img src="'.JURI::base().strtolower($own_image).'" />';
		}
		else if($quoteimage == 1){
			$data = "";
			$data .= '<img src="'.JURI::base().'modules/mod_monialsfader/images/'.strtolower($quote_type).'.png" />';
		}
		else{
			$data = " ";
		}
		return $data;
	}
	
	public static function linktext($displaylink, $link_text, $link_url, $displaylinknw){
		if($displaylink != 0){
			$ret = '<a href="'.$link_url.'" title="'.$link_text.'"';
			if($displaylinknw != 0)
			$ret .= 'target="_blank"';
			$ret .= '>'.$link_text.'</a>';
			return $ret;
		}
		else
			return "";
	}
	
	public static function callbacktext($callback){
		if($callback != 0)
			return '<br/><a href="http://gauti.info/" target="_blank" title="Created by Gauti Creator" >Created by Gauti Creator.</a>';
		else
			return "";
	}
	
	public static function getfont($font){
		if(is_numeric($font)){
			switch($font){
			case 1:
				$font_family = "'andale mono', times";
			break;
			case 2:
				$font_family = "arial, helvetica, sans-serif";
			break;
			case 3:
				$font_family = "'arial black', 'avant garde'";
			break;
			case 4:
				$font_family = "'book antiqua', palatino";
			break;
			case 5:
				$font_family = "'comic sans ms', sans-serif";
			break;
			case 6:
				$font_family = "'courier new', courier";
			break;
			case 7:
				$font_family = "georgia, palatino";
			break;
			case 8:
				$font_family = "helvetica";
			break;
			case 9:
				$font_family = "impact, chicago";
			break;
			case 10:
				$font_family = "tahoma, arial, helvetica, sans-serif";
			break;
			case 11:
				$font_family = "terminal, monaco";
			break;
			case 12:
				$font_family = "'times new roman', times";
			break;
			case 13:
				$font_family = "'trebuchet ms', geneva";
			break;
			case 14:
				$font_family = "verdana, geneva";
			break;
			default:
				$font_family = "";
			break;
			}
		}
		else{
			$font_family = str_replace("+"," ",$font);
		}
		return $font_family;
	}
	
	public static function font_import($title_font, $testi_font, $auth_font, $link_font){
		$import = "";
		if(!is_numeric($title_font))
			$import .= "@import url(http://fonts.googleapis.com/css?family=".$title_font.");";
		if(!is_numeric($testi_font))
			$import .= "@import url(http://fonts.googleapis.com/css?family=".$testi_font.");";
		if(!is_numeric($auth_font))
			$import .= "@import url(http://fonts.googleapis.com/css?family=".$auth_font.");";
		if(!is_numeric($link_font))
			$import .= "@import url(http://fonts.googleapis.com/css?family=".$link_font.");";
		return $import;
	}
	
	public static function img_url($url, $imgwidth){
		return '<img src="'.JURI::base().$url.'" width="'.$imgwidth.'"/>';
	}

}