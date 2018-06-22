<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');
require_once JPATH_COMPONENT . '/helpers/itemrating.php';
ItemratingHelper::loadLanguage();
// Execute the task.
$controller	= JControllerLegacy::getInstance('Itemrating');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
