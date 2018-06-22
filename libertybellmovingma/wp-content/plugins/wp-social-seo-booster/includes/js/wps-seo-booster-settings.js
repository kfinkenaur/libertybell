jQuery(document).ready(function() {
	var imgfield;
	jQuery(function() {			
			jQuery('#allways_image_btn').live('click',function() {
	 				imgfield = jQuery('#allways_image');
					tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	 			return false;
			});
			jQuery('#default_image_btn').live('click',function() {
	 				imgfield = jQuery('#default_image');
					tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	 			return false;
			});
			window.send_to_editor = function(html) {					
				mediaurl = jQuery('img',html).attr('src');	 					
	 			imgfield.val(mediaurl);
	 			tb_remove();
			}				
	});
});
jQuery(document).ready( function(){	
	if(jQuery('#wps_seo_booster_unique_rating').is(':checked')) {
		jQuery('#wps_seo_booster_unique_base_rating').removeClass('wps-seo-booster-hidden-controls');
	} else {
		jQuery('#wps_seo_booster_unique_base_rating').addClass('wps-seo-booster-hidden-controls');
	}

	jQuery('.wps_seo_booster_all_posts').live('click' ,function() {
		var post_name = jQuery(this).attr('value');
		var i = 0;
		if(jQuery(this).is(':checked')) {
			jQuery('#wps_seo_booster_indivisual_datacontent_'+post_name+' input').each(function() {
				jQuery(this).attr('checked',true);
				i++;
			});
			i--;
		} else {
			jQuery('#wps_seo_booster_indivisual_datacontent_'+post_name+' input').each(function() {
				jQuery(this).attr('checked',false);
				i++;
			});
			i = 0;
		}
		jQuery('#wps_seo_booster_selected_indivisual_'+post_name).text('( '+(i)+' ) Selected');
	});
	
	jQuery('#wps_seo_booster_set_submit').live('click' ,function() {
		var flag = false;
		var selected_id = '';
		jQuery('.wps_seo_booster_indivisual_entries_data input').each(function() {
			if(jQuery(this).is(':checked')) {
				flag = true;
				selected_id += jQuery(this).attr('value') + ',';
			} 
		});
		if(!flag) {
			jQuery('#wps_seo_booster_flush_message').addClass('wps-seo-booster-message');
			jQuery('#wps_seo_booster_flush_message').html("<strong>Please select atleast 1 post or page.</strong>");
		} else {
			jQuery('#wps_seo_booster_flush_message').html('');
			jQuery('#wps_seo_rate_loader').addClass('wps_seo_rating_loader');
			var data = {
							action: 'selected_flush_rating',
							id: selected_id
						};
					
			jQuery.post(ajaxurl, data, function(response) {
				jQuery('#wps_seo_rate_loader').removeClass('wps_seo_rating_loader');
				if(response == "success" ) {
					jQuery('#wps_seo_booster_flush_message').removeClass('wps-seo-booster-message');
					jQuery('#wps_seo_booster_flush_message').html("<strong>Rating have been flushed.</strong>");
					
					jQuery('.wps-seo-booster-indvisual input').each(function() {
						jQuery(this).attr('checked',false);
						jQuery('.wps_seo_booster_label').text('( 0 ) Selected');
					});
				}
			});
		}
			
	});
	
	jQuery('#wps_seo_booster_unique_rating').live('click' ,function() {
		if(jQuery(this).is(':checked')) {
			jQuery('#wps_seo_booster_unique_base_rating').removeClass('wps-seo-booster-hidden-controls');
		} else {
			jQuery('#wps_seo_booster_unique_base_rating').addClass('wps-seo-booster-hidden-controls');
		}
	});	
	
	jQuery('.wps-seo-booster-close-button , .wps-seo-booster-overlay').live('click',function() {
		jQuery('.wps-seo-booster-overlay').hide();
		jQuery('.wps-seo-booster-whitecontent').hide();
	});

});

function wps_seo_booster_popup_indivisual(id) {
		jQuery('.wps-seo-booster-overlay').show();
		jQuery('#wps_seo_booster_indivisual_datacontent_'+id).show();
		wps_seo_booster_indivisual_entries_done(id);
	
}
function wps_seo_booster_indivisual_entries_done(id) {
	jQuery('#wps_seo_booster_set_submit_indivisual').live('click' ,function() {
		
		var i=0;
		jQuery('#wps_seo_booster_indivisual_datacontent_'+id+' input').each(function() {
			if(jQuery(this).is(':checked')) {
				i++;
			} 
		});
		jQuery('#wps_seo_booster_selected_indivisual_'+id).text('( '+i+' ) Selected');
		
		jQuery('.wps-seo-booster-whitecontent').hide();
		jQuery('.wps-seo-booster-overlay').hide();
		
		return false;
			
	});
}
function wps_seo_booster_checkall(id) {
	jQuery('#wps_seo_booster_indivisual_datacontent_'+id+' input').each( function() {
		jQuery(this).attr('checked',true);
		
	});
}
function wps_seo_booster_uncheckall(id) {
	jQuery('#wps_seo_booster_indivisual_datacontent_'+id+' input').each( function() {
		jQuery(this).attr('checked',false);
	});
}

function wps_seo_booster_rating_popup_indivisual(id) {
		jQuery('.wps-seo-booster-overlay').show();
		jQuery('#wps_seo_booster_rating_indivisual_datacontent_'+id).show();
		wps_seo_booster_rating_indivisual_entries_done(id);
	
}
function wps_seo_booster_rating_indivisual_entries_done(id) {
	jQuery('#wps_seo_booster_rating_set_submit_indivisual').live('click' ,function() {
		
		var i=0;
		jQuery('#wps_seo_booster_rating_indivisual_datacontent_'+id+' input').each(function() {
			if(jQuery(this).is(':checked')) {
				i++;
			} 
		});
		jQuery('#wps_seo_booster_rating_selected_indivisual_'+id).text('( '+i+' ) Selected');
		
		jQuery('.wps-seo-booster-whitecontent').hide();
		jQuery('.wps-seo-booster-overlay').hide();
		
		return false;
			
	});
}
function wps_seo_booster_rating_checkall(id) {
	jQuery('#wps_seo_booster_rating_indivisual_datacontent_'+id+' input').each( function() {
		jQuery(this).attr('checked',true);
		
	});
}
function wps_seo_booster_rating_uncheckall(id) {
	jQuery('#wps_seo_booster_rating_indivisual_datacontent_'+id+' input').each( function() {
		jQuery(this).attr('checked',false);
	});
}

//code for tabs
jQuery(document).ready(function($) {	
	jQuery(".nav-tab-wrapper a:first").addClass("nav-tab-active");
	jQuery(".wps-seo-content div:first").show();
	
//  When user clicks on tab, this code will be executed
    jQuery(".nav-tab-wrapper a").live('click',function() {
        //  First remove class "active" from currently active tab
        jQuery(".nav-tab-wrapper a").removeClass('nav-tab-active');
 
        //  Now add class "active" to the selected/clicked tab
        jQuery(this).addClass("nav-tab-active");
 
        //  Hide all tab content
        jQuery(".wps-seo-tab-content").hide();
 
        //  Here we get the href value of the selected tab
        var selected_tab = $(this).attr("href");
 
        //  Show the selected tab content
        jQuery(selected_tab).show();
 
        //  At the end, we add return false so that the click on the link is not executed
        return false;
    });	
	
});