<?php

/**
 * @version     1.2.2
 * @package     com_itemrating
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomunited <contact@joomunited.com> - www.joomunited.com
 */
defined('_JEXEC') or die;


class ItemratingHelper {
      static $allowed=true;
      static $addCss=0;
      static $frating=0;
      static $final_sum=0;
      static $count=0;
	  static $snippettype=0;
	  static $snipppetcount=0;
     public static function loadWidget($row,$position="top") {
	 
	  $document=JFactory::getDocument();
	  $params = JComponentHelper::getParams('com_itemrating');
	  $category_view=$params->get('show_category_view',0);
	  $option=JFactory::getApplication()->input->getString('option');
	  self::$count++;
	  if(empty($row->categoryview))
	  {
	    $row->categoryview=0;
	  }
	  self::$allowed=$row->voteallowed;
	  
	      $desc=strip_tags($row->introtext);
	      $modified=$row->created;
	      if(!empty($row->modified))
	      {
	        $modified=$row->modified;
	      }
	      
	      $itemdata=json_decode($row->attribs);
	      $itemdata->position=$position;
	      if(empty($itemdata->groupdata))
	      {
	       return;
	      }
	      
	      
	      $html="";
	 $html='<div class="review_wrap">';
	if(($row->categoryview==1)&&($category_view==0))
	{
	  $data= ItemratingHelper::createCategoryWidget($itemdata,$row->id,$option);
	}
	else
	{
	$data= ItemratingHelper::createWidget($itemdata,$row->id,$option);
	}
	if(empty($data))
	{
	  return;
	}
	
	$html.=$data;
	if(self::$snipppetcount==1)
	{
if(($option=="com_hikashop")||($option=="com_virtuemart"))
{

if($option=="com_hikashop")
{
		require_once JPATH_ADMINISTRATOR.'/components/com_hikashop/helpers/helper.php';
		$hika_image=hikashop_get('helper.image');
		$image_file=$row->brand->images[0]->file_path;
		if($image_file)
		{
			$finalimage=$hika_image->getPath($image_file);
		}
		else
		{
			$finalimage='components/com_itemrating/assets/images/noimage.png';
		}
		$config =@hikashop::config();
		$currencyClass = hikashop_get('class.currency');
		$main_currency=$config->get('main_currency',1);
		$maincurrency=$currencyClass->get($main_currency)->currency_code;
		$vendorname=$row->brand->vendor->vendor_name;
		
}
else if($option=="com_virtuemart")
{
	$vendorname=$row->brand;
	$maincurrency=$row->currency;
	$finalimage=$row->image;
}

$html.='
<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "Product",
  "name": "'.$row->title.'",
  "image": "'.JURI::root().$finalimage.'",
  "description": "'.trim(preg_replace('/\s\s+/', ' ',strip_tags($row->introtext))).'",
  "mpn": "'.$row->id.'",
  "brand": {
    "@type": "Thing",
    "name": "'.$row->title.'"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "'.round((self::$frating/20),2).'",
     "bestRating": "5",
     "worstRating": "0",
    "reviewCount": "'.self::$final_sum.'"
  },
  "offers": {
    "@type": "Offer",
    "priceCurrency": "'.$maincurrency.'",
    "price": "'.floatval($row->productprice).'",
    "itemCondition": "http://schema.org/NewCondition",';
    if($row->quantity==0)
	{
		$html.='"availability": "http://schema.org/OutOfStock"';
	}
	else
	{
		$html.='"availability": "http://schema.org/InStock",';
	}    
    $html.='"seller": {
      "@type": "Organization",
      "name": "'.$vendorname.'"
    }
  }
}
</script>';
}
else
{
$date =JFactory::getDate($row->created );
if(isset($row->img)&&($row->img))
{
    
}
else
{
    $row->img='components/com_itemrating/assets/images/noimage.png';
}
if(self::$snippettype)
{
	  
$html.='<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "NewsArticle",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "'.JFactory::getURI()->toString().'"
  },
  "headline": "'.$row->title.'",
  "image": {
    "@type": "ImageObject",
    "url": "'.JURI::root().$row->img.'",
      "height": 800,
    "width": 800
  },
  "datePublished": "'.$date->toISO8601().'",
  "dateModified": "'.$date->toISO8601().'",
  "author": {
    "@type": "Person",
    "name": "'.$row->author.'"
  },
   "publisher": {
    "@type": "Organization",
    "name": "Google",
    "logo": {
      "@type": "ImageObject",
      "url": "'.JURI::root().$row->img.'",
        "width": 600,
      "height": 60
    }
  },
  "aggregateRating":
    {"@type": "AggregateRating",
     "ratingValue": "'.round((self::$frating/20),2).'",
     "bestRating": "5",
     "worstRating": "0",
     "reviewCount": "'.self::$final_sum.'"
    },
  "description": "'.trim(preg_replace('/\s\s+/', ' ',strip_tags($row->introtext))).'"
}
</script>';
}
else
{
	  
$html.='<script type="application/ld+json">
{ "@context": "http://schema.org",
  "@type": "Product",
  "name": "'.$row->title.'",
  "aggregateRating":
    {"@type": "AggregateRating",
     "ratingValue": "'.round((self::$frating/20),2).'",
     "bestRating": "5",
     "worstRating": "0",
     "reviewCount": "'.self::$final_sum.'"
    }
}
</script>';
}
}
	}
$html.='</div>';
	
return $html;

    }
     public static function createCategoryWidget($groupdata,$context_id=null,$context=null) {
	 
	       ItemratingHelper::loadLanguage();
               $document=  JFactory::getDocument();
	       $params = JComponentHelper::getParams('com_itemrating');
	  $group_id=$groupdata->groupdata;
	  $row=ItemratingHelper::getGroupData($group_id);
	  self::$snippettype=$row->snippettype;
	  if(!$row)
	    {
		  return;
	    }
	  $reviews=ItemratingHelper::getGroupRating($group_id);
	  if(empty($row->position))
	       {
		    $row->position=0;
	       }
	       if(($groupdata->position=="top")&&($row->position==3))
	       {
		    return;
	       }
	       else if(($groupdata->position=="bottom")&&($row->position!=3))
	       {
		    return;
	       }
	       else if($groupdata->position=="none")
	       {
		$row->position=2;    
	       }
	       $finalscore=0;
	  
	  $final_sum=0;
	  $user_count=0;
	  $final_count=0;
	  $rating_final=0;
	  $html="";
	  if(self::$addCss==0)
	  {
               $document->addStyleSheet(JURI::root().'components/com_itemrating/assets/rating.css');
	  
	  self::$addCss=1;
	  }
	  $frating="";
	 foreach($reviews as $itemdata)
	 {
	   $final_data=ItemratingHelper::getRating($context,$context_id,$itemdata->id);
	   $rating_sum=$itemdata->hits;
	  
	   if($rating_sum==0)
	   {
	       $rating_sum=1;
	   }
	   if(!empty($final_data->rating_sum))
	      {
	        $rating_sum=$final_data->rating_sum;
	      }
	       if(!empty($final_data))
	       {
		    $json=json_decode($final_data->rating_count);
		    $count_up=$json->up;
		    $count_down=$json->down;
		    $rating_final=$json->rating;
		   
	       }
	        $user_count=$user_count+$rating_final;
	
		$final_sum=$final_sum+$rating_sum;
		if($rating_final)
		{
		  	$finalscore=$finalscore+($rating_final*$rating_sum);
		}else
		{

		  $finalscore=$finalscore+($itemdata->rating*$itemdata->hits);
		}
		
		
		    
	 }
	 
	 if($final_sum!=0)
		    {
		    $frating=round(($finalscore/$final_sum));
		    }
		    	if(!empty($groupdata->textforscore))
			 {
			        $row->textforscore=$groupdata->textforscore;
			 }
			 
    
    $score_type=$params->get('score_type',2);
    if($score_type==9)
    {
       $html.=$frating.JText::_("COM_ITEMRATING_OUT").'100 ';
    }
    else if($score_type==2)
			{
			 $html.='<span class="post-large-rate stars-large post-single-rate"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($score_type==3)
			{
			 $html.='<span class="post-large-rate hearts-large post-single-rate"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($score_type==4)
			{
			 $html.='<span class="post-large-rate thumbs-large post-single-rate"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($score_type==6)
			{
			 $html.='<span class="post-large-rate arrows-large post-single-rate"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($score_type==7)
			{
			 $html.='<span class="post-large-rate check-large post-single-rate"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($score_type==8)
			{
			 $html.='<span class="post-large-rate light-large post-single-rate"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($score_type==5)
			{
			 $html.='<div class="progress user-rate"><div style="width: '.$frating.'%;" class="bar"><span class="text-percent">'.$frating.'%</span></div></div>';
			}
    $html.=JText::_("COM_ITEMRATING_BASED").' <span class="cat-rating-count">'.$final_sum.'</span> '.JText::_("COM_ITEMRATING_RATINGS").' ';
  	self::$frating=$frating;
		self::$final_sum=$final_sum;
  
  return $html;
	
     }
	 
	 public static function getFinalScoreWidget($score_type,$frating,$final_sum)
	 {
			$frating=round($frating,2);
			if($score_type==9)
			{
				   $html=$frating.JText::_("COM_ITEMRATING_OUT").'100 ';
			}
    else if($score_type==2)
			{
			 $html='<span class="post-large-rate stars-large post-single-rate"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($score_type==3)
			{
			 $html='<span class="post-large-rate hearts-large post-single-rate"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($score_type==4)
			{
			 $html='<span class="post-large-rate thumbs-large post-single-rate"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($score_type==6)
			{
			 $html='<span class="post-large-rate arrows-large post-single-rate"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($score_type==7)
			{
			 $html='<span class="post-large-rate check-large post-single-rate"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($score_type==8)
			{
			 $html='<span class="post-large-rate light-large post-single-rate"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($score_type==5)
			{
			 $html='<div class="progress user-rate"><div style="width: '.$frating.'%;" class="bar"><span class="text-percent">'.$frating.'%</span></div></div>';
			}
			$html.=JText::_("COM_ITEMRATING_BASED").' <span class="cat-rating-count">'.$final_sum.'</span> '.JText::_("COM_ITEMRATING_RATINGS").' ';
			return $html;
	 }
     
      public static function createWidget($groupdata,$context_id=null,$context=null) {
	  
	  ItemratingHelper::loadLanguage();
          $params = JComponentHelper::getParams('com_itemrating');
	       $document=JFactory::getDocument();
	       $group_id=$groupdata->groupdata;
	       $row=ItemratingHelper::getGroupData($group_id);
			self::$snippettype=$row->snippettype;
               if(!$row)
	       {
		  return;
	       }
	       if(($context=="com_community")||($context=="com_comprofiler"))
	       {
		   $row->position=2;     
	       }
               else if($context=="com_hikashop")
               {
		   $row->position=3;     
	       }
               
	       if(empty($groupdata->jsinclude))
	       {
		    $groupdata->jsinclude=0;
	       }
	       if(empty($row->position))
	       {
		    $row->position=0;
	       }
	       if(($groupdata->position=="top")&&($row->position==3))
	       {
		    return;
	       }
	       else if(($groupdata->position=="bottom")&&($row->position!=3))
	       {
		    return;
	       }
	       else if($groupdata->position=="none")
	       {
		$row->position=2;    
	       }
		 self::$snipppetcount=1;
	       $html="";
               $script="";
	       $document=JFactory::getDocument();
	       $colorstyle=json_decode($row->styling);
	       
	        $outerborder=$colorstyle->outer_border;
		$headbackground=$colorstyle->head_background;
		$headcolor=$colorstyle->head_color;
		$itembackground=$colorstyle->item_background;
		$scorebg=$colorstyle->score_bg;
		$fontcolor=$colorstyle->link_color;
		$customcss=$row->customcss;
		$barbg=$colorstyle->bar_bg;
		$show_vote=$colorstyle->show_vote;
		$votecolor=$colorstyle->vote_color;
		$score_type=$colorstyle->score_type;
		$score_position=$colorstyle->score_position;
                 $jsilclude="";
                 $alert="";
                 $alertclose="";
                 $show_form=$params->get('show_form_alert',1);
             
                if($groupdata->jsinclude==0)
                {
                JHtml::_('jquery.framework');
                $document->addStyleSheet(JURI::root().'components/com_itemrating/assets/rating.css');
                $document->addStyleSheet(JURI::root().'components/com_itemrating/assets/circle.css');
                $document->addScript(JURI::root()."components/com_itemrating/assets/progress-circle.js");
		    $document->addScript(JURI::root()."components/com_itemrating/assets/jquery.mobile.custom.js");
                 if($show_form)
                 {
                $document->addStyleSheet(JURI::root().'components/com_itemrating/assets/alertify-bootstrap.css');
                $document->addScript(JURI::root()."components/com_itemrating/assets/alertify.js");   
                    $alert="alertify.prompt('".JText::_('COM_ITEMRATING_ITEMS_RATING_ENTERED')."', function (q,value)                                                 {
				if (q) {
                                value=parseFloat(value);
                                if (value > 100) {
			value = 100;
                        }
		ngg = (value*5)/100;
                                
			";
                 $alertclose="} else {
					alertify.error('".JText::_('COM_ITEMRATING_ITEMS_RATING_CANCEL')."');
				}
			},''+gg );";   
                
                  }
                
                
                }
                else
                {
                    $jsilclude.=JHtml::_('jquery.framework');
                $jsilclude.="<link rel='stylesheet' href='".JURI::root()."components/com_itemrating/assets/rating.css' type='text/css' />
		<link rel='stylesheet' href='".JURI::root()."components/com_itemrating/assets/circle.css' type='text/css' />
		<script src='".JURI::root()."components/com_itemrating/assets/progress-circle.js' type='text/javascript'></script>
		<script src='".JURI::root()."components/com_itemrating/assets/jquery.mobile.custom.js' type='text/javascript'></script>
		";
                }
                $style=".review-box{
		background-color:".$outerborder.";
		}
                #review-box h2.review-box-header,.user-rate-wrap
		{
		background-color:".$headbackground.";
		color:".$headcolor.";
		}
		.review-stars .review-item,.review-percentage .review-item span,.review-summary,.review-container
		{
		    background-color:".$itembackground.";
		}
		.review-percentage .review-item span span,.review-final-score
		{
		     background-color:".$scorebg.";
		}
		#review-box .progress .bar
		{
		     background-color:".$barbg.";
		     background-image:linear-gradient(to bottom, ".$barbg.", ".$barbg.");
		    
		}
		
		#review-box .prog-circle .fill,#review-box .prog-circle .bar
		{
		    border-color:".$barbg.";
		}
		#review-box .prog-circle .percenttext
	       {
		    color:".$barbg.";
		    font-size:20px;
	       }
		
		#review-box .review-item h5,#review-box h1, #review-box h2, #review-box h3, #review-box h4, #review-box h5, #review-box h6, #review-box p, #review-box strong,.user-rate-wrap .user-rating-text,#review-box .review-final-score h3,#review-box .review-final-score h4
		{
		    color:".$fontcolor."
		}
		";
		if($show_vote==0)
		{
		    $style.=".voting{display:none;}";
		}
		else
		{
		    $style.=".voting{color:".$votecolor.";}";
		    
		}
                if($row->display==0)
                {
                     $style.=".review-box-header".$row->id."{display:none;}";
                }
		if($row->position==0)
		{
		   $style.=".review-top { float: left; }"; 
		}
		else if($row->position==1)
		{
		    $style.=".review-top { float: right; }";
		}
		
		else if($row->position==2)
	       {
		    $style.="#review-box{  margin: 0 auto; width :100%;}";
	       }
		else
	       {
		    $style.="#review-box{  margin: left;}";
	       }
	       if($colorstyle->score_position==1)
	       {
		     $style.=".rating-view { width:60%;float:right;} .review-summary{width:39%;float:left;}.review-short-summary{ padding:10px 2px 10px 10px;}.rating-view{border-left:1px dashed #eee}";
	       }
	       else if($colorstyle->score_position==2)
	       {
		    $style.=".rating-view { width:60%;float:left;} .review-summary{width:39%;float:left;}.review-short-summary{ padding:10px 2px 10px 10px;}.rating-view{border-right:1px dashed #eee}";
	       }
               
		$style.=$customcss;
		 if($groupdata->jsinclude==0)
                {
                $document->addStyleDeclaration($style);
                } 
                else
                {
                    $jsilclude.="<style type='text/css'>".$style."</style>";
                }
				$bar="";
				if($score_type==0)
				{
				  $bar="nPercent=jQuery( '#circle_".$context_id."' ).attr('data-rate');
jQuery( '#circle_".$context_id."' ).progressCircle({
nPercent        : nPercent,
thickness       : 8
});";
				}
                $script.="
				function isTouchSupported() {
    var msTouchEnabled = window.navigator.msMaxTouchPoints;
    var generalTouchEnabled = 'ontouchstart' in document.createElement('div');
 
    if (msTouchEnabled || generalTouchEnabled) {
        return true;
    }
    return false;
}
				if (isTouchSupported()) {
				  var custom_event ='tap touchend';
				}else
				{
				  var custom_event ='click';
				}
				
				
		var rateObject = {
	urlRate : 'index.php',
	urlReset : 'index.php',
	rate : function(obj) {
		obj.live(custom_event, function(e) {
                
			var thisObj = jQuery(this);
                        var cnst=thisObj.attr('class').split(' ')[2];	
                        var thisType = thisObj.hasClass('rateUp') ? 'up' : 'down';
			var thisItem = thisObj.attr('data-item');
			var thisValue = thisObj.children('span').text();
                        var context=thisObj.attr('data-context');
                        var context_id=thisObj.attr('data-contextid');
			var value=-2;
			if(thisType=='up')
			{
			 value=-1;
			}
			jQuery.post(rateObject.urlRate, { option:'com_itemrating',task:'item.rating',type : thisType, value:value,item : thisItem,context_id:context_id,context:context,tmpl:'component','".JSession::getFormToken()."':'1'  }, function(data) {
					var error=(data.error);
					if(error==false)
					{
					var count=jQuery( '.review-item').find( '.itemrate-count_'+ cnst).text();
					jQuery( '.review-item').find( '.itemrate-count_'+ cnst).text(parseInt(count)+1);
					thisObj.children('span').html(parseInt(thisValue, 10) + 1);
					thisObj.parent('.rateWrapper').find('.rate').addClass('rateDone').removeClass('rate');
					thisObj.addClass('active');
					     jQuery('.error_'+cnst).show();
					     jQuery('.errordiv_'+cnst).html(data.message);
					}
					else
					{
					     jQuery('.error_'+cnst).show();
					     jQuery('.errordiv_'+cnst).html(data.message);
					}
			}, 'json');
			e.preventDefault();
		});
	}
};

jQuery(function() {
	jQuery.ajaxSetup({ cache:false });
	rateObject.rate(jQuery('.rate'));
});

jQuery(document).ready(function() {
".$bar."

jQuery(document).on('mousemove touchmove', '.user-rate-active' , function (e) {
		var rated = jQuery(this);
		if( rated.hasClass('rated-done') ){
			return false;
		}
		if (!e.offsetX){
			e.offsetX = e.clientX - jQuery(e.target).offset().left;
		}
		var offset = e.offsetX + 4;
		if (offset > 100) {
			offset = 100;
		}
		rated.find('.user-rate-image span').css('width', offset + '%');
		var score = Math.floor(((offset / 10) * 5)) / 10;
		if (score > 5) {
			score = 5;
		}
		rated.find('.user-rate-image span').attr('title',offset);
	});
	jQuery(document).on('mousemove touchmove', '.progress-rate-active' , function (e) {
		var rated = jQuery(this);
		if( rated.hasClass('rated-done') ){
			return false;
		}
		if (!e.offsetX){
			e.offsetX = e.clientX - jQuery(e.target).offset().left;
		}
		var offset = Math.round(e.offsetX*100/rated.width());
		rated.find('.bar').css('width', offset + '%');
		rated.find('.text-percent').text(offset + '%');
		
	       });
	jQuery(document).on(custom_event, '.user-rate-active' , function (e) {
		var rated = jQuery(this);
		var cnst=jQuery(this).attr('class').split(' ')[2];
                
		var numVotes = rated.parent().find('.itemrate-count').text();
		var thisObj = jQuery(this);
			var thisType = 'rate';
			var thisItem = thisObj.attr('data-item');
			var thisValue = thisObj.children('span').text();
                        var context=thisObj.attr('data-context');
                        var context_id=thisObj.attr('data-contextid');
			var olddata=jQuery( '.review-item').find( '.itemrate-score_'+ cnst).text();
			var count=jQuery( '.review-item').find( '.itemrate-count_'+ cnst).text();
			var gg = rated.find('.user-rate-image_'+cnst+' span').width();
                       
		if (gg > 100) {
			gg = 100;
		}
		ngg = (gg*5)/100;
                ".$alert."
			jQuery.post(rateObject.urlRate, { option:'com_itemrating',task:'item.rating',type : thisType, item : thisItem,context_id:context_id,context:context,value:ngg,oldData:olddata,count:count,tmpl:'component','".JSession::getFormToken()."':'1'  }, function(data) {
			 
			var error=(data.error);
					if(error==false)
					{
					     var fcount=jQuery.parseJSON(data.rating);
					     jQuery('.error_'+cnst).show();
					     jQuery('.errordiv_'+cnst).html(data.message);
					     var count=jQuery( '.review-item').find( '.itemrate-count_'+ cnst).text();
					     jQuery( '.review-item').find( '.itemrate-count_'+ cnst).text(parseInt(count)+1);
					     jQuery( '.review-item').find( '.itemrate-score_'+ cnst).text(fcount.rating);
					     rated.addClass('rated-done_'+cnst).attr('data-rate',fcount.rating);
					     rated.find('.user-rate-image_'+cnst+' span').width(fcount.rating+'%');
                                           
					     rated.removeClass('user-rate-active');
		    
					}
					else
					{
					     jQuery('.error_'+cnst).show();
					     jQuery('.errordiv_'+cnst).html(data.message);
					}
			}, 'json');
                        ".$alertclose."
			e.preventDefault();
                        e.stopImmediatePropagation();
			return false;
	});
	jQuery(document).on(custom_event, '.progress-rate-active' , function (e) {
		var rated = jQuery(this);
		var cnst=jQuery(this).attr('class').split(' ')[3];
		var numVotes = rated.parent().find('.itemrate-count').text();
		var thisObj = jQuery(this);
			var thisType = 'rate';
			var thisItem = thisObj.attr('data-item');
                         var context=thisObj.attr('data-context');
                        var context_id=thisObj.attr('data-contextid');
			var thisValue = thisObj.children('span').text();
			var olddata=jQuery( '.review-item').find( '.itemrate-score_'+ cnst).text();
			var count=jQuery( '.review-item').find( '.itemrate-count_'+ cnst).text();
			var gg = parseFloat(rated.find('.bar_'+cnst+' span').text());
			var ngg=(gg/20);
                        ".$alert."
                        		jQuery.post(rateObject.urlRate, { option:'com_itemrating',task:'item.rating',type : thisType, item : thisItem,context_id:context_id,context: context,value:ngg,oldData:olddata,count:count,tmpl:'component','".JSession::getFormToken()."':'1'  }, function(data) {
			 
			var error=(data.error);
					if(error==false)
					{
					     var fcount=jQuery.parseJSON(data.rating);
					     jQuery('.error_'+cnst).show();
					     jQuery('.errordiv_'+cnst).html(data.message);
					     var count=jQuery( '.review-item').find( '.itemrate-count_'+ cnst).text();
					     jQuery( '.review-item').find( '.itemrate-count_'+ cnst).text(parseInt(count)+1);
					     jQuery( '.review-item').find( '.itemrate-score_'+ cnst).text(fcount.rating);
					     rated.addClass('rated-done_'+cnst).attr('data-rate',fcount.rating);
					     rated.find('.bar_'+cnst).width(fcount.rating+'%');
                                               rated.find('.text-percent_'+cnst).text(fcount.rating + '%');
					     rated.removeClass('user-rate-active');
		    
					}
					else
					{
					     jQuery('.error_'+cnst).show();
					     jQuery('.errordiv_'+cnst).html(data.message);
					}
			}, 'json');
                        ".$alertclose."
			e.preventDefault();
                        e.stopImmediatePropagation();
			return false;
	});
	
	jQuery(document).on('mouseleave touchend', '.progress-rate-active' , function () {
		var rated = jQuery(this);
		if( rated.hasClass('rated-done') ){
			return false;
		}
		var post_rate = rated.attr('data-rate');
		rated.find('.bar').css('width', post_rate + '%');
		rated.find('.text-percent').text(post_rate + '%');
		
	});
	
	jQuery(document).on('mouseleave touchend', '.user-rate-active' , function () {
		var rated = jQuery(this);
		if( rated.hasClass('rated-done') ){
			return false;
		}
		var post_rate = rated.attr('data-rate');
		rated.find('.user-rate-image span').css('width', post_rate + '%');
	});
});
function closeSpan(elem)
{
    jQuery('.error_'+elem).hide();
}
";
                 $html="";
	       
                 if($groupdata->jsinclude==0)
                {
                 $document->addScriptDeclaration($script);
                     
                } 
                else
                {
                    $jsilclude.="<script type='text/javascript'>".$script."</script>";
                    $html.=$jsilclude;
                    
                }
               $class='stars';
		$html.='<div class="review-box review-top review-'.$class.'" id="review-box"><div class="review-container">';
	$html.='<div class="rating-view"><h2 class="review-box-header review-box-header'.$row->id.'">'.$row->title.'</h2>';
	$reviews=ItemratingHelper::getGroupRating($group_id);
	$c=0;
	$finalscore=0;
	$final_sum=0;
	$user_count=0;
	$final_count=0;
	foreach($reviews as $itemdata)
	{
	  $iconstyle=$itemdata->icon;
          $constant=$context."_".$context_id."_".$itemdata->id;
	   $rating_sum=$itemdata->hits;
	   if($rating_sum==0)
	   {
	       $rating_sum=1;
	   }
	      $rating_final="";
	      $count_up=0;
	      $count_down=0;
	      $final_data=ItemratingHelper::getRating($context,$context_id,$itemdata->id);
	      $allow=json_decode(ItemratingHelper::AllowRating($itemdata,$final_data));
	       
	  if(!empty($final_data->rating_sum))
	      {
	        $rating_sum=$final_data->rating_sum;
	      }
	  
	  if(!empty($final_data))
	       {
		    $json=json_decode($final_data->rating_count);
		    $count_up=$json->up;
		    $count_down=$json->down;
		    $rating_final=$json->rating;
		   
	       }
	  if($itemdata->type==1)
	  {
	       $active="";
	    if(empty($rating_final))
	    {
	       $rating_final=$itemdata->rating;
	    }
	     if($allow->error==false)
	      {
	       
	      $active="user-rate-active ".$constant;
	      }
			if(!$itemdata->label)
			{
				  $active="";
			}
		    $user_count=$user_count+$rating_final;
		    
	    	  $html.='<div class="review-item">
			<h5 class="item-score">'.$itemdata->title.': <span class="itemrate-score_'.$constant.'"> '.$rating_final.'</span>%<small class="small_'.$constant.' voting">  - <span class="itemrate-count_'.$constant.'">'.$rating_sum.' </span>'.JText::_('COM_ITEMRATING_VOTES').'</small></h5>
			<div class="user-rate '. $active.'" data-item="'.$itemdata->id.'" data-rate="'.$rating_final.'" data-context="'.$context.'" data-contextid="'.$context_id.'"><span class="user-rate-image user-rate-image_'.$constant.' post-large-rate '.$iconstyle.'-large"><span style="width: '.$rating_final.'%;"></span></span>';
			if($itemdata->misc)
			{
				  $html.=ItemratingHelper::getLabelTextData($itemdata,$rating_final,$constant);
				  
			}
			$html.="</div></div>";
		$finalscore=$finalscore+($rating_final*$rating_sum);
		$final_sum=$final_sum+$rating_sum;
	  }
	   else if($itemdata->type==2)
	  {
	       $active="";
	    if(empty($rating_final))
	    {
	       $rating_final=$itemdata->rating;
	    }
	     if($allow->error==false)
	      {
	       
	      $active="progress-rate-active ".$constant;
	      }
		  if(!$itemdata->label)
			{
				  $active="";
			}
		    $user_count=$user_count+$rating_final;
		    
	    	  $html.='<div class="review-item">
			<h5>'.$itemdata->title.': <span class="itemrate-score_'.$constant.'">'.$rating_final.'</span>%<small class="small_'.$constant.' voting"> - <span class="itemrate-count_'.$constant.'">'.$rating_sum.'</span> '.JText::_('COM_ITEMRATING_VOTES').'</small></h5>';
			$html.='<div class="progress user-rate '. $active.'" data-context="'.$context.'" data-contextid="'.$context_id.'" data-item="'.$itemdata->id.'" data-rate="'.$rating_final.'"><div class="bar bar_'.$constant.'" style="width:'.$rating_final.'%;"><span class="text-percent text-percent_'.$constant.'">'.$rating_final.'%</span></div>';
			$html.='</div>';
			if($itemdata->misc)
			{
				  $html.=ItemratingHelper::getLabelTextData($itemdata,$rating_final,$constant);
				  
			}
			
			$html.='</div>';
			$finalscore=$finalscore+($rating_final*$rating_sum);
			$final_sum=$final_sum+$rating_sum;
	}
	else if($itemdata->type==3)
	  {
	       $active="";
	    if(empty($rating_final))
	    {
	       $rating_final=$itemdata->rating;
	    }
	     if($allow->error==false)
	      {
	       
	      $active="user-rate-active ".$constant;
	      }
			if(!$itemdata->label)
			{
				  $active="";
			}
		    $user_count=$user_count+$rating_final;
		    $data=json_decode($itemdata->fasetting);
			
	    	  $html.='<div class="review-item faw">
			<h5 class="item-score">'.$itemdata->title.': <span class="itemrate-score_'.$constant.'"> '.$rating_final.'</span>%<small class="small_'.$constant.' voting">  - <span class="itemrate-count_'.$constant.'">'.$rating_sum.' </span>'.JText::_('COM_ITEMRATING_VOTES').'</small></h5>
			<div class="user-rate '. $active.'" data-item="'.$itemdata->id.'" data-rate="'.$rating_final.'" data-context="'.$context.'" data-contextid="'.$context_id.'"><span class="user-rate-image user-rate-image_'.$constant.' post-large-rate glyph-large" data-content="'.$data->icon.$data->icon.$data->icon.$data->icon.$data->icon.'" style="color:'.$data->inactivecolor.';"><span style="width:'.$rating_final.'%;color:'.$data->activecolor.';" data-content="'.$data->icon.$data->icon.$data->icon.$data->icon.$data->icon.'"></span></span>';
			if($itemdata->misc)
			{
				  $html.=ItemratingHelper::getLabelTextData($itemdata,$rating_final,$constant);
				  
			}
			$html.="</div></div>";
		$finalscore=$finalscore+($rating_final*$rating_sum);
		$final_sum=$final_sum+$rating_sum;
	  }
	  else
	  {
	       $up_c="";
	       $up_d="";
	       $active="";
	       if($allow->error==true)
	      {
	      $active="Done";
	      }
	       if( $count_up!=0)
	       {
		    $up_c="active";
	       }
	       
	       if( $count_down!=0)
	       {
		    $up_d="active";
	       }
	       if(empty($final_data->rating_sum))
	      {
	      $rating_sum=0;
	      }
	       	  $html.='<div class="review-item">
			<h5>'.$itemdata->title.'<small class="voting"> - <span class="itemrate-count_'.$constant.'">'.($rating_sum).'</span> '.JText::_('COM_ITEMRATING_VOTES').'</small></h5><div class="rateWrapper"><span data-item="'.$itemdata->id.'" data-context="'.$context.'" data-contextid="'.$context_id.'"  class="rate'.$active.' rateUp '.$constant.' '.$up_c.'"><span class="rateUpN">'.$count_up.'</span></span><span data-item="'.$itemdata->id.'" class="rate'.$active.' rateDown '.$constant.' '.$up_d.'" data-context="'.$context.'" data-contextid="'.$context_id.'"><span class="rateDownN" data-item="'.$itemdata->id.'">'.$count_down.'</span></span></div></div>';

	  }
	  $html.='<span class="error_'.$constant.' item-warning" style="display:none;"><div class="alert alert-error">
              <button  class="btn-close" type="button" onClick="javascript:closeSpan(\''.$constant.'\')">x</button><span class="errordiv_'.$constant.'"></span></div></span>';
	      
		
		$c++;
	}
	$frating="";
	if($final_sum!=0)
	{
	$frating=round(($finalscore/$final_sum));
	}
	if(!empty($groupdata->textforscore))
	{
	  $row->textforscore=$groupdata->textforscore;
	}
	if(!empty($groupdata->reviewsummary))
	{
	  $row->reviewsummary=$groupdata->reviewsummary;
	}
	$html.="</div>";
	$html.='<div class="review-summary">
		<div class="review-final-score">';
			
			if($colorstyle->score_type==1)
			{
			  $html.='<h2>'.$frating.'%</h2>';
			}
			else if($colorstyle->score_type==2)
			{
			 $html.='<span class="post-large-rate stars-large"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($colorstyle->score_type==3)
			{
			 $html.='<span class="post-large-rate hearts-large"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($colorstyle->score_type==4)
			{
			 $html.='<span class="post-large-rate thumbs-large"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($colorstyle->score_type==6)
			{
			 $html.='<span class="post-large-rate arrows-large"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($colorstyle->score_type==7)
			{
			 $html.='<span class="post-large-rate check-large"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($colorstyle->score_type==8)
			{
			 $html.='<span class="post-large-rate light-large"><span style="width: '.$frating.'%;"></span></span>';
			}
			else if($colorstyle->score_type==5)
			{
			 $html.='<div class="progress user-rate"><div style="width: '.$frating.'%;" class="bar"><span class="text-percent">'.$frating.'%</span></div></div>';
			}
			else
			{
	  $html.='<span title="'.$row->textforscore.'"><div id="circle_'.$context_id.'"  data-rate="'.$frating.'"></div></span>';
			}
				$html.='<h4>'.$row->textforscore.'</h4>
			</div>
			<div  class="review-short-summary">
				<p>'.$row->reviewsummary.'</p>
			</div>
		</div>';
		
		$html.='</div></div>';
		self::$frating=$frating;
		self::$final_sum=$final_sum;
	 
	  return $html;
	 
      }
      public static function getGroupData($group_id)
	{
	$db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__itemrating_group');
        $query->where('id='.(int)$group_id);
        $db->setQuery($query);
        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
	
        $row= $db->loadObject();
	return $row;
	}
	public static function getGroupRating($group_id)
	{
	  $db = JFactory::getDBO();
	$query = $db->getQuery(true);
        $query->select('*');
        $query->from('#__itemrating_item');
        $query->where('group_id='.(int)$group_id);
	  $query->where('state=1');
	  $query->order('ordering');
	  $db->setQuery($query);
        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
            exit;
        }
        $reviews= $db->loadObjectList();
	return   $reviews;
	}
	
	public static function getRating($context,$context_id,$rating_id)
	{
		
			// Initialize variables.
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
		// Create the base select statement.
			$query->select('*')
				->from($db->quoteName('#__itemrating_itemdata'))
				->where($db->quoteName('context') . ' = ' . $db->quote($context))
				->where($db->quoteName('context_id') . ' = ' . (int)$context_id)
				->where($db->quoteName('rating_id') . ' = ' . (int)$rating_id);

			// Set the query and load the result.
			$db->setQuery($query);
			
			// Check for a database error.
			try
			{
				$rating = $db->loadObject();
			}
			catch (RuntimeException $e)
			{
				  JFactory::getApplication()->enqueueMessage($e->getMessage(),'error');
				return false;
			}
			return $rating;
	}
	public static function AllowRating($group,$rating)
	{
	   if(!(self::$allowed))
	   {
	        return json_encode(array("error"=>true,"message"=>JText::_('COM_ITEMRATING_VOTE_DISABLE')));
	   }
	       $user=JFactory::getUser();
	       $found=0;
	    $params = JComponentHelper::getParams('com_itemrating');
	    $userIP = $_SERVER['REMOTE_ADDR'];
	    $msg="";
	    $user_group=$params->get('guest_usergroup');
	    
	    if(!empty($user_group))
	    {
	       foreach($user_group as $group)
	       {
		    if (in_array($group,$user->groups))
		    {
			 
			 $found=1;
			 break;
		    }
	       }
	       
	       if($found==0)
	       {
		    
		    return json_encode(array("error"=>true,"message"=>JText::_('COM_ITEMRATING_VOTE_DISABLE')));
	       }
	    }
	       $msg=json_encode(array("error"=>false,"message"=>"Welcome to Rate"));
	       return $msg;
	}
	  public static function loadLanguage() {
	       $lang = JFactory::getLanguage();
	       $lang->load('com_itemrating', JPATH_ADMINISTRATOR);
	  }
	  public static function allowCategory($category,$component) {
	    $db    = JFactory::getDbo();
	    $query = $db->getQuery(true);
	    $query->select('*')
	    ->from($db->quoteName('#__itemrating_group'))
	    ->where($db->quoteName('customcategory') . ' REGEXP \'"'. $db->escape($component).'":\\\[("[[:digit:]]*",)?"'.(int)$category.'"\'');
	
	    $db->setQuery($query);
	    $catallow = $db->loadObject();
	   
	    return $catallow;
	  }
	  public static function getLabelTextData($itemdata,$value,$constant)
	  {
			$document=JFactory::getDocument();
			$miscdata=json_decode($itemdata->misc);
			$rand=rand();
			$script="";
			$text='<span id="datashow_'.$itemdata->id.'_'.$rand.'" class="ratingdata"><span class="br-current-rating label" id="datalabel_'.$itemdata->id.'_'.$rand.'">';
			$script.="jQuery(document).on('mousemove touchmove', '.".$constant."' , function (e) {
			var rated = jQuery(this);
			if (!e.offsetX){
			e.offsetX = e.clientX - jQuery(e.target).offset().left;
			}
			var offset = Math.round(e.offsetX*100/rated.width());
			
			";
			$q=0;
			$if="";
			foreach($miscdata as $misc)
			{
				  
				  if($q==0)
				  {
						$if="if";
				  }
				  else
				  {
						$if="else if";
				  }
				  $script.=$if."((parseInt(".$misc->rangestart.")<=offset)&&(offset<=parseInt(".$misc->rangeend.")))
				  {
				  
						jQuery('#datalabel_".$itemdata->id."_".$rand."').text('".$misc->rangetext."');
				  }
				  ";
				  if( ($misc->rangestart <= $value) && ( $value<= $misc->rangeend))
				  {
						$text.=$misc->rangetext;
				  }
				  $q++;
			}
			if($q==0)
			{
				  return;
			}
			
			$script.="else{
			rated.find('#datalabel_".$itemdata->id."_".$rand."').text('');
			}";
			$script.="});";
			$document->addScriptDeclaration($script);
			
			$text.="</span></span>";
			return $text;
	  }
}
