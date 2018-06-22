<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Itemrating model.
 */

JTable::addIncludePath(JPATH_ADMINISTRATOR .'/components/com_itemrating/tables');
class ItemratingModelItem extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_ITEMRATING';
	
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Item', $prefix = 'ItemratingTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app	= JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm('com_itemrating.item', 'item', array('control' => 'jform', 'load_data' => $loadData));
        
        
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	
	public function saveRating($data)
	{
                        $params = JComponentHelper::getParams('com_itemrating');
                        $ip_restriction=$params->get('ip_restriction',true);
                        $cookie_restriction=$params->get('cookie_restriction',false);
                        $cookie_restriction_hour=$params->get('cookie_restriction_hour',24);
			$user=JFactory::getUser();
			$userIP = $_SERVER['REMOTE_ADDR'];
			$rating=ItemratingHelper::getRating($data['context'],$data['context_id'],$data['rating_id']);
			$type = 'itemdata';
			$prefix = 'ItemratingTable';
			$config = array();
			$table = JTable::getInstance($type, $prefix, $config);
			if (!$rating)
			{
			
			}
			else
			{
				
				$rating_data=json_decode($rating->rating_count,true);
				if($data['type']=="up")
				{
					$rating_data['up']=$rating_data['up']+1;
					$data['rating_sum']=$rating_data['up']+$rating_data['down'];
				}
				else if($data['type']=="down")
				{
				$rating_data['down']=$rating_data['down']+1;
				$data['rating_sum']=$rating_data['up']+$rating_data['down'];
				}
				else
				{
				$rating_data['rating']=round(((($rating_data['rating']*$rating->rating_sum)+($data['value']*20))/($rating->rating_sum+1)),2);
				$data['rating_sum']=$rating->rating_sum+1;
				}
				$data['rating_count']=json_encode(array('up' => $rating_data['up'],'down' => $rating_data['down'],'rating'=>$rating_data['rating']));
				$data['rating_value']=$rating_data['rating'];
				if($ip_restriction)
                                {
                                     if(($user->guest)&&((strpos($rating->jsondata,'guest_'.$userIP.'_')!== false)))
				{
				 echo json_encode(array("error"=>true,"message"=>JText::_('COM_ITEMRATING_ALREDY')));die();
				}
				else if (!empty($user->id)&&(strpos($rating->jsondata,$user->id .'_'.$userIP.'_')!== false)) {
				echo json_encode(array("error"=>true,"message"=>JText::_('COM_ITEMRATING_ALREDY')));die();
				}
                                }
                                else if($cookie_restriction)
                                {
									$cookieval=JFactory::getApplication()->input->cookie->get('itemrating-'.$rating->id,null);
                                 if(isset($cookieval))
                                 {
                                    echo json_encode(array("error"=>true,"message"=>JText::_('COM_ITEMRATING_ALREDY').JText::_('COM_ITEMRATING_WAIT'). $cookie_restriction_hour.JText::_('COM_ITEMRATING_HOUR')));die(); 
                                 }
                                    
                                }
				$data['jsondata']=json_encode(@array_merge(json_decode($data['jsondata'],true),json_decode($rating->jsondata,true)));
				  $data['id'] =$rating->id; 
				
			}
        $table->bind($data);
        if (!$table->check()) {

            JFactory::getApplication()->enqueueMessage($table->getError(), 'error');
	    return false;
        }
        if (!$table->store()) {
            JFactory::getApplication()->enqueueMessage($table->getError(), 'error');
	    return false;
        }
        if($cookie_restriction)
        {
          $app = JFactory::getApplication();
          $cookieName='itemrating-'.$table->id;
          $cookieValue="set";
			JFactory::getApplication()->input->cookie->set('itemrating-'.$table->id, $cookieValue, time() + ( 60 * 60 *$cookie_restriction_hour ));
        }
        
			    echo json_encode(array("error"=>false,"message"=>JText::_('COM_ITEMRATING_THANK'),"rating"=>$data['rating_count']));die();
                        
	}
	
	



}