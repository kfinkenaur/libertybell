<?php
/********************************************************************
Product		: Flexicontact
Date		: 12 November 2012
Copyright	: Les Arbres Design 2009-2012
Contact		: http://extensions.lesarbresdesign.info
Licence		: GNU General Public License
*********************************************************************/
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.controller');

class FlexicontactController extends JControllerLegacy
{
function display($cachable = false, $urlparams = false)
{
	$this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR.'/models');	// the log and config models are in the back end
	$config_model = $this->getModel('config');
	$config_data = $config_model->getData(true);					// get config data merged with menu parameters

	$email_model = $this->getModel('email');
	$post_data = $email_model->getPostData($config_data);			// initialises all fields
	$msg = $email_model->email_check($config_data);					// Check the email-to address
	if ($msg != '')
		{
		echo $msg;
		return;
		}
		
	$view_name = JRequest::getVar('view','contact');
	$view = $this->getView($view_name,'html');
	$view->assignRef('config_data',	$config_data);
	$view->assignRef('post_data', $post_data);
	$view->display();
}

function send()
{
	$this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR.'/models');	// the log and config models are in the back end
	$config_model = $this->getModel('config');
	$config_data = $config_model->getData(true);					// get config data merged with menu parameters

	$email_model = $this->getModel('email');
	$email_model->getPostData($config_data);
	
	$errors = array();
	$email_model->validate($errors, $config_data);

	if (isset($errors['kill']))
		{														// too many captcha attempts
		$session = JFactory::getSession();						// kill the session
		$session->destroy();
		$app = JFactory::getApplication();
		$app->redirect(JRoute::_('index.php',false));			// start again
		return;
		}

	if (!empty($errors))										// if validation failed
		{
		$view_name = JRequest::getVar('view','contact');
		$view = $this->getView($view_name,'html');
		$view->assignRef('config_data',	$config_data);
		$view->assignRef('errors', $errors);
		$view->assignRef('post_data', $email_model->data);
		$view->display();
		return;
		}

// here if validation ok

	$email_status = $email_model->sendEmail($config_data);
	
	if ($config_data->logging)
		{
		$log_model = $this->getModel('log');
		$log_model->store($email_model->data);
		}
		
	if ($email_status != '1')					// if send failed, show status using our _confirm view
		{
		$view = $this->getView('_confirm','html');
		$failed_message = JText::_('COM_FLEXICONTACT_MESSAGE_FAILED').': '.$email_status;
		$view->assignRef('message',	$failed_message);
		$view->display();
		return;
		}
		
// here if the email was sent ok

	if ($config_data->confirm_link)
		$this->setRedirect($config_data->confirm_link);
	else
		$this->setRedirect(JRoute::_('index.php?option=com_flexicontact&task=confirm', false));

// save the data in the Joomla session in case the confirmation page needs it

	$app = JFactory::getApplication();
	$app->setUserState(LAFC_COMPONENT."data", $email_model->data);
	
	return;
}

//---------------------------------------------------------------------------------------------
// Retrieve the user data from the session, merge it into the confirmation page, and display it
//
function confirm()
{
	$this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR.'/models');
	$config_model = $this->getModel('config');
	$config_data = $config_model->getData(true);		// get config data merged with menu parameters
	$email_model = $this->getModel('email');
	$app = JFactory::getApplication();
	$email_model->data = $app->getUserState(LAFC_COMPONENT."data");
	$message = $email_model->email_merge($config_data->confirm_text, $config_data);
	$view = $this->getView('_confirm','html');
	$view->assignRef('message',	$message);
	$view->display();
}




}
?>
