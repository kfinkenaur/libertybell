jQuery(document).ready(function(){
	_ppsUpdateSub4dLists();
	jQuery('#ppsPopupEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_ppsUpdateSub4dLists();
	});
	jQuery('#ppsPopupEditForm').find('[name="params[tpl][sub_4d_name]"]').change(function(){
		_ppsUpdateSub4dLists();
	});
	jQuery('#ppsPopupEditForm').find('[name="params[tpl][sub_4d_pass]"]').change(function(){
		_ppsUpdateSub4dLists();
	});
});
function _ppsUpdateSub4dLists() {
	if(jQuery('#ppsPopupEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'fourdem') {
		var username = jQuery.trim(jQuery('#ppsPopupEditForm input[name="params[tpl][sub_4d_name]"]').val())
		,	password = jQuery.trim(jQuery('#ppsPopupEditForm input[name="params[tpl][sub_4d_pass]"]').val());
		jQuery('#ppsSub4dListsShell').hide();
		jQuery.sendFormPps({
			msgElID: 'ppsSub4dMsg'
		,	data: {mod: 'fourdem', action: 'getLists', username: username, pass: password}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#ppsSub4dLists').html('');
					var selectedListsIds = ppsPopup && ppsPopup.params.tpl && ppsPopup.params.tpl.sub_4d_lists ? ppsPopup.params.tpl.sub_4d_lists : [];
					for(var i in res.data.lists) {
						var listId = res.data.lists[ i ].id
						,	listName = res.data.lists[ i ].name
						,	selected = toeInArrayPps(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#ppsSub4dLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ listName+ '</option>');
					}
					jQuery('#ppsSub4dListsShell').show();
					jQuery('#ppsSub4dLists').chosen().trigger('chosen:updated');
				}
			}
		});
	}
}