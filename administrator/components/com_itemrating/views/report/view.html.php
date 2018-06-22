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
 * View to edit
 */
class ItemratingViewReport extends JViewLegacy {

    protected $state;
    protected $item;
    protected $form;
    protected $rate;
    protected $group;
    
    /**
     * Display the view
     */
    public function display($tpl = null) {
        //$this->state = $this->get('State');
        //$this->item = $this->get('Item');
        //$this->form = $this->get('Form');
        $this->ratings=$this->get('Rating');
       // $this->group=$this->get('Group');
        
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        $this->addToolbar();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     */
    protected function addToolbar() {
        JFactory::getApplication()->input->set('hidemainmenu', true);
        JToolBarHelper::title(JText::_('Edit Report'), 'item.png');
        JToolBarHelper::cancel('report.cancel', 'JTOOLBAR_CANCEL');
        
    }

}
