jQuery(document).ready(function(){
	_cfsUpdateAweberLists();
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_cfsUpdateAweberLists();
	});
});
function _cfsUpdateAweberLists() {
	if(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'aweber') {
		jQuery('#cfsAweberListsShell').hide();
		jQuery('#cfsAweberNoApiKey').hide();
		jQuery.sendFormCfs({
			msgElID: 'cfsAweberMsg'
		,	data: {mod: 'aweber', action: 'getLists'}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#cfsAweberLists').html('');
					var selectedListsIds = cfsForm && cfsForm.params.tpl && cfsForm.params.tpl.sub_aweber_lists ? cfsForm.params.tpl.sub_aweber_lists : [];
					for(var listId in res.data.lists) {
						var selected = toeInArrayCfs(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#cfsAweberLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ res.data.lists[ listId ]+ '</option>');
					}
					jQuery('#cfsAweberListsShell').show();
					jQuery('#cfsAweberLists').chosen().trigger('chosen:updated');
				}
			}
		});
	} else {
		jQuery('#cfsAweberNoApiKey').show();
		jQuery('#cfsAweberListsShell').hide();
	}
}