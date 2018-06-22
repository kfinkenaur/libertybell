<?php
/**
 * @version     1.0.0
 * @package     com_cubic
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Theophile Marcellus <cnngraphics@gmail.com> - http://www.linksmediacorp.com
 */
// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_cubic/assets/css/cubic.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
        
	js('input:hidden.category').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('categoryhidden')){
			js('#jform_category option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_category").trigger("liszt:updated");
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'item.cancel') {
            Joomla.submitform(task, document.getElementById('item-form'));
        }
        else {
            
				js = jQuery.noConflict();
				if(js('#jform_thumb').val() != ''){
					js('#jform_thumb_hidden').val(js('#jform_thumb').val());
				}
				if (js('#jform_thumb').val() == '' && js('#jform_thumb_hidden').val() == '') {
					alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
					return;
				}
            if (task != 'item.cancel' && document.formvalidator.isValid(document.id('item-form'))) {
                
                Joomla.submitform(task, document.getElementById('item-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_cubic&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="item-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CUBIC_TITLE_ITEM', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

                    				<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php if(empty($this->item->created_by)){ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />

				<?php } 
				else{ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />

				<?php } ?>			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('item_name'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('item_name'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('item_subtitle'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('item_subtitle'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('item_type'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('item_type'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('category'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('category'); ?></div>
			</div>

			<?php
				foreach((array)$this->item->category as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="category" name="jform[categoryhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('thumb'); ?></div>
				<div class="controls">
					<?php echo $this->form->getInput('thumb'); ?>
					<?php if($this->form->getValue('thumb')) echo '<img src="'.JURI::root().'components/com_cubic/assets/'.$this->form->getValue('thumb').'" width="100" />' ?>
				</div>
			</div>

				<?php /*if (!empty($this->item->thumb)) : ?>
						<a href="<?php echo JRoute::_(JUri::root() . 'components' . DIRECTORY_SEPARATOR . 'com_cubic' . DIRECTORY_SEPARATOR . 'assets'. DIRECTORY_SEPARATOR . $this->item->thumb, false);?>"><?php echo JText::_("COM_CUBIC_VIEW_FILE"); ?></a>
				<?php endif;*/ ?>
				<input type="hidden" name="jform[thumb]" id="jform_thumb_hidden" value="<?php echo $this->item->thumb ?>" />			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('cost'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('cost'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('item_size'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('item_size'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('item_weight'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('item_weight'); ?></div>
			</div>
				<input type="hidden" name="jform[uid]" value="<?php echo (($this->item->uid>0)?$this->item->uid:JFactory::getUser()->id); ?>" />


                </fieldset>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
        <?php if (JFactory::getUser()->authorise('core.admin','cubic')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'permissions', JText::_('JGLOBAL_ACTION_PERMISSIONS_LABEL', true)); ?>
		<?php echo $this->form->getInput('rules'); ?>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
<?php endif; ?>

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>