<?php
/**
 * ReDJ Community component for Joomla
 *
 * @author selfget.com (info@selfget.com)
 * @package ReDJ
 * @copyright Copyright 2009 - 2014
 * @license GNU Public License
 * @link http://www.selfget.com
 * @version 1.7.8
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

class ReDJModelErrors extends JModelList
{
  public function __construct($config = array())
  {
    if (empty($config['filter_fields'])) {
      $config['filter_fields'] = array(
        'id', 'e.id',
        'visited_url', 'e.visited_url',
        'error_code', 'e.error_code',
        'redirect_url', 'e.redirect_url',
        'hits', 'e.hits',
        'last_visit', 'e.last_visit',
        'last_referer', 'e.last_referer'
      );
    }

    parent::__construct($config);
  }

  /**
   * Method to auto-populate the model state
   *
   * Note. Calling getState in this method will result in recursion
   */
  protected function populateState($ordering = null, $direction = null)
  {
    $error_code = $this->getUserStateFromRequest($this->context.'.filter.error_code', 'filter_error_code');
    $this->setState('filter.error_code', $error_code);

    $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
    // Convert search to lower case
    $search = JString::strtolower($search);
    $this->setState('filter.search', $search);

    $decode = $this->getUserStateFromRequest($this->context.'.filter.decode', 'filter_decode');
    $this->setState('filter.decode', $decode);

    // Load the parameters.
    $params = JComponentHelper::getParams('com_redj');
    $this->setState('params', $params);

    // List state information.
    parent::populateState('e.id', 'asc');
  }

  /**
   * Method to build an SQL query to load the list data
   *
   * @return string An SQL query
   */
  protected function getListQuery()
  {
    // Create a new query object
    $db = $this->getDbo();
    $query = $db->getQuery(true);
    // Select required fields
    $query->select(
      $this->getState(
        'list.select',
        'e.id, e.visited_url, e.error_code, e.redirect_url, e.hits, e.last_visit, e.last_referer, "0" AS checked_out'
      )
    );

    // From the table
    $query->from('#__redj_errors AS e');

    // Filter by error code
    $error_code = $this->getState('filter.error_code');
    if (!empty($error_code)) {
      $query->where('(e.error_code = '.(int) $error_code.')');
    }

    // Filter by search
    $search = $this->getState('filter.search');
    if (!empty($search)) {
      $query->where('(LOWER(e.visited_url) LIKE '.$db->quote('%'.$db->escape($search, true).'%').' OR LOWER(e.redirect_url) LIKE '.$db->quote('%'.$db->escape($search, true).'%').' OR LOWER(e.last_referer) LIKE '.$db->quote('%'.$db->escape($search, true).'%').')');
    }

    // Add the list ordering clause
    $orderCol = $this->state->get('list.ordering', 'e.id');
    $orderDirn = $this->state->get('list.direction', 'asc');
    $query->order($db->escape($orderCol.' '.$orderDirn));

    return $query;
  }

}
