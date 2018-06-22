function SGRB(){
	'use strict';
	this.init();
	SGRB.sgrbRateTypeStar = 1;
	SGRB.sgrbRateTypePercent = 2;
	SGRB.sgrbRateTypePoint = 3;
	SGRB.tagIndex = 0;
};

function SGReview(){
};

SGRB.prototype.init = function(){
	var that = this;
	SGReview.prototype.isHidden();
	if (SGReview.prototype.getURLParameter('edit')) {
		jQuery('<div class="updated notice notice-success is-dismissible below-h2">' +
				'<p>Review updated.</p>' +
				'<button type="button" class="notice-dismiss" onclick="jQuery(\'.notice\').remove();"></button></div>').appendTo('.sgrb-top-bar h1');
	}

	jQuery('.sg-banner-close-js').click(function(){
		SGRB.ajaxCloseBanner();
	});

	jQuery('.sgrb-save-tables').click(function(){
		that.ajaxSaveFreeTables();
	});

	if (jQuery('#sgrbWooReviewShowTypeProduct').is(':checked')) {
		var productsToLoad = jQuery('input[name=productsToLoad]').val();
		var reviewId = jQuery('input[name=sgrb-id]').val();
		if (!reviewId) {
			reviewId = 0;
		}
		SGRB.ajaxWooProductLoad(0,reviewId,productsToLoad);
	}

	jQuery('.sgrb-tagcloud-link').click(function(){
		jQuery('.sgrb-tags-cloud').toggle();
	});

	jQuery('.sgrb-select-all-products').click(function(){
		jQuery('.sgrb-woo-product').prop('checked', this.checked);
	});

	jQuery('.sgrb-select-all-categories').click(function(){
		jQuery('.sgrb-selected-categories').prop('checked', this.checked);
	});

	jQuery('#wooReviewShowType').click(function(){
		jQuery('.sgrb-woo-products-wrapper').hide();
		jQuery('.sgrb-woo-products-select-all').hide();
		jQuery('.sgrb-woo-category-wrapper').show();
		jQuery('.sgrb-woo-categories-select-all').show();
	});

	jQuery('#sgrbWooReviewShowTypeProduct').click(function(){
		jQuery('.sgrb-woo-category-wrapper').hide();
		jQuery('.sgrb-woo-categories-select-all').hide();
		jQuery('.sgrb-woo-products-wrapper').show();
		jQuery('.sgrb-woo-products-select-all').show();

		if (jQuery('.sgrb-no-first-click').length < 1) {
			var productsToLoad = jQuery('input[name=productsToLoad]').val();
			var reviewId = jQuery('input[name=sgrb-id]').val();
			if (!reviewId) {
				reviewId = 0;
			}
			SGRB.ajaxWooProductLoad(0,reviewId,productsToLoad);
		}
	});

	jQuery('.sgrb-reviewId').each(function(){
		var reviewId = jQuery(this).val();
		var commentFormWrapper = jQuery('#sgrb-review-'+reviewId);
		commentFormWrapper.find('#sgrb-review-form-title').click(function(){
			commentFormWrapper.find('.sgrb-show-hide-comment-form').toggle(400);
			SGRB.prototype.ajaxUserRate(false, true);
		});
	});
	/*
	 * add tags
	*/
	jQuery('.sgrb-tagadd').click(function(){
		SGRB.prototype.setTags(false);
	});

	jQuery(document).ajaxComplete(function(){
		jQuery('.sgrb-common-wrapper').find('.sgrb-each-comment-rate').remove();
		jQuery('.sgrb-widget-wrapper').find('.sgrb-loading-spinner').hide();
		var formCommentTextColor = jQuery('.sgrb-rate-text-color');
		if (formCommentTextColor.length) {
			var contentTextColor = formCommentTextColor.val();
			if (contentTextColor) {
				jQuery('.sgrb-comment-text').attr('style','border-bottom:1px solid '+contentTextColor+'');
			}
		}
	});
	SGReview.prototype.checkRateClickedCount();
	/*
	 * additionally set the field's values equal to '' ;
	 */
	var tempPartWrapper = jQuery('.sgrb-template-part-wrapper');
	var fieldsArray = ['.sg-tempo-title',
						'.sg-tempo-title-second',
						'.sg-tempo-title-info',
						'.sg-tempo-by',
						'.sg-tempo-price',
						'.sg-tempo-shipping',
						'.sg-tempo-subtitle',
						'.sg-tempo-context'
					];

	for (var i=0;i<fieldsArray.length;i++) {
		if (tempPartWrapper.find(fieldsArray[i]).text().replace(/\s/g, "").length <= 0) {
			tempPartWrapper.find(fieldsArray[i]).text('');
		}
	}

   /*
	*/
	if (jQuery('.sgrb-show-tooltip').length) {
		var totalRateCout = jQuery('.sgrb-show-tooltip');
		var sgrbTooltip = jQuery('.sgrb-tooltip');

		totalRateCout.on('mouseenter', function(){
			sgrbTooltip.show(100);
		});
		totalRateCout.on('mouseleave', function(){
			sgrbTooltip.hide(100);
		});
	}
	if (jQuery('.sgrb-widget-wrapper').find('.sgrb-show-tooltip-widget').length) {
		var totalRateCoutw = jQuery('.sgrb-show-tooltip-widget');
		var sgrbTooltipw = jQuery('.sgrb-tooltip-widget');

		totalRateCoutw.on('mouseenter', function(){
			sgrbTooltipw.show();
		});
		totalRateCoutw.on('mouseleave', function(){
			sgrbTooltipw.hide();
		});
	}

	/* border:none; if template image-div has background-image */
	if (jQuery('.sgrb-image-review').length) {
		jQuery('.sgrb-image-review').each(function(){
			if (jQuery(this).attr('style') != 'background-image:url();') {
				jQuery(this).parent().attr('style', 'border:none;');
			}
		});
	}

	jQuery('.sgrb-custom-template-hilghlighting').next().click(function(){
		jQuery('.sgrb-custom-template-hilghlighting').attr('style','position:absolute;color:#3F3F3F;margin-left:10px;z-index:9');
		jQuery(this).prev().attr('style','position:absolute;color:#3F3F3F;margin:-4px;z-index:9');
		jQuery('.sgrb-template-label').find('.sgrb-highlighted').removeClass('sgrb-highlighted');
		jQuery(this).addClass('sgrb-highlighted');
	});

	if (jQuery('.sgrb-custom-template-hilghlighting').length) {
		jQuery('.sgrb-default-template-js').click(function(){
			jQuery('.sgrb-custom-template-hilghlighting').attr('style','position:absolute;color:#3F3F3F;margin-left:10px;z-index:9');
			jQuery('.sgrb-custom-template-hilghlighting').next().removeClass('sgrb-highlighted');
		});
	}

	if (jQuery('.sgrb-template-shadow-style').val()) {
		var shadowStyle = jQuery('.sgrb-template-shadow-style').val();
		jQuery('.sg-template-wrapper').find('.sg-tempo-title').attr('style', shadowStyle);
		jQuery('.sg-template-wrapper').find('.sg-tempo-image ').attr('style', shadowStyle);
		jQuery('.sg-template-wrapper').find('.sg-tempo-title-second ').attr('style', shadowStyle);
		jQuery('.sg-template-wrapper').find('.sg-tempo-title-info ').attr('style', shadowStyle);
		jQuery('.sg-template-wrapper').find('.sg-tempo-context').attr('style', shadowStyle);
	}
	SGRB.uploadImageButton();
	SGRB.removeImageButton();
	jQuery('.sgrb-reviewId').each(function(){
		var reviewId = jQuery(this).val();
		var sgrbMainWrapper = jQuery('#sgrb-review-'+reviewId);
		if (sgrbMainWrapper.find('.sgrb-captchaOn').val() == 1) {
			var captchaRegenerate = sgrbMainWrapper.find('.sgrb-captcha-text').val();
			jQuery('#sgrb-captcha-'+reviewId).realperson({
				regenerate: captchaRegenerate
			});
		}
		if (sgrbMainWrapper.find('.sgrb-approved-comments-to-show').length) {
			var commentsPerPage = parseInt(sgrbMainWrapper.find('.sgrb-comments-count').val());
			SGRB.ajaxPagination(1,0,commentsPerPage,reviewId);
		}
	});

	jQuery('.sgrb-read-more').on('click', function(){
		showHideComment('sgrb-read-more');
	});

	jQuery('.sgrb-hide-read-more').on('click', function(){
		showHideComment('sgrb-hide-read-more');
	});

	var currentFont = jQuery('.sgrb-current-font').val();
	if(currentFont) {
		SGReview.prototype.changeFont(currentFont);
	}

	if (!jQuery('.sgrb-total-rate-title').length) {
		jQuery('.sgrb-total-rate-wrapper').remove();
	}
	jQuery('.sgrb-google-search-checkbox').on('change', function(){
		var googleSearchOn = jQuery(this).prop("checked");
		if (!googleSearchOn) {
			jQuery('.sgrb-hide-google-preview').hide('slow');
			jQuery('.sgrb-google-search-box').attr('style', 'min-height:100px !important;');
		}
		else {
			jQuery('.sgrb-hide-google-preview').show('slow');
			jQuery('.sgrb-google-search-box').removeAttr('style');
		}
	});

	jQuery('.sgrb-email-hide-show-js').on('change', function(){
		var emailNotification = jQuery('.sgrb-email-notification');
		if (jQuery(this).is(':checked')) {
			var adminEmail = jQuery('.sgrb-admin-email').val();
			emailNotification.val(adminEmail);
		}
		else {
			emailNotification.val('');
		}
	});

	jQuery('.sgrb-js-update').on('click', function(){
		that.save();
	});

	jQuery('.sgrb-add-field').on('click', function(){
		that.clone();
	});

	jQuery('.sgrb-reset-options').on('click', function(){
		if (confirm('Are you sure?')) {
			jQuery('input[name=skin-color]').val('');
			jQuery('input[name=rate-text-color]').val('');
			jQuery('input[name=total-rate-background-color]').val('');
			jQuery('.wp-color-result').css('background-color','');
		}
	});

	jQuery('.sgrb-rate-type').on('change', function(){
		var value = jQuery(this).val();
		SGReview.prototype.changeType(value);
		SGReview.prototype.preview(value);
	});

	jQuery(function(){
		if(jQuery(".color-picker").length) {
			jQuery(".color-picker").wpColorPicker();
		}
	});

	var currentPreviewType = jQuery('.sgrb-rate-type:checked').val();
	SGReview.prototype.preview(currentPreviewType);

	var totalColorOptions = jQuery('.sgrb-total-color-options');

	jQuery('.sgrb-template-selector').on('click', function(){
		var reviewId = jQuery('input[name=sgrb-id]').val();
		var notAllow = false;
		var currentTemplate = jQuery('input[name=sgrb-template]').val();
		/* if it is post review */
		if (reviewId) {
			if (currentTemplate == 'post_review') {
				notAllow = 'Post';
			}
			if (currentTemplate == 'woo_review') {
				notAllow = 'WooCommerce';
			}
			if (notAllow) {
				alert(notAllow+' review cannot be changed to another type');
				return;
			}
		}
		var currentTemplateName = jQuery('input[name=sgrb-template]').val(),
			all = jQuery('#sgrb-template-name').text(),
			container = jQuery('#sgrb-template').dialog({
				width:875,
				height: 600,
				modal: true,
				resizable: false,
				buttons : {
					"Select template": function() {
						var tempName = jQuery('input[name=sgrb-template-radio]:checked').val();
						if (all != tempName) {
							if (confirm('When change the template, you\'ll lose your uploaded images and texts. Continue ?')) {
								if (tempName == 'post_review') {
									jQuery('.sgrb-main-template-wrapper').hide();
									jQuery('.sgrb-template-options-box').hide();
									jQuery('.sgrb-woo-template-wrapper').hide();
									jQuery('.sgrb-post-template-wrapper').show();
									jQuery('.sgrb-template-post-box').attr('style', 'min-height:150px;');
								}
								else if (tempName == 'woo_review') {
									jQuery('.sgrb-main-template-wrapper').hide();
									jQuery('.sgrb-template-options-box').hide();
									jQuery('.sgrb-post-template-wrapper').hide();
									jQuery('.sgrb-woo-template-wrapper').show();
									jQuery('.sgrb-template-post-box').attr('style', 'min-height:150px;');
									jQuery('input[name=wooReviewShowType]').each(function(){
										if (jQuery(this).is(':checked')) {
											var wooReviewShowType = jQuery(this).val();
											if (wooReviewShowType == 'showByProduct') {
												jQuery('.sgrb-woo-category-wrapper').hide();
												jQuery('.sgrb-woo-categories-select-all').hide();
												jQuery('.sgrb-woo-products-wrapper').show();
												jQuery('.sgrb-woo-products-select-all').show();

											}
											else if (wooReviewShowType == 'showByCategory') {
												jQuery('.sgrb-woo-products-wrapper').hide();
												jQuery('.sgrb-woo-products-select-all').hide();
												jQuery('.sgrb-woo-category-wrapper').show();
												jQuery('.sgrb-woo-categories-select-all').show();
											}
										}
									});
								}
								else {
									jQuery('.sgrb-main-template-wrapper').show();
									jQuery('.sgrb-template-options-box').show();
									jQuery('.sgrb-post-template-wrapper').hide();
									jQuery('.sgrb-woo-template-wrapper').hide();
									that.ajaxSelectTemplate(tempName);
								}
								jQuery('input[name=sgrb-template]').val(tempName);
								jQuery('#sgrb-template-name').html(tempName);
								jQuery(this).dialog('destroy');
							}
						}
						else {
							jQuery(this).dialog("close");
						}
					},
					Cancel: function() {
						jQuery(this).dialog("close");
					}
				}
			}),
			scrollTo = jQuery('input[name=sgrb-template-radio]:checked').parent();
			jQuery('input[name=sgrb-template-radio]').each(function(){
				if (jQuery(this).val() == all) {
					jQuery(this).parent().find('input').attr('checked','checked');
					scrollTo = jQuery(this).parent();
				}
			});
		if (scrollTo.length != 0) {
			if(typeof container.offset().top !== 'undefined') {
				container.animate({
					scrollTop: (scrollTo.offset().top - container.offset().top + container.scrollTop()) - 7
					/* Lowered to 7,because label has border and is highlighted (wip) */
				});
			}

		}
		else {
		/* Select template for the first time */
			var defaultTheme = jQuery('#TB_ajaxContent label:first-child'),
				res = jQuery(defaultTheme).find('input').attr('checked','checked');
		}


	});
	var defaultFont = jQuery('.sgrb-main-container .bfh-selectbox-option').text();
	if (defaultFont == '') {
		jQuery('.sgrb-main-container .bfh-selectbox-option').text('Current theme font');
	}
};

SGRB.prototype.setTags = function (hasTags) {
	var newTag = jQuery('.sgrb-newtag').val();
	if (hasTags) {
		newTag = hasTags;
	}
	var tagsArray = [];
	jQuery('.sgrb-new-tag-text').each(function(){
		var tagsString = jQuery(this).text();
		if (tagsString) {
			tagsArray.push(tagsString);
		}
	});
	if (newTag.replace(/\s/g, "").length <= 0) {
		jQuery('.sgrb-newtag').val('');
		jQuery('.sgrb-newtag').focus();
		return;
	}
	if (newTag != '') {
		var hasComma = newTag.search(',');
		if (hasComma > 0) {
			newTag = newTag.split(',');
			var array3 = arrayUnique(newTag.concat(tagsArray));
			jQuery('.tagchecklist').empty();
			array3.sort();
			for (var i=0;i<array3.length;i++) {
				tagsArray.push(array3[i]);
				var tagHtml = '<span id="sgrb-tag-index-'+SGRB.tagIndex+'"><a href="javascript:void(0)" id="post_tag-check-num-'+SGRB.tagIndex+'" onclick="SGRB.prototype.deleteTag('+SGRB.tagIndex+')" class="ntdelbutton" tabindex="'+SGRB.tagIndex+'"></a></span><span id="sgrb-tag-'+SGRB.tagIndex+'" class="sgrb-new-tag-text">'+array3[i]+'</span> <input type="hidden" value="'+array3[i]+'" name="tagsArray[]">';
				jQuery('.tagchecklist').append(tagHtml);
				jQuery('.sgrb-newtag').val('');
				jQuery('.sgrb-newtag').focus();
				SGRB.tagIndex = parseInt(SGRB.tagIndex+1);
			}
		}
		else {
			newTag = jQuery.makeArray(newTag);
			var array3 = arrayUnique(newTag.concat(tagsArray));
			jQuery('.tagchecklist').empty();
			array3.sort();
			for (var i=0;i<array3.length;i++) {
				var tagHtml = '<span id="sgrb-tag-index-'+SGRB.tagIndex+'"><a href="javascript:void(0)" id="post_tag-check-num-'+SGRB.tagIndex+'" onclick="SGRB.prototype.deleteTag('+SGRB.tagIndex+')" class="ntdelbutton" tabindex="'+SGRB.tagIndex+'"></a></span><span id="sgrb-tag-'+SGRB.tagIndex+'" class="sgrb-new-tag-text">'+array3[i]+'</span> <input type="hidden" value="'+array3[i]+'" name="tagsArray[]">';
				tagsArray.push(newTag);
				jQuery('.tagchecklist').append(tagHtml);
				jQuery('.sgrb-newtag').val('');
				jQuery('.sgrb-newtag').focus();
				SGRB.tagIndex = parseInt(SGRB.tagIndex+1);
			}
		}
	}
	else {
		jQuery('.sgrb-newtag').val('');
		jQuery('.sgrb-newtag').focus();
		return;
	}
};


SGRB.prototype.deleteTag = function(tagIndex){
	jQuery('#sgrb-tag-index-'+tagIndex).remove();
	jQuery('#sgrb-tag-'+tagIndex).remove();
};

SGRB.prototype.ajaxSaveFreeTables = function(){
	jQuery('.sgrb-review-setting-notice').hide();
	var settingsAction = 'Review_ajaxSaveFreeTables';
	var saveFreeTables = jQuery('input[name=saveFreeTables]').is(':checked');
	if (saveFreeTables) {
		saveFreeTables = 1;
	}
	else {
		saveFreeTables = 0;
	}
	var ajaxHandler = new sgrbRequestHandler(settingsAction, {saveFreeTables:saveFreeTables});
	ajaxHandler.dataType = 'html';
	ajaxHandler.callback = function(response){
		if(response) {
			jQuery('.sgrb-review-setting-notice').show();
			jQuery('.sgrb-review-setting-notice').text('Successfully saved.');
		}
	}
	ajaxHandler.run();
};

SGRB.prototype.ajaxSelectTemplate = function(tempName){
	var changeAction = 'Review_ajaxSelectTemplate';
	var ajaxHandler = new sgrbRequestHandler(changeAction, {template:tempName});
	ajaxHandler.dataType = 'html';
	ajaxHandler.callback = function(response){
		/* If success */
		if(response) {
			jQuery('.sgrb-change-template').empty();
			jQuery('div.sgrb-main-template-wrapper').html(response);
			SGRB.uploadImageButton();
			SGRB.removeImageButton();
		}
	}
	ajaxHandler.run();

};

SGRB.uploadImageButton = function(){
	jQuery('span.sgrb-upload-btn').on('click', function(e) {
		var wrapperDiv = jQuery(this).parent().parent(),
			wrap = jQuery(this),
			imgNum = jQuery(this).next('.sgrb-img-num').attr('data-auto-id');
		e.preventDefault();
		var image = wp.media({
			title: 'Upload Image',
			multiple: false
		}).open()
		.on('select', function(e){
			var uploaded_image = image.state().get('selection').first();
			var image_url = uploaded_image.toJSON().url;
			jQuery('#sgrb_image_url_'+imgNum).val(image_url);
			jQuery(wrap).addClass('sgrb-image-review-plus');
			jQuery(wrapperDiv).addClass('sgrb-image-review');
			jQuery(wrapperDiv).parent().attr('style',"background-image:url("+image_url+")");
			jQuery(wrapperDiv).parent().parent().attr('style',"border:none;");
		});
	});
}

SGRB.removeImageButton = function(){
	jQuery('span.sgrb-remove-img-btn').on('click', function() {
		var uploaded_image = '';
		jQuery(this).parent().parent().parent().attr('style', "background-image:url()");
		jQuery(this).parent().parent().find('.sgrb-images').val('');
		jQuery(this).parent().parent().parent().parent().attr('style',"border: 2px dashed #ccc;border-radius: 10px;");
	});
}

SGRB.prototype.save = function(){
	var isEdit = true;
	var sgrbError = false;
	jQuery('.sgrb-updated').remove();
	var form = jQuery('.sgrb-js-form');
	var font = jQuery('.bfh-selectbox-option').text();
	if (font == 'Current theme font') {
		font = '';
	}
	if(jQuery('.sgrb-title-input').val().replace(/\s/g, "").length <= 0){
		sgrbError = 'Title field is required';
	}
	if (jQuery('.sgrb-one-field').length > 1) {
		jQuery('.sgrb-field-name').each(function() {
			if (jQuery(this).val() == '') {
				sgrbError = 'Empty category fields';
			}
		});
	}
	else if (jQuery('.sgrb-one-field').length == 1 || (jQuery('.sgrb-field-name').first().val() == '')) {
		if (jQuery('.sgrb-field-name').val() == '') {
			sgrbError = 'At least one feature is required';
		}
	}
	if (sgrbError) {
		alert(sgrbError);
		if ((sgrbError == 'At least one feature is required') || (sgrbError == 'Empty feature fields')) {
			jQuery('.sgrb-field-name:last').focus();
		}
		return;
	}
	var products = {};
	if (jQuery('input[name=sgrb-template]').val() == 'woo_review') {
		if (jQuery('#sgrbWooReviewShowTypeProduct').is(':checked')) {
			if (reviewId) {
				var currentProducts = jQuery('.sgrb-all-products-categories').val();
				products = JSON.parse(currentProducts);
			}
			jQuery('.sgrb-woo-product').each(function(){
				if (jQuery(this).is(':checked') && !jQuery(this).attr('disabled')) {
					var eachCategoryId = jQuery(this).val();
					products[eachCategoryId] = 1;
				}
				if (!jQuery(this).is(':checked') && !jQuery(this).attr('disabled')) {
					var eachCategoryId = jQuery(this).val();
					products[eachCategoryId] = 0;
				}
			});
			jQuery('.sgrb-all-products-categories').val(JSON.stringify(products));
		}
		else if (jQuery('#wooReviewShowType').is(':checked')) {
			var id = '';
			jQuery('.sgrb-woo-category').each(function(){
				if (jQuery(this).is(':checked')) {
					var eachCategoryId = jQuery(this).val();
					id += eachCategoryId+',';
					jQuery('.sgrb-all-products-categories').val(id);
				}
			});
		}
	}


	jQuery('.fontSelectbox').val(font);
	var saveAction = 'Review_ajaxSave';
	var ajaxHandler = new sgrbRequestHandler(saveAction, form.serialize());
	ajaxHandler.dataIsObject = false;
	ajaxHandler.dataType = 'html';
	var sgrbSaveUrl = jQuery('.sgrbSaveUrl').val();
	jQuery('.sgrb-loading-spinner').show();
	ajaxHandler.callback = function(response){
		/* If success */
		if(response) {
			jQuery('input[name=sgrb-id]').val(response);
			location.href=sgrbSaveUrl+"&id="+response+'&edit='+isEdit;
		}
		else {
			alert('The review could not be save.');
		}
		jQuery('.sgrb-loading-spinner').hide();

	}
	ajaxHandler.run();
}

SGRB.prototype.clone = function(){
	var oneField = jQuery('.sgrb-one-field');
	var elementsCount = oneField.length,
		elementToClone = oneField.first(),
		elementToAppend = jQuery('.sgrb-field-container'),
		clonedElementId = elementsCount+1,
		clonedElement = elementToClone
							.clone()
							.find("input:text")
							.val("")
							.end()
							.appendTo(elementToAppend)
							.attr('id', 'clone_' + clonedElementId);
		clonedElement
			.find('.sgrb-remove-button')
			.removeAttr('onclick')
			.attr('onclick', "SGRB.remove('clone_"+clonedElementId+"')");
		clonedElement
			.find('.sgrb-fieldId')
			.val('');
	if (jQuery('.sgrb-field-name').length > 1) {
		jQuery('.sgrb-category-empty-warning').hide();
		jQuery('.sgrb-categories-title').attr('style', 'margin-bottom:32px;');
	}
};
SGRB.remove = function(elementId){
	var oneField = jQuery('.sgrb-one-field');
	var elementsCount = oneField.length;
	if (elementsCount <= 1) {
		alert('At least 1 field is needed');
		return;
	}
	if (confirm('Are you sure?')) {
		if (elementId.length > 5) {
			var clone = elementId.slice(0,6);
			if (clone) {
				jQuery('#' + elementId).remove();
				if (jQuery('.sgrb-field-name').length <= 1) {
					jQuery('.sgrb-category-empty-warning').show();
					jQuery('.sgrb-categories-title').removeAttr('style');
				}
				return;
			}
		}

		jQuery('#sgrb_' + elementId).remove();
		SGRB.ajaxDeleteField(elementId);
	}
};

SGRB.ajaxCloseBanner = function(){
	var deleteAction = 'Review_ajaxCloseBanner';
	var ajaxHandler = new sgrbRequestHandler(deleteAction);
	ajaxHandler.dataType = 'html';
	ajaxHandler.callback = function(response){
		location.reload();
	}
	ajaxHandler.run();
};

SGRB.ajaxDelete = function(id){
	if (confirm('Are you sure?')) {
		var deleteAction = 'Review_ajaxDelete';
		var ajaxHandler = new sgrbRequestHandler(deleteAction, {id: id});
		ajaxHandler.dataType = 'html';
		ajaxHandler.callback = function(response){
			/* If success */
			location.reload();
		}
		ajaxHandler.run();
	}
};

SGRB.ajaxDeleteField = function(id){
	var deleteAction = 'Review_ajaxDeleteField';
	var ajaxHandler = new sgrbRequestHandler(deleteAction, {id: id});
	ajaxHandler.dataType = 'html';
	ajaxHandler.callback = function(response){
		/* If success */
	}
	ajaxHandler.run();
};

SGRB.ajaxWooProductLoad = function(start,reviewId,perPage){
	var productsToLoad = jQuery('input[name=productsToLoad]').val();
	var allProductsCount = jQuery('input[name=allProductsCount]').val();
	productsToLoad = parseInt(productsToLoad);
	if (!productsToLoad || productsToLoad == 0) {
		alert('Products count to load is not valid (min-max: 1-999)');
		jQuery('input[name=productsToLoad]').val('');
		jQuery('input[name=productsToLoad]').focus();
		return;
	}
	perPage = 500;
	if (jQuery('.sgrb-woo-products-wrapper').hasClass('sgrb-no-first-click')) {
		perPage = productsToLoad;
	}
	jQuery('.sgrb-woo-products-wrapper').show();
	var loading = 'Loading...';
	jQuery('.sgrb-categories-selector').val(loading);
	var productsHtml = '';
	var loadItemsAction = 'Review_ajaxWooProductLoad';
	var ajaxHandler = new sgrbRequestHandler(loadItemsAction, {start:start,reviewId:reviewId,perPage:perPage});
	ajaxHandler.dataType = 'html';
	ajaxHandler.callback = function(response){
		jQuery('.sgrb-load-more-woo').remove();
		var obj = jQuery.parseJSON(response);
		if (jQuery.isEmptyObject(obj)) {
			productsHtml += '<div class="sgrb-each-product-wrapper"><span class="sgrb-woo-product-category-name">No products found</span></div>';
			jQuery('.sgrb-woo-products-wrapper').prepend(productsHtml);
			return;
		}
		else {
			var allowCheck = '';
			var disableClass = '';

			for(var i in obj) {
				if (obj[i].matchProdId) {
					disableClass = ' sgrb-disable-woo-products';
					allowCheck = '';
				}
				else {
					disableClass = '';
					allowCheck = 'sgrb-woo-product ';
				}
				productsHtml += '<div class="sgrb-each-product-wrapper"><label for="sgrb-woo-product-'+obj[i].id+'">';
				productsHtml += '<input class="'+allowCheck+obj[i].checkedClass+'" id="sgrb-woo-product-'+obj[i].id+'" type="checkbox" value="'+obj[i].id+'"'+obj[i].checked+obj[i].matchProdId+'>';
				productsHtml += '<span class="sgrb-woo-product-category-name'+disableClass+'">'+obj[i].name+obj[i].matchReview+'</span>';
				productsHtml += '</label></div>';
			}
			start = parseInt(start)+parseInt(productsToLoad);
			if (allProductsCount > start) {
				productsHtml += '<div class="sgrb-load-more-woo"><input onclick="SGRB.ajaxWooProductLoad('+start+','+reviewId+','+productsToLoad+')" class="button-small button sgrb-categories-selector" value="Load more products" type="button"></div>';
			}
			else {
				jQuery('input[name=productsToLoad]').attr('disabled', 'disabled');
				productsHtml += '<div class="sgrb-load-more-woo"><input class="button-small button sgrb-categories-selector" value="No more products" type="button" disabled></div>';
			}
			jQuery('.sgrb-woo-products-wrapper').addClass('sgrb-no-first-click');
			jQuery('.sgrb-woo-products-wrapper').append(productsHtml);
		}

	}
	ajaxHandler.run();

};

SGRB.ajaxPagination = function(page,itemsRangeStart,perPage,reviewId){
	var count = 0;
	var sgrbMainWrapper = jQuery('#sgrb-review-'+reviewId);
	if (sgrbMainWrapper.find('.sgrb-load-it').length != '') {
		perPage = parseInt(sgrbMainWrapper.find('.sgrb-comments-count-load').val());
	}
	var postId = '';
	var commentsPerPage = perPage,
		pageCount = sgrbMainWrapper.find('.sgrb-page-count').val(),
		postId = sgrbMainWrapper.find('.sgrb-post-id').val(),
		loadMore = sgrbMainWrapper.find('.sgrb-comment-load'),
		arr = parseInt(sgrbMainWrapper.find('.sgrb-current-page').text());

	var review = sgrbMainWrapper.find('.sgrb-reviewId').val();
	var jPageAction = 'Review_ajaxPagination';
	var ajaxHandler = new sgrbRequestHandler(jPageAction, {review:review,page:page,itemsRangeStart:itemsRangeStart,perPage:perPage,postId:postId});
	ajaxHandler.dataType = 'html';
	sgrbMainWrapper.find('.sgrb-loading-spinner').show();
	sgrbMainWrapper.find('.sgrb-comment-load').hide();
	ajaxHandler.callback = function(response){
		var obj = jQuery.parseJSON(response);
		if (jQuery.isEmptyObject(obj)) {
			sgrbMainWrapper.find('.sgrb-loading-spinner').hide();
			loadMore.attr({
				'disabled':'disabled',
				'style' : 'cursor:default;color:#c1c1c1;vertical-align: text-top;pointer-events: none;'
			}).text('no more comments');
			return;
		}

		var commentHtml = '';
		var next = parseInt(itemsRangeStart+commentsPerPage);
		var formTextColor = sgrbMainWrapper.find('.sgrb-rate-text-color').val();
		var formBackgroundColor = sgrbMainWrapper.find('.sgrb-rate-background-color').val();
		if (!formTextColor) {
			formTextColor = '#4c4c4c';
		}
		if (!formBackgroundColor) {
			formBackgroundColor = '#fbfbfb';
		}
		if (jQuery.isEmptyObject(obj)) {
			loadMore.attr({
				'disabled':'disabled',
				'style' : 'cursor:default;color:#c1c1c1;vertical-align: text-top;pointer-events: none;'
			}).text('no more comments');
		}
		else {
			loadMore.removeAttr('disabled style');
			loadMore.attr('onclick','SGRB.ajaxPagination(1,'+next+','+commentsPerPage+','+reviewId+')');
		}
		if (!sgrbMainWrapper.find('.sgrb-row-category').is(':visible') || jQuery('.sgrb-widget-wrapper')) {
			sgrbMainWrapper.find('.sgrb-widget-wrapper .sgrb-comment-load').remove();
		}
		var additional = '';
		var additionalFieldWrapper = '';
		for(var i in obj) {
			/* if using custom comment form */
			if (jQuery('input[name=customForm]').val()) {
				if (typeof obj[i].comment === 'undefined') {
					obj[i].comment = '';
				}
				if (!jQuery.isEmptyObject(obj[i].additional)) {
					var labelName = jQuery(obj[1].key).toArray();
					var eachLabelShow = jQuery(obj[1].show).toArray();
					var labelVal = jQuery(obj[i].additional.val).toArray();

					additionalFieldWrapper = '<div class="sg-row"><div class="sg-col-12"><div class="sgrb-comment-wrapper"><ul style="margin-left:20px">';
					for (var k=0;k<labelVal.length;k++) {
						if (labelName[k] == '' || labelName[k] == 'additional' || labelName[k] === 'undefined' || typeof labelName[k] === 'undefined' || labelName === 'undefined' || labelName == '' || typeof labelName === 'undefined') {
							labelName = [];
							labelName[k] = '';
						}
						else {
							labelName[k] = labelName[k]+':';
						}
						if (eachLabelShow[k] == 1) {
							additionalFieldWrapper += '<li><span><b>'+labelName[k]+' </b>'+labelVal[k]+'</span></li>';
						}
					}
					additionalFieldWrapper += '</ul></div></div></div>';
				}
				var titleWrapper = '<div class="sg-row"><div class="sg-col-12"><div class="sgrb-comment-wrapper"><span style="width:100%;"><i><b>'+obj[i].title+' </i></b></span></div></div></div>';
				var commentWrapper = '<div class="sg-row"><div class="sg-col-12"><div class="sgrb-comment-wrapper">';
				if (obj[i].comment.length >= 200) {
					commentWrapper += '<input class="sgrb-full-comment" type="hidden" value="'+obj[i].comment+'">';
					commentWrapper += '<span class="sgrb-comment-text sgrb-comment-max-height">" '+obj[i].comment.substring(0,200)+' ... <a onclick="SGRB.prototype.showHideComment('+obj[i].id+', \'sgrb-read-more\')" href="javascript:void(0)" class="sgrb-read-more">show all&#9660</a></span>';
				}
				else {
					commentWrapper += '<span class="sgrb-comment-text">" '+obj[i].comment+' "</span>';
				}
				commentWrapper += '</div></div></div>';
				var nameWrapper = '<i> , comment by </i><b>'+obj[i].name+'</b>';
				if (obj[i].title == '' || typeof obj[i].title === 'undefined') {
					titleWrapper = '';
				}
				if (obj[i].comment == '' || typeof obj[i].comment === 'undefined') {
					commentWrapper = '';
				}
				if (obj[i].name == '' || typeof obj[i].name === 'undefined') {
					nameWrapper = '';
				}
				commentHtml += '<div id="sgrb-comment-'+obj[i].id+'" class="sgrb-approved-comments-wrapper" style="background-color:'+formBackgroundColor+';color:'+formTextColor+'">';
				if (!jQuery('.sgrb-load-it').length) {
					if (!sgrbMainWrapper.find('.sgrb-row-category').is(':visible') || sgrbMainWrapper.find('.sgrb-widget-wrapper')) {
						commentHtml += '<input type="hidden" class="sgrb-each-comment-avg-widget" value="'+obj[i].rates+'">';
						commentHtml += '<div class="sg-row"><div class="sg-col-12"><div class="sgrb-comment-wrapper sgrb-each-comment-rate"></div></div></div>';
					}
				}
				commentHtml += titleWrapper;
				commentHtml += additionalFieldWrapper;
				commentHtml += commentWrapper;

				commentHtml += '<div class="sg-row"><div class="sg-col-12"><span class="sgrb-name-title-text"><b>'+obj[i].date+'</b>'+nameWrapper+'</span></div></div>';
				commentHtml += '</div>';
				if (obj[i].count !== 'undefined' && obj[i].count != '') {
					count = obj[i].count;
				}
			}
			else {
				commentHtml += '<div id="sgrb-comment-'+obj[i].id+'" class="sgrb-approved-comments-wrapper" style="background-color:'+formBackgroundColor+';color:'+formTextColor+'">';
				if (!jQuery('.sgrb-load-it').length) {
					if (!sgrbMainWrapper.find('.sgrb-row-category').is(':visible') || sgrbMainWrapper.find('.sgrb-widget-wrapper')) {
						commentHtml += '<input type="hidden" class="sgrb-each-comment-avg-widget" value="'+obj[i].rates+'">';
						commentHtml += '<div class="sg-row"><div class="sg-col-12"><div class="sgrb-comment-wrapper sgrb-each-comment-rate"></div></div></div>';
					}
				}
				commentHtml += '<div class="sg-row"><div class="sg-col-12"><div class="sgrb-comment-wrapper"><span style="width:100%;"><i><b>'+obj[i].title+' </i></b></span></div></div></div>';
				commentHtml += '<div class="sg-row"><div class="sg-col-12"><div class="sgrb-comment-wrapper">';
				if (obj[i].comment.length >= 200) {
					commentHtml += '<input class="sgrb-full-comment" type="hidden" value="'+obj[i].comment+'">';
					commentHtml += '<span class="sgrb-comment-text sgrb-comment-max-height">" '+obj[i].comment.substring(0,200)+' ... <a onclick="SGRB.prototype.showHideComment('+obj[i].id+', \'sgrb-read-more\')" href="javascript:void(0)" class="sgrb-read-more">show all&#9660</a></span>';
				}
				else {
					commentHtml += '<span class="sgrb-comment-text">" '+obj[i].comment+' "</span>';
				}

				if (!obj[i].name) {
					var name = 'Guest';
					var addWidth = '';
				}
				else {
					var name = obj[i].name;
					if (name.length >= 100) {
						var addWidth = 'style="width:95%;"';
					}
					else {
						var addWidth = '';
					}
				}
				commentHtml += '</div></div></div><div class="sg-row"><div class="sg-col-12"><span class="sgrb-name-title-text" '+addWidth+'><b>'+obj[i].date+'</b> <i> , comment by </i><b>&nbsp;'+name+'</b> </span></div></div>';
				commentHtml += '</div>';
				if (obj[i].count !== 'undefined' && obj[i].count != '') {
					count = obj[i].count;
				}
			}
		}
		sgrbMainWrapper.find('.sgrb-approved-comments-to-show').append(commentHtml);
		sgrbMainWrapper.find('.sgrb-approved-comments-to-show').addClass('sgrb-load-it');
		sgrbMainWrapper.find('.sgrb-loading-spinner').hide();
		sgrbMainWrapper.find('.sgrb-comment-load').show();
		/* if no more comments */
			if (jQuery('.sgrb-approved-comments-wrapper').length) {
				var countOfLoadedComments = jQuery('.sgrb-approved-comments-wrapper').length;
				if (countOfLoadedComments && count && countOfLoadedComments == count) {
					loadMore.attr({
						'disabled':'disabled',
						'style' : 'cursor:default;color:#c1c1c1;vertical-align: text-top;pointer-events: none;'
					}).text('no more comments');
				}
			}
	}
	ajaxHandler.run();
};

SGRB.prototype.ajaxUserRate = function(reviewId, isFirstClick){
	var sgrbMainWrapper = jQuery('#sgrb-review-'+reviewId);
	var categoryCount = 0;
	var clickedCount = 0;
	var skinWrapperToClick = '';
	if (isFirstClick && !jQuery('.sgrb-hide-show-wrapper').find('.br-widget').length) {
		jQuery('.sgrb-rate-clicked-count').each(function(){
			jQuery(this).click(function(){
				jQuery(this).data('clicked', true);
			});
			if (jQuery(this).data('clicked')) {
				 clickedCount++;
			}
			categoryCount++;
		});
		isFirstClick = false;
		return;
	}
	else if (isFirstClick && jQuery('.sgrb-hide-show-wrapper').find('.br-widget').length) {
		jQuery('.sgrb-hide-show-wrapper').find('.br-widget a').each(function(){
			jQuery(this).click(function(){
				jQuery(this).data('clicked', true);
			});
			if (jQuery(this).data('clicked')) {
				 clickedCount++;
			}
		});
		jQuery('.sgrb-hide-show-wrapper').find('.br-widget').each(function(){
			jQuery(this).click(function(){
				jQuery(this).data('clicked', true);
			});
			categoryCount++;
		});
		isFirstClick = false;
		return;
	}
	var errorInputStyleClass = 'sgrb-form-input-notice-styles';
	sgrbMainWrapper.find('input[name=addTitle]').removeClass(errorInputStyleClass);
	sgrbMainWrapper.find('input[name=addEmail]').removeClass(errorInputStyleClass);
	sgrbMainWrapper.find('input[name=addName]').removeClass(errorInputStyleClass);
	sgrbMainWrapper.find('textarea[name=addComment]').removeClass(errorInputStyleClass);
	sgrbMainWrapper.find('input[name=addTitle]').next().text('');
	sgrbMainWrapper.find('input[name=addEmail]').next().text('');
	sgrbMainWrapper.find('input[name=addName]').next().text('');
	sgrbMainWrapper.find('textarea[name=addComment]').next().text('');
	sgrbMainWrapper.find('.sgrb-notice-rates').hide();
	var error = false,
		captchaError = false,
		requiredEmail = sgrbMainWrapper.find('.sgrb-requiredEmail').val(),
		requiredTitle = sgrbMainWrapper.find('.sgrb-requiredTitle').val(),
		thankText = sgrbMainWrapper.find('.sgrb-thank-text').val(),
		noRateText = sgrbMainWrapper.find('.sgrb-no-rate-text').val(),
		noNameText = sgrbMainWrapper.find('.sgrb-no-name-text').val(),
		noEmailText = sgrbMainWrapper.find('.sgrb-no-email-text').val(),
		noTitleText = sgrbMainWrapper.find('.sgrb-no-title-text').val(),
		noCommentText = sgrbMainWrapper.find('.sgrb-no-comment-text').val(),
		noCaptchaText = sgrbMainWrapper.find('.sgrb-no-captcha-text').val(),
		name = sgrbMainWrapper.find('input[name=addName]').val(),
		email = sgrbMainWrapper.find('input[name=addEmail]').val(),
		title = sgrbMainWrapper.find('input[name=addTitle]').val(),
		comment = sgrbMainWrapper.find('textarea[name=addComment]').val();
	var post = sgrbMainWrapper.find('input[name=addPostId]').val();	var isRated = false;
	if (sgrbMainWrapper.find('.sgrb-hide-show-wrapper').find('.br-widget').length) {
		skinWrapperToClick = '.br-widget a';
		sgrbMainWrapper.find('.sgrb-hide-show-wrapper').find('.br-widget a').each(function(){
			jQuery(this).click(function(){
				jQuery(this).data('clicked', true);
			});
			if (jQuery(this).data('clicked')) {
				 clickedCount++;
			}
		});
		sgrbMainWrapper.find('.sgrb-hide-show-wrapper').find('.br-widget').each(function(){
			jQuery(this).click(function(){
				jQuery(this).data('clicked', true);
			});
			categoryCount++;
		});
		isFirstClick = false;
	}
	else {
		skinWrapperToClick = '.sgrb-rate-each-skin-wrapper';
		sgrbMainWrapper.find('.sgrb-hide-show-wrapper').find('.sgrb-rate-each-skin-wrapper').each(function(){
			jQuery(this).click(function(){
				jQuery(this).data('clicked', true);
			});
			if (jQuery(this).data('clicked')) {
				 clickedCount++;
			}
			categoryCount++;
		});
		isFirstClick = false;
	}
	if (sgrbMainWrapper.find('input[name=sgRate]').val() == 0) {
		if ((parseInt(categoryCount) != parseInt(clickedCount)) || (parseInt(categoryCount) > parseInt(clickedCount))) {
			error = noRateText;
			sgrbMainWrapper.find('.sgrb-user-comment-submit').removeAttr('disabled');
			sgrbMainWrapper.find('.sgrb-notice-rates span').show().text(error);
			sgrbMainWrapper.find('.sgrb-notice-rates').show();
		}
	}
	if (sgrbMainWrapper.find('input[name=captchaOn]').val() == 1) {
		var captchaCode = jQuery('#sgrb-captcha-'+reviewId).realperson('getHash');
	}
	else {
		var captchaCode = '';
	}
	/* default form errors */
	if (jQuery('input[name=customForm]').val() == 0) {
		if (requiredEmail && !email) {
			error = noEmailText;
		}
		if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) && requiredEmail) {
			error = noEmailText;
			sgrbMainWrapper.find('input[name=addEmail]').addClass(errorInputStyleClass);
			sgrbMainWrapper.find('input[name=addEmail]').next().text(error);
		}
		if (requiredTitle && !title) {
			error = noTitleText;
			sgrbMainWrapper.find('input[name=addTitle]').addClass(errorInputStyleClass);
			sgrbMainWrapper.find('input[name=addTitle]').next().text(error);
		}
		if (!name) {
			error = noNameText;
			sgrbMainWrapper.find('input[name=addName]').addClass(errorInputStyleClass);
			sgrbMainWrapper.find('input[name=addName]').next().text(error);
		}
		if (!comment) {
			error = noCommentText;
			sgrbMainWrapper.find('textarea[name=addComment]').addClass(errorInputStyleClass);
			sgrbMainWrapper.find('textarea[name=addComment]').next().text(error);
		}
	}
	else {
		/* created form errors */
		jQuery('.sgrb-user-form-error').text('');
		var hasInputField = false;
		var hasInput = sgrbMainWrapper.find('input');
		if (hasInput) {
			var hasInputField = true;
		}
		if (sgrbMainWrapper.find('.sgrb-comment-form-asterisk').length || hasInputField) {
			sgrbMainWrapper.find('input').each(function(){
				if (jQuery(this).attr('type') == 'email') {
					var emailText = jQuery(this).val();
					var errorEmailFieldInput = jQuery(this);
					var emailFieldError = jQuery(this).next();
					if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(emailText))) {
						error = 'Invalid email address';
						errorEmailFieldInput.addClass(errorInputStyleClass);
						emailFieldError.text(error);
					}
				}
				if (jQuery(this).attr('type') == 'number') {
					var emailText = jQuery(this).val();
					var errorEmailFieldInput = jQuery(this);
					var emailFieldError = jQuery(this).next();
					var validNumber = /^[0-9]+$/;
					if (emailText.match(validNumber) == '' || jQuery.isEmptyObject(emailText.match(validNumber))) {
						error = 'Not a number';
						errorEmailFieldInput.addClass(errorInputStyleClass);
						emailFieldError.text(error);
					}
				}
			});
			sgrbMainWrapper.find('.sgrb-comment-form-asterisk').each(function(){
				var errorFieldName = jQuery(this).prev().text();
				if (errorFieldName == '' || errorFieldName === 'undefined') {
					var errorFieldName = 'Current';
				}
				/* if no label */
				if (errorFieldName == 'Current') {
					var errorFieldInput = jQuery(this).parent().find('input');
					var errorFieldTextarea = jQuery(this).parent().find('textarea');
					var errorFieldInputType = jQuery(this).next().attr('type');
					var fieldError = jQuery(this).parent().find('.sgrb-user-form-error');
				}
				else {
					var errorFieldInput = jQuery(this).next().find('input');
					var errorFieldTextarea = jQuery(this).next().find('textarea');
					var errorFieldInputType = jQuery(this).next().find('input').attr('type');
					var fieldError = jQuery(this).next().find('.sgrb-user-form-error');
				}
				fieldError.text('');
				if (errorFieldInput.length) {
					if (errorFieldInputType == 'text') {
						errorFieldInput.removeClass(errorInputStyleClass);
						if (errorFieldInput.val() == '') {
							error = errorFieldName+' field is required';
							errorFieldInput.addClass(errorInputStyleClass);
							fieldError.text(error);
						}
					}
					if (errorFieldInputType == 'number') {
						var numbers = /^[0-9]+$/;
						errorFieldInput.removeClass(errorInputStyleClass);
						if (errorFieldInput.val().match(numbers) == '' || jQuery.isEmptyObject(errorFieldInput.val().match(numbers))) {
							error = errorFieldName+' field is required';
							errorFieldInput.addClass(errorInputStyleClass);
							fieldError.text(error);
						}
					}
					if (errorFieldInputType == 'email') {
						errorFieldInput.removeClass(errorInputStyleClass);
						if (errorFieldInput.val() == '') {
							error = errorFieldName+' field is required';
							errorFieldInput.addClass(errorInputStyleClass);
							fieldError.text(error);
						}
						else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(errorFieldInput.val()))) {
							error = 'Invalid email address';
							errorFieldInput.addClass(errorInputStyleClass);
							fieldError.text(error);
						}
					}
				}
				if (errorFieldTextarea.length) {
					if (errorFieldTextarea.val() == '') {
						error = errorFieldName+' field is required';
						errorFieldTextarea.addClass(errorInputStyleClass);
						fieldError.text(error);
					}
					else {
						fieldError.val('');
						errorFieldTextarea.removeClass(errorInputStyleClass);
					}
				}
			});
		}
	}
	if (error) {
		return;
	}
	sgrbMainWrapper.find('.sgrb-user-comment-submit').attr('disabled','disabled');
	var form = sgrbMainWrapper.parent(),
		cookie = sgrbMainWrapper.find('.sgrb-cookie').val(),
		saveAction = 'Review_ajaxUserRate';
	var ajaxHandler = new sgrbRequestHandler(saveAction, form.serialize()+'&captchaCode='+captchaCode);
	ajaxHandler.dataType = 'html';
	ajaxHandler.dataIsObject = false;
	ajaxHandler.callback = function(response){
		if (response != 0 && response != NaN) {
			if (sgrbMainWrapper.find('.sgrb-total-rate-title').length == 0) {
				sgrbMainWrapper.find('.sgrb-total-rate-wrapper').removeAttr('style');
			}
			sgrbMainWrapper.find('.sgrb-notice-rates').hide(500);
			sgrbMainWrapper.find('.sgrb-hide-show-wrapper').hide(1000);
			sgrbMainWrapper.find('.sgrb-user-comment-wrapper').append('<span>'+thankText+'</span>');
			jQuery.cookie('rater', cookie);
		}
		else if (response == false) {
			captchaError = noCaptchaText;
			sgrbMainWrapper.find('.sgrb-user-comment-submit').removeAttr('disabled');
			sgrbMainWrapper.find('.sgrb-captcha-notice span').show().text(captchaError);
			sgrbMainWrapper.find('.sgrb-captcha-notice').show();
			sgrbMainWrapper.find('input[name=addCaptcha]').addClass(errorInputStyleClass);
		}
	}
	ajaxHandler.run();
};

SGRB.ajaxCloneReview = function (id) {
	var cloneAction = 'Review_ajaxCloneReview';
	var ajaxHandler = new sgrbRequestHandler(cloneAction, {id: id});
	ajaxHandler.dataType = 'html';
	ajaxHandler.callback = function(response){
		/* If success */
		if (response) {
			location.reload();
		}
	}
	ajaxHandler.run();
}

/* show more or less comment */
SGRB.prototype.showHideComment = function (commentId,className) {
	var currentComment = jQuery('#sgrb-comment-'+commentId);
	if (className == 'sgrb-read-more') {
		var fullText = currentComment.find('.sgrb-read-more')
							.parent()
							.parent()
							.find('.sgrb-full-comment')
							.val();
		currentComment.find('.sgrb-read-more')
			.parent()
			.parent()
			.find('.sgrb-comment-text')
			.empty()
			.removeClass('sgrb-comment-max-height')
			.html('" '+fullText+' " <a onclick="SGRB.prototype.showHideComment('+commentId+',\'sgrb-hide-read-more\')" href="javascript:void(0)" class="sgrb-hide-read-more">hide&#9650</a>');
	}

	if (className == 'sgrb-hide-read-more') {
		var fullText = currentComment.find('.sgrb-hide-read-more').parent().parent().find('.sgrb-full-comment').val();
		var cuttedText = fullText.substr(0, 200);
		jQuery('.sgrb-hide-read-more').parent().parent().find('.sgrb-comment-text').empty().addClass('sgrb-comment-max-height').html('" '+cuttedText+' ... <a onclick="SGRB.prototype.showHideComment('+commentId+',\'sgrb-read-more\')" href="javascript:void(0)" class="sgrb-read-more">show all&#9660</a>');
	}
}

/**
 * changeType() get skin style and set it as default.
 * @param type is integer
 */
SGReview.prototype.changeType = function (type) {
	if (type == SGRB.sgrbRateTypeStar) {
		span = ' Rate (1-5) : ';
		type = 'star';
		count = 5;
	}
	else if (type == SGRB.sgrbRateTypePercent) {
		span = ' Rate (1-100) : ';
		type = 'percent';
		count = 100;
	}
	else if (type == SGRB.sgrbRateTypePoint) {
		span = ' Rate (1-10) : ';
		type = 'point';
		count = 10;
	}
	SGReview.prototype.rateSelectboxHtmlBuilder(type,span,count);
}

/**
 * preview() get skin style for show preview.
 * @param type is integer
 */
SGReview.prototype.preview = function (type) {
	var selectedType = '.sgrb-preview-'+type,
		skinColor = jQuery('.sgrb-skin-color'),
		skinStylePreview = jQuery('.sgrb-skin-style-preview');

	if (selectedType == '.sgrb-preview-1') {
		skinColor.show(200);
		skinStylePreview
			.empty()
			.html('<div></div>')
			.find('div')
			.attr('class','')
			.addClass('rateYoPreview');
		skinStylePreview.find('.sgrb-point').hide();
		skinStylePreview.removeClass('sgrb-skin-style-preview-percent sgrb-skin-style-preview-point');
		jQuery('.rateYoPreview').rateYo({
			rating: "3",
			fullStar: true,
			starWidth: "40px"
		});
	}
	else if (selectedType == '.sgrb-preview-2') {
		skinColor.show(200);
		skinStylePreview.empty().html('<div class="sgrb-percent-preview"><div></div></div>');
		skinStylePreview.removeClass('sgrb-skin-style-preview-point').addClass('sgrb-skin-style-preview-percent');
		jQuery('.sgrb-percent-preview').find('div').attr('class','').addClass('circles-slider');
		skinStylePreview.find('.sgrb-point').hide();
		jQuery(".circles-slider").slider({
			max:100,
			value: 40,
		}).slider("pips", {
			rest: false,
			labels:100
		}).slider("float", {
		});
	}
	else if (selectedType == '.sgrb-preview-3') {
		skinColor.hide(200);
		skinStylePreview.empty();
		skinStylePreview.removeClass('sgrb-skin-style-preview-percent').addClass('sgrb-skin-style-preview-point');
		skinStylePreview.html('<select class="sgrb-point"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select>');
		jQuery('.sgrb-point').barrating({
			theme : 'bars-1to10'
		});
		jQuery('.sgrb-point').barrating('set',5);
		jQuery('.br-theme-bars-1to10 .br-widget a').attr("style", "height:23px !important;width:18px !important;");
		jQuery(".br-current-rating").attr("style", 'display:none;');
	}
}

/**
 * rateSelectboxHtmlBuilder() get skin style for show preview.
 * @param type is integer
 */
SGReview.prototype.rateSelectboxHtmlBuilder = function (type,span,count) {
	var selectBox = jQuery('.sgrb-select-box-count');
	jQuery('.sgrb-rate-count-span').text(span);
	jQuery('code').text(type);
	selectBox.val(count);
	var selectBoxCount = selectBox.val();
	var htmlRateSelectBox = '';
	for (var i=1;i<=selectBoxCount;i++) {
			htmlRateSelectBox += '<option value="'+i+'">'+i+'</option>';
	}
	jQuery('.sgrb-rate').empty();
	jQuery(htmlRateSelectBox).appendTo('.sgrb-rate');
}

/**
 * isHidden() checked if review rated by current user
 * and hide the comment form
 */
SGReview.prototype.isHidden = function () {
	if (!jQuery('.sgrb-hide-show-wrapper').is(":visible")) {
		/* jQuery('.sgrb-row-category').hide(); */
	}
}

/**
 * getURLParameter() checked if it is create
 * or edit
 * @param params is boolean
 */
SGReview.prototype.getURLParameter = function (params) {
	var sPageURL = window.location.search.substring(1);
	var sURLVariables = sPageURL.split('&');
	for (var i = 0; i < sURLVariables.length; i++) {
		var sParameterName = sURLVariables[i].split('=');
		if (sParameterName[0] == params) {
			return sParameterName[1];
		}
	}
}

SGReview.prototype.changeFont = function (fontName) {
	var font = fontName.replace(new RegExp(" ",'g'),"");
	var res = font.match(/[A-Z][a-z]+/g);
	var result = '';

	for (var i=0;i<res.length;i++) {
		result += res[i]+' ';
	}
	WebFontConfig = {
	google: { families: [ result.substr(0, result.length-1) ] }
  };
  (function() {
	var wf = document.createElement('script');
	wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
	  '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
	wf.type = 'text/javascript';
	wf.async = 'true';
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(wf, s);

  })();
}

SGReview.prototype.checkRateClickedCount = function() {
	SGRB.prototype.ajaxUserRate(false, true);
}

function arrayUnique(array) {
	var a = array.concat();
	for(var i=0; i<a.length; ++i) {
		for(var j=i+1; j<a.length; ++j) {
			if(a[i] === a[j])
				a.splice(j--, 1);
		}
	}

	return a;
}
