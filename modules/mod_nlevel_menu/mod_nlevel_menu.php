<?php
/**
 * @package NLevel Responsive Menu
 * @version 2.0.0
 * @license http://www.raindropsinfotech.com GNU/GPL
 * @copyright (c) 2015 Raindrops Company. All Rights Reserved.
 * @author http://www.raindropsinfotech.com
 */

defined('_JEXEC') or die;


if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

require_once dirname(__FILE__).'/helper.php';

$layout = $params->get('layout', 'default');
$cacheid = md5(serialize(array ($layout, $module->id)));
$cacheparams = new stdClass;
$cacheparams->cachemode = 'id';
$cacheparams->class = 'NLevelMenuHelper';
$cacheparams->method = 'getList';
$cacheparams->methodparams = $params;
$cacheparams->modeparams = $cacheid;
$menus = JModuleHelper::moduleCache ($module, $params, $cacheparams);

$type_menu = $params->get('type_menu');
$imagesURI = JURI::base()."modules/".$module->module."/assets/images";
$icon_normal = $imagesURI."/icon_active.png";
$icon_active = $imagesURI."/icon_normal.png";
$itemID = JRequest::getInt('Itemid');
require JModuleHelper::getLayoutPath($module->module, $layout);
require JModuleHelper::getLayoutPath($module->module, $layout.'_js');
?>