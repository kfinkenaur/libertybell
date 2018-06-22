<?php
defined('_JEXEC') or 	die( 'Direct Access to ' . basename( __FILE__ ) . ' is not allowed.' ) ;
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */

if (!class_exists('vmCustomPlugin')) require(JPATH_VM_PLUGINS . DIRECTORY_SEPARATOR . 'vmcustomplugin.php');

class plgVmCustomItemRating extends vmCustomPlugin {

	function __construct(& $subject, $config) {

		parent::__construct($subject, $config);

		$varsToPush = array(	'custom_groupdata'=>array(0.0,'int'),
			'custom_textforscore'=>array('', 'string'),
			'custom_reviewsummary'=>array('', 'string'),
			
		);
		$lang = JFactory::getLanguage();
		$lang->load('com_itemrating', JPATH_ADMINISTRATOR);

		$this->setConfigParameterable('customfield_params',$varsToPush);

	}

	// get product param for this plugin on edit
	function plgVmOnProductEdit($field, $product_id, &$row,&$retValue) {

		if ($field->custom_element != $this->_name) return '';
		     $db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('id', 'title')));
			$query->where('state=1');
			$query->from('#__itemrating_group');
			$query->order('title ASC');
			$db->setQuery($query);
			$rows= $db->loadObjectList();
			$options[] = JHTML::_('select.option','',JText::_('JSELECT'));
			 foreach ($rows as $key => $value) {
			     $options[] = JHTML::_('select.option', $value->id, JText::_($value->title));    
			 }

		//VmConfig::$echoDebug = true;
		//vmdebug('plgVmOnProductEdit',$field);
		$html ='
			<fieldset>
				<legend>'. vmText::_('Item Rating') .'</legend>
				<span class="label label-warning"> Use Plugin once in Product</span>
				<table class="admintable">
				<tr>
			<td class="key">
				'.JTEXT::_('COM_ITEMRATING_FORM_LBL_ITEM_GROUP').'
			</td>
			<td>
					'.JHTML::_('select.genericlist', $options, 'customfield_params['.$row.'][custom_groupdata]', 'class="groupdata"', 'value','text',$field->custom_groupdata).'</td></tr>'.VmHTML::row('input','COM_ITEMRATING_FORM_LBL_GROUP_TEXTFORSCORE','customfield_params['.$row.'][custom_textforscore]',$field->custom_textforscore).VmHTML::row('input','COM_ITEMRATING_FORM_LBL_GROUP_REVIEWSUMMARY','customfield_params['.$row.'][custom_reviewsummary]',$field->custom_reviewsummary);
		$html .='</td>
		</tr>
				</table>
			</fieldset>';
		$retValue .= $html;
		$row++;
		return true ;
	}

	function plgVmOnDisplayProductFEVM3(&$product,&$group) {
	
		if ($group->custom_element != $this->_name) return '';
		
		
		$group->display .= $this->renderByLayout('default',array(&$product,&$group) );

		return true;
	}


	
	
	/**
	 * Declares the Parameters of a plugin
	 * @param $data
	 * @return bool
	 */
	function plgVmDeclarePluginParamsCustomVM3(&$data){

		return $this->declarePluginParams('custom', $data);
	}

	function plgVmGetTablePluginParams($psType, $name, $id, &$xParams, &$varsToPush){
		return $this->getTablePluginParams($psType, $name, $id, $xParams, $varsToPush);
	}

	function plgVmSetOnTablePluginParamsCustom($name, $id, &$table,$xParams){
		return $this->setOnTablePluginParams($name, $id, $table,$xParams);
	}

	/**
	 * Custom triggers note by Max Milbers
	 */
	function plgVmOnDisplayEdit($virtuemart_custom_id,&$customPlugin){
		return $this->onDisplayEditBECustom($virtuemart_custom_id,$customPlugin);
	}

	function plgVmOnSelfCallFE($type,$name,&$render) {
		$render->html = '';
	}

}

// No closing tag