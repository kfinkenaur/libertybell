<?php

/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Itemrating records.
 */
class ItemratingModelItems extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                                'id', 'a.id',
                'state', 'a.state',
                'created_by', 'a.created_by',
                'title', 'a.title',
                'rating', 'a.rating',
                'label', 'a.label',
                'group', 'a.group_id',
                'type', 'a.type',
                'icon', 'a.icon',
                'number', 'a.number',
                'ordering', 'a.ordering',
                'hits', 'a.hits',
				
			

            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        
		//Filtering group
		$this->setState('filter.group', $app->getUserStateFromRequest($this->context.'.filter.group', 'filter_group', '', 'string'));

		//Filtering type
		$this->setState('filter.type', $app->getUserStateFromRequest($this->context.'.filter.type', 'filter_type', '', 'integer'));

		//Filtering hits
		$this->setState('filter.hits', $app->getUserStateFromRequest($this->context.'.filter.hits', 'filter_hits', '', 'string'));


        // Load the parameters.
        $params = JComponentHelper::getParams('com_itemrating');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.id', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'a.*'
                )
        );
        $query->from('`#__itemrating_item` AS a');

        
		// Join over the users for the checked out user
		$query->select("uc.name AS editor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");
		// Join over the user field 'created_by'
		$query->select('created_by.name AS created_by');
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
		
        $query->select('g.title as groupname');
	$query->join("LEFT", "#__itemrating_group AS g ON g.id=a.group_id");
        

		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('a.state = ' . (int) $published);
		} else if ($published === '') {
			$query->where('(a.state IN (0, 1))');
		}
	$query->where('g.state = 1');
        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                    $query->where('(title LIKE ' .$search . ')');
            }
        }

        

		//Filtering group

		//Filtering type
		$filter_type = $this->state->get("filter.type");
		if ($filter_type) {
			if($filter_type==3)
			{
				$filter_type=0;
			}
			$query->where("a.type = '".$db->escape($filter_type)."'");
		}
		$filter_group = $this->state->get("filter.group");
		if ($filter_group) {
			$query->where("a.group_id = '".$db->escape($filter_group)."'");
		}
		//Filtering hits


        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }
		
        return $query;
    }

    public function getItems() {
        $items = parent::getItems();
        
        return $items;
    }

}
