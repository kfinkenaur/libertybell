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

jimport('joomla.application.component.modeladmin');

/**
 * Itemrating model.
 */
class ItemratingModelItem extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_ITEMRATING';


	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Item', $prefix = 'ItemratingTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app	= JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm('com_itemrating.item', 'item', array('control' => 'jform', 'load_data' => $loadData));
        
        
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_itemrating.edit.item.data', array());

		if (empty($data)) {
			$data = $this->getItem();
            
		}

		return $data;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param	integer	The id of the primary key.
	 *
	 * @return	mixed	Object on success, false on failure.
	 * @since	1.6
	 */
	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk)) {

			//Do any procesing on fields here if needed

		}

		return $item;
	}
	/**
	 * Method to save the form data.
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   1.6
	 */
	public function save($data)
	{
		$data['fasetting'] = json_encode(array("icon"=>$data['faval'],"activecolor"=>$data['activecolor'],"inactivecolor"=>$data['inactivecolor']));
			if (parent::save($data))
		{
			return true;
		}

		return false;
	}

	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @since	1.6
	 */
	protected function prepareTable($table)
	{
		jimport('joomla.filter.output');

		if (empty($table->id)) {

			// Set ordering to the last item if not set
			if (@$table->ordering === '') {
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__itemrating_item');
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}

		}
	}
	public function saveRating($data)
	{
			require_once JPATH_SITE. '/components/com_itemrating/helpers/itemrating.php';
			$type = 'itemdata';
			$prefix = 'ItemratingTable';
			$config = array();
			$table = JTable::getInstance($type, $prefix, $config);
			$rating=ItemratingHelper::getRating($data['context'],$data['context_id'],$data['rating_id']);
			if(!empty($rating))
			{
				$data['id']=$rating->id;
				$rating_data=json_decode($rating->rating_count,true);
			
				if($data['type']=="up")
				{
					$rating_data['up']=$rating_data['up']+1;
					$data['rating_sum']=$rating_data['up']+$rating_data['down'];
				}
				else if($data['type']=="down")
				{
				$rating_data['down']=$rating_data['down']+1;
				$data['rating_sum']=$rating_data['up']+$rating_data['down'];
				}
				else
				{
				$rating_data['rating']=round(($data['value']*20),2);
				}
				$data['rating_count']=json_encode(array('up' => $rating_data['up'],'down' => $rating_data['down'],'rating'=>$rating_data['rating']));
				$data['rating_value']=$rating_data['rating'];
			}
				$table->bind($data);
			if (!$table->check()) {
			 JFactory::getApplication()->enqueueMessage($table->getError(), 'error');
			    return false;
		        }
	        if (!$table->store()) {
		    JFactory::getApplication()->enqueueMessage($table->getError(), 'error');
		    return false;
		}
		echo json_encode(array("error"=>false,"message"=>JText::_('COM_ITEMRATING_THANK'),"rating"=>$data['rating_count']));die();
       
			
	}
	public function sync()
	{
		 $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('r.*');
		$query->from('#__itemrating_itemdata as r');
		$query->join('LEFT','#__itemrating_item as i ON r.rating_id = i.id');
        $query->where('r.rating_value=""');
		$query->where('i.type!=0');
        $db->setQuery($query);
        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        $results = $db->loadObjectList();
		foreach( $results  as $result)
		{	$cdata=json_decode($result->rating_count);
			$result->rating_value=$cdata->rating;
			$result = JFactory::getDbo()->updateObject('#__itemrating_itemdata', $result, 'id');
			
		}
		JFactory::getApplication()->enqueueMessage('sync completed', 'notice');
		JFactory::getApplication()->redirect('index.php?option=com_itemrating');
		
	}
}