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
class CubicViewReservation extends JViewLegacy {

    protected $items;
    protected $params;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $app = JFactory::getApplication();
		        
        $params = $app->getParams('com_cubic');
        $cid = JRequest::getVar('cid', 0);
        //$simple_inventory=$params->get('simple_inventory');
        /*if(JFactory::getUser()->id<=0){
		  $return=base64_encode(JRoute::_('index.php?option=com_cubic&view=reservation'));
		  JFactory::getApplication()->redirect('index.php?option=com_users&view=login&return='.$return,'You are not authorized to view this page');
		}*/

        //$model = $app->getModel();
        //var_dump($model);exit;
        $this->model = $this->getModel('Reservation', 'CubicModel');
        $this->results = $this->model->getEstimationData($cid);
        $this->catsresults = $this->model->getCategoriesData();

        $this->order_id = JRequest::getInt('order', 0);

        $this->savedOrderData = false;

        if(!empty($this->order_id)) {
            $this->savedOrderData = $this->model->getSavedOrderData($this->order_id);
        }

        //var_dump($this->savedOrderData);exit;
        //get Category Items
		 //$db=JFactory::getDBO();
		 //$db->setQuery('');
		 //$db->query();
		//get Category Items				

        // Check for errors
        parent::display($tpl);
    }
}