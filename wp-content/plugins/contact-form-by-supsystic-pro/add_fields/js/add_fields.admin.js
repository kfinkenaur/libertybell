jQuery(document).bind('cfsAfterFieldsEditInit', function(){
	g_cfsFieldsFrame._$editWnd.find('[name="value_preset"]').change(function(){
		var presetValue = jQuery(this).val();
		g_cfsFieldsFrame._$editWnd.find('[name="value"]').val( presetValue ? '['+ presetValue+ ']' : '');
	});
});