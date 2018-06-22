<?php
/**
 * @package     corejoomla.administrator
 * @subpackage  com_cjlib
 *
 * @copyright   Copyright (C) 2009 - 2014 corejoomla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

class CjMailHelper
{
	public static function getMessage($msgid)
	{
		$db = JFactory::getDbo();
		$messages = array();
		
		$query = $db->getQuery(true)
			->select('q.id, q.to_addr, q.cc_addr, q.bcc_addr, q.html, q.message_id, q.params AS qparams')
			->from('#__corejoomla_messagequeue AS q');
		
		// join over messages
		$query->select('m.id AS msgid, m.asset_id, m.asset_name, m.subject, m.description, m.params AS msgparams')
			->join('inner', '#__corejoomla_messages AS m ON m.id = q.message_id');
		
		// where conditions
		if(is_array($msgid))
		{
			JArrayHelper::toInteger($msgid);
			$query->where('q.id IN ('.implode(',', $msgid).')');
		}
		else 
		{
			$query->where('q.id = '.(int) $msgid);
		}
		
		$db->setQuery($query);
		try
		{
			$messages = $db->loadObjectList();
		}
		catch(Exception $e)
		{
			return false;
		}
		
		if(empty($messages))
		{
			return false;
		}
		
		foreach ($messages as &$message)
		{
			// First replace all message placeholders
			$params = json_decode($message->qparams);
			$message->attachment = null;
			
			if(!empty($params->placeholders))
			{
				foreach ($params->placeholders as $key=>$value)
				{
					$message->subject = JString::str_ireplace($key, $value, $message->subject);
					$message->description = JString::str_ireplace($key, $value, $message->description);
				}
			}

			if(!empty($params->attachment))
			{
				$message->attachment = JPATH_ROOT . $params->attachment;
			}

			// Then replace all queue item placeholders
			$params = json_decode($message->msgparams);
			if(!empty($params->placeholders))
			{
				foreach ($params->placeholders as $key=>$value)
				{
					$message->subject = JString::str_ireplace($key, $value, $message->subject);
					$message->description = JString::str_ireplace($key, $value, $message->description);
				}
			}
			
			if(!empty($params->attachment))
			{
				$message->attachment = JPATH_ROOT . $params->attachment;
			}
		}
		
		return $messages;
	}
}