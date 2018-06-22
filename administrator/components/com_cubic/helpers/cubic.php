<?php

/**
 * @version     1.0.0
 * @package     com_cubic
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Theophile Marcellus <cnngraphics@gmail.com> - http://www.linksmediacorp.com
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Cubic helper.
 */
class CubicHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        		JHtmlSidebar::addEntry(
			JText::_('COM_CUBIC_TITLE_CUBES'),
			'index.php?option=com_cubic&view=cubes',
			$vName == 'cubes'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_CUBIC_TITLE_CATEGORIESS'),
			'index.php?option=com_cubic&view=categoriess',
			$vName == 'categoriess'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_CUBIC_TITLE_ITEMS'),
			'index.php?option=com_cubic&view=items',
			$vName == 'items'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_CUBIC_TITLE_CREATED_INVENTORIES'),
			'index.php?option=com_cubic&view=inventories',
			$vName == 'inventories'
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

        $assetName = 'com_cubic';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }


}
