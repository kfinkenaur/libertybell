<?php

/*
 * @version     1.2.2
 * @package     com_seoglossary
 * @copyright   JoomUnited (C) 2011. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @author      Created by JoomUnited (C)
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

/**
 * Form Field class for the Joomla Framework.
 *
 */
class JFormFieldColorpicker extends JFormField {

    /**
     * Color picker form field type compatible with Joomla 1.6. Displays an Adobe type color picker panel, and returns a six-digit hex value, eg #cc99ff
     */
    protected $type = 'Colorpicker';

    /**
     */
    protected function getInput() {

        $baseurl = JURI::base();
        $baseurl = str_replace('administrator/', '', $baseurl);

        $document = JFactory::getDocument();
        // Initialize some field attributes.
        $size = $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
        $maxLength = $this->element['maxlength'] ? ' maxlength="' . (int) $this->element['maxlength'] . '"' : '';
        $class = 'class="color {hash:true, adjust:false}"';
        $readonly = ((string) $this->element['readonly'] == 'true') ? ' readonly="readonly"' : '';
        $disabled = ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';
        $document->addScript(JURI::root() . '/administrator/components/com_itemrating/assets/jscolor.js');
        $options = array();
        if ($this->element['cellwidth']) {
            $options[] = "cellWidth:" . (int) $this->element['cellwidth'];
        }
        if ($this->element['cellheight']) {
            $options[] = "cellHeight:" . (int) $this->element['cellheight'];
        }
        if ($this->element['top']) {
            $options[] = "top:" . (int) $this->element['top'];
        }
        if ($this->element['left']) {
            $options[] = "left:" . (int) $this->element['left'];
        }

        $optionString = implode(',', $options);




        // Initialize JavaScript field attributes.
        $onchange = $this->element['onchange'] ? ' onchange="' . (string) $this->element['onchange'] . '"' : '';

        return '<input type="text" name="' . $this->name . '" id="' . $this->id . '"' .
                ' value="' . htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '"' .
                $class . $size . $disabled . $readonly . $onchange . $maxLength . '/>';
    }

}
