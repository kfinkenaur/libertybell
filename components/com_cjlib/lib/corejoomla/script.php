<?php
/**
 * @package     corejoomla.administrator
 * @subpackage  com_cjlib
 *
 * @copyright   Copyright (C) 2009 - 2014 corejoomla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

class CjScript
{
	protected static $registry = array();

	public static function _($key)
	{
		if (array_key_exists($key, static::$registry))
		{
			return false;
		}

		// function name should be removed
		$args = func_get_args();
		array_shift($args);
		
		// call the function
		static::register($key, $key);
		$toCall = array('CjScript', $key);
		
		return static::call($toCall, $args);
	}
	
	protected static function call($function, $args)
	{
		if (!is_callable($function))
		{
			throw new InvalidArgumentException('Function not supported', 500);
		}
	
		// PHP 5.3 workaround
		$temp = array();
	
		foreach ($args as &$arg)
		{
			$temp[] = &$arg;
		}
	
		return call_user_func_array($function, $temp);
	}
	
	public static function register($key, $function)
	{
		if (is_callable($function))
		{
			static::$registry[$key] = $function;
	
			return true;
		}
	
		return false;
	}
	
	private static function fontawesome($options = null)
	{
		$custom = isset($options['custom']) ? $options['custom'] : null;
		static::addStyleSheet(JUri::root(true).'/media/com_cjlib/fontawesome/css/font-awesome.min.css', $custom);
	}

	private static function noty($options = null)
	{
		$custom = isset($options['custom']) ? $options['custom'] : null;
		static::addScript(JUri::root(true).'/media/com_cjlib/noty/jquery.noty.packaged.min.js', $custom);
	}
	
	private static function chained($options = null)
	{
		$custom = isset($options['custom']) ? $options['custom'] : null;
		$remote = isset($options['remote']) ? $options['remote'] : false;
		
		if($remote)
		{
			static::addScript(JUri::root(true).'/media/com_cjlib/chained/jquery.chained.remote.min.js', $custom);
		}
		else 
		{
			static::addScript(JUri::root(true).'/media/com_cjlib/chained/jquery.chained.min.js', $custom);
		}
	}

	private static function bootbox($options = null)
	{
		$custom = isset($options['custom']) ? $options['custom'] : null;
		$version = isset($options['bootstrap']) && $options['bootstrap'] == 2 ? 'v3.3.0' : 'v4.4.0';
		static::addScript(JUri::root(true).'/media/com_cjlib/bootbox/bootbox_'.$version.'.min.js', $custom);
	}
	
	private static function jssocials($options = null)
	{
		$custom = isset($options['custom']) ? $options['custom'] : null;
		$theme	= isset($options['theme']) ? $options['theme'] : 'flat';
		static::addStyleSheet(JUri::root(true).'/media/com_cjlib/jssocials/jssocials.css', $custom);
		static::addStyleSheet(JUri::root(true).'/media/com_cjlib/jssocials/jssocials-theme-'.$theme.'.css', $custom);
		static::addScript(JUri::root(true).'/media/com_cjlib/jssocials/jssocials.min.js', $custom);
	}

	private static function datetime($options = null)
	{
		$custom = isset($options['custom']) ? $options['custom'] : null;
		static::addStyleSheet(JUri::root(true).'/media/com_cjlib/bscalendar/bootstrap-datetimepicker.min.css', $custom);
		static::addScript(JUri::root(true).'/media/com_cjlib/bscalendar/moment.min.js', $custom);
		static::addScript(JUri::root(true).'/media/com_cjlib/bscalendar/bootstrap-datetimepicker.min.js', $custom);
	}
	
	private static function mediaplayer($options = null)
	{
		$custom = isset($options['custom']) ? $options['custom'] : null;
		static::addStyleSheet(JUri::root(true).'/media/com_cjlib/mediaplayer/mediaelementplayer.min.css', $custom);
		static::addScript(JUri::root(true).'/media/com_cjlib/mediaplayer/mediaelement-and-player.min.js', $custom);
	}
	
	private static function addStyleSheet($css, $custom = false)
	{
		$document = JFactory::getDocument();
		if(method_exists($document, 'addCustomTag') && $document->getType() != 'feed')
		{
			if($custom)
			{
				$document->addCustomTag('<link rel="stylesheet" href="'.$css.'" type="text/css" />');
			}
			else
			{
				$document->addStyleSheet($css);
			}
		}
	}
	
	private static function addScript($script, $custom = false)
	{
		$document = JFactory::getDocument();
		if(method_exists($document, 'addCustomTag') && $document->getType() != 'feed')
		{
			if($custom)
			{
				$document->addCustomTag('<script src="'.$script.'" type="text/javascript"></script>');
			}
			else
			{
				$document->addScript($script);
			}
		}
	}
}