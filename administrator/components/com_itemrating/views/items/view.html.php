<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Itemrating.
 */
class ItemratingViewItems extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
        
		ItemratingBackendHelper::addSubmenu('items');
        
		$this->addToolbar();
        
        $this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/itemrating.php';
		ItemratingBackendHelper::getSyncButton();
		$state	= $this->get('State');
		$canDo	= ItemratingBackendHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_ITEMRATING_TITLE_ITEMS'), 'items.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/item';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
			    JToolBarHelper::addNew('item.add','JTOOLBAR_NEW');
		    }

		    if ($canDo->get('core.edit') && isset($this->items[0])) {
			    JToolBarHelper::editList('item.edit','JTOOLBAR_EDIT');
		    }

        }

		if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::custom('items.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			    JToolBarHelper::custom('items.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'items.delete','JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::archiveList('items.archive','JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
            	JToolBarHelper::custom('items.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
		}
        
        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
		    if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			    JToolBarHelper::deleteList('', 'items.delete','JTOOLBAR_EMPTY_TRASH');
			    JToolBarHelper::divider();
		    } else if ($canDo->get('core.edit.state')) {
			    JToolBarHelper::trash('items.trash','JTOOLBAR_TRASH');
			    JToolBarHelper::divider();
		    }
        }

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_itemrating');
		}
        
        //Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_itemrating&view=items');
        
        $this->extra_sidebar = '';
        
		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);

		//Filter for the field type
		$select_label = JText::sprintf('COM_ITEMRATING_FILTER_SELECT_LABEL', 'Type');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "1";
		$options[0]->text = "Rating";
		$options[1] = new stdClass();
		$options[1]->value = "3";
		$options[1]->text = "Thumbs Up Down";
		$options[2] = new stdClass();
		$options[2]->value = "2";
		$options[2]->text = "Bar";
	
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_type',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.type'), true)
		);
		
		//Filter for the field type
		$select_label = JText::sprintf('COM_ITEMRATING_FILTER_SELECT_LABEL', 'Group');
		$db=JFactory::getDbo();
		$query = "SELECT id as value, title as text FROM #__itemrating_group WHERE state = 1";
		$db->setQuery($query);
		$options=$db->loadObjectList() ;
		
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_group',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.group'), true)
		);
        
	}
    
	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.state' => JText::_('JSTATUS'),
		'a.checked_out' => JText::_('COM_ITEMRATING_ITEMS_CHECKED_OUT'),
		'a.checked_out_time' => JText::_('COM_ITEMRATING_ITEMS_CHECKED_OUT_TIME'),
		'a.created_by' => JText::_('COM_ITEMRATING_ITEMS_CREATED_BY'),
		'a.group' => JText::_('COM_ITEMRATING_ITEMS_GROUP'),
		'a.type' => JText::_('COM_ITEMRATING_ITEMS_TYPE'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.hits' => JText::_('COM_ITEMRATING_ITEMS_HITS'),
		);
	}

    
}
