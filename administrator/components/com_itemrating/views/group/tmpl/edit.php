<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
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
$document->addStyleSheet('components/com_itemrating/assets/css/itemrating.css');
$document->addScript('components/com_itemrating/assets/jscolor.js');

?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
        
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'group.cancel') {
            Joomla.submitform(task, document.getElementById('group-form'));
        }
        else {
            
            if (task != 'group.cancel' && document.formvalidator.isValid(document.id('group-form'))) {
                
                Joomla.submitform(task, document.getElementById('group-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>
<style type="text/css">
    .form-horizontal .control-label
    {
	width: 160px;
    }
</style>

<form action="<?php echo JRoute::_('index.php?option=com_itemrating&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="group-form" class="form-validate">

    <div class="form-horizontal">
       
        <div class="row-fluid">
            <div class="span12 form-horizontal">
                <fieldset class="adminform">
<div class="span5">
    <div class="control-group" style="display: none;">
				<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
			</div>
			
			<div class="control-group" style="display: none;">
				<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('title'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('display'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('display'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('snippettype'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('snippettype'); ?></div>
			</div>
			<div class="style-box">
			    <h3><?php echo JText::_('JCATEGORY'); ?></h3>
			   <?php echo $this->form->getInput('customcategory'); ?>
			</div>
                    <div class="well">
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('textforscore'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('textforscore'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('reviewsummary'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('reviewsummary'); ?></div>
			</div>
                        
                    </div>

			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('position'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('position'); ?></div>
			</div>
			    <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
			</div>
			    <?php
    if(!empty($this->item->id))
    {
	$itemdata=new stdClass();
	$itemdata->groupdata=$this->item->id;
	$itemdata->position="none";
	$html=ItemratingHelper::createWidget($itemdata);
	print_r("<h3>".JText::_('COM_ITEMRATING_PREVIEW')."</h3>".$html);
    }
    ?>
</div><div class="span5">
			<div class="control-group style-box">
				<h3><?php echo $this->form->getLabel('styling'); ?></h3>
				<?php
				$json=json_decode($this->form->getValue('styling'));
				if(!empty($this->item->id))
				{
				$this->form->setValue('show_vote', '' , $json->show_vote);
				$this->form->setValue('score_position', '' , $json->score_position);
				$this->form->setValue('score_type', '' , $json->score_type);
				}
				?>
                                <div class="style-box-item" style="display:none;"><?php echo $this->form->getInput('styling'); ?>      
                                </div>
				 <div class="control-group">
				<div class="control-label">
				<label title="" class="hasTooltip" for="jform_textforscore" id="jform_textforscore-lbl" data-original-title="<?php echo JText::_('COM_ITEMRATING_FORM_BORDER_DESC')?>"><?php echo JText::_('COM_ITEMRATING_FORM_BORDER')?></label></div>
				<div class="controls"><input type="text" name="outer_border" id="outer_border" class="color" value="<?php if(!empty($json->outer_border)) { echo $json->outer_border; }else {echo '#eeeeee';}?>"></div>
				 </div>
				 <div class="control-group">
				<div class="control-label">
				<label title="" class="hasTooltip" for="jform_textforscore" id="jform_textforscore-lbl" data-original-title="<?php echo JText::_('COM_ITEMRATING_FORM_BACK_DESC')?>"><?php echo JText::_('COM_ITEMRATING_FORM_BACK')?></label></div>
				<div class="controls"><input type="text" name="head_background" id="head_background" class="color" value="<?php if(!empty($json->head_background)) { echo $json->head_background; }else {echo '#444444';}?>"></div>
				 </div>
				 
				 <div class="control-group">
				<div class="control-label">
				<label title="" class="hasTooltip" for="jform_textforscore" id="jform_textforscore-lbl" data-original-title="<?php echo JText::_('COM_ITEMRATING_FORM_HCOLOR_DESC')?>"><?php echo JText::_('COM_ITEMRATING_FORM_HCOLOR')?></label>
				</div>
				<div class="controls"><input type="text" name="head_color" id="head_color" class="color" value="<?php if(!empty($json->head_color)) { echo $json->head_color; }else {'#eeeeee';}?>"></div>
				 </div>
				 
				 <div class="control-group">
				<div class="control-label">
				<label title="" class="hasTooltip" for="jform_textforscore" id="jform_textforscore-lbl" data-original-title="<?php echo JText::_('COM_ITEMRATING_FORM_BCOLOR_DESC')?>"><?php echo JText::_('COM_ITEMRATING_FORM_BCOLOR')?></label></div>
				<div class="controls"><input type="text" name="item_background" id="item_background" class="color" value="<?php if(!empty($json->item_background)) { echo $json->item_background; }else {echo '#e0e0e0';}?>"></div>
				 </div>
				 <div class="control-group">
				<div class="control-label">
				<label title="" class="hasTooltip" for="jform_textforscore" id="jform_textforscore-lbl" data-original-title="<?php echo JText::_('COM_ITEMRATING_BAR_BG_DESC')?>"><?php echo JText::_('COM_ITEMRATING_BAR_BG')?></label></div>
				<div class="controls"><input type="text" name="bar_bg" id="bar_bg" class="color" value="<?php if(!empty($json->bar_bg)) { echo $json->bar_bg; }else {echo '#4db2ec';}?>"></div>
				 </div>
				 <div class="control-group">
				<div class="control-label">
				<label title="" class="hasTooltip" for="jform_textforscore" id="jform_textforscore-lbl" data-original-title="<?php echo JText::_('COM_ITEMRATING_FORM_PCOLOR_DESC')?>"><?php echo JText::_('COM_ITEMRATING_FORM_PCOLOR')?></label></div>
				<div class="controls"><input type="text" name="score_bg" id="score_bg" class="color" value="<?php if(!empty($json->score_bg)) { echo $json->score_bg; }else {echo '#ffffff';}?>"></div>
				 </div>
				 <div class="control-group">
				<div class="control-label">
				<label title="" class="hasTooltip" for="jform_textforscore" id="jform_textforscore-lbl" data-original-title="<?php echo JText::_('COM_ITEMRATING_FORM_FCOLOR_DESC')?>"><?php echo JText::_('COM_ITEMRATING_FORM_FCOLOR')?></label></div>
				<div class="controls"><input type="text" name="link_color" id="font-color" class="color" value="<?php if(!empty($json->link_color)) { echo $json->link_color; }else {echo '#666666';}?>"></div>
				 </div>
				 <div class="control-group">
				<div class="control-label">
				<label title="" class="hasTooltip" for="jform_textforscore" id="jform_textforscore-lbl" data-original-title="<?php echo JText::_('COM_ITEMRATING_VOTE_FCOLOR_DESC')?>"><?php echo JText::_('COM_ITEMRATING_VOTE_FCOLOR')?></label></div>
				<div class="controls"><input type="text" name="vote_color" id="vote_color" class="color" value="<?php if(!empty($json->vote_color)) { echo $json->vote_color; }else {echo '#666666';}?>"></div>
				 </div>
				 <div class="control-group">
				<div class="control-label">
				<label title="" class="hasTooltip" for="jform_textforscore" id="jform_textforscore-lbl" data-original-title="<?php echo JText::_('COM_ITEMRATING_VOTE_SHOW_DESC')?>"><?php echo JText::_('COM_ITEMRATING_VOTE_SHOW')?></label></div>
				<div class="controls">
				<?php echo $this->form->getInput('show_vote'); ?>    
				</div>
				 </div>
				 
				 <div class="control-group">
				<div class="control-label">
				<label title="" class="hasTooltip" for="jform_textforscore" id="jform_textforscore-lbl" data-original-title="<?php echo JText::_('COM_ITEMRATING_FORM_FCOLOR_DESC')?>"><?php echo JText::_('COM_ITEMRATING_FORM_FCOLOR')?></label></div>
				<div class="controls"><input type="text" name="link_color" id="font-color" class="color" value="<?php if(!empty($json->link_color)) { echo $json->link_color; }else {echo '#666666';}?>"></div>
				 </div>
				 
				 <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('score_position'); ?></div>
				<div class="controls">
				<?php echo $this->form->getInput('score_position'); ?>    
				</div>
				 </div>
				 
				 <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('score_type'); ?></div>
				<div class="controls">
				<?php echo $this->form->getInput('score_type'); ?>    
				</div>
				 </div>
				 
				 <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('show_vote'); ?></div>
				<div class="controls">
				<?php echo $this->form->getInput('show_vote'); ?>    
				</div>
				 </div>
				 
				 
			</div>
    <div class="control-group style-box"><h3><?php echo $this->form->getLabel('customcss'); ?></h3><div class="style-box-item"><?php echo $this->form->getInput('customcss'); ?></div>
			</div>
</div>
            </fieldset>
            </div>
        </div>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>