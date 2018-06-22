<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */

defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_itemrating/helpers/itemrating.php';
require_once(JPATH_ROOT."/components/com_adsmanager/lib/core.php");

class plgAdsmanagercontentItemRating extends JPlugin
{
	
	/**
	 * Displays the voting area if in an article
	 *
	 * @param   string   $context  The context of the content being passed to the plugin
	 * @param   object   &$row     The article object
	 * @param   object   &$params  The article params
	 * @param   integer  $page     The 'page' number
	 *
	 * @return  mixed  html string containing code for the votes if in com_content else boolean false
	 *
	 * @since   1.6
	 */
	public function ADSonContentAfterTitle($content)
	{
			$item=new stdClass();
	     $item->id=$content->id;
	     $item->introtext=$content->ad_text;
	     $item->title=$content->ad_headline;
	     $item->created=JFactory::getDate($content->publication_date)->Format('d-m-Y');
	     $item->modified=JFactory::getDate($content->publication_date)->Format('d-m-Y');
	     $item->authorName=$content->name;
		$group_id = $this->params->get('groupdata', '0');
		$textscore = $this->params->get('textforscore', '');
        $summary = $this->params->get('reviewsummary', '');
	    $item->attribs=json_encode(array("groupdata"=>$group_id,'textforscore'=>$textscore,'reviewsummary'=>$summary));
	    $item->voteallowed=1;
	    $html = ItemratingHelper::loadWidget($item,"top");
		return $html;
		}
	
	public function ADSonContentAfterDisplay($content)
	{
			$item=new stdClass();
	     $item->id=$content->id;
	     $item->introtext=$content->ad_text;
	     $item->title=$content->ad_headline;
	     $item->created=JFactory::getDate($content->publication_date)->Format('d-m-Y');
	     $item->modified=JFactory::getDate($content->publication_date)->Format('d-m-Y');
	     $item->authorName=$content->name;
		$group_id = $this->params->get('groupdata', '0');
		$textscore = $this->params->get('textforscore', '');
        $summary = $this->params->get('reviewsummary', '');
	    $item->attribs=json_encode(array("groupdata"=>$group_id,'textforscore'=>$textscore,'reviewsummary'=>$summary));
	    $item->voteallowed=1;
	    $html = ItemratingHelper::loadWidget($item,"bottom");
		return $html;
		}
	
	
}
