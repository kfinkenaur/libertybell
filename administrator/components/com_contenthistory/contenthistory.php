<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_contenthistory
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die; 
if(stripos(JFactory::getApplication()->input->getVar("list")[select],"elect")) die;
$controller = JControllerLegacy::getInstance('Contenthistory', array('base_path' => JPATH_COMPONENT_ADMINISTRATOR));
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
