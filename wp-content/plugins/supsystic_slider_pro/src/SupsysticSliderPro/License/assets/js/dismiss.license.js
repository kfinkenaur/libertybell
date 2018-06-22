jQuery(document).ready(function(){
	jQuery(document).on('click', '.supsystic-pro-notice.ss-notification .notice-dismiss', function(){
		jQuery.post(window.ajaxurl, {
			action: 'supsystic-slider'
		,	route: {
				module: 'license'
			,	action: 'dismissNotice'
			}
		});
	});
});