<?php

/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */
// No direct access
defined ('_JEXEC') or die ('resticted aceess');

AddonParser::addAddon('sp_itemrating','sp_itemrating_addon');

function sp_itemrating_addon($atts) {
	extract(spAddonAtts(array(
		'group_id' => '',
		'textforscore' => '',
		'reviewsummary' => '',
		'class' => '',
		), $atts));
	
	$style = 'text-align:center;';
	$font_size = '';

	if($group_id) {
			require_once JPATH_SITE . '/components/com_itemrating/helpers/itemrating.php';
			$view=JFactory::getApplication()->input->getString('view');
			if($view!="page")
			{
				return;
			}
			$id=JFactory::getApplication()->input->getInt('id');
			JModelLegacy::addIncludePath( JPATH_SITE . '/components/com_sppagebuilder/'. '/models', 'SppagebuilderModel');
			$page = JModelLegacy::getInstance('Page', 'SppagebuilderModel', array('ignore_request' => true));
			$data=$page->getItem( $id );
			
		 $item=new stdClass();
		 $item->id=$data->id;
		$item->introtext='';
		$item->title=$data->title;
		$item->created=$data->created_time;
		$item->modified=$data->modified_time;
		$item->authorName=$data->author_name;
		$item->voteallowed=1;
		 $item->attribs=json_encode(array("groupdata"=>$group_id,'textforscore'=>$textforscore,'reviewsummary'=>$reviewsummary));
		$output= ItemratingHelper::loadWidget($item,"top");
		return $output;
	}

	return;

}