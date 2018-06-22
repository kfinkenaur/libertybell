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

class PlgContentItemRating extends JPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;

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
	public function onContentBeforeDisplay($context, &$row, &$params, $page=0)
	{
				$parts = explode(".", $context);

		if ($parts[0] != 'com_content')
		{
			return false;
		}
		$componentparam=JComponentHelper::getParams('com_itemrating');
		$itemdata=json_decode($row->attribs);
		if(empty($itemdata->groupdata))
		{
			$catallow=ItemratingHelper::allowCategory($row->catid,"com_content");
			
		  if($catallow)
		  {
			
			$show_form_category=$componentparam->get('show_form_category',0);
			if(!$show_form_category)
			{
						return;
			}
			$itemdata = array();
			
		   $itemdata['groupdata']=$catallow->id;
		   $itemdata['textforscore']=$catallow->textforscore;
		   $itemdata['reviewsummary']=$catallow->reviewsummary;
		   $row->attribs=json_encode(array_merge(json_decode($row->attribs, true),$itemdata));
		  }
		  else
		  {
			return;
		  }
		}
		
		$row->voteallowed=1;
		if($context!="com_content.article")
		{
                    
			
			
			$show_category=$componentparam->get('show_category',0);
			if(($show_category==0))
		   {
		    return;
		   }
                    $row->voteallowed=1;
                    $row->categoryview=1;
		}
		$row->authorName=$row->author;
                $row->img=json_decode($row->images)->image_intro;
		$html="";
		$html.= ItemratingHelper::loadWidget($row,"top");
		return $html;
	}
	
	public function onContentAfterDisplay($context, &$row, &$params, $page=0)
	{
				$parts = explode(".", $context);

		if ($parts[0] != 'com_content')
		{
			return false;
		}
                $componentparam=JComponentHelper::getParams('com_itemrating');
		$itemdata=json_decode($row->attribs);
		if(empty($itemdata->groupdata))
		{
			$catallow=ItemratingHelper::allowCategory($row->catid,"com_content");
			
		  if($catallow)
		  {
			$show_form_category=$componentparam->get('show_form_category',0);
			if(!$show_form_category)
			{
						return;
			}
			$itemdata = array();
			
		     $itemdata['groupdata']=$catallow->id;
		   $itemdata['textforscore']=$catallow->textforscore;
		   $itemdata['reviewsummary']=$catallow->reviewsummary;
		   $row->attribs=json_encode(array_merge(json_decode($row->attribs, true),$itemdata));
		  }
		  else
		  {
			return;
		  }
		}
		$row->voteallowed=1;
		if($context!="com_content.article")
		{
			
		
			$show_category=$componentparam->get('show_category',0);
			if(($show_category==0))
		   {
		    return;
		   }
                   $row->voteallowed=1;
		   $row->categoryview=1;
		}
		$html="";
			$row->authorName=$row->author;
                        $row->img=json_decode($row->images)->image_intro;
		$html.= ItemratingHelper::loadWidget($row,"bottom");
		
		return $html;
	}
	
	 public function onContentPrepareForm($form, $data)
	{
	if (!($form instanceof JForm))
	{
        JFactory::getApplication()->enqueueMessage('JERROR_NOT_A_FORM','error');
         return false;
	}
	if ($form->getName()!='com_content.article') {
	    return true;
        }
		$document = JFactory::getDocument();
		
		JForm::addFormPath(JPATH_SITE.'/administrator/components/com_itemrating/models/forms/');
		$form->loadFile('itemrating', false);
		return true;
	}
	public function onContentAfterSave($context, $article, $isNew)
	{
		// Check we are handling the frontend edit form.
		if ($context != 'com_content.article')
		{
			return true;
		}
	}
}
