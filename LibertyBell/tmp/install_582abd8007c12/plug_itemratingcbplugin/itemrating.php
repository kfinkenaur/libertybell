<?php

/**
 * @version     1.1.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */
// No direct access
defined('_JEXEC') or die('Restricted access');

if(!@include_once(rtrim(JPATH_SITE . '/components/com_itemrating/helpers/itemrating.php'))){
	return;
};

if(!class_exists('cbTabHandler') || !method_exists($_PLUGINS,'registerFunction') || class_exists('ItemratingHelper')){
	//we should not be there!
	return;
}


class getItemRatingTab extends cbTabHandler
{
	var $installed = true;
	var $errorMessage = 'This plugin can not work without the ItemRating Component.<br/>Please download it from <a href="http://www.joomunited.com">http://www.joomunited.com</a> and install it.';

	function getItemRatingTab(){
		if(!class_exists('ItemRating')){
			$this->installed = false;
		}

		$this->cbTabHandler();
	}

	
	function getDisplayTab( $tab, $user, $ui){
		$my = JFactory::getUser();
		$item=new stdClass();
		$item->id=$user->id;
		$item->introtext='';
		$item->title=$user->name;
		$item->created=$user->registerDate;
		$item->modified=$user->lastvisitDate;
		$item->authorName=$user->name;
		$item->attribs=json_encode(array("groupdata"=>$this->params->get('groupdata'),'textforscore'=>$this->params->get('textforscore'),'reviewsummary'=>$this->params->get('reviewsummary')));
		$item->voteallowed=1;
		
		$html = ItemratingHelper::loadWidget($item,"top");
		return $html;
	}
	

}

