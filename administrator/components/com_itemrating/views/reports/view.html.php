<?php

/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Itemrating.
 */
class ItemratingViewReports extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        ItemratingBackendHelper::addSubmenu('reports');

        $this->addToolbar();

        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        require_once JPATH_COMPONENT . '/helpers/itemrating.php';
        ItemratingBackendHelper::getSyncButton();
        $state = $this->get('State');
        $canDo = ItemratingBackendHelper::getActions($state->get('filter.category_id'));

        JToolBarHelper::title(JText::_('COM_ITEMRATING_TITLE_REPORTS'), 'reports.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/report';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
               // JToolBarHelper::addNew('report.add', 'JTOOLBAR_NEW');
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                //JToolBarHelper::editList('report.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
               // JToolBarHelper::custom('reports.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                //JToolBarHelper::custom('reports.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                //JToolBarHelper::deleteList('', 'reports.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                //JToolBarHelper::divider();
                //JToolBarHelper::archiveList('reports.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('reports.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'reports.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('reports.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_itemrating');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_itemrating&view=reports');

        $this->extra_sidebar = '';
        $options = array();
        $options[] = JHtml::_('select.option', 'com_k2', JText::_('K2'));
        $options[] = JHtml::_('select.option', 'com_community', JText::_('Joomsocial Users'));
        $options[] = JHtml::_('select.option', 'com_comprofiler', JText::_('Community Builder'));
        $options[] = JHtml::_('select.option', 'com_zoo', JText::_('ZOO Articles'));
        $options[] = JHtml::_('select.option', 'com_virtuemart', JText::_('Virtuemart Products'));
        $options[] = JHtml::_('select.option', 'com_hikashop', JText::_('Hikashop Products'));
        $options[] = JHtml::_('select.option', 'com_mtree', JText::_('Moset Tree'));
        $options[] = JHtml::_('select.option', 'com_sppagebuilder', JText::_('Sp Page Builder'));
         $options[] = JHtml::_('select.option', 'com_mymaplocations', JText::_('My Map Locations'));
        $options[] = JHtml::_('select.option', 'com_gmapfp', JText::_('GMap FP'));
        JHtmlSidebar::addFilter(
                JText::_('Joomla Articles'), 'filter_context', JHtml::_('select.options', $options, 'value', 'text', $this->state->get('filter.context'))
        );

    }

	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
		);
	}

}
