<?php
/**
 * @version		$Id: mod_cjblogmybadges.php 01 2011-11-11 11:37:09Z maverick $
 * @package		CoreJoomla.cjblog
 * @subpackage	Modules.cjblogmybadges
 * @copyright	Copyright (C) 2009 - 2014 corejoomla.com. All rights reserved.
 * @author		Maverick
 * @link		http://www.corejoomla.com/
 * @license		License GNU General Public License version 2 or later
 */
//don't allow other scripts to grab and execute our file
defined('_JEXEC') or die();
defined('CJBLOG') or define('CJBLOG', 'com_cjblog');

require_once JPATH_ROOT.'/components/com_content/helpers/route.php';
require_once JPATH_ROOT.'/components/'.CJBLOG.'/api.php';
require_once JPATH_ROOT.'/components/'.CJBLOG.'/router.php';

$user = JFactory::getUser();
if(!$user->guest)
{
	$limit = intval($params->get('num_badges', 20));
	$badges = CjBlogApi::get_user_badges($user->id, 0, $limit);
	require JModuleHelper::getLayoutPath( 'mod_cjblogmybadges', $params->get('layout', 'default') );
}