<?php
/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2015. All rights reserved.
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
$document->addStyleSheet(JURI::root().'components/com_itemrating/assets/rating.css');
$context=JFactory::getApplication()->input->getString('context');
$id=JFactory::getApplication()->input->getInt('id');
?>
<style type="text/css">
    .user-rate span{
        min-height: 10px !important;
    }   
</style>
    
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
        js(document).on('click', '.rating-submit' , function (e) {
            var thisObj = jQuery(this);
            var thisItem = thisObj.attr('data-item');
            
            var rating_id = parseInt(js('#rating_id_'+thisItem).val());
            var rating_type=parseInt(js('#rating_type_'+thisItem).val());
            if(rating_type==0)
            {
                var up = parseFloat(js('#up_'+thisItem).val());
                var down= parseFloat(js('#down_'+thisItem).val());
                var r = confirm("You want to Update Score Up with "+up+" and Down with "+down);
            }
            else
            {
                var score = parseFloat(js('#score_'+thisItem).val());
            var count = parseFloat(js('#sum_'+thisItem).val());
            var r = confirm("You want to Update Score with "+score+" and Count with "+count);
               }
            if(r==false)
            {
                e.preventDefault();
            }
            else
            {
                var data;
                 if(rating_type==0)
                {
                     score=0;
                     count=1;
                }
                else
                {
                    up=0;
                    down=0;
                
                }
               js.post('index.php',{ option:'com_itemrating',up:up,down:down,score:score,count:count,rating_id:rating_id,task:'saveresult',context:'<?php echo $context;?>',context_id:'<?php echo $id;?>',tmpl:'component','<?php echo JSession::getFormToken();?>':'1'  }, function(data) {
					var error=(data.error);
					if(error==false)
					{
                                            var fcount=jQuery.parseJSON(data.rating);
                                            var rating_type=parseInt(js('#rating_type_'+thisItem).val());                                      
                                            if(rating_type==0)
                                            {
                                             jQuery( '.rateUp_'+ thisItem).text(parseInt(fcount.up));
                                             jQuery( '.rateDown_'+ thisItem).text(parseInt(fcount.down));
                                         }
                                         else if(rating_type==1)
                                         {
                                             jQuery( '.itemrate-score_'+ thisItem).text(parseInt(fcount.rating));
                                             jQuery( '.itemrate-count_'+ thisItem).text(parseInt(data.count));
                                             jQuery( '.itemrate-span_'+ thisItem).css("width",parseInt(fcount.rating)+'%');
                                             
                                             
                                         }else
                                         {
                                                   jQuery( '.itemrate-score_'+ thisItem).text(parseInt(fcount.rating));
                                             jQuery( '.itemrate-count_'+ thisItem).text(parseInt(data.count));
                                             jQuery( '.bar_'+ thisItem).css("width",parseInt(fcount.rating)+'%');
                                                   jQuery( '.text-percent_'+ thisItem).text(parseInt(fcount.rating)+'%');
                                       
                                         }
                                            
                                            jQuery('.error_'+thisItem).show();
					     jQuery('.errordiv_'+thisItem).html(data.message);
                                        }
					else
					{
                                            
                                             jQuery('.error_'+thisItem).show();
					     jQuery('.errordiv_'+thisItem).html(data.message);                                                  
                                        }
			}, 'json');
			e.preventDefault();
            }
            
            });
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'report.cancel') {
            Joomla.submitform(task, document.getElementById('report-form'));
        }
        else {
            
            if (task != 'report.cancel' && document.formvalidator.isValid(document.id('report-form'))) {
                
                Joomla.submitform(task, document.getElementById('report-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
    function closeSpan(elem)
{
    jQuery('.error_'+elem).hide();
}
</script>
<?php
$title=JFactory::getApplication()->input->getString('title');

?>

<form action="<?php echo JRoute::_('index.php?option=com_itemrating&layout=edit'); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="report-form" class="form-validate">

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

</form>

<div class="form-horizontal">
<div class="row-fluid">
			<div class="span6">
<?php 
$ch="";
$c=0;
$total_sum=0;
$total_count=0;
$rating_data=array();
foreach($this->ratings as $rating)
{

    if(isset($rating->rating_count))
    {
        $result=json_decode($rating->rating_count); 
        
    }
    else
    {
       $result=new stdClass();
       $rating->rating_sum=$rating->hits;
       $result->rating=$rating->rating;
        $result->up=0;
        $result->down=0;
      
    }
      $ch.=$rating->title.'|';
       
                         if($rating->type!=0)
                         {
      $total_count+=  ( $rating->rating_sum*$result->rating);
      $total_sum+=$rating->rating_sum;
      $rating_data[$c]['title']=$rating->title;
      $rating_data[$c]['sum']=$rating->rating_sum*$result->rating;
                         }
    ?>
                          
                               <h3 style="float:left;width:100%">Score Details for <?php echo $rating->title;?></h3>
                               
                            <div id="review-box" class="review-box review-top review-stars">
                         
                            <div class="review-item">
                               
			<h5 class="item-score"> <?php echo $rating->title;?>  <?php
                         if($rating->type!=0)
                         {?>: <span class="itemrate-score_<?php echo $c;?>"><?php echo $result->rating;?></span>%<small class="small_1 voting">  - <span class="itemrate-count_<?php echo $c;?>"><?php echo $rating->rating_sum;?> </span>votes</small><?php } ?></h5>
                         <?php
                         if($rating->type==0)
                         {?>
                         <div class="rateWrapper" ><span class="rateDone rateUp active"><span class="rateUp_<?php echo $c;?>"><?php echo $result->up;?></span></span><span class="rateDone rateDown active"><span class="rateDown_<?php echo $c;?>"><?php echo $result->down;?></span></span></div>    
                         <?php
                         
                         }
                         else if($rating->type==2)
                                {?>
                                <div class="progress user-rate "><div style="width:<?php echo $result->rating;?>%;" class="bar bar_<?php echo $c;?>"><span class="text-percent text-percent_<?php echo $c;?>"><?php echo $result->rating;?></span></div></div>    
                                <?php 
                                
                                }
                                else
                                {
                                ?>
			<div  class="user-rate "><span class="user-rate-image user-rate-image_1 post-large-rate <?php echo $rating->icon?>-large"><span class="itemrate-span_<?php echo $c; ?>" style="width: <?php echo $result->rating;?>%;"></span></span></div>
		
                                <?php } ?>
               </div>
                            </div>
                              <span class="error_<?php echo $c;?> item-warning" style="float:left;display:none;width:60%;"><div class="alert alert-error">
              <button  class="btn-close btn btn-danger" type="button" onClick="javascript:closeSpan(<?php echo $c;?>)">x</button><span class="errordiv_<?php echo $c;?>"></span></div></span>
            <div class="control-group" style="float:left;width:100%">  
          <?php
                         if($rating->type==0)
                         {?>
                <div class="control-label"><label>
	Up Count</label></div>
		<div class="controls"><input type="text" class="input-mini validate-numeric" value="<?php echo $result->up;?>" id="up_<?php echo $c;?>" name="up_<?php echo $c;?>" aria-invalid="false"></div>
</div>
                            
<div class="control-group" style="float:left;width:100%">
			<div class="control-label"><label>
	Down Count</label></div>
		<div class="controls"><input type="text" class="input-mini validate-numeric" value="<?php echo $result->down;?>" id="down_<?php echo $c;?>" name="down_<?php echo $c;?>" aria-invalid="false"></div>
                         <?php }else {?>

			<div class="control-label"><label>
	Score</label></div>
		<div class="controls"><input type="text" class="input-mini validate-numeric" value="<?php echo $result->rating;?>" id="score_<?php echo $c;?>" name="score_<?php echo $c;?>" aria-invalid="false"></div>
</div>
                            
<div class="control-group" style="float:left;width:100%">
			<div class="control-label"><label>
	Count</label></div>
		<div class="controls"><input type="text" class="input-mini validate-numeric" value="<?php echo $rating->rating_sum;?>" id="sum_<?php echo $c;?>" name="sum_<?php echo $c;?>" aria-invalid="false"></div>
                         <?php } ?>
                <input type="hidden" id="rating_type_<?php echo $c; ?>" value="<?php echo $rating->type?>">
                
<input type="hidden" id="rating_id_<?php echo $c; ?>" value="<?php echo $rating->rate_id;?>">
                               <button class="btn rating-submit btn-small btn-success" data-item="<?php echo $c;?>">
	
                                   <span class="icon-apply icon-white"></span>
        
	<?php echo JTEXT::_('JAPPLY')?></button>
                </div>

<?php
$c++;
}
$total=round(($total_count/$total_sum));
$empty=(100-$total);
$str="";
foreach($rating_data as $final_rate){
$str.="['".$final_rate['title']."',".round($final_rate['sum']/$total_sum)."],";
}

?>
                        </div>
<div class="span6">
   <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Title', 'Rating'],
          ['Empty',<?php echo $empty;?>],
            <?php echo substr($str,0,-1); ?>
          
        ]);

        var options = {
          title: 'Number of votes for <?php echo $title;?>',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
<div id="piechart_3d" style="width: 100%; height: 500px;"></div>


</div>
</div></div>
