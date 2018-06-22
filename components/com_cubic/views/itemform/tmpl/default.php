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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_cubic', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/components/com_cubic/assets/js/form.js');

/**/
?>
<script type="text/javascript">
	if (jQuery === 'undefined') {
		document.addEventListener("DOMContentLoaded", function (event) {
			jQuery('#form-item').submit(function (event) {
				
		if(jQuery('#jform_thumb').val() != ''){
			jQuery('#jform_thumb_hidden').val(jQuery('#jform_thumb').val());
		}
		if (jQuery('#jform_thumb').val() == '' && jQuery('#jform_thumb_hidden').val() == '') {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			event.preventDefautl();
		}
			});

			
			jQuery('input:hidden.category').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('categoryhidden')){
					jQuery('#jform_category option[value="' + jQuery(this).val() + '"]').attr('selected', 'selected');
				}
			});
					jQuery("#jform_category").trigger("liszt:updated");
		});
	} else {
		jQuery(document).ready(function () {
			jQuery('#form-item').submit(function (event) {
				
		if(jQuery('#jform_thumb').val() != ''){
			jQuery('#jform_thumb_hidden').val(jQuery('#jform_thumb').val());
		}
		if (jQuery('#jform_thumb').val() == '' && jQuery('#jform_thumb_hidden').val() == '') {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			event.preventDefautl();
		}
			});

			
			jQuery('input:hidden.category').each(function(){
				var name = jQuery(this).attr('name');
				if(name.indexOf('categoryhidden')){
					jQuery('#jform_category option[value="' + jQuery(this).val() + '"]').attr('selected', 'selected');
				}
			});
					jQuery("#jform_category").trigger("liszt:updated");
		});
	}
</script>

<div class="item-edit front-end-edit">
	<?php if (!empty($this->item->id)): ?>
		<h1>Edit <?php echo $this->item->id; ?></h1>
	<?php else: ?>
		<h1>Add</h1>
	<?php endif; ?>

	<form id="form-item" action="<?php echo JRoute::_('index.php?option=com_cubic&task=item.save'); ?>" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
		
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

	<?php if(empty($this->item->created_by)): ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />
	<?php else: ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
	<?php endif; ?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('item_name'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('item_name'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('category'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('category'); ?></div>
	</div>
	<?php foreach((array)$this->item->category as $value): ?>
		<?php if(!is_array($value)): ?>
			<input type="hidden" class="category" name="jform[categoryhidden][<?php echo $value; ?>]" value="<?php echo $value; ?>" />';
		<?php endif; ?>
	<?php endforeach; ?>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('thumb'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('thumb'); ?></div>
	</div>
	<?php if (!empty($this->item->thumb)) : ?>
		<a href="<?php echo JRoute::_(JUri::base() . 'administrator' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_cubic' . DIRECTORY_SEPARATOR . 'images/cubic/' .DIRECTORY_SEPARATOR . $this->item->thumb, false);?>"><?php echo JText::_("COM_CUBIC_VIEW_FILE"); ?></a>
	<?php endif; ?>
	<input type="hidden" name="jform[thumb]" id="jform_thumb_hidden" value="<?php echo $this->item->thumb ?>" />
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('cost'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('cost'); ?></div>
	</div>
	<div class="control-group">
		<div class="control-label"><?php echo $this->form->getLabel('item_size'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('item_size'); ?></div>
	</div>
	<input type="hidden" name="jform[uid]" value="<?php echo $this->item->uid; ?>" />
				<div class="fltlft" <?php if (!JFactory::getUser()->authorise('core.admin','cubic')): ?> style="display:none;" <?php endif; ?> >
                <?php echo JHtml::_('sliders.start', 'permissions-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
                <?php echo JHtml::_('sliders.panel', JText::_('ACL Configuration'), 'access-rules'); ?>
                <fieldset class="panelform">
                    <?php echo $this->form->getLabel('rules'); ?>
                    <?php echo $this->form->getInput('rules'); ?>
                </fieldset>
                <?php echo JHtml::_('sliders.end'); ?>
            </div>
				<?php if (!JFactory::getUser()->authorise('core.admin','cubic')): ?>
                <script type="text/javascript">
                    jQuery.noConflict();
                    jQuery('.tab-pane select').each(function(){
                       var option_selected = jQuery(this).find(':selected');
                       var input = document.createElement("input");
                       input.setAttribute("type", "hidden");
                       input.setAttribute("name", jQuery(this).attr('name'));
                       input.setAttribute("value", option_selected.val());
                       document.getElementById("form-item").appendChild(input);
                    });
                </script>
             <?php endif; ?>
		<div class="control-group">
			<div class="controls">

				<?php if ($this->canSave): ?>
					<button type="submit" class="validate btn btn-primary"><?php echo JText::_('JSUBMIT'); ?></button>
				<?php endif; ?>
				<a class="btn" href="<?php echo JRoute::_('index.php?option=com_cubic&task=itemform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
			</div>
		</div>

		<input type="hidden" name="option" value="com_cubic" />
		<input type="hidden" name="task" value="itemform.save" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
