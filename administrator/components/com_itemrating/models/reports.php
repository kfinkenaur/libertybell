<?php

/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      kurchania <abhijeet.k@cisinlabs.com> - http://cisin.com
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Itemrating records.
 */
class ItemratingModelReports extends JModelList {

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
                                'context', 'a.context'

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

         $component = $this->getUserStateFromRequest($this->context . '.filter.context', 'filter_context', 'com_content');
            $this->setState('filter.context', $component);

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
        $component = $this->getState('filter.context');
       if(!($component))
       {
           $component="com_content";
       }
        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'DISTINCT a.*'
                )
        );
        $query->select('SUM(a.rating_sum) AS total');
        if($component=="com_k2")
            {
               $query->select('k.title as title');
            
            }
            else if($component=="com_content")
            {
               $query->select('k.title as title');
            
            }
            else if($component=="com_adsmanager")
            {
               $query->select('k.ad_headline as title');
            
            }
            else if($component=="com_zoo")
            {
               $query->select('k.name as title');
            
            }
            else if($component=="com_virtuemart")
            {
               $query->select('k.product_name as title');
            
            }
            else if($component=="com_hikashop")
            {
               $query->select('k.product_name as title');
            
            }
            else if(($component=="com_community")||($component=="com_comprofiler"))
            {
               $query->select('k.name as title');
            
            }
            else if($component=="com_mtree")
            {
               $query->select('k.link_name as title');
            
            }
            else if($component=="com_sppagebuilder")
            {
               $query->select('k.title as title');
            
            }
            else if($component=="com_gmapfp")
            {
                $query->select('k.nom as title');
            }
            else if($component=="com_mymaplocations")
            {
                $query->select('k.name as title');
            }
            
        $query->from('`#__itemrating_itemdata` AS a');
            if($component=="com_k2")
            {
                $query->join('LEFT', '#__k2_items AS k ON k.id = a.context_id');
            
            }
            else if($component=="com_adsmanager")
            {
                $query->join('LEFT', '#__adsmanager_ads AS k ON k.id = a.context_id');
            
            }
            else if($component=="com_content")
            {
                $query->join('LEFT', '#__content AS k ON k.id = a.context_id');
            }
            else if($component=="com_zoo")
            {
                $query->join('LEFT', '#__zoo_item AS k ON k.id = a.context_id');
            }
            else if($component=="com_virtuemart")
            {
                if (!class_exists( 'VmConfig' )) require(JPATH_ROOT.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_virtuemart'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'config.php');
                $vm=VmConfig::loadConfig();
            $query->join('LEFT', '#__virtuemart_products_'.$vm->get('vmlang').' AS k ON k.virtuemart_product_id = a.context_id');
            }
            else if($component=="com_hikashop")
            {
               $query->join('LEFT', '#__hikashop_product AS k ON k.product_id = a.context_id'); 
            
        }
        else if(($component=="com_community")||($component=="com_comprofiler"))
            {
               $query->join('LEFT', '#__users AS k ON k.id = a.context_id'); 
            }
	   else if($component=="com_mtree")
            {
               $query->join('LEFT', '#__mt_links AS k ON k.link_id = a.context_id'); 
            
        }
        else if($component=="com_sppagebuilder")
        {
               $query->join('LEFT', '#__sppagebuilder AS k ON k.id = a.context_id'); 
            
        }
        else if($component=="com_gmapfp")
        {
               $query->join('LEFT', '#__gmapfp AS k ON k.id = a.context_id'); 
            
        }
        else if($component=="com_mymaplocations")
        {
               $query->join('LEFT', '#__mymaplocations_location AS k ON k.id = a.context_id'); 
            
        }
        	// Join over the users for the checked out user
		
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

         $query->where('a.context = ' . $db->quote($component));
         $query->group($db->quoteName('a.context_id'));
         $query->group($db->quoteName('a.context'));

        // Add the list ordering clause.
       $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }
            //echo nl2br($query);die();
        return $query;
    }

    public function getItems() {
        $items = parent::getItems();
        
        return $items;
    }

}
