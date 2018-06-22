<?php
/**
 * @version		$Id: helper.php 01 2011-01-11 11:37:09Z maverick $
 * @package		CoreJoomla.CjBlog
 * @subpackage	Components.modules
 * @copyright	Copyright (C) 2009 - 2012 corejoomla.com, Inc. All rights reserved.
 * @author		Maverick
 * @link		http://www.corejoomla.com/
 * @license		License GNU General Public License version 2 or later
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class CjBloggersHelper {
	
	public static function get_bloggers_list($type, $count = 10, $excludes = array()){
		
		$db = JFactory::getDbo();
		$order = ($type == 1) ? 'a.id desc' : ($type == 2 ? 'a.num_articles desc' : 'a.profile_views desc');
		
		$where = '';
		
		if(!empty($excludes)){
				
			$where = ' and u.id not in (
					select
						distinct(user_id)
					from
						#__usergroups as ug1
					inner join
						#__usergroups AS ug2 ON ug2.lft >= ug1.lft AND ug1.rgt >= ug2.rgt
					inner join
						#__user_usergroup_map AS m ON ug2.id=m.group_id
					where
						ug1.id in ('.implode(',', $excludes).'))';
		}
		
		$query = '
				select 
					a.id, a.avatar, a.num_articles, a.profile_views, a.points,
					u.name, u.username, u.email
				from
					#__cjblog_users a
				left join
					#__users u on a.id = u.id
				where
					a.num_articles > 0'.$where.'
				order by
					'.$order;
		
		$db->setQuery($query, 0, $count);
		$bloggers = $db->loadObjectList();
		
		return $bloggers;
	}
}