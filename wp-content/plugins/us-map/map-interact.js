﻿// Quick feature detection
function isTouchEnabled() {
 	return (('ontouchstart' in window)
      	|| (navigator.MaxTouchPoints > 0)
      	|| (navigator.msMaxTouchPoints > 0));
}
jQuery(function(){addEvent('st_1');addEvent('st_2');addEvent('st_3');addEvent('st_4');addEvent('st_5');addEvent('st_6');addEvent('st_7');addEvent('st_8');addEvent('st_9');addEvent('st_10');addEvent('st_11');addEvent('st_12');addEvent('st_13');addEvent('st_14');addEvent('st_15');addEvent('st_16');addEvent('st_17');addEvent('st_18');addEvent('st_19');addEvent('st_20');addEvent('st_21');addEvent('st_22');addEvent('st_23');addEvent('st_24');addEvent('st_25');addEvent('st_26');addEvent('st_27');addEvent('st_28');addEvent('st_29');addEvent('st_30');addEvent('st_31');addEvent('st_32');addEvent('st_33');addEvent('st_34');addEvent('st_35');addEvent('st_36');addEvent('st_37');addEvent('st_38');addEvent('st_39');addEvent('st_40');addEvent('st_41');addEvent('st_42');addEvent('st_43');addEvent('st_44');addEvent('st_45');addEvent('st_46');addEvent('st_47');addEvent('st_48');addEvent('st_49');addEvent('st_50');addEvent('st_51');})
jQuery(function(){
	jQuery('#lakes').find('path').attr({'fill':st_config['default']['lakesfill']}).css({'stroke':st_config['default']['lakesoutline']});
	jQuery('#mapshadow').find('path').attr({'fill':st_config['default']['shadowcolor']});
});

function addEvent(id,relationId){
	var _obj = jQuery('#'+id);
	var _Textobj = jQuery('#'+id+','+'#'+st_config[id]['iso']);
	var _h = jQuery('#map').height();

	jQuery('#'+['text-abb']).attr({'fill':st_config['default']['namescolor']});

		_obj.attr({'fill':st_config[id]['upcolor'],'stroke':st_config['default']['bordercolor']});
		_Textobj.attr({'cursor':'default'});
		if(st_config[id]['enable'] == true){
			if (isTouchEnabled()) {
				_Textobj.on('touchstart', function(e){
					var touch = e.originalEvent.touches[0];
					var x=touch.pageX-10, y=touch.pageY+(-15);
					var maptipw=jQuery('#map-tip-us').outerWidth(), maptiph=jQuery('#map-tip-us').outerHeight(), 
					x=(x+maptipw>jQuery(document).scrollLeft()+jQuery(window).width())? x-maptipw-(20*2) : x
					y=(y+maptiph>jQuery(document).scrollTop()+jQuery(window).height())? jQuery(document).scrollTop()+jQuery(window).height()-maptiph-10 : y
					if(st_config[id]['target'] != 'none'){
						jQuery('#'+id).css({'fill':st_config[id]['downcolor']});
					}
					jQuery('#map-tip-us').show().html(st_config[id]['hover']);
					jQuery('#map-tip-us').css({left:x, top:y})
				})
				_Textobj.on('touchend', function(){
					jQuery('#'+id).css({'fill':st_config[id]['upcolor']});
					if(st_config[id]['target'] == '_blank'){
						window.open(st_config[id]['url']);	
					}else if(st_config[id]['target'] == '_self'){
						window.parent.location.href=st_config[id]['url'];
					}
					jQuery('#map-tip-us').hide();
				})
			}
			_Textobj.attr({'cursor':'pointer'});
			_Textobj.hover(function(){
				//moving in/out effect
				jQuery('#map-tip-us').show().html(st_config[id]['hover']);
				_obj.css({'fill':st_config[id]['overcolor']})
			},function(){
				jQuery('#map-tip-us').hide();
				jQuery('#'+id).css({'fill':st_config[id]['upcolor']});
			})
			if(st_config[id]['target'] != 'none'){
				//clicking effect
				_Textobj.mousedown(function(){
					jQuery('#'+id).css({'fill':st_config[id]['downcolor']});
				})
			}
			_Textobj.mouseup(function(){
				jQuery('#'+id).css({'fill':st_config[id]['overcolor']});
				if(st_config[id]['target'] == '_blank'){
					window.open(st_config[id]['url']);	
				}else if(st_config[id]['target'] == '_self'){
					window.parent.location.href=st_config[id]['url'];
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