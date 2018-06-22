jQuery(document).ready(function(){
	_ppsUpdateSubSbLists();
	jQuery('#ppsPopupEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_ppsUpdateSubSbLists();
	});
	jQuery('#ppsPopupEditForm').find('[name="params[tpl][sub_sb_api_key]"]').change(function(){
		_ppsUpdateSubSbLists();
	});
});
function _ppsUpdateSubSbLists() {
	if(jQuery('#ppsPopupEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'sendinblue') {
		var apiKey = jQuery.trim(jQuery('#ppsPopupEditForm input[name="params[tpl][sub_sb_api_key]"]').val());
		jQuery('#ppsSubSbListsShell').hide();
		jQuery.sendFormPps({
			msgElID: 'ppsSubSbMsg'
		,	data: {mod: 'sendinblue', action: 'getLists', api_key: apiKey}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#ppsSubSbLists').html('');
					var selectedListsIds = ppsPopup && ppsPopup.params.tpl && ppsPopup.params.tpl.sub_sb_lists ? ppsPopup.params.tpl.sub_sb_lists : [];
					for(var i in res.data.lists) {
						var listId = res.data.lists[ i ].id
						,	listName = res.data.lists[ i ].name
						,	selected = toeInArrayPps(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#ppsSubSbLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ listName+ '</option>');
					}
					jQuery('#ppsSubSbListsShell').show();
					jQuery('#ppsSubSbLists').chosen().trigger('chosen:updated');
				}
			}
		});
	}
}