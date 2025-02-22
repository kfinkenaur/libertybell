<?php
/********************************************************************
Product		: Flexicontact
Date		: 1 February 2013
Copyright	: Les Arbres Design 2010-2013
Contact		: http://extensions.lesarbresdesign.info
Licence		: GNU General Public License
*********************************************************************/
defined('_JEXEC') or die('Restricted Access');

define("LAFC_COMPONENT",      "com_flexicontact");
define("LAFC_COMPONENT_NAME", "FlexiContact");
define("LAFC_COMPONENT_LINK", "index.php?option=".LAFC_COMPONENT);
define("LAFC_ADMIN_ASSETS_URL",  JURI::root().'administrator/components/'.LAFC_COMPONENT.'/assets/');
define("LAFC_SITE_IMAGES_PATH",  JPATH_COMPONENT_SITE.'/images');
define("LAFC_SITE_ASSETS_PATH",  JPATH_COMPONENT_SITE.'/assets');
define("LAFC_HELPER_PATH",       JPATH_ROOT.'/administrator/components/com_flexicontact/helpers');

// email merge variables

define("LAFC_T_FROM_NAME",     "%V_FROM_NAME%");
define("LAFC_T_FROM_EMAIL",    "%V_FROM_EMAIL%");
define("LAFC_T_SUBJECT",       "%V_SUBJECT%");
define("LAFC_T_MESSAGE_PROMPT","%V_MESSAGE_PROMPT%");
define("LAFC_T_MESSAGE_DATA",  "%V_MESSAGE_DATA%");
define("LAFC_T_FIELD1_PROMPT", "%V_FIELD1_PROMPT%");
define("LAFC_T_FIELD1_DATA",   "%V_FIELD1_DATA%");
define("LAFC_T_FIELD2_PROMPT", "%V_FIELD2_PROMPT%");
define("LAFC_T_FIELD2_DATA",   "%V_FIELD2_DATA%");
define("LAFC_T_FIELD3_PROMPT", "%V_FIELD3_PROMPT%");
define("LAFC_T_FIELD3_DATA",   "%V_FIELD3_DATA%");
define("LAFC_T_FIELD4_PROMPT", "%V_FIELD4_PROMPT%");
define("LAFC_T_FIELD4_DATA",   "%V_FIELD4_DATA%");
define("LAFC_T_FIELD5_PROMPT", "%V_FIELD5_PROMPT%");
define("LAFC_T_FIELD5_DATA",   "%V_FIELD5_DATA%");
define("LAFC_T_BROWSER",       "%V_BROWSER%");
define("LAFC_T_IP_ADDRESS",    "%V_IP_ADDRESS%");

// log date filters

define("LAFC_LOG_ALL", 0);					// report filters
define("LAFC_LOG_LAST_7_DAYS", 1);
define("LAFC_LOG_LAST_28_DAYS", 2);
define("LAFC_LOG_LAST_12_MONTHS", 3);

// copy me

define("LAFC_COPYME_NEVER", 0);				// never copy the user
define("LAFC_COPYME_CHECKBOX", 1);			// show the checkbox on the contact form
define("LAFC_COPYME_ALWAYS", 2);			// always copy the user

// Themes - If you update this list, make sure that you update the make_theme_list function in this file

define("THEME_ALL", 'all');
define("THEME_STANDARD", 'standard');
define("THEME_TOYS", 'toys');
define("THEME_NEON", 'neon');
define("THEME_WHITE", 'white');
define("THEME_BLACK", 'black');

// create the new class names used by Joomla 3 and above, if they don't already exist.
// (you can't define a class inside a method of a class, but you can include a file that does so)

if (!class_exists('JControllerLegacy'))
	{
	jimport('joomla.application.component.controller');
	class JControllerLegacy extends JController { };
	}
if (!class_exists('JModelLegacy'))
	{
	jimport('joomla.application.component.model');
	class JModelLegacy extends JModel { };
	}
if (!class_exists('JViewLegacy'))
	{
	jimport('joomla.application.component.view');
	class JViewLegacy extends JView { };
	}

class Flexicontact_Utility
{

// -------------------------------------------------------------------------------
// Draw the top menu and make the current item active
//
static function addSubMenu($submenu = '')
{
	JSubMenuHelper::addEntry(JText::_('COM_FLEXICONTACT_CONFIGURATION'), 'index.php?option='.LAFC_COMPONENT.'&task=config', $submenu == 'config');
	JSubMenuHelper::addEntry(JText::_('COM_FLEXICONTACT_LOG'), 'index.php?option='.LAFC_COMPONENT.'&task=log_list', $submenu == 'log');
	JSubMenuHelper::addEntry(JText::_('COM_FLEXICONTACT_HELP_AND_SUPPORT'), 'index.php?option='.LAFC_COMPONENT.'&help', $submenu == 'help');
}
  
//-------------------------------------------------------------------------------
// Make a pair of boolean radio buttons
// $name          : Field name
// $current_value : Current value (boolean)
//
static function make_radio($name,$current_value)
{
	$html = '';
	if ($current_value == 1)
		{
		$yes_checked = 'checked="checked" ';
		$no_checked = '';
		}
	else
		{
		$yes_checked = '';
		$no_checked = 'checked="checked" ';
		}
	$html .= ' <input type="radio" name="'.$name.'" value="1" '.$yes_checked.' /> '.JText::_('COM_FLEXICONTACT_V_YES')."\n";
	$html .= ' <input type="radio" name="'.$name.'" value="0" '.$no_checked.' /> '.JText::_('COM_FLEXICONTACT_V_NO')."\n";
	return $html;
}

//-------------------------------------------------------------------------------
// Make a select list
// $name          : Field name
// $current_value : Current value
// $list          : Array of ID => value items
// $first         : ID of first item to be placed in the list
// $extra         : Javascript or styling to be added to <select> tag
//
static function make_list($name, $current_value, &$items, $first = 0, $extra='')
{
	$html = "\n".'<select name="'.$name.'" id="'.$name.'" class="input" size="1" '.$extra.'>';
	if ($items == null)
		return '';
	foreach ($items as $key => $value)
		{
		if (strncmp($key,"OPTGROUP_START",14) == 0)
			{
			$html .= "\n".'<optgroup label="'.$value.'">';
			continue;
			}
		if (strncmp($key,"OPTGROUP_END",12) == 0)
			{
			$html .= "\n".'</optgroup>';
			continue;
			}
		if ($key < $first)					// skip unwanted entries
			{
			continue;
			}
		$selected = '';

		if ($current_value == $key)
			$selected = ' selected="selected"';
		$html .= "\n".'<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
		}
	$html .= '</select>'."\n";

	return $html;
}

//-------------------------------------------------------------------------------
// Make an info button
//
static function make_info($title, $link='')
{
	JHTML::_('behavior.tooltip');
	if ($link == '')
		{
		$icon_name = 'info-16.png';
		$html = '';
		}
	else
		{
		$icon_name = 'link-16.png';
		$html = '<a href="'.$link.'" target="_blank">';
		}

	$icon = JHTML::_('image', LAFC_ADMIN_ASSETS_URL.$icon_name,'', array('style' => 'vertical-align:text-bottom;'));
	$html .= '<span class="hasTip" title="'.htmlspecialchars($title, ENT_COMPAT, 'UTF-8').'">'.$icon.'</span>';
		
	if ($link != '')
		$html .= '</a>';
		
	return $html;
}

//-------------------------------------------------------------------------------
// Makes the list of all (currently) possible themes
//
static function make_theme_list()
{
	$version = new JVersion();
	$joomla_version = $version->RELEASE;
	if ($joomla_version == '1.5')
		$result[THEME_ALL] = ucfirst(JText::_('ALL'));
	else
		$result[THEME_ALL] = ucfirst(JText::_('JALL'));
		
	$result[THEME_STANDARD] = 'Standard';
	$result[THEME_TOYS] = 'Toys';
	$result[THEME_NEON] = 'Neon';
	$result[THEME_WHITE] = 'White Tiles';
	$result[THEME_BLACK] = 'Black Tiles';
		
	return $result;
}

// -------------------------------------------------------------------------------
// Create a constant for the Joomla version
//
static function get_joomla_version()
{
	$version = new JVersion();
	$joomla_version = $version->RELEASE;
//	$joomla_level = $version->DEV_LEVEL;
	switch ($joomla_version)
		{
		case '1.5':
			define("LAFC_JVERSION", 150);
			break;
		case '1.6':
			define("LAFC_JVERSION", 160);
			break;
		case '1.7':
			define("LAFC_JVERSION", 170);
			break;
		case '2.5':
			define("LAFC_JVERSION", 250);
			break;
		case '3.0':
			define("LAFC_JVERSION", 300);
			break;
		default:							// some future version
			define("LAFC_JVERSION", 300);
			break;
		}
		
	return LAFC_JVERSION;
}


}

?>


