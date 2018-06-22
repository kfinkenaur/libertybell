﻿// Quick feature detection
function isTouchEnabled() {
 	return (('ontouchstart' in window)
      	|| (navigator.MaxTouchPoints > 0)
      	|| (navigator.msMaxTouchPoints > 0));
}
jQuery(function(){addEvent('re_1');addEvent('re_2');addEvent('re_3');addEvent('re_4');addEvent('re_5');addEvent('re_6');addEvent('re_7');addEvent('re_8');addEvent('re_9');addEvent('re_10');})
jQuery(function(){
	jQuery('#lakes').find('path').attr({'fill':re_config['default']['lakesfill']}).css({'stroke':re_config['default']['lakesoutline']});
	jQuery('#mapshadow').find('path').attr({'fill':re_config['default']['shadowcolor']});
});

function addEvent(id,relationId){
	var _obj = jQuery('#'+id);
	var _Textobj = jQuery('#'+id+','+'#'+re_config[id]['reg']);
	var _h = jQuery('#map').height();

	jQuery('#'+['text-abb']).attr({'fill':re_config['default']['namescolor']});

		_obj.attr({'fill':re_config[id]['upcolor'],'stroke':re_config['default']['bordercolor']});
		_Textobj.attr({'cursor':'default'});
		if(re_config[id]['enable'] == true){
			if (isTouchEnabled()) {
				_Textobj.on('touchstart', function(e){
					var touch = e.originalEvent.touches[0];
					var x=touch.pageX-10, y=touch.pageY+(-15);
					var maptipw=jQuery('#map-tip-us').outerWidth(), maptiph=jQuery('#map-tip-us').outerHeight(), 
					x=(x+maptipw>jQuery(document).scrollLeft()+jQuery(window).width())? x-maptipw-(20*2) : x
					y=(y+maptiph>jQuery(document).scrollTop()+jQuery(window).height())? jQuery(document).scrollTop()+jQuery(window).height()-maptiph-10 : y
					if(re_config[id]['target'] != 'none'){
						jQuery('#'+id).css({'fill':re_config[id]['downcolor']});
					}
					jQuery('#map-tip-us').show().html(re_config[id]['hover']);
					jQuery('#map-tip-us').css({left:x, top:y})
				})
				_Textobj.on('touchend', function(){
					jQuery('#'+id).css({'fill':re_config[id]['upcolor']});
					if(re_config[id]['target'] == '_blank'){
						window.open(re_config[id]['url']);	
					}else if(re_config[id]['target'] == '_self'){
						window.parent.location.href=re_config[id]['url'];
					}
					jQuery('#map-tip-us').hide();
				})
			}
			_Textobj.attr({'cursor':'pointer'});
			_Textobj.hover(function(){
				//moving in/out effect
				jQuery('#map-tip-us').show().html(re_config[id]['hover']);
				_obj.css({'fill':re_config[id]['overcolor']})
			},function(){
				jQuery('#map-tip-us').hide();
				jQuery('#'+id).css({'fill':re_config[id]['upcolor']});
			})
			if(re_config[id]['target'] != 'none'){
				//clicking effect
				_Textobj.mousedown(function(){
					jQuery('#'+id).css({'fill':re_config[id]['downcolor']});
				})
			}
			_Textobj.mouseup(function(){
				jQuery('#'+id).css({'fill':re_config[id]['overcolor']});
				if(re_config[id]['target'] == '_blank'){
					window.open(re_config[id]['url']);	
				}else if(re_config[id]['target'] == '_self'){
					window.parent.location.href=re_config[id]['url'];
				}
			})
			_Textobj.mousemove(function(e){
				var x=e.pageX+10, y=e.pageY+15;
				var maptipw=jQuery('#map-tip-us').outerWidth(), maptiph=jQuery('#map-tip-us').outerHeight(), 
				x=(x+maptipw>jQuery(document).scrollLeft()+jQuery(window).width())? x-maptipw-(20*2) : x
				y=(y+maptiph>jQuery(document).scrollTop()+jQuery(window).height())? jQuery(document).scrollTop()+jQuery(window).height()-maptiph-10 : y
				jQuery('#map-tip-us').css({left:x, top:y})
			})
		}	
}