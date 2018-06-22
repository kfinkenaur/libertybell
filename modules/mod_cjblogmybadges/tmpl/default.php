<?php 
/**
 * @version		$Id: default.php 01 2012-12-29 11:37:09Z maverick $
 * @package		CoreJoomla.cjblogmybadges
 * @subpackage	Modules.site
 * @copyright	Copyright (C) 2009 - 2014 corejoomla.com, Inc. All rights reserved.
 * @author		Maverick
 * @link		http://www.corejoomla.com/
 * @license		License GNU General Public License version 2 or later
 */
// no direct access
defined('_JEXEC') or die;

$itemid = CJFunctions::get_active_menu_id(true, 'index.php?option='.CJBLOG.'&view=users');
?>
<style type="text/css">
<!--
ul.badges, ul.badges li {list-style: none; list-style-image: none; list-style-type: none;}
ul.badges li {margin-right: 10px; }
-->
</style>

<div id="cj-wrapper" class="cj-wrapper-main">
<?php 
if(!empty($badges))
{
	?>
	<ul class="badges unstyled clearfix">
	<?php 
	foreach ($badges as $badge)
	{
		$url = JRoute::_('index.php?option='.CJBLOG.'&view=users&task=badge&id='.$badge['badge_id'].':'.$badge['alias'].$itemid);
		?>
		<li>
			<a href="<?php echo $url;?>" class="tooltip-hover" title="<?php echo htmlspecialchars($badge['description'], ENT_COMPAT, 'UTF-8');?>">
				<?php 
				if(!empty($badge['icon']))
				{
					?>
					<img src="<?php echo CJBLOG_BADGES_BASE_URI.$badge['icon'];?>"/>
					<?php 
				} else {
					?>
					<span class="badge <?php echo $badge['css_class']?>">&bull; <?php echo htmlspecialchars($badge['title'], ENT_COMPAT, 'UTF-8');?></span>
					<?php 
				}
				?>
			</a>
			
			<?php
			if($badge['num_times'] > 1)
			{
				?>
				<small> x <?php echo $badge['num_times'];?></small>
				<?php 
			}
			?>
		</li>
		<?php 
	}
	?>
	</ul>
	<?php 
}
else
{
	echo '<p>'.JText::_('LBL_NO_RESULTS_FOUND').'</p>';
}
?>	
</div>