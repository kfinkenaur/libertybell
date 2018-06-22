<?php

/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Itemrating helper.
 */
class ItemratingBackendHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        		JHtmlSidebar::addEntry(
			JText::_('COM_ITEMRATING_TITLE_ITEMS'),
			'index.php?option=com_itemrating&view=items',
			$vName == 'items'
		);
			JHtmlSidebar::addEntry(
			JText::_('COM_ITEMRATING_TITLE_GROUPS'),
			'index.php?option=com_itemrating&view=groups',
			$vName == 'groups'
		);
			JHtmlSidebar::addEntry(
			JText::_('Report'),
			'index.php?option=com_itemrating&view=reports',
			$vName == 'reports'
		);

    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_itemrating';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }
	 public static function getSyncButton() {
			
	  $db = JFactory::getDBO();
	$query = $db->getQuery(true);
        $query->select('count(*)');
        $query->from('#__itemrating_itemdata as r');
		$query->join('LEFT','#__itemrating_item as i ON r.rating_id = i.id');
        $query->where('r.rating_value=""');
		$query->where('i.type!=0');
	  $db->setQuery($query);
        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
      $count = $db->loadResult();
		if($count!=0)
		{
			$html="<a href='index.php?option=com_itemrating&task=sync' class='btn btn-primary'>Click here</a> to Sync the data";
			JFactory::getApplication()->enqueueMessage($html, 'error');
		}
		return ;
	 }

}
