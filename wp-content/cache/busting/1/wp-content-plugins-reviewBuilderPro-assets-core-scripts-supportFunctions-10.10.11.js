jQuery(document).ready(function(){
	'use strict';
	SGRB.sgrbRateTypeStar = 1;
	SGRB.sgrbRateTypePercent = 2;
	SGRB.sgrbRateTypePoint = 3;
	jQuery('#wpcontent').find('.subsubsub').attr('style','margin-top:66px;position:absolute;');
	jQuery('.sgrb-reviewId').each(function(){
		var reviewId = jQuery(this).val();
		var mainWrapper = jQuery('#sgrb-review-'+reviewId);
		var type = mainWrapper.find('.sgrb-rating-type').val(),
			isRated = true,
			value = 1,
			skinHtml = '',
			mainFinalRate = mainWrapper.find('.sgrb-final-rate');
			if (mainWrapper.find('.sgrb-show-tooltip span').text().match('^0')) {
				isRated = false;
			}
		if (type == SGRB.sgrbRateTypeStar) {
				skinHtml = '<div class="sgrb-each-rateYo"></div>';
				if (!jQuery('.sgrb-row-category').is(':visible') && jQuery('.sgrb-widget-wrapper').length) {
					jQuery(document).ajaxComplete(function(){
						jQuery('.sgrb-each-comment-rate').append(skinHtml);
						jQuery('.sgrb-approved-comments-wrapper').each(function(){
							value = jQuery(this).find('.sgrb-each-comment-avg-widget').val();
							avgVal = 0;
							value = value.split(',');
							for (var i=0;i<value.length;i++) {
								avgVal = parseInt(avgVal+parseInt(value[i]));
							}
							avgVal = Math.round(avgVal/value.length);
							jQuery(this).find('.sgrb-each-rateYo').rateYo({
								rating: avgVal,
								readOnly: true
							});
						});
					});
				}
				if (mainWrapper.length > 0) {
					var rateTextColor = mainWrapper.find('.sgrb-rate-text-color').val();
					if (rateTextColor) {
						mainFinalRate.css('color',rateTextColor);
					}
					var skinColor = mainWrapper.find('.sgrb-skin-color').val();
					if (!skinColor) {
						skinColor = '#F39C12';
					}
					var eachCategoryTotal = '';
					/* show total (if rates) */
					if (isRated && mainWrapper.find('.sgrb-tooltip-text').text() != 'no rates') {
						mainWrapper.find('.sgrb-rate-each-skin-wrapper').each(function(){
							eachCategoryTotal = jQuery(this).find('.sgrb-each-category-total').val();
							if (eachCategoryTotal) {
								jQuery(this).find('.rateYoTotal').rateYo({
									ratedFill: skinColor,
									rating: eachCategoryTotal,
									fullStar : true,
									readOnly: true
								});
							}
						});
					}
					/* show total for the first time (if no rates) */
					if (mainWrapper.find('.sgrb-tooltip-text').text().match('^no rates')) {
						mainWrapper.find('.sgrb-rate-each-skin-wrapper').each(function(){
							jQuery(this).find('.rateYoTotal').rateYo({
								ratedFill: skinColor,
								readOnly: true
							});
						});
					}
					/* edit rate (review) */
					if (mainWrapper.find('input[name=sgRate]').val() != 0) {
						mainWrapper.find('input[name=sgRate]').each(function(){
							var sgRate = jQuery(this).val();
							jQuery(this).parent().parent().find('.sgrb-each-rate-skin').val(sgRate);
							jQuery(this).next().rateYo({
								rating:sgRate,
								ratedFill: skinColor,
								fullStar: true,
								maxValue: 5,
								onChange: function (rating, rateYoInstance) {
									jQuery(this).next().text(rating);
									var res = jQuery(this).parent().find(".sgrb-counter").text()
									jQuery(this).parent().parent().find('.sgrb-each-rate-skin').val(res);
								}
							});
						});
					}
					/* add new rate (review) */
					if (mainWrapper.find('input[name=sgRate]').val() == 0) {
						mainWrapper.find(".rateYo").rateYo({
							starWidth: "30px",
							ratedFill: skinColor,
							fullStar: true,
							maxValue: 5,
							onChange: function (rating, rateYoInstance) {
								jQuery(this).next().text(rating);
								mainWrapper.find('.sgrb-each-rate-skin').each(function(){
									var res = jQuery(this).parent().find(".sgrb-counter").text();
									jQuery(this).parent().find('.sgrb-each-rate-skin').val(res);
								});
							}
						});
					}

					jQuery('.rateYoAll').attr('style', 'margin-top: 110px; margin-left:30px;position:absolute');
					jQuery('.sgrb-counter').attr('style', 'display:none');
					jQuery('.sgrb-allCount').attr('style', 'display:none');

					jQuery('.sgrb-user-comment-submit').on('click', function(){
						jQuery(".rateYo").rateYo({readOnly:true});
					});
				}
		}
		else if (type == SGRB.sgrbRateTypePercent) {
			skinHtml = '<div class="circles-slider"></div>';
			if (!mainWrapper.find('.sgrb-row-category').is(':visible') && mainWrapper.find('.sgrb-widget-wrapper')) {
				jQuery(document).ajaxComplete(function(){
					var slider = mainWrapper.find('.sgrb-widget-wrapper').find('.circles-slider');
					mainWrapper.find('.sgrb-each-comment-rate').append(skinHtml).attr('style','padding:0 !important;min-height:30px;');
					mainWrapper.find('.sgrb-approved-comments-wrapper').each(function(){
						value = jQuery(this).find('.sgrb-each-comment-avg-widget').val();
						avgVal = 0;
						value = value.split(',');
						for (var i=0;i<value.length;i++) {
							avgVal = parseInt(avgVal+parseInt(value[i]));
						}
						avgVal = Math.round(avgVal/value.length);
						jQuery(this).find('.circles-slider').slider({
							max:100,
							value: avgVal
						}).slider("pips", {
							rest: false,
							labels:100
						}).slider("float", {
						});
					});
					mainWrapper.find('.circles-slider').attr('style','pointer-events:none;margin: 40px 30px 0 27px !important;width: 78% !important;clear: right !important;');
					mainWrapper.find('.circles-slider .ui-slider-handle').addClass('ui-state-hover ui-state-focus');
				});
			}
			if (mainWrapper.find('.sgrb-common-wrapper')) {
				if (isRated) {
					mainWrapper.find('.sgrb-each-percent-skin-wrapper').each(function(){
						value = jQuery(this).find('.sgrb-each-category-total').val();
						jQuery(this).find('.circles-slider').slider({
							max:100,
							value: value
						}).slider("pips", {
							rest: false,
							labels:100
						}).slider("float", {
						});
					});
					mainWrapper.find('.circles-slider').attr('style','pointer-events:none;float:right !important;');
					mainWrapper.find('.circles-slider .ui-slider-handle').addClass('ui-state-hover ui-state-focus');
				}
				if (!mainWrapper.find('input[name=sgRate]').val()) {
					mainWrapper.find(".sgrb-circle-total").slider({
						max:100,
						value: value,
						change: function(event, ui) {
							jQuery(this).parent().parent().find('.sgrb-each-rate-skin').val(ui.value);
						}
					}).slider("pips", {
						rest: false,
						labels:100
					}).slider("float", {
					});
					mainWrapper.find('.sgrb-circle-total').attr('style','float:right !important;');
				}
				else {
					jQuery('input[name=sgRate]').each(function(){
						var sgRate = jQuery(this).val();
						jQuery(this).prev().slider({
							max:100,
							value: sgRate,
							change: function(event, ui) {
								jQuery(this).parent().parent().find('.sgrb-each-rate-skin').val(ui.value);
							}
						}).slider("pips", {
							rest: false,
							labels:100
						}).slider("float", {
						});
						mainWrapper.find('.sgrb-circle-total').attr('style','float:right !important;');
					});
				}
			}
		}
		else if (type == SGRB.sgrbRateTypePoint) {
			var point = mainWrapper.find('.sgrb-point');
			var pointEditable = mainWrapper.find('.sgrb-point-user-edit');
			mainFinalRate.parent().css('margin','30px 15px 30px 0');
			skinHtml = '<select class="sgrb-point">'+
									  '<option value="1">1</option>'+
									  '<option value="2">2</option>'+
									  '<option value="3">3</option>'+
									  '<option value="4">4</option>'+
									  '<option value="5">5</option>'+
									  '<option value="6">6</option>'+
									  '<option value="7">7</option>'+
									  '<option value="8">8</option>'+
									  '<option value="9">9</option>'+
									  '<option value="10">10</option>'+
								'</select>';
			if (!mainWrapper.find('.sgrb-row-category').is(':visible') && mainWrapper.find('.sgrb-widget-wrapper')) {
				jQuery(document).ajaxComplete(function(){
					mainWrapper.find('.sgrb-each-comment-rate').append(skinHtml).attr('style','padding:0 !important;min-height:30px;');
					mainWrapper.find('.sgrb-approved-comments-wrapper').each(function(){
						var value = jQuery(this).find('.sgrb-each-comment-avg-widget').val();
						var avgVal = 0;
						value = value.split(',');
						for (var i=0;i<value.length;i++) {
							avgVal = parseInt(avgVal+parseInt(value[i]));
						}
						avgVal = Math.round(avgVal/value.length);
						jQuery(this).find('.sgrb-point').barrating({
							theme : 'bars-1to10',
							readonly: true
						});
						jQuery(this).find('.sgrb-point').barrating('set', avgVal);
						mainWrapper.find(".br-wrapper").attr('style','margin-top: 2px !important;');
						mainWrapper.find('.sgrb-point').parent().find('a').attr("style", 'width:8%;box-shadow:none;border:1px solid #dbe867;');
						mainWrapper.find('.br-current-rating').attr('style','height:27px !important;line-height:1.5 !important;');
					});
				});
			}
			if (!isRated) {
				mainWrapper.find('.sgrb-rate-each-skin-wrapper').each(function(){
					jQuery(this).find('.sgrb-point').barrating({
						theme : 'bars-1to10',
						readonly: true
					});
				});
				point.barrating('show');
			}
			if (isRated) {
				mainWrapper.find('.sgrb-rate-each-skin-wrapper').each(function(){
					var pointValue = jQuery(this).find('.sgrb-each-category-total').val();
					pointValue = Math.round(pointValue);
					jQuery(this).find('.sgrb-point').barrating({
						theme : 'bars-1to10',
						readonly: true
					});
					jQuery(this).find('.sgrb-point').barrating('set',pointValue);
				});
				point.barrating('show');
			}
			if (mainWrapper.find('input[name=sgRate]').val()) {
				mainWrapper.find('.sgrb-rate-each-skin-wrapper').each(function(){
					var sgRate = jQuery(this).find('.sgrb-each-category-total').val();
					pointEditable.barrating({
						theme : 'bars-1to10',
						onSelect: function (value, text, event) {
							this.$widget.parent().parent().parent().find('.sgrb-each-rate-skin').val(value);
							mainFinalRate.text(value);
							mainFinalRate.attr('style','margin:8px 0 0 30px;color: rgb(237, 184, 103); display: inline-block;width:70px;height:70px;position:relative;font-size:4em;text-align:center');
						}
					});
					jQuery(this).find('.sgrb-point-user-edit').barrating('set', sgRate);
				});
			}
				point.barrating('show');
				mainWrapper.find('.br-current-rating').attr('style','display:none');
				mainWrapper.find(".br-wrapper").attr("style", 'display:inline-block;float:right;height:28px;');
				mainWrapper.find('.sgrb-each-rate-skin').each(function(){
					var skinColor = mainWrapper.find('.sgrb-skin-color').val(),
						colorOptions = '';

					if (skinColor) {
						colorOptions += 'background-color:'+skinColor;
					}
					point.parent().find('a').attr("style", 'width:9px;box-shadow:none;border:1px solid #dbe867;');
					pointEditable.parent().find('a').attr("style", 'width:9px;box-shadow:none;border:1px solid #dbe867;');
				});
				mainWrapper.find('.sgrb-user-comment-submit').on('click', function(){
					point.barrating('readonly',true);
				});
		}
	});

});
