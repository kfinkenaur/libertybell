<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      kurchania <abhijeet.k@cisinlabs.com> - http://cisin.com
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');
JTable::addIncludePath(JPATH_ADMINISTRATOR .'/components/com_itemrating/tables');

/**
 * Itemrating model.
 */
class ItemratingModelReport extends JModelAdmin
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
	public function getTable($type = 'Report', $prefix = 'ItemratingTable', $config = array())
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
		$form = $this->loadForm('com_itemrating.report', 'report', array('control' => 'jform', 'load_data' => $loadData));
        
        
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
		$data = JFactory::getApplication()->getUserState('com_itemrating.edit.report.data', array());

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
         * Get data of Rating
         * custom method
         */
        public function getRating()
        {
           
            $context_id=JFactory::getApplication()->input->getInt('id');
            $context=JFactory::getApplication()->input->getString('context');
            $db    = JFactory::getDbo();
                        $published=1;
			$query = $db->getQuery(true);
                        $query->select('a.group_id')
                        ->from($db->quoteName('#__itemrating_itemdata'))
                        ->join('LEFT', $db->quoteName('#__itemrating_item') . ' AS a ON a.id = rating_id')
                        ->where('a.state = ' . (int) $published)
                        ->where($db->quoteName('context') . ' = ' . $db->quote($context))
			->where($db->quoteName('context_id') . ' = ' . (int)$context_id)
                        ;
                        $db->setQuery($query);
			
			// Check for a database error.
			try
			{
				$group = $db->loadObject();
			}
			catch (RuntimeException $e)
			{
				 JFactory::getApplication()->enqueueMessage($e->getMessage(),'error');

				return false;
			}
                        if(!$group->group_id)
                        {
                        	return false;    
                        }
                        // Create the base select statement.
                        $query = $db->getQuery(true);
			$query->select('*')
                                ->select('a.*')
                                ->select('a.id as rate_id') 
				->from($db->quoteName('#__itemrating_itemdata'))
                                ->join('LEFT', $db->quoteName('#__itemrating_item') . ' AS a ON a.id = rating_id')
				->where($db->quoteName('context') . ' = ' . $db->quote($context))
				->where($db->quoteName('context_id') . ' = ' . (int)$context_id);

			// Set the query and load the result.
			$db->setQuery($query);
			try
			{
				$ratings = $db->loadObjectList();
			}
			catch (RuntimeException $e)
			{
				 JFactory::getApplication()->enqueueMessage($e->getMessage(),'error');

				return false;
			}
                        $ratingIDs=array();
                        foreach($ratings as $rating)
                        {
                            $ratingIDs[]=$rating->rating_id;
                        }
                         $query = $db->getQuery(true);
                        JArrayHelper::toInteger($extraFieldsIDs);
                        $condition = @implode(',', $ratingIDs);
                        $query = $db->getQuery(true);
			$query->select('*')
                        ->select('id as rate_id') 
                        ->from($db->quoteName('#__itemrating_item'))     
                        ->where('id NOT IN (' . $condition . ')')
                         ->where('group_id='.$group->group_id);
                        $db->setQuery($query);
                        try
			{
				$cdata = $db->loadObjectList();
			}
                        catch (RuntimeException $e)
			{
				 JFactory::getApplication()->enqueueMessage($e->getMessage(),'error');

				return false;
			}
                        $ratings=array_merge($ratings ,$cdata);
                        return $ratings;
            
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
				$db->setQuery('SELECT MAX(ordering) FROM #__itemrating_reports');
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}

		}
	}
        public function saveRating($data)
        {
            
                        $type = 'itemdata';
			$prefix = 'ItemratingTable';
			$config = array();
			$table = JTable::getInstance($type, $prefix, $config);
                        $rating=ItemratingHelper::getRating($data['context'],$data['context_id'],$data['rating_id']);
                  
                    $data['rating_count']=json_encode(array('up' => $data['up'],'down' => $data['down'],'rating'=>$data['rating']));
					 $data['rating_value']=$data['rating'];
			
                        if (!$rating)
			{
			
                        }
                        else
                        {
                      
                         $data['id'] =$rating->id;
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
        echo json_encode(array("error"=>false,"message"=>JText::_('COM_ITEMRATING_THANK'),"rating"=>$data['rating_count'],"count"=>$data['rating_sum']));die();
        }

}