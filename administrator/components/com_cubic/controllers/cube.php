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

jimport('joomla.application.component.controllerform');

/**
 * Cube controller class.
 */
class CubicControllerCube extends JControllerForm
{

    function __construct() {
        $this->view_list = 'cubes';
        parent::__construct();
    }

}