jQuery(document).ready(function(){
	_cfsUpdateSubFeedbLists();
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_cfsUpdateSubFeedbLists();
	});
	jQuery('#cfsFormEditForm input[name="params[tpl][sub_feedb_key]"]').change(function(){
		_cfsUpdateSubFeedbLists();
	});
});
function _cfsUpdateSubFeedbLists() {
	if(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'feedblitz') {
		jQuery('#cfsSubFeedbListsShell').hide();
		jQuery.sendFormCfs({
			msgElID: 'cfsSubFeedbMsg'
		,	data: {
				mod: 'feedblitz'
			,	action: 'getLists'
			,	sub_feedb_api_name: jQuery('#cfsFormEditForm input[name="sub_feedb_api_name"]').val()
			,	sub_feedb_api_key: jQuery('#cfsFormEditForm input[name="sub_feedb_api_key"]').val()
			}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#cfsSubFeedbLists').html('');
					var selectedListsIds = cfsForm && cfsForm.params.tpl && cfsForm.params.tpl.sub_feedb_lists ? cfsForm.params.tpl.sub_feedb_lists : [];
					for(var listId in res.data.lists) {
						var selected = toeInArrayCfs(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#cfsSubFeedbLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ res.data.lists[ listId ]+ '</option>');
					}
					jQuery('#cfsSubFeedbListsShell').show();
					jQuery('#cfsSubFeedbLists').chosen().trigger('chosen:updated');
				}
			}
		});
	}
}

