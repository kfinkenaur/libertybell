<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */

defined('_JEXEC') or die;
jimport('joomla.form.form');
JLoader::register('K2Plugin', JPATH_ADMINISTRATOR .'/components/com_k2/lib/k2plugin.php');
require_once JPATH_SITE . '/components/com_itemrating/helpers/itemrating.php';
class plgK2ItemRating extends K2Plugin {

 var $pluginName = 'itemrating';
    var $pluginNameHumanReadable = 'Item Rating';
 
	protected $autoloadLanguage = true;

  function onK2BeforeDisplayContent(&$item, &$params, $limitstart) {
   
	   	    $html="";
		    $view=JFactory::getApplication()->input->getString('view','');
		    $item->voteallowed=1;
		     $componentparam=JComponentHelper::getParams('com_itemrating');
		    if($view!="item")
		    {
		     $item->voteallowed=1;
		   
			$show_category=$componentparam->get('show_category',0);
			 $item->categoryview=1;
		   if(($show_category==0))
		   {
		    return;
		   }
		    }
		   
		   $data=json_decode($item->plugins);
	     if(empty($data->itemratinggroupdata))
	     {
	     
	          $catallow=ItemratingHelper::allowCategory($item->catid,"com_k2");
		  if($catallow)
		  {
		   
			$show_form_category=$componentparam->get('show_form_category',0);
			if(!$show_form_category)
			{
						return;
			}
		  $data = new stdClass();
		   $data->itemratinggroupdata=$catallow->id;
		   $data->itemratingtextforscore=$catallow->textforscore;
		   $data->itemratingreviewsummary=$catallow->reviewsummary;
		  }
		  else
		  {
		  return;
		  }
	     }
	     $item->attribs=json_encode(array("groupdata"=>$data->itemratinggroupdata,'textforscore'=>$data->itemratingtextforscore,'reviewsummary'=>$data->itemratingreviewsummary));
	     $item->authorName=JFactory::getUser($item->created_by)->name;
             $item->img=$item->imageMedium;
	     $html = ItemratingHelper::loadWidget($item,"top");
	     
	   return $html;
  }
  
  function onK2AfterDisplayContent(&$item, &$params, $limitstart) {

	   	    $html="";
		    $view=JFactory::getApplication()->input->getString('view','');
		    $item->voteallowed=1;
		     $componentparam=JComponentHelper::getParams('com_itemrating');
		    if($view!="item")
		    {
		     $item->voteallowed=1;
		   
			$show_category=$componentparam->get('show_category',0);
			
		   if(($show_category==0))
		   {
		    return;
		   }
		   $item->categoryview=1;
		  
		    }
		    $view=JFactory::getApplication()->input->getString('view','');
	     $data=json_decode($item->plugins);
	     if(empty($data->itemratinggroupdata))
	     {
	      $catallow=ItemratingHelper::allowCategory($item->catid,"com_k2");
		  if($catallow)
		  {
		   
			$show_form_category=$componentparam->get('show_form_category',0);
			if(!$show_form_category)
			{
						return;
			}
		  $data = new stdClass();
		   $data->itemratinggroupdata=$catallow->id;
		   $data->itemratingtextforscore=$catallow->textforscore;
		   $data->itemratingreviewsummary=$catallow->reviewsummary;
		  }
		  else
		  {
		  return;
		  }
	     }
	     
	     $item->authorName=JFactory::getUser($item->created_by)->name;
              $item->img=$item->imageMedium;
	     $item->attribs=json_encode(array("groupdata"=>$data->itemratinggroupdata,'textforscore'=>$data->itemratingtextforscore,'reviewsummary'=>$data->itemratingreviewsummary));
	     $html = ItemratingHelper::loadWidget($item,"bottom");
	     
	   return $html;
  }


  
  }
