<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */

defined('_JEXEC') or die;

/*
	Class: Element
		The Element abstract class
*/
class ElementItemrating extends Element {
public function edit() {

require_once JPATH_SITE . '/components/com_itemrating/helpers/itemrating.php';
ItemratingHelper::loadLanguage();
		 $form = JForm::getInstance('form', JPATH_ADMINISTRATOR . '/components/com_itemrating/models/forms/itemrating.xml');
		 $chtml="";
		 
		 $form->setValue('groupdata','attribs', $this->get('groupdata'));
		 $form->setValue('textforscore','attribs', $this->get('textforscore'));
		 $form->setValue('reviewsummary','attribs',$this->get('reviewsummary'));
	$chtml.='<table width="100%">
				<tbody>';
				$chtml.='<tr>
			<td class="key"><label>' . $form->getLabel('groupdata','attribs') . '</label></td>
									<td >
			' .  str_replace('attribs[groupdata]',$this->getControlName('groupdata'),$form->getInput('groupdata','attribs') ) . '</td>
								</tr>
								<tr>
			<td class="key"><label>' . $form->getLabel('textforscore','attribs') . '</label></td>
									<td >
				' .  str_replace('attribs[textforscore]',$this->getControlName('textforscore'),$form->getInput('textforscore','attribs')) . '</td>
								</tr>
								<tr>
                            <td class="key"><label>' . $form->getLabel('reviewsummary','attribs') . '
				</label></td>
			<td >' . str_replace('attribs[reviewsummary]',$this->getControlName('reviewsummary'), $form->getInput('reviewsummary','attribs'))  . '</td>
								</tr>';
			
				$chtml.='</table>';
				
	$html[]=$chtml;
	return implode("\n", $html);
}

public function render($params = array()) {
	$view=JFactory::getApplication()->input->getString('view');
	$layout=$params['_layout'];
require_once JPATH_SITE . '/components/com_itemrating/helpers/itemrating.php';
ItemratingHelper::loadLanguage();
$html="";
	if($this->get('groupdata'))
	{
		$item=new stdClass();
	     $item->id= $this->_item->id;
	     $item->introtext='';
	     $item->title=$this->_item->name;
	     
	     $item->created=JFactory::getDate($this->_item->created)->Format('d-m-Y');
	     $item->modified=JFactory::getDate($this->_item->modified)->Format('d-m-Y');
	    
	     $item->authorName= JFactory::getUser($this->_item->created_by)->name;;
		$user   = $this->app->user->get($this->_item->created_by);

			if (empty($author) && $user) {
				$item->author = $user->name;
			}
		if($layout=="full")
		{
		$item->voteallowed=1;
		}
		else
		{
			$item->voteallowed=1;
			$componentparam=JComponentHelper::getParams('com_itemrating');
			$show_category=$componentparam->get('show_category',0);
			if(($show_category==0))
		   {
		    return;
		   }
			$item->categoryview=1;
		
		}
	     $item->attribs=json_encode(array("groupdata"=>$this->get('groupdata'),'textforscore'=>$this->get('textforscore'),'reviewsummary'=>$this->get('reviewsummary')));
	     if($layout=="itemmetadata")
	     {
		$item->scoreonly=1;
		$result= ItemratingHelper::loadWidget($item,"top");
		$fresult=(explode("%",strip_tags($html)));
		$html=$this->_item->name." ".$fresult[0]."%";
			
	     }
	     else
	     {
	     $html.="<style type='text/css'>.review_wrap .review-top{width:100%;}</style>";
	     $html.= ItemratingHelper::loadWidget($item,"top");
	     }
	}
	return $html;
}

public function hasValue($params = array()) {
	$groupdata = $this->get('groupdata');
	$textforscore = $this->get('textforscore');
	$reviewsummary = $this->get('reviewsummary');
	return !empty($groupdata) ||!empty($textforscore) ||($reviewsummary);
}
/*
		Function: renderSubmission
			Renders the element in submission.

	   Parameters:
            $params - AppData submission parameters

		Returns:
			String - html
	*/
	public function renderSubmission($params = array()) {
        return $this->edit();
	}

}