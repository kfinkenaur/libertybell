jQuery(document).ready(function(){
	_cfsUpdateSubVrLists();
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_cfsUpdateSubVrLists();
	});
});
function _cfsUpdateSubVrLists() {
	if(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'verticalresponse') {
		jQuery('#cfsSubVrListsShell').hide();
		jQuery.sendFormCfs({
			msgElID: 'cfsSubVrMsg'
		,	data: {mod: 'verticalresponse', action: 'getLists'}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#cfsSubVrLists').html('');
					var selectedListsIds = cfsForm && cfsForm.params.tpl && cfsForm.params.tpl.sub_vr_lists ? cfsForm.params.tpl.sub_vr_lists : [];
					for(var i in res.data.lists) {
						var listId = res.data.lists[ i ].id
						,	listName = res.data.lists[ i ].name
						,	selected = toeInArrayCfs(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#cfsSubVrLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ listName+ '</option>');
					}
					jQuery('#cfsSubVrListsShell').show();
					jQuery('#cfsSubVrLists').chosen().trigger('chosen:updated');
				}
			}
		});
	}
}