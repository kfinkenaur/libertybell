/* ***************************
  Star Ratings js - start
*************************** */

jQuery(document).ready( function($){
	$('.wps-seo-booster-star-ratings').starratings({
		'path' : star_ratings.path,
		'position' : star_ratings.pos
	});
});

(function( $ ){
   	
   $.fn.starratings = function( options ) {
	   
		settings = {
			'path' : null,
			'nonce' : null,
			'root' : null,
			'position' : 'top-left'
		};
		
		return this.each(function() {        
		
			if ( options ) { 
			  $.extend( settings, options );
			}
			
			var obj = this;
		
			if($.browser.msie)
			    $(obj).css({'background-color' : '#FFF' });
			//alert(settings.position);
			
			
			// ANIMATION
			
			$(".seo-booster-hover-panel > a", obj).mouseover( function() {
				  var obj = $(this).parent().parent();
				  if(obj.hasClass('open'))
				  {
					  $('.seo-booster-stars-turned-on', obj).stop(true, true);
					  $('.seo-booster-stars-turned-on', obj).hide();
					  $(this).addClass('seo-booster-hovered-rating');
					  var flag = true;
					  $(".seo-booster-hover-panel > a", obj).each( function(index) {
						  if(flag)
						  {
							  $(".seo-booster-hover-panel > a", obj).stop(true, true);
							  $(this).hide();
							  $(this).addClass('seo-booster-hovered-star')
							  $(this).fadeIn('slow');
						  }
						  if($(this).hasClass('seo-booster-hovered-rating')==true)
						  {
							  flag = false;
						  }
					  });
					  $(this).removeClass('seo-booster-hovered-rating');
				  }
			  });

			  $(".seo-booster-hover-panel > a", obj).mouseout( function() {
				    var obj = $(this).parent().parent();
					var stars = $(".seo-booster-hovered-star", obj).get();  
					for(var i = stars.length - 1; i >= 0; i--)
					{
					    $(".seo-booster-hovered-star", obj).stop(true, true);
					    $(".seo-booster-hovered-star:eq("+i+")", obj).fadeOut('fast', function() {
						    $(this).removeClass('seo-booster-hovered-star') ;
						    $(this).css({'display':'block'});
						});
					}
					$('.seo-booster-stars-turned-on', obj).fadeIn(1000);
			  });
            
			//var id = $("span:eq(0)",obj).html();
			var id = $("span:eq(0)",obj).attr('id');
			
			$(obj).addClass('open');
			
			var data = {
				action: 'get_data',
				id: id,
				op: 'get'
			};
			
			// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
			$.post(ajaxurl, data, function(response) {
				/*alert(response);*/
				var result = response.split('$##$');
				
				if(result[0] == '1')
		    	{
					var per = result[1];
				   	var legend = result[2];
				   	var open = result[3];
					var animation = result[4];
					var postId = result[5];
					
					if($.browser.opera) {
					  $('.seo-booster-stars-turned-on',obj).css({'width':per+'%'});
					} else {
						if(animation) {
							$('.seo-booster-stars-turned-on',obj).animate({
							   'width' : '0%'
							}, 'slow', function(){
							   $('.seo-booster-stars-turned-on',obj).animate({
								   'width' : per+'%'
							   }, 'slow');
							});
						} else {
							$('.seo-booster-stars-turned-on',obj).css({'width':per+'%'});
						}
					}
					//fill up the description below the stars for rating
					$('.seo-booster-casting-desc',obj).html(legend);
					
					if(open=='no') {
					   $(obj).removeClass('open');
					   $('.seo-booster-stars-turned-on',obj).addClass('seo-booster-stars-turned-strict');
					   $('#wps-seo-booster-'+postId+' a').hide();
					   
					} else {
					   $(obj).addClass('open');
					   $('.seo-booster-stars-turned-on',obj).removeClass('seo-booster-stars-turned-strict');
					   $('#wps-seo-booster-'+postId+' a').show();
					}
			   	}
			   	else
			   	{

			   	}
			});

				var busy = false;
				$(".seo-booster-hover-panel > a", obj).click( function() {
					  var obj = $(this).parent().parent();
					  var percentage = 0;
					  var flag = true;
					  if(obj.hasClass('open'))
					  {
						  var current = $(this);
						  var starsT = current.attr('rel');
						  var starsTT = starsT.split('-');
						  var stars = parseInt(starsTT[1]);
						  //var id = $("span:eq(0)",obj).text();
						  var id = $("span:eq(0)",obj).attr('id');
						  if(!busy)
						  {
					      busy = true;
					      
					      var data = {
								action: 'get_data',
								id: id,
								op: 'put',
								stars: stars
							};
							
							// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
							$.post(ajaxurl, data, function(response) {
								
								var result = response.split('$##$');
								
								if(result[0] == '1')
						    	{
									var per = result[1];
								   	var legend = result[2];
								   	var open = result[3];
								   	var animation = result[4];
									var postId = result[5];
								   	
									percentage = per;
									
									$('.seo-booster-casting-desc',obj).html(legend);
									
									if(open=='no')
									{
									   obj.removeClass('open');
									   $('.seo-booster-stars-turned-on',obj).addClass('seo-booster-stars-turned-strict');
									   $('#wps-seo-booster-'+postId+' a').hide();
									} 
									else
									{
									   obj.addClass('open');
									   $('.seo-booster-stars-turned-on',obj).removeClass('seo-booster-stars-turned-strict');
									   $('#wps-seo-booster-'+postId+' a').show();
									}
								}
								else
								{
									flag = false;
								}
								
								if(flag)
								{
								   obj.stop(true, true);
								   obj.fadeTo('slow',1, function(){
								   	   $(".seo-booster-casting-thanks",obj).html( Wps_Seo_Ratings.successmsg ); //show success message
								   	   $(".seo-booster-casting-thanks",obj).fadeIn('slow').delay(1000).fadeOut('slow', function(){
								   	   		$('.seo-booster-casting-desc',obj).fadeIn('slow');
								   	   		$(".seo-booster-casting-thanks",obj).html(''); //empty success message element
									   });
									   
									   if($.browser.opera)
										  $('.seo-booster-stars-turned-on',obj).css({'width':percentage+'%'});
									   else
									   {
										   if(animation) {
												$('.seo-booster-stars-turned-on',obj).animate({
												   'width' : '0%'
											   }, 'slow', function(){
												   $('.seo-booster-stars-turned-on',obj).animate({
													   'width' : percentage+'%'
												   }, 'slow');
											   });
											} else {
												$('.seo-booster-stars-turned-on',obj).css({'width':per+'%'});
											}
									   }
								   });
								} else {
									
								   obj.stop(true, true);
								   obj.fadeTo('slow',1, function(){
									   $(".seo-booster-casting-error",obj).fadeIn('slow').delay(1000).fadeOut('slow', function(){
										   $('.seo-booster-casting-desc',obj).fadeIn('slow'); 
									   });
								   });
								}
							});
						  }
					  }
					  return false;
				});
		});
   };
   
})( jQuery );

/* ***************************
  Star Ratings js - end
*************************** */