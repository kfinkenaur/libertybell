<?php

/**
 * @version     1.0.0
 * @package     com_cubic
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Chintan Khorasiya <chints.khorasiya@gmail.com>
 */
// No direct access
defined('_JEXEC') or die('Restricted access');
 
class CubicModelReservation extends JModelItem
{
	/**
	 * Get the estimation data along with products and categories
         *
	 * @return  array of all data contains products and categories
	 */
	public function getEstimationData($cid)
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		 
		// Create a new query object.
		$query = $db->getQuery(true);

		$where_cid = '';

		if($cid > 0) $where_cid = ' AND '.$db->quoteName('pros.category').' = '.$cid;
		 
		// Select all articles for users who have a username which starts with 'a'.
		// Order it by the created date.
		// Note by putting 'a' as a second parameter will generate `#__content` AS `a`
		$query
		    ->select(array('pros.id', 'pros.item_name', 'pros.item_subtitle', 'pros.item_type', 'pros.category', 'pros.thumb as proimage', 'pros.cost', 'pros.item_size', 'pros.item_weight', 'cates.cat_name', 'cates.thumb'))
		    ->from($db->quoteName('#__cubic_items', 'pros'))
		    ->join('LEFT', $db->quoteName('#__cubic_categories', 'cates') . ' ON (' . $db->quoteName('cates.id') . ' = ' . $db->quoteName('pros.category') . ')')
		    ->where($db->quoteName('pros.state') . ' = 1 AND '.$db->quoteName('cates.state') . ' = 1'.$where_cid)
		    ->order($db->quoteName('pros.ordering') . ' ASC');
		 
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		 
		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();
 
		return $results;
	}

	/**
	 * Get the estimation data along with products and categories
         *
	 * @return  array of all data contains products and categories
	 */
	public function getCategoriesData()
	{
		$db = JFactory::getDbo();
		 
		$query = $db->getQuery(true);

		//$where_cid = '';

		//if($cid > 0) $where_cid = ' AND '.$db->quoteName('pros.category').' = '.$cid;
		 
		$query
		    ->select(array('cates.id', 'cates.cat_name', 'cates.thumb'))
		    ->from($db->quoteName('#__cubic_categories', 'cates'))
		    ->where($db->quoteName('cates.state') . ' = 1 AND ' . $db->quoteName('cates.parent_category') . ' = 0')
		    ->order($db->quoteName('cates.ordering') . ' ASC');
		 
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		 
		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();

		foreach ($results as $cate_key => $cate_value) {
			$subquery = $db->getQuery(true);

			$subquery
			    ->select(array('cates.id', 'cates.cat_name', 'cates.thumb'))
			    ->from($db->quoteName('#__cubic_categories', 'cates'))
			    ->where($db->quoteName('cates.state') . ' = 1 AND ' . $db->quoteName('cates.parent_category') . ' = '.$cate_value->id)
			    ->order($db->quoteName('cates.ordering') . ' ASC');
			 
			$db->setQuery($subquery);
			 
			$sub_results = $db->loadObjectList();

			//$results[$cate_key]->showCategories = false;

			//var_dump();exit;
			if(!empty($sub_results)) $results[$cate_key]->items = $sub_results;
		}

		//echo '<pre>';print_r($results);exit;
 
		return $results;
	}

	public function getSavedOrderData($orderId)
	{
		$user = JFactory::getUser();
		
		$db = JFactory::getDbo();
		 
		$query = $db->getQuery(true);

		$query
		    ->select(array('ord.orderdata'))
		    ->from($db->quoteName('#__cubic_savedorders', 'ord'))
		    ->where($db->quoteName('ord.user_id') . ' = '.$db->quote($user->id) .' AND '. $db->quoteName('ord.id') . ' = '.$db->quote($orderId))
		    ->order($db->quoteName('ord.user_id') . ' DESC');
		 
		//var_dump($query);exit;
		$db->setQuery($query);
		 
		$results = $db->loadObject();
 
		return $results;
	}
}