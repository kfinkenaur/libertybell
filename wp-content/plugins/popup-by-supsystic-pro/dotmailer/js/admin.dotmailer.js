jQuery(document).ready(function(){
	_ppsUpdateSubDmsLists();
	jQuery('#ppsPopupEditForm').find('[name="params[tpl][sub_dms_api_user]"]').change(function(){
		_ppsUpdateSubDmsLists();
	});
	jQuery('#ppsPopupEditForm').find('[name="params[tpl][sub_dms_api_password]"]').change(function(){
		_ppsUpdateSubDmsLists();
	});
});
function _ppsUpdateSubDmsLists() {
	if(jQuery('#ppsPopupEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'dotmailer') {
		var apiUser = jQuery.trim(jQuery('#ppsPopupEditForm input[name="params[tpl][sub_dms_api_user]"]').val())
		,	apiPassword = jQuery.trim(jQuery('#ppsPopupEditForm input[name="params[tpl][sub_dms_api_password]"]').val());
		if(apiUser && apiPassword) {
			jQuery('#ppsSubDmsListsShell').hide();
			jQuery.sendFormPps({
				msgElID: 'ppsSubDmsMsg'
			,	data: {mod: 'dotmailer', action: 'getLists', sub_dms_api_user: apiUser, sub_dms_api_password: apiPassword}
			,	onSuccess: function(res) {
					if(!res.error) {
						jQuery('#ppsSubDmsLists').html('');
						var selectedListsIds = ppsPopup && ppsPopup.params.tpl && ppsPopup.params.tpl.sub_dms_lists ? ppsPopup.params.tpl.sub_dms_lists : [];
						for(var i in res.data.lists) {
							var listId = res.data.lists[ i ].id
							,	listName = res.data.lists[ i ].name
							,	selected = toeInArrayPps(listId, selectedListsIds) ? 'selected="selected"' : '';
							jQuery('#ppsSubDmsLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ listName+ '</option>');
						}
						jQuery('#ppsSubDmsListsShell').show();
						jQuery('#ppsSubDmsLists').chosen().trigger('chosen:updated');
					}
				}
			});
		}
	}
}