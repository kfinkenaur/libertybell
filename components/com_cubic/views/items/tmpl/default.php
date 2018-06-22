<?php
/**
 * @version     1.0.0
 * @package     com_cubic
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Chintan Khorasiya <chints.khorasiya@gmail.com> - http://raindropsinfotech.com
 */
// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_cubic');
$canEdit    = $user->authorise('core.edit', 'com_cubic');
$canCheckin = $user->authorise('core.manage', 'com_cubic');
$canChange  = $user->authorise('core.edit.state', 'com_cubic');
$canDelete  = $user->authorise('core.delete', 'com_cubic');
?>

<form action="<?php echo JRoute::_('index.php?option=com_cubic&view=items'); ?>" method="post" name="adminForm" id="adminForm">

	<?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
	<table class="table table-striped" id="itemList">
		<thead>
		<tr>
			<?php if (isset($this->items[0]->state)): ?>
				<th width="5%">
	<?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
</th>
			<?php endif; ?>

							<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_CUBIC_ITEMS_ITEM_NAME', 'a.item_name', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_CUBIC_ITEMS_CATEGORY', 'a.category', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_CUBIC_ITEMS_THUMB', 'a.thumb', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_CUBIC_ITEMS_COST', 'a.cost', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_CUBIC_ITEMS_ITEM_SIZE', 'a.item_size', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_CUBIC_ITEMS_UID', 'a.uid', $listDirn, $listOrder); ?>
				</th>


			<?php if (isset($this->items[0]->id)): ?>
				<th width="1%" class="nowrap center hidden-phone">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>
			<?php endif; ?>

							<?php if ($canEdit || $canDelete): ?>
					<th class="center">
				<?php echo JText::_('COM_CUBIC_ITEMS_ACTIONS'); ?>
				</th>
				<?php endif; ?>

		</tr>
		</thead>
		<tfoot>
		<tr>
			<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) : ?>
			<?php $canEdit = $user->authorise('core.edit', 'com_cubic'); ?>

							<?php if (!$canEdit && $user->authorise('core.edit.own', 'com_cubic')): ?>
					<?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
				<?php endif; ?>

			<tr class="row<?php echo $i % 2; ?>">

				<?php if (isset($this->items[0]->state)): ?>
					<?php $class = ($canEdit || $canChange) ? 'active' : 'disabled'; ?>
					<td class="center">
	<a class="btn btn-micro <?php echo $class; ?>" href="<?php echo ($canEdit || $canChange) ? JRoute::_('index.php?option=&task=item.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>">
		<?php if ($item->state == 1): ?>
			<i class="icon-publish"></i>
		<?php else: ?>
			<i class="icon-unpublish"></i>
		<?php endif; ?>
	</a>
</td>
				<?php endif; ?>

								<td>
				<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'items.', $canCheckin); ?>
				<?php endif; ?>
				<a href="<?php echo JRoute::_('index.php?option=com_cubic&view=itemform&id='.(int) $item->id); ?>">
				<?php echo $this->escape($item->item_name); ?></a>
				</td>
				<td>

					<?php echo $item->category; ?>
				</td>
				<td>

					<?php
						if (!empty($item->thumb)):
							$uploadPath = 'administrator' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_cubic' . DIRECTORY_SEPARATOR . 'images/cubic' .DIRECTORY_SEPARATOR . $item->thumb;
							echo '<a href="' . JRoute::_(JUri::base() . $uploadPath, false) . '" target="_blank" title="See the thumb">' . $item->thumb . '</a>';
						else:
							echo $item->thumb;
						endif; ?>				</td>
				<td>

					<?php echo $item->cost; ?>
				</td>
				<td>

					<?php echo $item->item_size; ?>
				</td>
				<td>

					<?php echo $item->uid; ?>
				</td>


				<?php if (isset($this->items[0]->id)): ?>
					<td class="center hidden-phone">
						<?php echo (int) $item->id; ?>
					</td>
				<?php endif; ?>

								<?php if ($canEdit || $canDelete): ?>
					<td class="center">
						<?php if ($canEdit): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_cubic&task=itemform.edit&id=' . $item->id, false, 2); ?>" class="btn btn-mini" type="button"><i class="icon-edit" ></i></a>
						<?php endif; ?>
						<?php if ($canDelete): ?>
							<button data-item-id="<?php echo $item->id; ?>" class="btn btn-mini delete-button" type="button"><i class="icon-trash" ></i></button>
						<?php endif; ?>
					</td>
				<?php endif; ?>

			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<?php if ($canCreate): ?>
		<a href="<?php echo JRoute::_('index.php?option=com_cubic&task=itemform.edit&id=0', false, 2); ?>"
			class="btn btn-success btn-small"><i
				class="icon-plus"></i> <?php echo JText::_('COM_CUBIC_ADD_ITEM'); ?></a>
	<?php endif; ?>

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>

<script type="text/javascript">

	jQuery(document).ready(function () {
		jQuery('.delete-button').click(deleteItem);
	});

	function deleteItem() {
		var item_id = jQuery(this).attr('data-item-id');
		if (confirm("<?php echo JText::_('COM_CUBIC_DELETE_MESSAGE'); ?>")) {
			window.location.href = '<?php echo JRoute::_('index.php?option=com_cubic&task=itemform.remove&id=', false, 2) ?>' + item_id;
		}
	}
</script>


