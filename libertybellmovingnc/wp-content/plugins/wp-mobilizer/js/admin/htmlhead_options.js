/* ----------------------------------- */
/**
 * @package WP-Mobilizer
 * @link http://www.wp-mobilizer.com
 * @copyright Copyright &copy; 2013, Kilukru Media
 * @version: 1.0.6
 */
/* ----------------------------------- */

/*jslint browser: true, devel: true, indent: 4, maxerr: 50, sub: true */
/*global jQuery, tb_show, tb_remove */

jQuery(document).ready(function ($) {
	'use strict';

	var formfield;

	/* Create Element to test */
	//var idBlockUpload = 'btn_upload_html';
	//$("body").append( '<div id="' + idBlockUpload + '" style="display:none;"></div>' );

	/**
	 * Element For Metaboxes Switch
	 */
	$(".mblzr_wrap .cb-enable").click(function(){
		var parent = $(this).parents('.switch');
		$('.cb-disable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', true);
	});
	$(".mblzr_wrap .cb-disable").click(function(){
		var parent = $(this).parents('.switch');
		$('.cb-enable',parent).removeClass('selected');
		$(this).addClass('selected');
		$('.checkbox',parent).attr('checked', false);
	});

	/**
	 * Elements for Radio Images
	 */
	$('.mblzr-radio-image').live('click', function() {
		$(this).closest('.type-radio-image').find('.mblzr-radio-image').removeClass('mblzr-radio-image-selected');
		$(this).toggleClass('mblzr-radio-image-selected');
		$(this).parent().find('.mblzr-radio').attr('checked', true);
	});


	/**
	 * Initialize timepicker (this will be moved inline in a future release)
	 */
	$('.mblzr_timepicker').each(function () {
		$('#' + jQuery(this).attr('id')).timePicker({
			startTime		: "00:00",
			endTime			: "23:59",
			show24Hours		: true,
			separator		: ':',
			step			: 30
		});
	});

	/**
	 * Initialize jQuery UI datepicker (this will be moved inline in a future release)
	 */
	$('.mblzr_datepicker').each(function () {
		$('#' + jQuery(this).attr('id')).datepicker();
		// $('#' + jQuery(this).attr('id')).datepicker({ dateFormat: 'yy-mm-dd' });
		// For more options see http://jqueryui.com/demos/datepicker/#option-dateFormat
	});
	// Wrap date picker in class to narrow the scope of jQuery UI CSS and prevent conflicts
	$("#ui-datepicker-div").wrap('<div class="mblzr_element" />');

	/**
	 * Initialize color picker
	 */
	if (typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function') {
		$('input:text.mblzr_colorpicker').wpColorPicker();
	} else {
		$('input:text.mblzr_colorpicker').each(function (i) {
			$(this).after('<div id="picker-' + i + '" style="z-index: 1000; background: #EEE; border: 1px solid #CCC; position: absolute; display: block;"></div>');
			$('#picker-' + i).hide().farbtastic($(this));
		})
		.focus(function () {
			$(this).next().show();
		})
		.blur(function () {
			$(this).next().hide();
		});
	}

	/**
	 * File and image upload handling
	 */
	 /*var custom_uploader;
	$('.btn_upload_button').click(function(e) {
		e.preventDefault();
		
		var relId = $( this ).attr('rel');
 
		//If the uploader object has already been created, reopen the dialog
		if (custom_uploader) {
			custom_uploader.open();
			return;
		}
 
		//Extend the wp.media object
		custom_uploader = wp.media.frames.file_frame = wp.media({
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		});
 
		//When a file is selected, grab the URL and set it as the text field's value
		custom_uploader.on('select', function() {
			attachment = custom_uploader.state().get('selection').first().toJSON();
			
			var itemurl = attachment.url;
			
			if( typeof(itemurl) != 'undefined' ){
				itemurl = itemurl.replace('http://' + location.hostname, '');
			}
		
			$( '#' + relId ).val(itemurl);
		});
 
		//Open the uploader dialog
		custom_uploader.open();
 
	});*/
	
	
	$('.mblzr_upload_file').change(function () {
		formfield = $(this).attr('id');
		$('#' + formfield + '_id').val("");
	});

	$('.mblzr_upload_button').live('click', function () {
		var buttonLabel;
		formfield = $(this).prev('input').attr('id');
		buttonLabel = 'Use as ' + $('label[for=' + formfield + ']').text();
		//tb_show('', 'media-upload.php?post_id=' + $('#post_ID').val() + '&type=file&mblzr_force_send=true&mblzr_send_label=' + buttonLabel + '&TB_iframe=true');
		tb_show('', 'media-upload.php?type=file&mblzr_force_send=true&mblzr_send_label=' + buttonLabel + '&TB_iframe=true');
		return false;
	});

	$('.mblzr_remove_file_button').live('click', function () {
		formfield = $(this).attr('rel');
		$('input#' + formfield).val('');
		$('input#' + formfield + '_id').val('');
		$(this).parent().remove();
		return false;
	});

	window.original_send_to_editor = window.send_to_editor;
	window.send_to_editor = function (html) {
		var itemurl, itemclass, itemClassBits, itemid, htmlBits, itemtitle,
			image, uploadStatus = true;

		if (formfield) {

			if ($(html).html(html).find('img').length > 0) {
				itemurl = $(html).html(html).find('img').attr('src'); // Use the URL to the size selected.
				itemclass = $(html).html(html).find('img').attr('class'); // Extract the ID from the returned class name.
				itemClassBits = itemclass.split(" ");
				itemid = itemClassBits[itemClassBits.length - 1];
				itemid = itemid.replace('wp-image-', '');
			} else {
				// It's not an image. Get the URL to the file instead.
				htmlBits = html.split("'"); // jQuery seems to strip out XHTML when assigning the string to an object. Use alternate method.
				itemurl = htmlBits[1]; // Use the URL to the file.
				itemtitle = htmlBits[2];
				itemtitle = itemtitle.replace('>', '');
				itemtitle = itemtitle.replace('</a>', '');
				itemid = ""; // TO DO: Get ID for non-image attachments.
			}

			if( typeof(itemurl) != 'undefined' ){
				itemurl = itemurl.replace('http://' + location.hostname, '');
			}

			image = /(jpe?g|jpg|png|gif|ico)$/gi;

			if ( itemurl.match(image) ) {
				uploadStatus = '';
				uploadStatus += '<div class="img_status">';
					uploadStatus += '<img style="max-width:600px;height:auto;" src="' + itemurl + '" alt="" />';
					uploadStatus += '<div class="clear"></div>';
					uploadStatus += '<a href="#" class="mblzr_remove_file_button" rel="' + formfield + '">Remove Image</a>';
				uploadStatus += '</div>';
			} else {
				// No output preview if it's not an image
				// Standard generic output if it's not an image.
				html = '<a href="' + itemurl + '" target="_blank" rel="external">View File</a>';
				uploadStatus = '<div class="no_image"><span class="file_link">' + html + '</span>&nbsp;&nbsp;&nbsp;<a href="#" class="mblzr_remove_file_button" rel="' + formfield + '">Remove</a></div>';
			}

			$('#' + formfield).val(itemurl);
			$('#' + formfield + '_id').val(itemid);
			$('#' + formfield).siblings('.mblzr_media_status').slideDown().html(uploadStatus);
			tb_remove();

		} else {
			window.original_send_to_editor(html);
		}

		formfield = '';
	};

	/**
	 * Ajax oEmbed display
	 */

	// ajax on paste
	$('.mblzr_oembed').bind('paste', function (e) {
		var pasteitem = $(this);
		// paste event is fired before the value is filled, so wait a bit
		setTimeout(function () {
			// fire our ajax function
			doCMBajax(pasteitem, 'paste');
		}, 100);
	}).blur(function () {
		// when leaving the input
		setTimeout(function () {
			// if it's been 2 seconds, hide our spinner
			$('.postbox table.mblzr_metabox .mblzr-spinner').hide();
		}, 2000);
	});

	// ajax when typing
	$('.mblzr_metabox').on('keyup', '.mblzr_oembed', function (event) {
		// fire our ajax function
		doCMBajax($(this), event);
	});

	// function for running our ajax
	function doCMBajax(obj, e) {
		// get typed value
		var oembed_url = obj.val();
		// only proceed if the field contains more than 6 characters
		if (oembed_url.length < 6)
			return;

		// only proceed if the user has pasted, pressed a number, letter, or whitelisted characters
		if (e === 'paste' || e.which <= 90 && e.which >= 48 || e.which >= 96 && e.which <= 111 || e.which == 8 || e.which == 9 || e.which == 187 || e.which == 190) {

			// get field id
			var field_id = obj.attr('id');
			// get our inputs context for pinpointing
			var context = obj.parents('.mblzr_metabox tr td');
			// show our spinner
			$('.mblzr-spinner', context).show();
			// clear out previous results
			$('.embed_wrap', context).html('');
			// and run our ajax function
			setTimeout(function () {
				// if they haven't typed in 500 ms
				if( $('.mblzr_oembed:focus').val() == oembed_url ){

					alert( window.ajaxurl );

					$.post(
						window.ajaxurl,{

							'action'				: 'mblzr_oembed_handler',
							'oembed_url'			: oembed_url,
							'field_id'				: field_id,
							//'post_id'				: window.mblzr_ajax_data.post_id,
							'mblzr_ajax_nonce'		: window.mblzr_ajax_data.ajax_nonce

						},function(data) {
							// if we have a response id
							if (typeof data.id !== 'undefined') {
								// hide our spinner
								$('.mblzr-spinner', context).hide();
								// and populate our results from ajax response
								$('.embed_wrap', context).html(data.result);
							}
						},
						'json'
					);
				}
			}, 500);
		}
	}

});