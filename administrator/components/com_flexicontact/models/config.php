<?php
/********************************************************************
Product		: Flexicontact
Date		: 12 November 2012
Copyright	: Les Arbres Design 2010-2012
Contact		: http://extensions.lesarbresdesign.info
Licence		: GNU General Public License
*********************************************************************/
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class FlexicontactModelConfig extends JModelLegacy
{
var $_data;
var $_app = null;

function __construct()
{
	parent::__construct();
	$this->_app = JFactory::getApplication();
}

//-------------------------------------------------------------------------------
// Get the component parameters
// Returns a stdClass Object containing all our parameters
// This is called from the front and the back so any language strings used must be in both language files
//
function &getData($site=false)
{
	if ($site)
		{
		$app = JFactory::getApplication('site');
		$component_params =  $app->getParams();
		}
	else
		$component_params = JComponentHelper::getParams(LAFC_COMPONENT);		// for back end
	$this->data = $component_params->toObject();

// set defaults for all our parameters so that we have this all in one place

	if (!isset($this->data->logging))          $this->data->logging          = 0;
	if (!isset($this->data->email_html))       $this->data->email_html       = 1;
	if (!isset($this->data->autofill))         $this->data->autofill         = 'off';
	if (!isset($this->data->agreement_prompt)) $this->data->agreement_prompt = '';
	if (!isset($this->data->agreement_name))   $this->data->agreement_name   = '';
	if (!isset($this->data->agreement_link))   $this->data->agreement_link   = '';

	if (!isset($this->data->show_copy))        $this->data->show_copy        = LAFC_COPYME_CHECKBOX;
	if (!isset($this->data->show_subject))     $this->data->show_subject     = 1;
	if (!isset($this->data->default_subject))  $this->data->default_subject  = '';
	if (!isset($this->data->area_prompt))      $this->data->area_prompt      = '';
	if (!isset($this->data->area_opt))         $this->data->area_opt         = 'optional';
	if (!isset($this->data->area_width))       $this->data->area_width       = 40;
	if (!isset($this->data->area_height))      $this->data->area_height      = 3;
	
	for ($i = 1; $i <= 5; $i++)
		{
		$fieldname = 'field_opt'.$i;
		$this->data->$fieldname = (isset($this->data->$fieldname))  ? $this->data->$fieldname  : 'disabled';
		$promptname = 'field_prompt'.$i;
		$this->data->$promptname = (isset($this->data->$promptname)) ? $this->data->$promptname : 'Field '.$i;
		}

	if (!isset($this->data->confirm_link)) $this->data->confirm_link = '';
	if (!isset($this->data->confirm_text)) $this->data->confirm_text = JText::_('COM_FLEXICONTACT_MESSAGE_SENT');

	if (!isset($this->data->user_template))
		$this->data->user_template = '%V_MESSAGE_DATA%<br />';

	if (!isset($this->data->admin_template))
		$this->data->admin_template = 'From %V_FROM_NAME% at %V_FROM_EMAIL%<br /><br />%V_MESSAGE_DATA%<br />';

	if (!isset($this->data->page_text)) $this->data->page_text = '';
	if (!isset($this->data->bottom_text)) $this->data->bottom_text = '';

// defaults for the front end

	if ($site)
		{
		if (!isset($this->data->magic_word)) $this->data->magic_word = '';
		if (!isset($this->data->num_images)) $this->data->num_images = 0;
		for ($i = 1; $i <= 5; $i++)
			{
			$promptname = 'field_prompt'.$i;
			}
		}
		
	return $this->data;
}

//-------------------------------------------------------------------------------
// Get the post data and return it as an associative array
//
function &getPostData($view, $param1)
{
	switch ($view)
		{
		case 'config_general':
			$post_data['logging'] = JRequest::getVar('logging');					// radio button
			$post_data['email_html'] = JRequest::getVar('email_html');				// radio button
			$post_data['autofill'] = JRequest::getVar('autofill');
			$post_data['agreement_prompt'] = JRequest::getVar('agreement_prompt');
			$post_data['agreement_name'] = JRequest::getVar('agreement_name');
			$post_data['agreement_link'] = JRequest::getVar('agreement_link');
			$post_data['show_copy'] = JRequest::getVar('show_copy');
			break;
			
		case 'config_template':
			if ($param1 == 'user_template')
				$post_data['user_template'] = JRequest::getVar('user_template',"","","",JREQUEST_ALLOWRAW);
			if ($param1 == 'admin_template')
				$post_data['admin_template'] = JRequest::getVar('admin_template',"","","",JREQUEST_ALLOWRAW);
			break;
			
		case 'config_fields':
			$post_data['show_subject'] = JRequest::getVar('show_subject');			// radio button
			$post_data['default_subject'] = JRequest::getVar('default_subject');
			$post_data['area_prompt'] = JRequest::getVar('area_prompt');
			$post_data['area_opt'] = JRequest::getVar('area_opt');
			$post_data['area_width'] = JRequest::getVar('area_width');
			$post_data['area_height'] = JRequest::getVar('area_height');
			for ($i = 1; $i <= 5; $i++)
				{
				$post_data['field_prompt'.$i] = JRequest::getVar('field_prompt'.$i);
				$post_data['field_opt'.$i] = JRequest::getVar('field_opt'.$i);
				}
			break;
			
		case 'config_confirm':
			$post_data['confirm_link'] = JRequest::getVar('confirm_link');
			$post_data['confirm_text'] = JRequest::getVar('confirm_text',"","","",JREQUEST_ALLOWRAW);
			break;

		case 'config_text':
			if ($param1 == 'page_text')
				$post_data['page_text'] = JRequest::getVar('page_text',"","","",JREQUEST_ALLOWRAW);
			if ($param1 == 'bottom_text')
				$post_data['bottom_text'] = JRequest::getVar('bottom_text',"","","",JREQUEST_ALLOWRAW);
			break;
		}
		
	return $post_data;
}

// ------------------------------------------------------------------------------------
// Validate all the configuration entries
// Return TRUE on success or FALSE if there is any invalid data
//
function check($view)
{
	return true;
}

//---------------------------------------------------------------
// Save component parameters
// Returns TRUE on success or FALSE if there is an error
//
function store($view, $param1)
{
	$this->getData();											// get the currently saved parameters
	foreach ($this->data as $param_name => $param_value)		// and store in $data['params']
		$data['params'][$param_name] = $param_value;

	$post_data = $this->getPostData($view, $param1);			// get the post data
	foreach ($post_data as $param_name => $param_value)			// and overwrite old values with any new values
		if (isset($param_value))
			$data['params'][$param_name] = $param_value;
		
	if (!$this->check($view))										// Validate the data
		return false;											// check() may have enqueued an error message

	$version = new JVersion();
	$joomla_version = $version->RELEASE;
	if ($joomla_version == '1.5')
		{
		$table = JTable::getInstance('component');		// Joomla 1.5
		$table->loadByOption(LAFC_COMPONENT);
		}
	else
		{
		$table	= JTable::getInstance('extension');		// Joomla 1.6
		$id = $table->find(array('element' => LAFC_COMPONENT));
		$table->load($id);
		}
		
	$table->bind($data);
	$ret = $table->store();

// clean the cache. Not sure this works properly on Joomla 1.6

	if (($joomla_version == '1.5') or ($joomla_version == '1.6'))
		{
		$cache = JFactory::getCache(LAFC_COMPONENT);
		$cache->clean();
		}
	else
		{
		$this->cleanCache('_system', 0);
		$this->cleanCache('_system', 1);
		}
		
	return $ret;
}

}
		
		