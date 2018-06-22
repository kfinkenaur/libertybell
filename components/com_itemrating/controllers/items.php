<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Items list controller class.
 */
class ItemratingControllerItems extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'item', $prefix = 'ItemratingModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}

    
    
	/**
	 * Method to save the submitted ordering values for records via AJAX.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public function saveOrderAjax()
	{
		// Get the input
		$input = JFactory::getApplication()->input;
		$pks = $input->post->get('cid', array(), 'array');
		$order = $input->post->get('order', array(), 'array');

		// Sanitize the input
		JArrayHelper::toInteger($pks);
		JArrayHelper::toInteger($order);

		// Get the model
		$model = $this->getModel();

		// Save the ordering
		$return = $model->saveorder($pks, $order);

		if ($return)
		{
			echo "1";
		}

		// Close the application
		JFactory::getApplication()->close();
	}
	public function createBox()
	{
		$group_id=$this->input->getInt('id','');
		require_once JPATH_SITE . '/components/com_itemrating/helpers/itemrating.php';
		$context=$this->input->getString('context','');
		$context_id=$this->input->getInt('context_id','');
		$reviewsummary=$this->input->getString('reviewsummary','');
		$textforscore=$this->input->getString('textforscore','');
		$itemdata=new stdClass();
		if($group_id==0)
		{
			$html="";
		}
		else
		{
		
		$itemdata->groupdata=$group_id;
		$itemdata->textforscore=$textforscore;
		$itemdata->reviewsummary=$reviewsummary;
		$itemdata->position="none";
		$html=ItemratingHelper::createWidget($itemdata,$context_id,$context);
		}
		echo $html;
		exit;
	}
    
    
    
}