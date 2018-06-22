jQuery(document).ready(function(){
	_ppsUpdateSubV6Lists();
	jQuery('#ppsPopupEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_ppsUpdateSubV6Lists();
	});
	jQuery('#ppsPopupEditForm').find('[name="params[tpl][sub_v6_api_key]"]').change(function(){
		_ppsUpdateSubV6Lists();
	});
});
function _ppsUpdateSubV6Lists() {
	if(jQuery('#ppsPopupEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'vision6') {
		var apiKey = jQuery.trim(jQuery('#ppsPopupEditForm input[name="params[tpl][sub_v6_api_key]"]').val());
		jQuery('#ppsSubV6ListsShell').hide();
		jQuery.sendFormPps({
			msgElID: 'ppsSubV6Msg'
		,	data: {mod: 'vision6', action: 'getLists', api_key: apiKey}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#ppsSubV6Lists').html('');
					var selectedListsIds = ppsPopup && ppsPopup.params.tpl && ppsPopup.params.tpl.sub_v6_lists ? ppsPopup.params.tpl.sub_v6_lists : [];
					for(var i in res.data.lists) {
						var listId = res.data.lists[ i ].id
						,	listName = res.data.lists[ i ].name
						,	selected = toeInArrayPps(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#ppsSubV6Lists').append('<option '+ selected+ ' value="'+ listId+ '">'+ listName+ '</option>');
					}
					jQuery('#ppsSubV6ListsShell').show();
					jQuery('#ppsSubV6Lists').chosen().trigger('chosen:updated');
				}
			}
		});
	}
}