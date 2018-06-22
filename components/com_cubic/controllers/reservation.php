<?php
/**
 * @version     1.0.0
 * @package     com_cubic
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Chintan Khorasiya <chints.khorasiya@gmail.com> - http://raindropsinfotech.com
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Reservation list controller class.
 */
class CubicControllerReservation extends CubicController
{
    /**
     * Proxy for getModel.
     * @since   1.6
     */
    public function &getModel($name = 'Reservation', $prefix = 'CubicModel', $config = array())
    {
        $model = parent::getModel($name, $prefix, array('ignore_request' => true));
        return $model;
    }

    public function saveorder(){
    	//echo 'in save order<pre>';
    	//print_r($_POST);
 		$orderdata = json_encode($_POST);
    	//var_dump($orderdata);exit;
    	$user = JFactory::getUser();
    	//var_dump($user->id);
        if(!empty($user->id) && !empty($orderdata))
    	{
    		$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			 
			$columns = array('user_id', 'orderdata');
			$values = array($db->quote($user->id), $db->quote($orderdata));
			 
			$query
			    ->insert($db->quoteName('#__cubic_savedorders'))
			    ->columns($db->quoteName($columns))
			    ->values(implode(',', $values));
			 
			$db->setQuery($query);
			$result = $db->execute();
			if($result){
				return true;
			} else {
				return false;
			}
    	}
    	else
    	{
    		return false;
    	}
    	
    }

    public function updateorder(){
        
        $orderdata = json_encode($_POST);
        $order_id = JRequest::getInt('order');
        $user = JFactory::getUser();
        
        if(!empty($user->id) && !empty($orderdata) && !empty($order_id))
        {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            // Fields to update.
            $fields = array(
                $db->quoteName('user_id') . ' = ' . $db->quote($user->id),
                $db->quoteName('orderdata') . ' = '. $db->quote($orderdata)
            );
             
            // Conditions for which records should be updated.
            $conditions = array(
                $db->quoteName('id') . ' = ' . $db->quote($order_id)
            );
             
            //$columns = array('id', 'orderdata');
            //$values = array($db->quote($user->id), $db->quote($orderdata));
             
            $query
                ->update($db->quoteName('#__cubic_savedorders'))
                ->set($fields)->where($conditions);
             
            $db->setQuery($query);
            $result = $db->execute();
            if($result){
                return true;
            } else {
                return false;
            }
        }
        else
        {
            return false;
        }
        
    }

    function deleteorder(){

        //echo 'in delete order';exit;

        $order_id = JRequest::getInt('order');

        if(!empty($order_id))
        {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            $conditions = array(
                $db->quoteName('id') . ' = ' . $db->quote($order_id)
            );
             
            $query
                ->delete($db->quoteName('#__cubic_savedorders'))
                ->where($conditions);
             
            $db->setQuery($query);
            $result = $db->execute();
            if($result){
                return true;
            } else {
                return false;
            }
        }
        else
        {
            return false;
        }

    }

    function emailPlan(){

        //var_dump($_POST);exit;
        $htmlData = $_POST['postData'];
        $recipient = $_POST['email_id'];
        //$htmlData = json_decode($htmlData);
        //var_dump($htmlData);exit;

        $mailer = JFactory::getMailer();

        $config = JFactory::getConfig();
        $sender = array( 
            $config->get( 'mailfrom' ),
            $config->get( 'fromname' ) 
        );
        $mailer->setSender($sender);

        $user = JFactory::getUser();
        //$recipient = $user->email;
        $mailer->addRecipient($recipient);

        //$recipient = array( 'person1@domain.com', 'person2@domain.com', 'person3@domain.com' );
        //$mailer->addRecipient($recipient);

        $body = $htmlData;

        //$body   = "Your body string\nin double quotes if you want to parse the \nnewlines etc";
        $mailer->setSubject('Your Plan on Libertybellsmoving');
        $mailer->isHTML(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);
        // Optional file attached
        //$mailer->addAttachment(JPATH_COMPONENT.'/assets/document.pdf');

        $send = $mailer->Send();
        //var_dump($send);
        if ( $send !== true ) {
            //echo 'Error sending email: ' . $send->__toString();
            return false;
        } else {
            //echo 'Mail sent';
            return true;
        }

    }

    function submitPlan(){

        $htmlData = $_POST['postData'];

        $htmlUserData = $_POST['postUserData'];

        //var_dump($htmlUserData);exit;
        
        $mailer = JFactory::getMailer();

        $config = JFactory::getConfig();
        $sender = array( 
            $config->get( 'mailfrom' ),
            $config->get( 'fromname' ) 
        );
        $mailer->setSender($sender);

        $user = JFactory::getUser();
        $recipient = $config->get( 'mailfrom' );
        $mailer->addRecipient($recipient);

        $body = $htmlData;

        //$body   = "Your body string\nin double quotes if you want to parse the \nnewlines etc";
        $mailer->setSubject('One more move is booked !');
        $mailer->isHTML(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);
        // Optional file attached
        //$mailer->addAttachment(JPATH_COMPONENT.'/assets/document.pdf');

        $send = $mailer->Send();
        //var_dump($send);
        if ( $send !== true ) {
            //echo 'Error sending email: ' . $send->__toString();
            return false;
        } else {
            //echo 'Mail sent';
            if(!empty($htmlUserData)) $this->sendPlanToUser($htmlUserData);
            return true;
        }

    }

    function emailInventoryPlan(){

        $htmlData = $_POST['postData'];

        $htmlUserData = $_POST['postUserData'];

        $htmlFrontuserdata = $_POST['frontuserdata'];

        //var_dump($htmlUserData);exit;
        
        $mailer = JFactory::getMailer();

        $config = JFactory::getConfig();
        /*$sender = array( 
            $config->get( 'mailfrom' ),
            $config->get( 'fromname' ) 
        );*/
	
	$sender = array( 
            $htmlFrontuserdata['email'],
            $htmlFrontuserdata['firstname'].' '.$htmlFrontuserdata['lastname']
        );

        $mailer->setSender($sender);

        $user = JFactory::getUser();
        $recipient = $config->get( 'mailfrom' );
        $mailer->addRecipient($recipient);

        $body = $htmlData;

        //$body   = "Your body string\nin double quotes if you want to parse the \nnewlines etc";
        $mailer->setSubject('Inventory Submission');
        $mailer->isHTML(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);
        // Optional file attached
        //$mailer->addAttachment(JPATH_COMPONENT.'/assets/document.pdf');

        $send = $mailer->Send();
        //var_dump($send);
        if ( $send !== true ) {
            //echo 'Error sending email: ' . $send->__toString();
            return false;
        } else {
            //echo 'Mail sent';
            if(!empty($htmlUserData)) $this->sendPlanToFrontUser($htmlUserData, $htmlFrontuserdata);
            return true;
        }

    }

    function sendPlanToFrontUser($mailHtml, $htmlFrontuserdata){

        //$htmlData = $_POST['postData'];

        //var_dump($mailHtml);exit;
        
        $mailer = JFactory::getMailer();

        $config = JFactory::getConfig();
        $sender = array( 
            $config->get( 'mailfrom' ),
            $config->get( 'fromname' ) 
        );
        $mailer->setSender($sender);

        $user = JFactory::getUser();
        //$recipient = $user->get( 'email' );
        $recipient = $htmlFrontuserdata['email'];

        //var_dump($recipient);exit;
        //$recipient = $config->get( 'mailfrom' );
        $mailer->addRecipient($recipient);

        $body = $mailHtml;

        //$body   = "Your body string\nin double quotes if you want to parse the \nnewlines etc";
        $mailer->setSubject('Inventory submitted');
        $mailer->isHTML(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);
        // Optional file attached
        //$mailer->addAttachment(JPATH_COMPONENT.'/assets/document.pdf');

        $send = $mailer->Send();
        //var_dump($send);
        if ( $send !== true ) {
            //echo 'Error sending email: ' . $send->__toString();
            return false;
        } else {
            //echo 'Mail sent';
            return true;
        }

    }

    function sendPlanToUser($mailHtml){

        //$htmlData = $_POST['postData'];

        //var_dump($mailHtml);exit;
        
        $mailer = JFactory::getMailer();

        $config = JFactory::getConfig();
        $sender = array( 
            $config->get( 'mailfrom' ),
            $config->get( 'fromname' ) 
        );
        $mailer->setSender($sender);

        $user = JFactory::getUser();
        $recipient = $user->get( 'email' );

        //var_dump($recipient);
        //$recipient = $config->get( 'mailfrom' );
        $mailer->addRecipient($recipient);

        $body = $mailHtml;

        //$body   = "Your body string\nin double quotes if you want to parse the \nnewlines etc";
        $mailer->setSubject('Your move is booked !');
        $mailer->isHTML(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);
        // Optional file attached
        //$mailer->addAttachment(JPATH_COMPONENT.'/assets/document.pdf');

        $send = $mailer->Send();
        //var_dump($send);
        if ( $send !== true ) {
            //echo 'Error sending email: ' . $send->__toString();
            return false;
        } else {
            //echo 'Mail sent';
            return true;
        }

    }
}