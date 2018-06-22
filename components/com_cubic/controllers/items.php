<?php
/**
 * @version     1.0.0
 * @package     com_cubic
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Chintan Khorasiya <chints.khorasiya@gmail.com> - http://raindropsinfotech.com
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Items list controller class.
 */
class CubicControllerItems extends CubicController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'Items', $prefix = 'CubicModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}