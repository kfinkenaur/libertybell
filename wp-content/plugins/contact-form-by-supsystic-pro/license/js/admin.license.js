jQuery(document).ready(function(){
	jQuery('#cfsLicenseForm').submit(function(){
		jQuery(this).sendFormCfs({
			btn: jQuery(this).find('button.button-primary')
		,	onSuccess: function(res) {
				if(!res.error) {
					toeReload();
				}
			}
		});
		return false;
	});
});
