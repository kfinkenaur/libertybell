<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');


/**
 * Supports an HTML select list of categories
 */
class JFormFieldGroupData extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'text';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
            $name="jform";
		// Initialize variables.
		$script=<<<EOF
<script type="text/javascript">
var itemRating = jQuery.noConflict();

itemRating(document).ready(
    function(event) {

        var number;

        itemRating('#addItemratingButton').click(function(event){
            event.preventDefault();
            var inputs = itemRating('input[id*="slider_"]').last();
            if(inputs.length == 1) {
                number = inputs.attr('id').replace('slider_','');
                number++;
            }
            else {
                number = 1;
            }
            var item = itemRating('#item-list-item').clone().removeAttr('style').attr('id','item_' + number);
            item.find('#itemPlaceholder').attr('id','itemPlaceholder_' + number);
            item.find('#review').attr('id','review_'+number);
            item.find('#rating_val').attr('id','rating_val_'+number);
            item.find('#slider').attr('id','slider_'+number);

            //Add the new item holder to the list
            itemRating('#sortable-items').prepend(item);
         itemRating('#slider_'+number).slider({
	'handle':'square'
	});
	
         number++;
            //Unhide the "drag to reorder" button
            itemRating('#infobox').removeAttr('style');
       
        });

        // "Remove Image" buttons click event
        itemRating('.removeImageButton').live('click', function(event){
            event.preventDefault();
            itemRating(this).parent().parent().remove();
            
            if(itemRating('ul#sortable-items li').length == 0)
            {
                //Hide the "drag to reorder" button
                itemRating('#infobox').attr('style', 'display:none;');
            }
        });

        //Make item block sortable
        itemRating(function() {
		itemRating("#items ul").sortable({opacity: 0.6, cursor: 'move'});
	});
        itemRating('.slider').slider()
        
        
    }
    
);

</script>
<style type="text/css">
.slider-selection,.slider-handle
    {
	 background-color: #5bb75b;
    background-image: linear-gradient(to bottom, #62c462, #51a351);
    background-repeat: repeat-x;
    border-color: #51a351 #51a351 #387038;
    color: #fff;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }
    
    #rating_val
    {
	border:1px solid #bababa;
	padding: 10px;
    }</style>
EOF;
$css='';
JHtml::_('bootstrap.framework');
$document=JFactory::getDocument();
$document->addStyleDeclaration($css);
$document = JFactory::getDocument();

$document->addStyleSheet(JURI::root().'components/com_itemrating/assets/rating.css');
$document->addStyleSheet(JURI::root().'administrator/components/com_itemrating/assets/css/bootstrap-slider.css');
$document->addScript(JURI::root().'administrator/components/com_itemrating/assets/js/bootstrap-slider.js');
JHtml::_('jquery.ui', array('core', 'sortable'));

$c=1;

    $form=$script.' 
<div class="info-holder">    
	<div id="infobox" class="info" style="display:none;">Drag n drop to reorder</div>
<a href="#" id="addItemratingButton" class="addItemratingButton btn btn-primary"><i class="icon-new icon-white">
</i>
		Add New Review Criteria	</a>
		
</div>

<div id="items">
    <ul id="sortable-items">';
    if(!empty($this->value['review']))
    {
    
    foreach($this->value['review'] as $value)
    {
        if(empty($this->value['review'][$c-1]))
        {
            continue;
        }
                $form.='<li id="item_'.$c.'"  class="well span7">
    <div class="item-holder" id="itemPlaceholder_'.$c.'">
        <table class="itemtable">
	    <tr>
                    <td align="right" class="key_label">
                            Review Criteria            </td>
                    <td>
                            <input type="text" name="'.$this->name.'[review][]" id="review_'.$c.'" size="30" class="text_area" value="'.$this->value['review'][$c-1].'" />
                    </td>
            </tr>
            <tr>
                    <td align="right" class="key_label">
                            Criteria Score                  </td>
                    <td>
			 <input type="text" name="'.$this->name.'[score][]" size="30" id="slider_'.$c.'" data-slider-min="0" data-slider-max="100" data-slider-value="'.$this->value['score'][$c-1].'" value="'.$this->value['score'][$c-1].'" class="slider"/>
                    </td>
            </tr>
	    
        </table>

        <div style="clear:both;"></div>

        <a class="btn btn-danger removeImageButton" href="#" class="removeImageButton">
            <i class="icon-delete"></i>Delete</a>
    </div>
</li>';
        $c++;
    }
    
}
                   $form.='</ul>
</div>

<li id="item-list-item" style="display:none;" class="well span7">
    <div class="item-holder" id="itemPlaceholder">
        <table class="itemtable">
	    <tr>
                    <td align="right" class="key_label">
                            Review Criteria            </td>
                    <td>
                            <input type="text" name="'.$this->name.'[review][]" id="review" size="30" class="text_area" value="" />
                    </td>
            </tr>
            <tr>
                    <td align="right" class="key_label">
                            Criteria Score                  </td>
                    <td>
			 <input type="text" name="'.$this->name.'[score][]" size="30" id="slider" data-slider-min="0" data-slider-max="100"  value="" class="slider"/>
                    </td>
            </tr>
	    
        </table>

        <div style="clear:both;"></div>

        <a class="btn btn-danger removeImageButton" href="#" class="removeImageButton">
            <i class="icon-delete"></i>Delete</a>
    </div>
</li>
';

return $form;
	}
}