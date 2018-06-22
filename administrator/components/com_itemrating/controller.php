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

class ItemratingController extends JControllerLegacy {

    /**
     * Method to display a view.
     *
     * @param	boolean			$cachable	If true, the view output will be cached
     * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return	JController		This object to support chaining.
     * @since	1.5
     */
    public function display($cachable = false, $urlparams = false) {
        require_once JPATH_COMPONENT . '/helpers/itemrating.php';
        $view = JFactory::getApplication()->input->getCmd('view', 'items');
        JFactory::getApplication()->input->set('view', $view);

        parent::display($cachable, $urlparams);

        return $this;
    }
    public function saveresult()
    {
         //JSession::checkToken() or die( 'Invalid Token' );
    $data=array();
    $data['context']=JFactory::getApplication()->input->getString('context', '');
    $data['context_id']=JFactory::getApplication()->input->getInt('context_id');
    $data['rating_id']=JFactory::getApplication()->input->getInt('rating_id');
    $data['rating_sum']=JFactory::getApplication()->input->getInt('count');
     $data['rating']=JFactory::getApplication()->input->getFloat('score');
     $data['up']=JFactory::getApplication()->input->getInt('up');
     $data['down']=JFactory::getApplication()->input->getInt('down');
     if($data['rating']>100)
     {
     
         echo json_encode(array("error"=>true,"message"=>JText::_('The Value will be Less Then 100')));die();
     }
     
     $model = JModelLegacy::getInstance('Report', 'itemratingModel', array('ignore_request' => true));

    $result=$model->saveRating($data);
     exit();
        
    }
    public function sync()
    {
         $model = JModelLegacy::getInstance('Item', 'itemratingModel', array('ignore_request' => true));
          $result=$model->sync();
       
    }

}
