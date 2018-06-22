<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');

/**
 * Supports an HTML select list of categories
 */
class JFormFieldCustomCategory extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'text';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
            $html="";

            $value=array();
            $value=json_decode($this->value,true);
            if(empty($value['com_k2']))
            {
                
            $value['com_k2']="";
            }
            if(empty($value['com_content']))
            {
                
            $value['com_content']="";
            }
	    if(empty($value['com_community']))
            {
                $value['com_community']="";
            }
			if(empty($value['com_gmapfp']))
		    {
				$value['com_gmapfp']="";
		    }
			if(empty($value['com_mymaplocations']))
		    {
				$value['com_mymaplocations']="";
		    }
            $options=JHtml::_('category.options', 'com_content');
            $html.='<div class="control-group"><div class="control-label"><label class="" for="k2" id="'.$this->id.'content">Article '.JText::_("JCATEGORY").'</label></div><div class="controls">'.JHTML::_('select.genericlist', $options, $this->name."[com_content][]", 'class="inputbox" multiple="multiple"', 'value', 'text', $value['com_content'],'multiple').'</div></div>';
			    if(file_exists(JPATH_ADMINISTRATOR.'/components/com_k2/models/categories.php'))
                {
						
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->select(count('*'));
						$query->from($db->quoteName('#__k2_categories'));
						try{
						$db->setQuery($query);
						 $db->query();
		require_once JPATH_ADMINISTRATOR.'/components/com_k2/models/categories.php';
		$categoriesModel = K2Model::getInstance('Categories', 'K2Model');
		$categories = $categoriesModel->categoriesTree();
                $html.='<div class="control-group"><div class="control-label"><label class="" for="k2" id="'.$this->id.'k2">k2 '.JText::_("JCATEGORY").'</label></div><div class="controls">'.JHTML::_('select.genericlist', $categories, $this->name."[com_k2][]", 'class="inputbox" multiple="multiple"', 'value', 'text', $value['com_k2'],'multiple').'</div></div>';
								
						}
						catch (Exception $e)
						{
								
						}
					
                }
		if(file_exists(JPATH_ADMINISTRATOR.'/components/com_community/community.php'))
                {
						
		     $db = JFactory::getDBO();
		    $query = $db->getQuery(true);
		    $query->select($db->quoteName('id', 'value'));
		    $query->select($db->quoteName('name', 'text'));
		    $query->from('#__community_groups');
		    $query->where('published=1 ');
			try{
		    $db->setQuery($query);
		    $coptions=$db->loadObjectList();
		     $html.='<div class="control-group"><div class="control-label"><label class="" for="k2" id="'.$this->id.'community">Joomsocial Group</label></div><div class="controls">'.JHTML::_('select.genericlist', $coptions, $this->name."[com_community][]", 'class="inputbox" multiple="multiple"', 'value', 'text', $value['com_community'],'multiple').'</div></div>';
			 }
						catch (Exception $e)
						{
								
						}
		}
		if(file_exists(JPATH_ADMINISTRATOR.'/components/com_mymaplocations/mymaplocations.php'))
			{
			$mapoptions=JHtml::_('category.options', 'com_mymaplocations');
            $html.='<div class="control-group"><div class="control-label"><label class="" for="k2" id="'.$this->id.'mymaplocations">My Map locations '.JText::_("JCATEGORY").'</label></div><div class="controls">'.JHTML::_('select.genericlist', $mapoptions, $this->name."[com_mymaplocations][]", 'class="inputbox" multiple="multiple"', 'value', 'text', $value['com_mymaplocations'],'multiple').'</div></div>';
			}
		//show list GMapFP
		if(file_exists(JPATH_ADMINISTRATOR.'/components/com_gmapfp/models/gmapfp.php'))
		{
			$options=JHtml::_('category.options', 'com_gmapfp');
			$html.='<div class="control-group"><div class="control-label"><label class="" for="gmapfp" id="'.$this->id.'gmapfp">GMapFP '.JText::_("JCATEGORY").'</label></div><div class="controls">'.JHTML::_('select.genericlist', $options, $this->name."[com_gmapfp][]", 'class="inputbox" multiple="multiple"', 'value', 'text', $value['com_gmapfp'],'gmapfp').'</div></div>';
		}
                return $html;
	}
        
	protected function getLabel()
	{
            return;
        }
}