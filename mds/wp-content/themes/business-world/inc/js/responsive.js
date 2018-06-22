var window_cur_size = 'screen';

jQuery('document').ready(function(){
//var previus_view=document.getElementById('top_posts_web').innerHTML;
	screenSize=jQuery(".container").width();
	jQuery('.cont_vat_tab ul.content > li').filter(function() { return jQuery(this).css("display")!='none'}).addClass('active');
	jQuery('#wd-categories-tabs > .tabs > li').eq(0).addClass('active');
	sliderHeight=parseInt(jQuery("#slider-wrapper").height());
	sliderWidth=parseInt(jQuery("#slider-wrapper").width());
	sliderIndex=sliderHeight/sliderWidth;

	if(jQuery(".container").hasClass("phone")){
		phone();		
	}
	else if(jQuery(".container").hasClass("tablet")){
		tablet();
	}
	else{checkMedia();}
	
	var window_width = jQuery(window).width();
	jQuery(window).resize(function(){
	  //if(window_width>jQuery(window).width()) {
	   checkMedia();
	 // }
	});
	
	


	function checkMedia(){
		//###############################SCREEN
		if(jQuery('body').width()>=screenSize){screen();}
		//###############################TABLET
		if(jQuery('body').width()<screenSize && jQuery('body').width()>=768){tablet();}
		//################################PHONE
		if(jQuery('body').width()<768){phone(false);}

	}

	function screen(){
	    slider.install('top-posts-list');
		jQuery(".container").width(screenSize);
		jQuery(".container,#footer, #top-posts, #top-posts-list").removeClass("tablet");
		jQuery(".container,#footer, #top-posts, #top-posts-list").removeClass("phone");
		
		jQuery("#blog,.blog,#top-posts .container,#header-top + .container").removeAttr("style");
		jQuery('.container>#blog').before(jQuery('#sidebar1'));
		jQuery("#header .phone-menu-block").removeClass("container");
		jQuery(".container").width(jQuery("body").attr("screen-size"));
		jQuery("body > div, body header, body footer,#top-nav > div > ul,#top-nav > div > div > ul").not(".container").width("100%");
       // jQuery("#tabs_div").after(jQuery(".cont_horizontal_tab"));  
		sHeight=sliderIndex*parseInt(jQuery("#slider-wrapper").width());
		sliderSize(sHeight);	
		if(window_cur_size == 'phone'){
			jQuery("#header").find("#menu-button-block").remove();
			jQuery("#top-nav").css({"display":"block"});
			jQuery("#top-nav > div > ul  li.addedli,#top-nav > div > div > ul  li.addedli").remove();
			jQuery("#header-top .container").append(jQuery("#social"));
			jQuery("#header-middle").prepend(jQuery("#logo"));
			jQuery("aside .sidebar-container .widget-area").removeClass("clear");
			jQuery(".top-posts-block").width("100%");
			jQuery('#content').after(jQuery('#sidebar1'));
			jQuery("#top-nav .sub-menu").css("display","");
		}
		if(window_cur_size == 'tablet'){
			jQuery("#top-nav > div > ul  li.addedli,#top-nav > div > div > ul  li.addedli").remove();		
			jQuery("#top-nav .sub-menu").css("display","");	
		}
		jQuery('.cont_vat_tab ul.content').height(jQuery('.cont_vat_tab ul.content > li.active').filter(function() { return jQuery(this).css("display") != "none" }).height())
		inserting_div_float_problem(jQuery('#sidebar-footer'));
		jQuery("#top-posts-contents-nav").css({"display":"none"});
	  resize_iframes();
		window_cur_size	= 'screen';
	}
	
	function tablet(){	
	  slider.unbind(); 
		var str = (jQuery(window).width()/1024);	
		jQuery(".parallax-window").css("padding",business_world_options.wdwt_pinned_padding * str+"px 0");
		jQuery(".container,#footer, #top-posts, #top-posts-list").removeClass("phone");
		jQuery('#blog').after(jQuery('#sidebar1'));
		jQuery('.container>#content').after(jQuery('#content>#sidebar1'));
		
		jQuery("#header .phone-menu-block").removeClass("container");
		jQuery(".container,#footer, #top-posts, #top-posts-list").addClass("tablet");
		
		jQuery("#top-posts-list.tablet > li").click( 
        function(){
			if(!jQuery(this).find(".top-post-caption").hasClass("open")){
				jQuery(this).find(".top-post-caption").css({"height":"100%","background":"rgba(0,0,0,0.7)","opacity":"1","display":"block"});
				jQuery(this).find(".top-post-caption").addClass("open");
			}
			else{
				jQuery(this).find(".top-post-caption").css({"height":"0","background":"rgba(0,0,0,0.7)","opacity":"0","display":"none"});
				jQuery(this).find(".top-post-caption").removeClass("open");
			}
		});
		jQuery(".container").width(768);		
		jQuery(".tablet #blog,.tablet .blog,#top-posts .container.tablet,#header-top + .container.tablet").width(758);
	//	jQuery(".phone #tabs_div").after(jQuery(".cont_horizontal_tab"));
		if(window_cur_size == 'phone'){
			jQuery("#header").find("#menu-button-block").remove();
			jQuery("#top-nav").css({"display":"block"});
			jQuery("#top-nav > div > ul  li.addedli,#top-nav > div > div > ul  li.addedli").remove();
			
			jQuery("#header-top .container").append(jQuery("#social"));
			jQuery("#header-middle").prepend(jQuery("#logo"));
			jQuery("aside .sidebar-container .widget-area").removeClass("clear");
			jQuery(".top-posts-block").width("100%");
		}
		jQuery("#top-nav > div > ul  li.addedli,.tablet #top-nav > div > div > ul  li.addedli").remove();
		jQuery(".tablet #top-nav > div > ul  li:has(> ul),.tablet #top-nav > div > div > ul  li:has(> ul)").each(function(){
				var strtext=jQuery(this).children("a").html();
				var strhref=jQuery(this).children("a").attr("href");
				var strlink='<a href="'+strhref+'">'+strtext+'</a>';
				jQuery(this).children("ul").prepend('<li class="addedli">'+strlink+'</li>');
		});
		jQuery('.cont_vat_tab ul.content').height(jQuery('.cont_vat_tab ul.content > li.active').filter(function() { return jQuery(this).css("display") != "none" }).height())
		
		sHeight=sliderIndex*parseInt(jQuery("#slider-wrapper").width());
		sliderSize(sHeight);
    resize_iframes();
		window_cur_size	= 'tablet';
	}
	
	function phone(full){
	    slider.unbind();
		var str = (jQuery(window).width()/1024);	
		jQuery(".parallax-window").css("padding",business_world_options.wdwt_pinned_padding * str+"px 0");
		jQuery("#header .phone-menu-block").addClass("container");
		jQuery(".container,#footer, #top-posts, #top-posts-list").removeClass("tablet");
		jQuery(".container,#footer, #top-posts, #top-posts-list").addClass("phone");
		jQuery('.container>#content').after(jQuery('.container>#sidebar1'));
		jQuery('#blog').after(jQuery('#sidebar1'));
		if(jQuery('body').width()>320 && jQuery('body').width()<640){width="99%";}else if(jQuery('body').width()<=320){width="99%";}else{width="640px";}
		jQuery(".container").width(width);
		jQuery(".phone .featured-content .single-post-text").after(jQuery(".phone .featured-content img"));
		sHeight=sliderIndex*parseInt(jQuery("#slider-wrapper").width());
		sliderSize(sHeight);
		
		jQuery("#top-posts-list.phone > li").click( 
        function(){
			if(!jQuery(this).find(".top-post-caption").hasClass("open")){
				jQuery(this).find(".top-post-caption").css({"height":"100%","background":"rgba(0,0,0,0.7)","opacity":"1","display":"block"});
				jQuery(this).find(".top-post-caption").addClass("open");
			}
			else{
				jQuery(this).find(".top-post-caption").css({"height":"0","background":"rgba(0,0,0,0.7)","opacity":"0","display":"none"});
				jQuery(this).find(".top-post-caption").removeClass("open");
			}
		});
		//### PHONE UNIQUE STYLES
		
		
	//	jQuery(".cont_horizontal_tab").after(jQuery(".phone #tabs_div"))
		
		
		jQuery("#top-nav > div > ul  li.addedli,.phone #top-nav > div > div > ul  li.addedli").remove();
		jQuery(".phone #top-nav > div > ul  li:has(> ul),.phone #top-nav > div > div > ul  li:has(> ul)").each(function(){
				var strtext=jQuery(this).children("a").html();
				var strhref=jQuery(this).children("a").attr("href");
				var strlink='<a href="'+strhref+'">'+strtext+'</a>';
				jQuery(this).children("ul").prepend('<li class="addedli">'+strlink+'</li>');
		});
		if(window_cur_size != 'phone'){
			
			jQuery("#header-top .container").prepend(jQuery("#logo"));
		}
		
		for(var i=0;i<jQuery(".phone aside .sidebar-container .widget-area").length;i++){
			if (i%2 == 0){jQuery(".phone aside .sidebar-container .widget-area").eq(i).addClass("clear");}
		}
		
		
		jQuery("#header").find("#menu-button-block").remove();
		jQuery("#header .phone-menu-block").append('<div id="menu-button-block"><a href="#">Menu</a></div>');
		
		
		if(!jQuery("#top-nav").hasClass("open")){jQuery("#top-nav").css({"display":"none"})};
		jQuery('.cont_vat_tab ul.content').height(jQuery('.cont_vat_tab ul.content > li.active').filter(function() { return jQuery(this).css("display") != "none" }).height())
		window_cur_size	= 'phone';
		resize_iframes();
	}
	
	function resize_iframes(){

    var allVideos = jQuery("iframe, object, embed");

    allVideos.each(function() {

      var el = jQuery(this);
      fluidParent = el.parent();
      var newWidth = fluidParent.width();
        
      if(newWidth >= el.attr('data-origWidth')){
        newWidth = el.attr('data-origWidth');
      }
      el.width(newWidth)
        .height(newWidth * el.attr('data-aspectRatio'));

    });
  }
		
	function sliderSize(sHeight) {
		jQuery("#slider-wrapper").css('height',sHeight);
	}	
	function inserting_div_float_problem(main_div){
		jQuery(main_div).children('.clear:not(:last-child)').remove();
		var iner_elements=jQuery(main_div).children();
		var main_width=jQuery(main_div).width();
		var summary_width=0;
		for(i=0;i<iner_elements.length;i++){
			summary_width=summary_width+jQuery(iner_elements[i]).outerWidth();
			if(summary_width > main_width){
				jQuery(iner_elements[i]).before('<div class="clear"></div>')
				summary_width=jQuery(iner_elements[i]).outerWidth();
			}
		}
	}
	
});

