<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_googlecrumbs
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>

<div class="breadcrumbs<?php echo $moduleclass_sfx; ?>">
<?php if ($params->get('showHere', 1))
	{
		echo '<span class="showHere">' .JText::_('MOD_GOOGLECRUMBS_HERE').'</span>';
	}
?>
<?php for ($i = 0; $i < $count; $i ++) :
	// Workaround for duplicate Home when using multilanguage
	if ($i == 1 && !empty($list[$i]->link) && !empty($list[$i-1]->link) && $list[$i]->link == $list[$i-1]->link) {
		continue;
	}
	// If not the last item in the breadcrumbs add the separator
	if ($i < $count -1) {
		if (!empty($list[$i]->link)) {
			echo '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" style="display:inline-block;"><a href="'.$list[$i]->link.'" class="pathway" itemprop="url"><span  itemprop="title">'.$list[$i]->name.'</span></a></div>';
		} else {
			echo '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" style="display:inline-block;"><span itemprop="title">';
			echo $list[$i]->name;
			echo '</span></div>';
		}
		if($i < $count -2){
			echo ' '.$separator.' ';
		}
	}  elseif ($params->get('showLast', 1)) { // when $i == $count -1 and 'showLast' is true
		if($i > 0){
			echo ' '.$separator.' ';
		}
		 echo '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" style="display:inline-block;"><span itemprop="title">';
		echo $list[$i]->name;
		  echo '</span></div>';
	}
endfor; ?>
</div>