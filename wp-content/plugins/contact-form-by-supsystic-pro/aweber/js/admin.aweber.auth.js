jQuery(document).ready(function(){
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_aw_c_key]"]').change(function(){
		_cfsCheckAwebeerAuthUrl();
	});
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_aw_c_secret]"]').change(function(){
		_cfsCheckAwebeerAuthUrl();
	});
});
function _cfsCheckAwebeerAuthUrl() {
	if(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'aweber') {
		var key = jQuery.trim(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_aw_c_key]"]').val())
		,	secret = jQuery.trim(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_aw_c_secret]"]').val());
		if(key && secret) {
			jQuery.sendFormCfs({
				msgElID: 'cfsAweberAuthMsg'
			,	data: {mod: 'aweber', action: 'getAuthUrl', key: key, secret: secret, clb_url: jQuery('.cfsAweberAuthBtn').data('clb-url')}
			,	onSuccess: function(res) {
					if(!res.error) {
						jQuery('.cfsAweberAuthBtn').attr('href', res.data.url);
						jQuery('.cfsAweberAuthBtnRow').show();
					} else {
						jQuery('.cfsAweberAuthBtnRow').hide();
					}
				}
			});
			
		}
	}
}