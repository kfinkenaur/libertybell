jQuery(document).ready(function() {
	var uploadID = ''; /*setup the var*/
	
	jQuery(function() {			
		
		jQuery('#wps_seo_booster_upload_button').live('click',function(e) {
			e.preventDefault();
			var post_id = jQuery('#wps_seo_booster_upload_button').attr('rel');  // get post ID
			uploadID = jQuery(this).prev('input'); //grab the specific input
	 		window.imgfield = jQuery('#wps_seo_booster_upload_image').attr('name');
			tb_show('', 'media-upload.php?post_id='+ post_id +'&amp;type=image&amp;TB_iframe=true');
	 	
				window.original_send_to_editor = window.send_to_editor;
				window.send_to_editor = function(html) {
					if(window.imgfield) {
						imgurl = jQuery('img',html).attr('src');
						uploadID.val(imgurl); //assign the value to the input
						tb_remove();
					} else {
				        window.original_send_to_editor(html);
				    }
				   window.send_to_editor = window.original_send_to_editor; //send original editor content back to main editor
				}
			return false;
		});	
	});
});

jQuery(document).ready(function() {
	// tab between them
	jQuery('.metabox-tabs li a').each(function(i) {
		var thisTab = jQuery(this).parent().attr('class').replace(/active /, '');

		if ( 'active' != jQuery(this).attr('class') )
			jQuery('div.' + thisTab).hide();

		jQuery('div.' + thisTab).addClass('tab-content');
 
		jQuery(this).click(function(){
			// hide all child content
			jQuery(this).parent().parent().parent().children('div').hide();
 
			// remove all active tabs
			jQuery(this).parent().parent('ul').find('li.active').removeClass('active');
 
			// show selected content
			jQuery(this).parent().parent().parent().find('div.'+thisTab).show();
			jQuery(this).parent().parent().parent().find('li.'+thisTab).addClass('active');
		});
	});

	jQuery('.heading').hide();
	jQuery('.metabox-tabs').show();
	
	/******* Added for rating Start *******/	
	jQuery('#wps_seo_booster_flush_rating').click(function(){
		jQuery('#wps_seo_booster_flush_message').html('');
		jQuery('#wps_seo_meta_loader').show();
		var data = {
				action: 'flush_rating',
				id: jQuery('#wps_seo_booster_flush_rating').attr('rel')
			};
			
		jQuery.post(ajaxurl, data, function(response) {
			jQuery('#wps_seo_meta_loader').hide();
			if(response == "success") {
				jQuery('#wps_seo_booster_flush_message').html('<strong>Rating have been flushed.</strong>');
			}
			
		});
		
	});
	/******* Added for rating End *******/	
	
	if(jQuery('#wps_seo_booster_unique').val() == '1') {
		jQuery('#wps_seo_booster_unique_base').removeClass('wps-seo-booster-hidden-controls');
	} else {
		jQuery('#wps_seo_booster_unique_base').addClass('wps-seo-booster-hidden-controls');
	}		
	
	jQuery('#wps_seo_booster_unique').live('change' ,function() {
		if(jQuery(this).val() == '1') {
			jQuery('#wps_seo_booster_unique_base').removeClass('wps-seo-booster-hidden-controls');
		} else {
			jQuery('#wps_seo_booster_unique_base').addClass('wps-seo-booster-hidden-controls');
		}
	});
	
	/********* Added for repeating group ingredients Start *************/
	jQuery('.wps_seo_booster_recipe_ingredients_add_more').live('click',function() {
	
		jQuery('table.wps_seo_booster_repeat_ingredients_table .wps_seo_booster_repeat_ingredients_tr:last').after('<tr class="wps_seo_booster_repeat_ingredients_tr" id="wps_seo_booster_repeat_ingredients_tr_0">\
				<td>\
					<input type="text" class="wps_seo_booster_recipe_ingredients_amount" name="wps_seo_booster_recipe_ingredients_amount[]" id="wps_seo_booster_recipe_ingredients_amount"  size="10" value="" />\
				</td>\
				<td>\
					<input type="text" class="wps_seo_booster_recipe_ingredients_size" name="wps_seo_booster_recipe_ingredients_size[]" id="wps_seo_booster_recipe_ingredients_size"  size="20" value="" />\
				</td>\
				<td>\
					<input type="text" class="wps_seo_booster_recipe_ingredients" name="wps_seo_booster_recipe_ingredients[]" id="wps_seo_booster_recipe_ingredients" size="40" value="" />\
				</td>\
				<td>\
					<img class="wps_seo_booster_recipe_ingredients_minus" src="'+wps_seo_booster_obj.url+'includes/images/minus.png" alt="delete" />\
				</td>\
			</tr>');
	});
	jQuery('.wps_seo_booster_recipe_ingredients_minus').live('click',function() {
		//removing ingredients fields row
		jQuery(this).parent().parent().remove();
	});
	/********* Added for repeating group ingredients End *************/
	
	/********* Added for repeating group directions Start *************/
	jQuery('.wps_seo_booster_recipe_directions_add_more').live('click',function() {
	
		jQuery('table.wps_seo_booster_repeat_directions_table .wps_seo_booster_repeat_directions_tr:last').after('<tr class="wps_seo_booster_repeat_directions_tr" id="wps_seo_booster_repeat_directions_tr_0">\
				<td>\
					<textarea id="wps_seo_booster_recipe_ingredients_directions" name="wps_seo_booster_recipe_ingredients_directions[]" class="wps_seo_booster_recipe_ingredients_directions" cols="60" rows="4"></textarea>\
				</td>\
				<td>\
					<img class="wps_seo_booster_recipe_directions_minus" src="'+wps_seo_booster_obj.url+'includes/images/minus.png" alt="delete" />\
				</td>\
			</tr>');
	});
	jQuery('.wps_seo_booster_recipe_directions_minus').live('click',function() {
		//removing directions textarea
		jQuery(this).parent().parent().remove();
	});
	/********* Added for repeating group directions End *************/
});