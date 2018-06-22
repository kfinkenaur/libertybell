<?php

/**
 * @version     1.0.0
 * @package     com_cubic
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Chintan Khorasiya <chints.khorasiya@gmail.com> - http://www.linksmediacorp.com
 */
defined('_JEXEC') or die;

/**
 * Methods supporting a list of Cubic records.
 */
class CubicModelPlans extends JModelItem
{

	/**
	 * Get the plans details of user
         *
	 * @return  array of all data contains products and categories
	 */
	public function getUnbookedPlansData()
	{
		$user = JFactory::getUser();
		
		$db = JFactory::getDbo();
		 
		$query = $db->getQuery(true);

		$query
		    ->select(array('ord.id', 'ord.user_id', 'ord.orderdata'))
		    ->from($db->quoteName('#__cubic_savedorders', 'ord'))
		    ->where($db->quoteName('ord.user_id') . ' = '.$db->quote($user->id))
		    ->order($db->quoteName('ord.user_id') . ' DESC');
		 
		$db->setQuery($query);
		 
		$results = $db->loadObjectList();

		//echo '<pre>';print_r($results);exit;

		//echo '<pre>';print_r(json_decode($results, true));exit;
 
		return $results;
	}

}
