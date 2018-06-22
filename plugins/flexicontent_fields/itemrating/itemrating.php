<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */

defined('_JEXEC') or die;

jimport('joomla.event.plugin');
jimport('joomla.form.form');
require_once JPATH_SITE . '/components/com_itemrating/helpers/itemrating.php';
JTable::addIncludePath(JPATH_ADMINISTRATOR .'/components/com_itemrating/tables');


class plgFlexicontent_fieldsItemRating extends JPlugin
{
		static $field_types = array('itemrating');
		
		// ***********
	// CONSTRUCTOR
	// ***********
	
	function plgFlexicontent_fieldsItemRating( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}
	
	// *******************************************
	// DISPLAY methods, item form & frontend views
	// *******************************************
	
	// Method to create field's HTML display for item form
	function onDisplayField(&$field, &$item)
	{
		
		if ( !in_array($field->field_type, self::$field_types) ) return;
		
		ItemratingHelper::loadLanguage();
		 $form = JForm::getInstance('form', JPATH_ADMINISTRATOR . '/components/com_itemrating/models/forms/itemrating.xml');
		 if(!empty($item->id))
		 {
		$db = JFactory::getDBO();
		$sql = "select * from #__itemrating_context where context=" . $db->Quote('com_flexicontent') . "AND context_id=" . $db->Quote($item->id);
		$db->setQuery($sql);
		$ratingitem = $db->loadObject();
		if(!empty($ratingitem))
		{
	
			$form->setValue('groupdata','attribs', $ratingitem->group_id);
			$form->setValue('textforscore','attribs', $ratingitem->textscore);
			$form->setValue('reviewsummary','attribs', $ratingitem->summary);
		}
		 }
		 $chtml=""; 
	
	$chtml.='<table width="100%" class="admintable table">
				<tbody>';
				$chtml.='<tr>
			<td class="key"><label>' . $form->getLabel('groupdata','attribs') . '</label></td>
									<td >
			' .  $form->getInput('groupdata','attribs') . '</td>
								</tr>
								<tr>
			<td class="key"><label>' . $form->getLabel('textforscore','attribs') . '</label></td>
									<td >
				' . $form->getInput('textforscore','attribs') . '</td>
								</tr>
								<tr>
                            <td class="key"><label>' . $form->getLabel('reviewsummary','attribs') . '
				</label></td>
			<td >' . $form->getInput('reviewsummary','attribs') . '</td>
								</tr>';
			
				$chtml.='</table>';
		
		$field->html=$chtml;
		return false;
	}
	function onAfterSaveField( &$field, &$post, &$file, &$item ) {

		$this->saveItemrating($field,$item);
		return;
	}
	function saveItemrating($field,$item)
	{
		$data=JFactory::getApplication()->input->getArray();
		$ratingdata=array();
		$db = JFactory::getDBO();
		$sql = "select id from #__itemrating_context where context=" . $db->Quote('com_flexicontent') . "AND context_id=" . $db->Quote($item->id);
		$db->setQuery($sql);
		$ratingitem = $db->loadObject();
if(empty($data))
		{
			return;
		}
		if(empty($ratingitem)&&empty($data['attribs']['groupdata']))
		{
			
			return;
		}
		if(!empty($ratingitem))
		{
		 $ratingdata['id'] = $ratingitem->id;	
		}
		
		$ratingdata['context']='com_flexicontent';
		$ratingdata['context_id']=$item->id;
		$ratingdata['group_id']=$data['attribs']['groupdata'];;
		if(!empty($data['attribs']['textforscore']))
		$ratingdata['textscore']=$data['attribs']['textforscore'];
		if(!empty($data['attribs']['reviewsummary']))
		$ratingdata['summary']=$data['attribs']['reviewsummary'];
		$type = 'itemcontext';
		$prefix = 'ItemratingTable';
		$config = array();
		$table = JTable::getInstance($type, $prefix, $config);
		$table->bind($ratingdata);
		if (!$table->check()) {
		    JFactory::getApplication()->enqueueMessage($table->getError(), 'error');
		}
		if (!$table->store()) {
	            JFactory::getApplication()->enqueueMessage($table->getError(), 'error');
		}
	}
	

	// Method to create field's HTML display for frontend views
	function onDisplayFieldValue(&$field, $item, $values=null, $prop='display')
	{
		
		$db = JFactory::getDBO();
		$sql = "select * from #__itemrating_context where context=" . $db->Quote('com_flexicontent') . "AND context_id=" . $db->Quote($item->id);
		$db->setQuery($sql);

		$ratingitem = $db->loadObject();
	     if(empty($ratingitem->id))
	     {
	      return;
	     }
	    $item->attribs=json_encode(array("groupdata"=>$ratingitem->group_id,'textforscore'=>$ratingitem->textscore,'reviewsummary'=>$ratingitem->summary));
	    $item->voteallowed=1;
		
		$field->{$prop} = ItemratingHelper::loadWidget($item,"top");
	}
	
}
