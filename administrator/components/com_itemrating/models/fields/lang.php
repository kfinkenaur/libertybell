<?php

/**
 * @version     2.2.1
 * @package     com_mymaplocations
 * @copyright   JoomUnited (C) 2011. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * ****@author      joomunited - contact@joomunited.com
 */
defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

/**
 * Supports an HTML select list of categories
 */
class JFormFieldLang extends JFormField {

    /**
     * The form field type.
     *
     * @var		string
     * @since	1.6
     */
    protected $type = 'lang';

    /**
     * Method to get the field input markup.
     *
     * @return	string	The field input markup.
     * @since	1.6
     */
    protected function getInput() {
        
        // Initialize variable
        $lang = JFactory::getLanguage();
        $lang->load('com_itemrating', JPATH_ADMINISTRATOR);
        return;
    }
    protected function getLabel() {
            return;
        }

}