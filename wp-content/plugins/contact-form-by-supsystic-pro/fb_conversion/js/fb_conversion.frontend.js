var g_cfsFbConvFids = [];
jQuery(document).bind('cfsAfterFormInit', function(e, form){
	if(form.getParam('tpl', 'enb_fb_convert') && form.getParam('tpl', 'fb_convert_base')) {
		g_cfsFbConvFids.push( form.get('id') );
		_cfsAddFbConvEvent('form_show', {
			'label': form.get('label')
		});
	}
});
jQuery(document).bind('cfsAfterFormSubmitSuccess', function(e, form){
	if(toeInArrayCfs( form.get('id'), g_cfsFbConvFids )) {
		_cfsAddFbConvEvent('form_submit', {
			'label': form.get('label')
		});
	}
});
function _cfsAddFbConvEvent( event, params ) {
	if(typeof(fbq) !== 'undefined') {
		fbq('track', event, params);
	}
}