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
if(!@include_once(rtrim(JPATH_SITE,'/').'/components/com_itemrating/helpers/itemrating.php')){
	return;
};
require_once JPATH_SITE . '/components/com_itemrating/helpers/itemrating.php';
JTable::addIncludePath(JPATH_ADMINISTRATOR .'/components/com_itemrating/tables');
if(!class_exists('plgCommunityItemRating'))
{
class  plgCommunityItemRating extends CApplications
{
	var $_user		= null;
		var $name		= "Item Rating";
		var $_name 		= 'itemrating';

	    function plgCommunityItemRating(& $subject, $config)
		{
			ItemratingHelper::loadLanguage();
			$this->_user	= CFactory::getRequestUser();
			parent::__construct($subject, $config);
			
		}
	function onProfileDisplay()
	{
		
		$html="";
		$db = JFactory::getDBO();
		$item=new stdClass();
		$view=JFactory::getApplication()->input->getString('view','');
		
		if($view!="profile")
		{
			
			return;
		}
		$groupdata=$this->params->get('groupdata');
		$config	= CFactory::getConfig();
		$cache = JFactory::getCache('plgCommunityItemRating');
		$mainframe = JFactory::getApplication();
		$userid			= $this->_user->id;
		$caching = $this->params->get('cache', 1);
		$user = CFactory::getRequestUser();
		$groupsModel	= CFactory::getModel('groups');
		$groupIds = $groupsModel -> getGroupIds(JFactory::getUser()->id);
		if(!empty($groupIds))
		{
			$query = $db->getQuery(true);
			$query->select($db->quoteName('id'));
		    $query->select($db->quoteName('customcategory'));
		    $query->from('#__itemrating_group');
		    $query->where('state=1 ');
		    $search = $db->quote('%' . $db->escape('com_community', true) . '%');
			$query->where('(customcategory LIKE ' . $search .')');
			$orderCol="ordering";
			$orderDirn="desc";
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		    $db->setQuery($query);
		    $groups_categories=$db->loadObjectList();
		    $found=false;
		    foreach($groups_categories as $groups_category)
		    {
			$category=json_decode($groups_category->customcategory,true);
			foreach($groupIds as $groupId)
			{
				if(in_array($groupId,$category['com_community']))
				{
				$groupdata=$groups_category->id;
				$found=true;
				break;
				}
			}
			if($found)
			{
				break;
			}
			
			
		    }
		}
		if($caching)
				{
					$caching = $mainframe->getCfg('caching');
				}

			$cache->setCaching($caching);
		
		if(empty($groupdata))
		{
			return;
		}
		
		$item->id=$user->id;
		$item->introtext='';
		$item->title=$user->name;
		$item->created=$user->registerDate;
		$item->modified=$user->lastvisitDate;
		$item->authorName=$user->name;
		$item->attribs=json_encode(array("groupdata"=>$groupdata,'textforscore'=>$this->params->get('textforscore'),'reviewsummary'=>$this->params->get('reviewsummary')));
		$item->voteallowed=1;
	     $html = ItemratingHelper::loadWidget($item,"top");
	     
	     return $html;
		}
		
	
}
}
