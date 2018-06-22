jQuery(document).ready(function(){
	_cfsUpdateSubSbLists();
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_cfsUpdateSubSbLists();
	});
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_sb_api_key]"]').change(function(){
		_cfsUpdateSubSbLists();
	});
});
function _cfsUpdateSubSbLists() {
	if(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'sendinblue') {
		var apiKey = jQuery.trim(jQuery('#cfsFormEditForm input[name="params[tpl][sub_sb_api_key]"]').val());
		jQuery('#cfsSubSbListsShell').hide();
		jQuery.sendFormCfs({
			msgElID: 'cfsSubSbMsg'
		,	data: {mod: 'sendinblue', action: 'getLists', api_key: apiKey}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#cfsSubSbLists').html('');
					var selectedListsIds = cfsForm && cfsForm.params.tpl && cfsForm.params.tpl.sub_sb_lists ? cfsForm.params.tpl.sub_sb_lists : [];
					for(var i in res.data.lists) {
						var listId = res.data.lists[ i ].id
						,	listName = res.data.lists[ i ].name
						,	selected = toeInArrayCfs(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#cfsSubSbLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ listName+ '</option>');
					}
					jQuery('#cfsSubSbListsShell').show();
					jQuery('#cfsSubSbLists').chosen().trigger('chosen:updated');
				}
			}
		});
	}
}