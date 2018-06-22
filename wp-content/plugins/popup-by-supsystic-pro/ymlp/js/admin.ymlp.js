jQuery(document).ready(function(){
	_ppsUpdateSubYmlpLists();
	jQuery('#ppsPopupEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_ppsUpdateSubYmlpLists();
	});
	jQuery('#ppsPopupEditForm').find('[name="params[tpl][sub_ymlp_api_key]"]').change(function(){
		_ppsUpdateSubYmlpLists();
	});
	jQuery('#ppsPopupEditForm').find('[name="params[tpl][sub_ymlp_name]"]').change(function(){
		_ppsUpdateSubYmlpLists();
	});
});
function _ppsUpdateSubYmlpLists() {
	if(jQuery('#ppsPopupEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'ymlp') {
		var apiKey = jQuery.trim(jQuery('#ppsPopupEditForm input[name="params[tpl][sub_ymlp_api_key]"]').val())
		,	username = jQuery.trim(jQuery('#ppsPopupEditForm input[name="params[tpl][sub_ymlp_name]"]').val());
		jQuery('#ppsSubYmlpListsShell').hide();
		jQuery.sendFormPps({
			msgElID: 'ppsSubYmlpMsg'
		,	data: {mod: 'ymlp', action: 'getLists', api_key: apiKey, username: username}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#ppsSubYmlpLists').html('');
					var selectedListsIds = ppsPopup && ppsPopup.params.tpl && ppsPopup.params.tpl.sub_ymlp_lists ? ppsPopup.params.tpl.sub_ymlp_lists : [];
					for(var i in res.data.lists) {
						var listId = res.data.lists[ i ].id
						,	listName = res.data.lists[ i ].name
						,	selected = toeInArrayPps(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#ppsSubYmlpLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ listName+ '</option>');
					}
					jQuery('#ppsSubYmlpListsShell').show();
					jQuery('#ppsSubYmlpLists').chosen().trigger('chosen:updated');
				}
			}
		});
	}
}