<?php

/**
 * @version     1.0.0
 * @package     com_cubic
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Chintan Khorasiya <chints.khorasiya@gmail.com> - http://raindropsinfotech.com
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Cubic.
 */
class CubicViewPlans extends JViewLegacy {

    protected $items;
    protected $params;

    public function display($tpl = null) {
        $app = JFactory::getApplication();
		        
        $params = $app->getParams('com_cubic');
        $cid = JRequest::getVar('cid', 0);
        if(JFactory::getUser()->id<=0){
		  $return=base64_encode(JRoute::_('index.php?option=com_cubic&view=plans'));
		  JFactory::getApplication()->redirect('index.php?option=com_users&view=login&return='.$return,'You are not authorized to view this page');
		}

        $this->model = $this->getModel('Plans', 'CubicModel');
        $this->results = $this->model->getUnbookedPlansData();
        
        parent::display($tpl);
    }
}