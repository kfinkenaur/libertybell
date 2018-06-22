<?php 
/**
 * @package NLevel Responsive Menu
 * @version 2.0.0
 * @license http://www.raindropsinfotech.com GNU/GPL
 * @copyright (c) 2015 Raindrops Company. All Rights Reserved.
 * @author http://www.raindropsinfotech.com
 */
 defined('_JEXEC') or die;
 
$ipadPortrait = '1200';
if($params->get('ipad_portrait') == 2)
    $ipadPortrait = '768';
?>
<script type="text/javascript">
	var tops;
	var diff = 95;
	var leftSlide = 400;
	
	if ( jQuery( ".mobile_sticky" ).length ) {
		offset = jQuery('.mobile_sticky').offset();
		fromTop = offset.top;	

		jQuery(window).scroll(function(e){    
			scroll = jQuery(window).scrollTop();    	
			if(scroll > fromTop){
				jQuery('.mobile_sticky').find('.menu_icon').addClass('topFix');		
			}else{
				jQuery('.mobile_sticky').find('.menu_icon').removeClass('topFix');					
			}
		})	
	}
	/* for normal menu start */
	jQuery('.havechild').hover(function(){		
			
		jQuery(this).find('.have-content').first().css('display','block');					
		jQuery(this).find('.have-content').first().css('position','absolute');
		level = jQuery(this).find('.have-content').attr('level');		
		width = jQuery(this).width();
		height = jQuery(this).height()+6;

		if((level-2) > 0)
			jQuery(this).find('.have-content').first().css('margin','-'+height+'px 0 0 '+width+'px');
				
		jQuery(this).find('.level-'+level).each(function(){
			jQuery(this).css('display','block');
		})

	});

	jQuery('.havechild').mouseleave(function() {		
		jQuery(this).find('.have-content').css('display','none');						
	});

	/* for normal menu end*/		


	/* for responcive menu */

	jQuery(document).ready(function(){

		jQuery( window ).resize(function() {
			setView()			
		});
		jQuery('#yt-off-resmenu').appendTo('html');
		
		defaultOpen();
		setView();

		//make ordering of all ul for mobile view		
		for(i = (jQuery('.mm-list').length-1); i >= 0 ;i--){
			jQuery(this).find('#ul_header').after(jQuery('#mm-'+i+''));
		}		
	});

	jQuery('#mobile_menu_hide').click(function(){	
		
		jQuery('body').animate({left:"0"},800);	
		
		jQuery('#yt-off-resmenu').animate(
			{width:0},
			800,
			function() {
				jQuery('#yt-off-resmenu').removeClass('mm-opened');
				jQuery('#yt-off-resmenu').removeClass('mm-current');
				jQuery('#yt-off-resmenu').addClass('mm-offcanvas');	
				jQuery('body').removeClass('body-position');		
		});
		
		jQuery('body').css({'overflow': 'auto','height': 'auto'});
		//jQuery('body').css('left','0px');		
	});

	jQuery('#mobile_menu_show').click(function(){	
		
		window.scrollTo(0, 0);
		jQuery('#yt-off-resmenu').css('width','0px')		
		
		aa = jQuery( window ).width();
		if( ((aa*diff)/100) > leftSlide )
			aa=leftSlide;
		else
			aa=parseInt((aa*diff)/100);
		aa += 10;
		console.log(aa);

		jQuery('body').animate({left:aa},800);


		jQuery('body').addClass('body-position');		

		aa = jQuery( window ).width();
		if( ((aa*diff)/100) > leftSlide )
			aa=leftSlide;
		else
			aa=diff+'%';


		jQuery('#yt-off-resmenu').animate(
			{width:aa},
			800,
			function() {
				jQuery('#yt-off-resmenu').addClass('mm-opened');				
				jQuery('body').css({'overflow': 'hidden','height': '100%'});
				defaultOpen();								
		});

		jQuery('#yt-off-resmenu').addClass('mm-current');
		jQuery('#yt-off-resmenu').removeClass('mm-offcanvas');		

		return false;
	});				

	jQuery('.mm-subopen').click(function(){
		if('mm-0' == jQuery(this).parent().parent().attr('id') ){
			jQuery('.mm-list').each(function(){
				if('mm-0' == jQuery(this).attr('id') ){

				}else{
					jQuery(this).removeClass('mm-current');
					jQuery(this).removeClass('mm-subopened');
					jQuery(this).removeClass('mm-opened');	
					jQuery(this).removeClass('mm-highest');	
					jQuery(this).addClass('mm-hidden');
				}				
			})
		}

		<?php if($viewtype == 0) { ?>
			if('mm-0' != jQuery(this).parent().parent().attr('id') ){
				//jQuery(this).parent().parent().removeClass('mm-current');
				//jQuery(this).parent().parent().addClass('mm-subopened');
			}
		<?php } ?>


		currentUl = jQuery(this).attr('href');
		
		jQuery(currentUl).removeClass('mm-hidden');				
		jQuery(currentUl).addClass('mm-current');
		
		jQuery(currentUl).animate(
			{width:'100%'},
			100,
			function() {
				jQuery(currentUl).addClass('mm-opened');											
		});
		return false;
		
	})

	jQuery('.mm-subclose').click(function(){
		jQuery(this).parent().parent().removeClass('mm-current');				
		id = jQuery(this).parent().parent().attr('id');

		jQuery('#'+id).removeAttr("style");
		jQuery('#'+id).css('top',tops);
		jQuery('#'+id).removeClass('mm-opened');				
		currentUl = jQuery(this).attr('href');
		jQuery(currentUl).addClass('mm-current');			
		jQuery(currentUl).removeClass('mm-subopened');

		setTimeout(function() { jQuery('#'+id).addClass('mm-hidden'); }, 500);

		/*jQuery('#'+id).animate(
			{left:'700px'},
			700,
			,
			function(){															
				jQuery('#'+id).removeAttr("style");
				jQuery('#'+id).css('top',tops);
				jQuery('#'+id).removeClass('mm-opened');
				jQuery('#'+id).addClass('mm-hidden');
				currentUl = jQuery(this).attr('href');
				jQuery(currentUl).addClass('mm-current');			
				jQuery(currentUl).removeClass('mm-subopened');
			}
	);	*/			
		return false;
	})

	function setView(){

		//if(jQuery( window ).width() > 980){
		if(jQuery( window ).width() > <?php echo $ipadPortrait ?>){	
			if(jQuery('#yt-off-resmenu').hasClass('mm-offcanvas') == false){				
				jQuery('#mobile_menu_hide').click();
			}			
			jQuery('#mobile_menu_show').hide();
			jQuery('#rain_main_ul').show();
			
		}else{
			jQuery('#rain_main_ul').hide();
			jQuery('#mobile_menu_show').show();
		}

	}

	<?php if($viewtype == 1) { ?>
	function defaultOpen(){
		fistTab = jQuery('#mm-0');
		
		jQuery('.mm-list').each(function(){			
			jQuery(this).removeClass('mm-current');
			jQuery(this).removeClass('mm-subopened');
			jQuery(this).removeClass('mm-opened');	
			jQuery(this).removeClass('mm-highest');	
			jQuery(this).addClass('mm-hidden');							
		})
				
		currentUl = fistTab;//jQuery(fistTab).attr('href');
		jQuery(currentUl).addClass('mm-current');	
		jQuery(currentUl).addClass('mm-opened');
		jQuery(currentUl).removeClass('mm-hidden');
		jQuery('.mm-menu > .mm-panel').css('top','40px');	
		tops = 40;	

	}
	<?php }else{ ?>
	function defaultOpen(){

		fistTab = jQuery('#mm-0');
		
		jQuery('.mm-list').each(function(){		
			jQuery(this).removeClass('mm-current');
			jQuery(this).removeClass('mm-subopened');
			jQuery(this).removeClass('mm-opened');	
			jQuery(this).removeClass('mm-highest');	
			jQuery(this).addClass('mm-hidden');							
		})
				
		currentUl = fistTab;//jQuery(fistTab).attr('href');
		jQuery(currentUl).addClass('mm-current');	
		jQuery(currentUl).addClass('mm-opened');
		jQuery(currentUl).removeClass('mm-hidden');

		currentUl = jQuery('#mm-1');
		jQuery(currentUl).addClass('mm-current');	
		jQuery(currentUl).addClass('mm-opened');
		jQuery(currentUl).removeClass('mm-hidden');
				
		aa = jQuery( window ).width();
		if( ((aa*diff)/100) > leftSlide )
			aa=leftSlide;
		else
			aa=parseInt((aa*diff)/100);

		divWidth = jQuery('#yt-off-resmenu').width();
		totalWidth = 0;
		liHeight = 0;
		jQuery('#mm-0 li').each(function(){			
			totalWidth  = totalWidth+jQuery(this).width();
			liHeight = jQuery(this).height();
		});

		row = totalWidth/divWidth;
		row = parseInt(row)+1;
		tops = (row * liHeight)+40;		
		jQuery('.mm-menu > .mm-panel').css('top',tops+'px');
		
	}	
<?php } ?>

<?php
if(1 == $params->get('menu_position')){ ?>
	jQuery('#rd_menu').addClass('width90');
	jQuery('#sticky_menu').addClass('sticky_top');
	jQuery('#sticky_menu').appendTo('body');
<?php 
}else if(2 == $params->get('menu_position')){ ?>
	jQuery('#rd_menu').addClass('width90');
	jQuery('#sticky_menu').addClass('sticky_bottom');
	jQuery('#sticky_menu').appendTo('body');
<?php 
}
?>
</script>

<style>
<?php
if($viewtype == 0) {/* ?>
	.mm-menu > .mm-panel{
    	top:130px;
	}
<?php */} ?>
</style>