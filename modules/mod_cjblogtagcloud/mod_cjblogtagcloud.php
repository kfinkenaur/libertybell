<?php
/**
 * @version		$Id: mod_cjblogtagcloud.php 01 2011-11-11 11:37:09Z maverick $
 * @package		CoreJoomla.cjblog
 * @subpackage	Modules.cjblogtagcloud
 * @copyright	Copyright (C) 2009 - 2014 corejoomla.com. All rights reserved.
 * @author		Maverick
 * @link		http://www.corejoomla.com/
 * @license		License GNU General Public License version 2 or later
 */
//don't allow other scripts to grab and execute our file
defined('_JEXEC') or die();
defined('CJBLOG') or define('CJBLOG', 'com_cjblog');

// CJLib includes
$cjlib = JPATH_ROOT.'/components/com_cjlib/framework.php';

if(file_exists($cjlib)){

	require_once $cjlib;
}else{

	die('CJLib (CoreJoomla API Library) component not found. Please download and install it to continue.');
}

CJLib::import('corejoomla.framework.core');

require_once(JPATH_SITE.DS.'components'.DS.CJBLOG.DS.'router.php');

$count = intval($params->get('count', 20));
$db = JFactory::getDbo();
$doc = JFactory::getDocument();

$query = '
		select 
			a.id, a.tag_text, a.alias, s.num_items 
		from 
			#__cjblog_tags a
		join 
			(select(floor(max(id) * rand())) as maxid from #__cjblog_tags) as t on a.id >= t.maxid
		left join 
			#__cjblog_tags_stats s on a.id=s.tag_id';

$db->setQuery($query, 0, $count);
$rows = $db->loadObjectList();

$itemid = CJFunctions::get_active_menu_id(true, 'index.php?option='.CJBLOG.'&view=articles');

CJFunctions::load_jquery(array('libs'=>array()));
$doc->addScript(JUri::root(true).'/media/mod_cjblogtagcloud/jquery.tagcloud.js');

$doc->addScriptDeclaration(
		'jQuery(document).ready(function($) {
			$.fn.tagcloud.defaults = {
				size: {start: '.$params->get('start_font', 9).', end: '.$params->get('end_font', 18).', unit: "'.$params->get('font_unit', 'px').'"}, 
				color: {start: "'.$params->get('start_color', '#cde').'", end: "'.$params->get('end_color', '#f52').'"}
			}; 
			$("#cjblogtagcloud a").tagcloud();
		});');
?>

<div id="cjblogtagcloud">
	<?php
	if(!empty($rows)){
		foreach ($rows as $i=>$row){
		?>
		<a href="<?php echo JRoute::_('index.php?option='.CJBLOG.'&view=articles&task=tag&id='.$row->id.':'.$row->alias.$itemid);?>" rel="<?php echo $i;?>">
			<?php echo htmlspecialchars($row->tag_text, ENT_COMPAT, 'UTF-8');?>
		</a>
		<?php
		}
	}
	?>
</div>
