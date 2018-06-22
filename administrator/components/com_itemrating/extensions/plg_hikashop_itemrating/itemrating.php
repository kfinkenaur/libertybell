<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */

defined('_JEXEC') or die;

jimport('joomla.form.form');
require_once JPATH_SITE . '/components/com_itemrating/helpers/itemrating.php';
JTable::addIncludePath(JPATH_ADMINISTRATOR .'/components/com_itemrating/tables');

class plgHikashopItemRating extends JPlugin
{
    static $count=0;
	function plgHikashopItemRating(&$subject, $config){
		parent::__construct($subject, $config);
		
		if(!isset($this->params)){
			$plugin = JPluginHelper::getPlugin('hikashop', 'history');
			jimport('joomla.html.parameter');
			if(version_compare(JVERSION,'2.5','<')){
				$this->params = new JParameter($plugin->params);
			} else {
				$this->params = new JRegistry($plugin->params);
			}
		}
	}

	 function onProductFormDisplay(&$element,&$html) {
		ItemratingHelper::loadLanguage();
		 $form = JForm::getInstance('form', JPATH_ADMINISTRATOR . '/components/com_itemrating/models/forms/itemrating.xml');
		 if(!empty($element->product_id))
		 {
		$db = JFactory::getDBO();
		$sql = "select * from #__itemrating_context where context=" . $db->Quote('com_hikashop') . "AND context_id=" . $db->Quote($element->product_id);
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
				
	$html[]=$chtml;
	return true;
	}
	function onAfterProductCreate(&$element)
	{
		$this->saveItemrating($element);
		return;
	}
	function onAfterProductUpdate(&$element)
	{
		$this->saveItemrating($element);
		return;
	}
	function saveItemrating($element)
	{
		$data=JFactory::getApplication()->input->getArray();
		$ratingdata=array();
		$db = JFactory::getDBO();
		$sql = "select id from #__itemrating_context where context=" . $db->Quote('com_hikashop') . "AND context_id=" . $db->Quote($element->product_id);
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
		
		$ratingdata['context']='com_hikashop';
		$ratingdata['context_id']=$element->product_id;
		$ratingdata['group_id']=@$data['attribs']['groupdata'];
		if(!empty($data['attribs']['textforscore']))
		$ratingdata['textscore']=@$data['attribs']['textforscore'];
		if(!empty($data['attribs']['reviewsummary']))
		$ratingdata['summary']=@$data['attribs']['reviewsummary'];
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
	 function onHikashopAfterDisplayView(&$view)
	{
	    $layout=JFactory::getApplication()->input->getString('layout');
	    
        	if ((isset($view->ctrl))&&($view->ctrl=="product"))
		{
				if(empty($view->row->product_id))
			{
				return;
			}
			else if($layout!="show")
			{
			    return;
			}
			$html="";
			$db = JFactory::getDBO();
			$sql = "select * from #__itemrating_context where context=" . $db->Quote('com_hikashop') . "AND context_id=" . $db->Quote($view->row->product_id);
		$db->setQuery($sql);
		$ratingitem = $db->loadObject();
	     if(empty($ratingitem->id))
	     {
	      return;
	     }
	     
	     $item=new stdClass();
	     $item->id=$view->row->product_id;
	     $item->introtext=$view->row->product_description;
	     $item->title=$view->row->product_name;
	     $item->created=JFactory::getDate($view->row->product_created)->Format('d-m-Y');
	     $item->modified=JFactory::getDate($view->row->product_modified)->Format('d-m-Y');
	     $item->authorName=JFactory::getUser($view->row->product_vendor_id)->name;
	     $currencyClass = hikashop_get('class.currency');
	     if(empty($view->row->prices[0]->price_value_with_tax))
	     {
		$item->productprice=0;
	     }
	     else
	     {
	     $item->productprice=$currencyClass->format($view->row->prices[0]->price_value_with_tax,$view->row->prices[0]->price_currency_id);
	     }
	     $item->productcategory=$view->categories[0]->category_name;
	     $item->quantity=$view->row->product_quantity;
	     $item->brand=$view->row;
	     $item->attribs=json_encode(array("groupdata"=>$ratingitem->group_id,'textforscore'=>$ratingitem->textscore,'reviewsummary'=>$ratingitem->summary));
	     $item->voteallowed=1;
	    
	     $html2 = ItemratingHelper::loadWidget($item,"bottom");
             if(($html2)&&(self::$count==0))
             {
             echo $html2;
             self::$count++;
             }
             
             }
	}
	function onBeforeProductDelete(&$ids,&$do)
	{
		$db = JFactory::getDBO();
		$type = 'itemcontext';
		$prefix = 'ItemratingTable';
		$config = array();
		$table = JTable::getInstance($type, $prefix, $config);
		$type2 = 'itemdata';
		$prefix2 = 'ItemratingTable';
		$config2 = array();
		$table2 = JTable::getInstance($type2, $prefix2, $config2);
		
		foreach($ids as $id)
		{
		$sql = "select id from #__itemrating_context where context=" . $db->Quote('com_hikashop') . "AND context_id=" . $db->Quote($id);
		$db->setQuery($sql);
		$ratingitem = $db->loadObject();
		if(!empty($ratingitem))
		{
		$table->load($ratingitem->id);
		$table->delete($ratingitem->id);
		}
		$sql = "select id from #__itemrating_itemdata where context=" . $db->Quote('com_hikashop') . "AND context_id=" . $db->Quote($id);
		$db->setQuery($sql);
		$ratingdata = $db->loadObjectList();
		if(!empty($ratingdata))
		{
		foreach($ratingdata  as $data)
		{
		$table2->load($data->id);
		$table2->delete($data->id);
		}
		}
		}
	}
}
