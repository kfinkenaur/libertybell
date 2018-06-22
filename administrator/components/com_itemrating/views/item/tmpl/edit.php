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
require_once JPATH_SITE . '/components/com_itemrating/helpers/itemrating.php';
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');
$document->addStyleSheet('components/com_itemrating/assets/css/itemrating.css');
$document->addStyleSheet('components/com_itemrating/assets/css/itemrating.css');
$document->addStyleSheet(JURI::root().'components/com_itemrating/assets/rating.css');
$document->addStyleSheet('components/com_itemrating/assets/css/bootstrap-slider.css');
$document->addScript('components/com_itemrating/assets/js/bootstrap-slider.js');
$fasetting=$this->form->getValue('fasetting');
$selecticon=null;
$faicon="&#xf005;";
$facolor="#ffc500";
$fainctivecolor="#8a9091";
if($fasetting)
{
	$fatdata=json_decode($fasetting);
	$this->form->setValue('activecolor',null,$fatdata->activecolor);
	$this->form->setValue('inactivecolor',null,$fatdata->inactivecolor);
	$this->form->setValue('faval',null,$fatdata->icon);
	$faicon=$fatdata->icon;
	$facolor=$fatdata->activecolor;
	$fainctivecolor=$fatdata->inactivecolor;
}
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
    js('#jform_rating').slider({
	'handle':'square'
	});
    js('#jform_rating').on('slide', function(slideEvt) {
	js("#rating_val").text(slideEvt.value);
	js("#rating_slider").css('width', slideEvt.value+"%");
	
    });
    js('#jform_rating').on('slideStop', function(slideEvt) {
	js("#rating_val").text(slideEvt.value);
	js("#rating_slider").css('width', slideEvt.value+"%");
	
    });
    var val=js('#jform_type').val();
     changevalue(val);

    js('#jform_type').on('change', function() {
	  changevalue(this.value);
    });

    js('#jform_icon').on('change', function() {
		js('.stars-large').css("background-image", "url(components/com_itemrating/assets/images/"+this.value+"-large.png)");
	    js('#rating_slider').css("background-image", "url(components/com_itemrating/assets/images/"+this.value+"-large.png)");
	
	});	
	js('#jform_faval').on('change', function() {
		var label=js('#jform_faval option:selected').text();
		var acolor=js('#jform_activecolor').val();
		var icolor=js('#jform_inactivecolor').val();
		data='<i class="fa fa-'+label+' fa-2x active" style="color:'+acolor+'"></i><i class="fa fa-'+label+' fa-2x" style="color:'+acolor+'"></i><i class="fa fa-'+label+' fa-2x" style="color:'+acolor+'"></i><i class="fa fa-'+label+' fa-2x" style="color:'+icolor+'"></i><i class="fa fa-'+label+' fa-2x" style="color:'+icolor+'"></i>';
		js('.fa-icon-show').html(data);
		
		});	
	});
	
    function changevalue(value){
	 if( value==2 )
	  {
		js('.fa-icon-class').hide();
	    js('.stars-large').css("background-image", "url(components/com_itemrating/assets/images/bar.png)");
	     js('#rating_slider').css("background-image", "url(components/com_itemrating/assets/images/bar.png)");
	    js('.control-icon').hide();
		js('.textform').show();
		js('.post-large-rate').show();
		js('.fa-icon-show').hide();
		
	  }
	  else if (value==1) {
	   js('.control-icon').show();
	   js('.fa-icon-class').hide();
	   var val=(js("#jform_icon option:selected").val());
	   js('.stars-large').css("background-image", "url(components/com_itemrating/assets/images/"+val+"-large.png)");
	    js('#rating_slider').css("background-image", "url(components/com_itemrating/assets/images/"+val+"-large.png)");
	  js('.textform').show();
	  js('.post-large-rate').show();
	  js('.fa-icon-show').hide();
	  }
	  else if (value==3) {
		
	   js('.control-icon').hide();
	   js('.fa-icon-class').show();
	   var val=(js("#jform_icon option:selected").val());
		js('.post-large-rate').hide();
		js('.textform').show();
		js('.fa-icon-show').show();		
		}
	  else
	  {
		js('.fa-icon-class').hide();
	     js('.stars-large').css("background-image", "url(components/com_itemrating/assets/images/thumb.png)");
	     js('#rating_slider').css("background-image", "url(components/com_itemrating/assets/images/thumb.png)");
	    js('.control-icon').hide();
		js('.textform').hide();
		js('.post-large-rate').show();
		js('.fa-icon-show').hide();
	  }
	  }

    Joomla.submitbutton = function(task)
    {
	
    var rating_value=js("#jform_group_id option:selected").text();
   
        if (task == 'item.cancel') {
            Joomla.submitform(task, document.getElementById('item-form'));
        }
        else {
	    if (rating_value=="Select") {
		 alert('<?php echo $this->escape(JText::_('COM_ITEMRATING_FORM_SELECTGROUP')); ?>');
		 
	    }
            
            else if (task != 'item.cancel' && document.formvalidator.isValid(document.id('item-form'))) {
                
                Joomla.submitform(task, document.getElementById('item-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
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
    }
</style>
<form action="<?php echo JRoute::_('index.php?option=com_itemrating&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="item-form" class="form-validate">

    <div class="form-horizontal">
        <div class="row-fluid">
            <div class="span6 form-horizontal">
                <fieldset class="adminform">

                    			<div class="control-group" style="display:none;">
				<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
			</div>
			<div class="control-group" style="display:none;">
				<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('title'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('title'); ?></div>
			</div>
			<div class="control-group">
			<?php
			$rating_value=$this->form->getValue('rating');
			if(empty($rating_value))
			{
			    $rating_value="100";
			}
			?>
				<div class="control-label"><?php echo $this->form->getLabel('rating'); ?></div>
				<div class="controls"><?php echo str_ireplace('jform_rating"','jform_rating" data-slider-min="0" data-slider-max="100" data-slider-value="'.$rating_value.'"',$this->form->getInput('rating')); ?><span> <span id="rating_val"><?php echo $rating_value;?></span></span></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('label'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('label'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('group_id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('group_id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('type'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('type'); ?></div>
			</div>
			<div class="control-group control-icon">
				<div class="control-label"><?php echo $this->form->getLabel('icon'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('icon'); ?></div>
			</div>
			<div class="control-group fa-icon-class" style="display:none;">
				<div class="control-label"><?php echo $this->form->getLabel('faval'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('faval'); ?></div>
			</div>
			<div class="control-group fa-icon-class" style="display:none;">
				<div class="control-label"><?php echo $this->form->getLabel('activecolor'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('activecolor'); ?></div>
			</div>
			<div class="control-group fa-icon-class" style="display:none;">
				<div class="control-label"><?php echo $this->form->getLabel('inactivecolor'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('inactivecolor'); ?></div>
				<input type='hidden' name='jform[fasetting]' id='fasetting'  value='<?php echo $this->form->getValue('fasetting');?>'/>
			</div>
			
			<?php /*<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('number'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('number'); ?></div>
			</div>
			<?php */?>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('hits'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('hits'); ?></div>
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
			</div>

                </fieldset>
            </div>
	    <div class="span4 form-horizontal">
		 <fieldset class="adminform">
		    <legend><?php echo  JText::_('COM_ITEMRATING_PREVIEW');?></legend>
		   <div class="review-box review-top review-stars" id="review-box">
		    <div class="review-item">
			<h5 id="list-title"><?php echo $this->form->getValue('title');?></h5>
			<span class="fa-icon-show" style="float:right;display:none;">
				<span class="glyph-large" data-content="<?php echo $faicon.$faicon.$faicon.$faicon.$faicon;?>" style="color:<?php echo $fainctivecolor;?>"><span style="width:60%;color:<?php echo $facolor;?>" data-content="<?php echo $faicon.$faicon.$faicon.$faicon.$faicon;?>"></span></span>
				</span>
			<span class="post-large-rate stars-large"><span id="rating_slider" style="width:<?php echo $rating_value;?>%"></span></span>
		</div>
		   </div>
		  
		 </fieldset>
		 <div class="well textform" <?php if($this->form->getValue('type')==2) {?> style="display:none;"<?php }?>>
			
			 <p>Display specific text on a range on rating</p>
			 <input type='hidden' name='jform[misc]' id='rangeform'  value='<?php echo $this->form->getValue('misc');?>'/>
			 
	 <div class="table-responsive"> <span id="tag-table"></span></div>
          <div id="entry-form">
		<table width="100%" border="0" cellpadding="4" cellspacing="0" class="adminlist table table-bordered fltlft">
			<tr>
				<td>Range start</td>
				<td><input type="number"  min="-1" max="101" id="rangestart"></td>
			</tr>
			<tr>
				<td>Range End</td>
				<td><input type="number"  min="-1" max="101" id="rangeend"></td>
			</tr>
			
			<tr>
				<td>Text</td>
				<td><textarea row=4 cols=10 id="rangetext"></textarea></td>
			</tr>
			<tr>
				<td align="right"></td>
				<td><input type="button" value="<?php echo JTEXT::_('JTOOLBAR_APPLY')?>" id="save" class="btn btn-success" onClick="saveForm()"><input type="button" value="<?php echo JTEXT::_('JTOOLBAR_CANCEL')?>" id="cancel" class="btn btn btn-danger" onClick="hideform()"></td>
			</tr>
		</table>
	
			 <script type="text/javascript">
       function showform()
       {
        document.getElementById("entry-form").style.display="block";
       }
       function hideform()
       {
        document.getElementById("entry-form").style.display="none"; 
       }
        function saveForm()
        {
            var oldData = document.getElementById("rangeform").value;
            var json = [];
            var value=document.getElementById("rangeform").value;
            var rangestart=parseInt(document.getElementById("rangestart").value);
            var rangeend=parseInt(document.getElementById("rangeend").value);
			var rangetext=document.getElementById("rangetext").value;
			if ((rangestart==null)||(rangestart=="")) {
				alert("Please Enter Valid value for start range");
				return false;
			}
			if ((rangeend==null)||(rangeend=="")) {
				alert("Please Enter Valid value for end range");
				return false;
			}
			
			if ((rangestart>=101)||(rangestart<=-1)) {
				alert("Please Enter Valid value for start range");
				return false;
			}
			if ((rangeend>=101)||(rangeend<=-1)) {
				alert("Please Enter Valid value for end range");
				return false;
			}
			
			if 	((rangeend<rangestart)) {
				alert("End Range should be greater then Start Range");
				return false;
			}
	if(value!="")
	{
		json =JSON.parse(value);
	}
	json.push({"rangestart":rangestart,"rangeend":rangeend,"rangetext":rangetext});
        document.getElementById("rangeform").value=JSON.stringify(json);
        document.getElementById("rangestart").value="";
		document.getElementById("rangeend").value="";
        document.getElementById("rangetext").value="";
		addTagTableRow();
        }
        function addTagTableRow()
        {
        
      var oldData = document.getElementById("rangeform").value;
	  
	var data = "";
        if(oldData!="")
	{
	var jsonData = JSON.parse(oldData);
		for(i = 0; i < jsonData.length; i++){
		data= data+"<tr><td>"+jsonData[i].rangestart+"</td><td>"+jsonData[i].rangeend+"</td><td>"+jsonData[i].rangetext+"</td><td><input type='button' value='<?php echo JTEXT::_('JACTION_DELETE')?>' onclick='deleteRegion("+i+");' class='btn btn-danger'></td></tr>";
		}
	}
	var header = "<tr><th>Range start</th><th>Range End</th><th>Range Text</th><th>&nbsp;</th></tr>";
	data = "<table class=\"adminlist table table-bordered fltlft\">"+header+data+"</table>";
	var span = document.getElementById("tag-table");
	span.innerHTML = data;
        
        }
        
function deleteRegion(id){
	
		var newJson=[];
		var json = document.getElementById("rangeform").value;
		var jsonData = JSON.parse(json);

		for(i = 0; i < jsonData.length; i++){

			if(i!=id)
			{
			newJson.push({"rangestart":jsonData[i].rangestart,"rangeend":jsonData[i].rangeend,"rangetext":jsonData[i].rangetext});
			}
		}
		
		document.getElementById("rangeform").value =JSON.stringify(newJson);
		addTagTableRow();
        		}

        addTagTableRow();
        </script>
                </div>
			
		 </div>
	    </div>
        </div>
		

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>