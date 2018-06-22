jQuery(document).ready(function(){
	_cfsUpdateSubCcLists();
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_cfsUpdateSubCcLists();
	});
});
function _cfsUpdateSubCcLists() {
	if(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'constantcontact') {
		jQuery('#cfsSubCcListsShell').hide();
		jQuery.sendFormCfs({
			msgElID: 'cfsSubCcMsg'
		,	data: {mod: 'constantcontact', action: 'getLists'}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#cfsSubCcLists').html('');
					var selectedListsIds = cfsForm && cfsForm.params.tpl && cfsForm.params.tpl.sub_cc_lists ? cfsForm.params.tpl.sub_cc_lists : [];
					for(var listId in res.data.lists) {
						var selected = toeInArrayCfs(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#cfsSubCcLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ res.data.lists[ listId ]+ '</option>');
					}
					jQuery('#cfsSubCcListsShell').show();
					jQuery('#cfsSubCcLists').chosen().trigger('chosen:updated');
				}
			}
		});
	}
}
