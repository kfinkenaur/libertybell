<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */


// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_itemrating')) 
{
	JFactory::getApplication()->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'),'error');
}

// Include dependancies
jimport('joomla.application.component.controller');

         require_once JPATH_SITE . '/components/com_itemrating/helpers/itemrating.php';

$controller	= JControllerLegacy::getInstance('Itemrating');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
