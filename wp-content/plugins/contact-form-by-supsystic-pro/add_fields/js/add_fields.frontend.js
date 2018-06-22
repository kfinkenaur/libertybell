function cfsBeforeStartFileUpload(filename, filedata, butId) {
	var $btn = jQuery('#'+ butId)
	,	$msg = $btn.parent().find('.cfsFileSubmitMsg');
	$msg.showLoaderCfs();
}
function cfsAfterFileUpload(filename, res, butId) {
	var $btn = jQuery('#'+ butId)
	,	$msg = $btn.parent().find('.cfsFileSubmitMsg');
	toeProcessAjaxResponseCfs( res, $msg );
	if(!res.error && res.data && res.data.pub_hash) {
		jQuery('#'+ butId+ '_hidden').val( res.data.pub_hash );
	} else {
		jQuery('#'+ butId+ '_hidden').val( 0 );
	}
}
jQuery(document).bind('cfsAfterFormInit', function( event, form ){
	var fields = form.getFields();
	if(fields) {
		for(var i = 0; i < fields.length; i++) {
			if(fields[ i ]) {
				if( fields[ i ].value_preset ) {
					switch( fields[ i ].value_preset ) {
						case 'page_title':
							var $input = form.getFieldInput( fields[ i ].name );
							if($input && $input.size()) {
								$input.val( document.title );
							}
							break;
					}
				}
				switch( fields[ i ].html ) {
					case 'rating':
						var $input = form.getFieldInput( fields[ i ].name )
						,	$rateShell = $input.parents('.cfsRateShell:first')
						,	$rateBtns = $rateShell.find('.cfsRateBtn');
						if( $rateBtns && $rateBtns.size() ) {
							var markBtnsClb = function( rate, btn ) {
								var $rateBtns = jQuery( btn ).parents('.cfsRateShell:first').find('.cfsRateBtn');
								$rateBtns.removeClass('active').each(function(){
									var currRate = parseInt( jQuery(this).attr('href') );
									if( currRate <= rate ) {
										jQuery(this).addClass('active');
									} else 
										return false;
								});
							},	rateId = 'cfsRate_'+ randCfs(1, 999999);
							$input.attr('id', rateId);
							$rateBtns.data('rate-id', rateId);
							$rateBtns.click(function(){
								var rate = parseInt( jQuery(this).attr('href') )
								,	$input = jQuery('#'+ jQuery(this).data('rate-id'));
								$input.val( rate );
								markBtnsClb( rate, this );
								return false;
							}).hover(function(){
								var rate = parseInt( jQuery(this).attr('href') );
								markBtnsClb( rate, this );
							}, function( e ){
								var $input = jQuery('#'+ jQuery(this).data('rate-id'))
								,	rate = parseInt( $input.val() );
								markBtnsClb( rate, this );
							});
						}
						break;
					case 'file':
						var fileInput = fields[ i ].name+ '_file'
						,	$input = form.getFieldInput( fileInput );
						$input.fileupload({
							dataType: 'json'
						,	formData: {script: true}
						,	done: function (e, data) {
								var $parent = jQuery(this).parents('.cfsFieldShell:first')
								,	$filesShell = $parent.find('.cfsFileList:first')
								,	$msg = $parent.find('.cfsFileSubmitMsg');
								$msg.html('');
								if(data.result.error) {
									toeProcessAjaxResponseCfs(data.result, $msg);
									return;
								}
								if(data.result && data.result.data) {
									var $newFileShell = jQuery('<p class="cfsFileUploadedShell" />')
										.text( data.result.data.name )
										.appendTo( $filesShell )
									,	$removeBtn = jQuery('<a href="#" class="cfsFileRemoveBtn">Remove</a>')
									,	$this = jQuery( this );
									jQuery( $newFileShell ).append('<input type="hidden" name="fields['+ data.result.data.field_name+ '][]" value="'+ data.result.data.pub_hash+ '" />');
									jQuery( $newFileShell ).append('<span class="msgRemoveFile" />');
									jQuery( $newFileShell ).append( $removeBtn );
									$removeBtn.click(function(){
										var $parentShell = jQuery(this).parents('.cfsFileUploadedShell:first')
										,	fileHash = $parentShell.find('[type="hidden"]').val();
										jQuery.sendFormCfs({
											msgElID: $parentShell.find('.msgRemoveFile')
										,	data: {mod: 'add_fields', action: 'removeFile', hash: fileHash, fid: form.get('id')}
										,	onSuccess: function( res ){
												if(!res.error) {
													if($parentShell.parents('.cfsFileList:first').find('.cfsFileUploadedShell').size() <= 1
														&& $this.get(0)._cfsRequired
													) {
														// Get back required attribute
														$this.attr('required', 'required');
													}
													$parentShell.animateRemoveCfs( g_cfsAnimationSpeed );
												}
											}
										});
										return false;
									});
									// We will check here it's required settings
									var isRequired = $this.attr('required');
									if( isRequired ) {
										this._cfsRequired = true;
										// We create additional hidden fields for each file - so we will not need it to be required actually
										$this.removeAttr('required');
									}
								}
							}
						,	progressall: function (e, data) {
								var progress = parseInt(data.loaded / data.total * 100, 10)
								,	$progrBar = jQuery(this).parents('.cfsFieldShell:first').find('.cfsFileUploadProgress');
								$progrBar.css('width', progress + '%');
								if(progress == 100) {	// After it was on 100% - let it be nuled after 3sec - to be able to fill-in one more time in next time
									setTimeout(function(){
										$progrBar.animate({
											opacity: 0
										}, g_cfsAnimationSpeed, function(){
											$progrBar.css({
												'width': 0
											,	'opacity': 1
											});
										});
									}, 3000);
								}
							}
						});
						break;
				}
			}
		}
	}
});