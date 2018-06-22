<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */

defined('_JEXEC') or die('Restricted access');
require_once JPATH_SITE . '/components/com_itemrating/helpers/itemrating.php';
class mFieldType_itemrating extends mFieldType {

	function getOutput($view=1) {
		$task		= JFactory::getApplication()->input->getCmd('task', '');
		$html ='';
		$id=$this->getLinkId();
		$database = JFactory::getDBO();
		$database->setQuery( 'SELECT * FROM #__mt_links WHERE link_id = ' . $id . ' LIMIT 1' );
		$result = $database->loadObject();
		$item=new stdClass();
		$item->id=$result->link_id;
		$item->introtext=$result->link_desc;
		$item->title=$result->link_name;
		$item->created=JFactory::getDate($result->link_created)->Format('d-m-Y');
		$item->modified=JFactory::getDate($result->link_modified)->Format('d-m-Y');
		$item->authorName=JFactory::getUser($result->user_id)->name;
		$groupdata=$this->getParam('groupdata');
		$textforscore=$this->getParam('textforscore');
		$reviewsummary=$this->getParam('reviewsummary');
		if($task=="viewlink")
		{
		$item->voteallowed=1;  
		}
		else
		{
		$item->voteallowed=0;
		$item->categoryview=1;
		}
		$item->attribs=json_encode(array("groupdata"=>$groupdata,'textforscore'=>$textforscore,'reviewsummary'=>$reviewsummary));
		$html.="<style type='text/css'>.fieldRow .review-top { width:100%;}</style>";
		$html .= ItemratingHelper::loadWidget($item,"top");
		$html .= ItemratingHelper::loadWidget($item,"bottom");
		return $html;
	}
	
	function getInputHTML() {
		$html="";
		$html .= '<input type="hidden" name="' . $this->getInputFieldName(1) . '" id="' . $this->getInputFieldName(1) . '" size="' . $this->getSize() . '" value="' . htmlspecialchars($this->getParam('groupdata')) . '" />';
		return $html;
	}
	function hasCaption()
	{
		return false;
	}
	
}
?>