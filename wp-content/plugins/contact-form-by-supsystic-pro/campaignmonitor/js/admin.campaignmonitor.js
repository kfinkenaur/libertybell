jQuery(document).ready(function(){
	_cfsUpdateSubCmLists();
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_cfsUpdateSubCmLists();
	});
});
function _cfsUpdateSubCmLists() {
	if(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'campaignmonitor') {
		jQuery('#cfsSubCmListsShell').hide();
		jQuery.sendFormCfs({
			msgElID: 'cfsSubCmMsg'
		,	data: {mod: 'campaignmonitor', action: 'getLists'}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#cfsSubCmLists').html('');
					var selectedListsIds = cfsForm && cfsForm.params.tpl && cfsForm.params.tpl.sub_cm_lists ? cfsForm.params.tpl.sub_cm_lists : [];
					for(var listId in res.data.lists) {
						var selected = toeInArrayCfs(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#cfsSubCmLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ res.data.lists[ listId ]+ '</option>');
					}
					jQuery('#cfsSubCmListsShell').show();
					jQuery('#cfsSubCmLists').chosen().trigger('chosen:updated');
				}
			}
		});
	}
}

