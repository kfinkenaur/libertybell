<?php

/**
 * @version     1.0.0
 * @package     com_cubic
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Chintan Khorasiya <chints.khorasiya@gmail.com> - http://raindropsinfotech.com
 */
defined('_JEXEC') or die;

class CubicFrontendHelper
{
	

	/**
	 * Get an instance of the named model
	 *
	 * @param string $name
	 *
	 * @return null|object
	 */
	public static function getModel($name)
	{
		$model = null;

		// If the file exists, let's
		if (file_exists(JPATH_SITE . '/components/com_cubic/models/' . strtolower($name) . '.php'))
		{
			require_once JPATH_SITE . '/components/com_cubic/models/' . strtolower($name) . '.php';
			$model = JModelLegacy::getInstance($name, 'CubicModel');
		}

		return $model;
	}
}
