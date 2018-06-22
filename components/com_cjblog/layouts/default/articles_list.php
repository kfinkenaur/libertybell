<?php
/**
 * @package     corejoomla.administrator
 * @subpackage  com_cjforum
 *
 * @copyright   Copyright (C) 2009 - 2014 corejoomla.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die();

$user = JFactory::getUser();
$api = new CjLibApi();

$params 			= $displayData['params'];
$state				= isset($displayData['state']) ? $displayData['state'] : null;
$pagination 		= $displayData['pagination'];
$items 				= $displayData['items'];
$theme 				= $params->get('theme', 'default');
$avatar  			= $params->get('avatar_component', 'cjforum');
$profileComponent 	= $params->get('profile_component', 'cjforum');
$avatarSize 		= $params->get('list_avatar_size', 48);
$heading 			= isset($displayData['heading']) ? $displayData['heading'] : JText::_('COM_CJBLOG_ARTICLES');
$subHeading 		= '';
$thumbSize			= $params->get('thumbnail_size', 96);

$category = isset($displayData['category']) ? $displayData['category'] : null;
$subHeading = $category ? ' <small>['.$this->escape($category->title).']</small>' : $subHeading;

if(!empty($items))
{
	?>
	<div class="panel panel-<?php echo $theme?>">
		<?php
		if(!empty($heading))
		{
			?>
			<div class="panel-heading">
				<div class="panel-title"><?php echo $heading.$subHeading;?></div>
			</div>
			<?php
		}
		?>
		<ul class="list-group no-margin-left topics-list">
			<?php
			foreach($items as $item)
			{
				$slug = $item->alias ? ($item->id . ':' . $item->alias) : $item->id;
				$catslug = $item->category_alias ? ($item->catid . ':' . $item->category_alias) : $item->catid;
				$authorName = $this->escape($item->author);
				$profileUrl = JHtml::link($api->getUserProfileUrl($profileComponent, $item->created_by), $authorName);
				$articleUrl = JRoute::_(ContentHelperRoute::getArticleRoute($slug, $catslug));
				$categoryLink = JHtml::link(JRoute::_(ContentHelperRoute::getCategoryRoute($item->catid, $item->language)), $this->escape($item->category_title));
				?>
				<li class="list-group-item<?php echo $item->featured ? ' list-group-item-warning' : '';?> pad-bottom-5">
					<div class="row-fluid">
						<div class="span2 hidden-phone hidden-xs">
							<a href="<?php echo $articleUrl?>" class="thumbnail">
								<img src="<?php echo CjBlogHelper::get_article_thumbnail($item, $thumbSize);?>" style="width: auto"/>
							</a>
						</div>
						<div class="span10">
							<h4 class="media-heading no-margin-top"><a href="<?php echo $articleUrl; ?>"><?php echo $this->escape($item->title); ?></a></h4>
							<small class="align-middle">
								<?php 
								if($params->get('show_author'))
								{
									if($params->get('link_author'))
									{
										echo JText::sprintf('TXT_WRITTEN_BY', $profileUrl).' ';
									} 
									else 
									{
										echo JText::sprintf('TXT_WRITTEN_BY', $authorName).' ';
									}
								}
								
								if($params->get('show_category') && $params->get('show_create_date'))
								{
									echo JText::sprintf('TXT_POSTED_IN_CATEGORY_ON', $categoryLink, CjLibDateUtils::getHumanReadableDate($item->displayDate));
								} 
								else 
								{
									if($params->get('show_category'))
									{
										echo JText::sprintf('TXT_POSTED_IN_CATEGORY', $categoryLink);
									}
									
									if($params->get('show_create_date'))
									{
										echo JText::sprintf('TXT_POSTED_ON', CjLibDateUtils::getHumanReadableDate($item->displayDate));
									}
								}
								?>
								
								<?php if($params->get('show_hits')):?>
								<i class="icon-eye-open"></i> <?php echo JText::sprintf('TXT_NUM_HITS', $item->hits)?>.
								<?php endif;?>
							</small>
							<div class="muted text-muted"><?php echo JHtml::_('string.truncate', strip_tags($item->introtext), 250);?></div>
						</div>
					</div>
				</li>
				<?php
			}
			?>
		</ul>
	</div>
	
	<?php 
	if (($params->def('show_pagination', 2) == 1  || ($params->get('show_pagination') == 2)) && ($pagination->pagesTotal > 1))
	{
		?>
		<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm">
			<div class="pagination">
				<?php if ($params->def('show_pagination_results', 1)) : ?>
					<p class="counter pull-right">
						<?php echo $pagination->getPagesCounter(); ?>
					</p>
				<?php endif; ?>
		
				<?php echo $pagination->getPagesLinks(); ?>
			</div>
		</form>
		<?php
	}
}
else if($params->get('show_no_topics'))
{
	?>
	<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo JText::_('COM_CJBLOG_NO_ARTICLES_FOUND')?></div>
	<?php 
}