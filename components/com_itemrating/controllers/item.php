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

jimport('joomla.application.component.controllerform');

/**
 * Item controller class.
 */
class ItemratingControllerItem extends JControllerForm
{

    function __construct() {
        $this->view_list = 'items';
        parent::__construct();
    }
    function rating()
    {
   JSession::checkToken() or die( 'Invalid Token' );
   
    $userIP = $_SERVER['REMOTE_ADDR'];
    $model = $this->getModel('item');
    $data=array();
    $data['context']=JFactory::getApplication()->input->getString('context', '');
    $data['context_id']=JFactory::getApplication()->input->getInt('context_id');
    $data['rating_id']=JFactory::getApplication()->input->getInt('item');
    $data['rating_sum']=JFactory::getApplication()->input->getInt('count')+1;
    $data['type']=JFactory::getApplication()->input->getString('type','');
    $data['value']=JFactory::getApplication()->input->getFloat('value');
    $data['oldData']=JFactory::getApplication()->input->getFloat('oldData');
    $data['count']=JFactory::getApplication()->input->getInt('count');
    
    $user=JFactory::getUser();
    
            if($user->guest)
			{
				$data['jsondata']=json_encode(array('guest_'.$userIP.'_' =>$data['value'] ));
			}
			else
			{
				$data['jsondata']=json_encode(array($user->id .'_'.$userIP.'_' =>$data['value'] ));
			}
                        if(!empty($data['type']))
			{
				if($data['type']=="up")
				{
					$data['rating_count']=json_encode(array('up' => 1,'down'=>0,'rating'=>0,'rating'=>0));
				}
				else if($data['type']=="down")
				{
					$data['rating_count']=json_encode(array('up' => 0,'down' => 1,'rating'=>0,'rating'=>0));	
				}
                                else
                                {
                                        $data['rating_count']=json_encode(array('up' => 0,'down' => 0,'rating'=>round(($data['oldData']*$data['count']+($data['value']*20))/($data['count']+1),2)));
										$data['rating_value']=round(($data['oldData']*$data['count']+($data['value']*20))/($data['count']+1),2);
                                }
				$rating_sum=1;
			}
                        $result=$model->saveRating($data);
                        exit();

    }
    

}