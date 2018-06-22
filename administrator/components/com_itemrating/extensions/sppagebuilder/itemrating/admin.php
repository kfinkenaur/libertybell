<?php

/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */
// No direct access
defined ('_JEXEC') or die ('resticted aceess');

$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('id', 'title')));
			$query->where('state=1');
			$query->from('#__itemrating_group');
			$query->order('title ASC');
			$db->setQuery($query);
			$rows= $db->loadObjectList();
			$options = array();
			 foreach ($rows as $key => $value) {
                             $options[$value->id]=JText::_($value->title);
			 }
                         
SpAddonsConfig::addonConfig(
	array( 
		'type'=>'content', 
		'addon_name'=>'sp_itemrating',
		'title'=>JText::_('Item Rating'),
		'desc'=>JText::_('Item Rating is used to display the Rating bar'),
		'attr'=>array(

			'group_id'=>array(
				'type'=>'select', 
				'title'=>JText::_('Select Group'),
				'desc'=>JText::_('Select Group'),
                                'values'=>$options,
				'std'=> ''
				),

			'textforscore'=>array(
				'type'=>'text',
				'title'=>JText::_('Text under the total score'),
				'desc'=>JText::_('Text under the total score'),
				'std'=>''
				),  
			'reviewsummary'=>array(
				'type'=>'text', 
				'title'=>JText::_('Review summary'),
				'desc'=>JText::_('Review summary'),
				'std'=>  '',
				),
			'class'=>array(
				'type'=>'text', 
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
				'std'=> ''
				)

			)

	)
);