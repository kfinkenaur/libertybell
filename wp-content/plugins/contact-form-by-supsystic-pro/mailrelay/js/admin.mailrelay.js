jQuery(document).ready(function(){
	_cfsUpdateSubMrLists();
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_cfsUpdateSubMrLists();
	});
	jQuery('#cfsFormEditForm input[name="sub_mr_api_host"]').change(function(){
		_cfsUpdateSubMrLists();
	});
	jQuery('#cfsFormEditForm input[name="sub_mr_api_key"]').change(function(){
		_cfsUpdateSubMrLists();
	});
});
function _cfsUpdateSubMrLists() {
	if(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'mailrelay') {
		jQuery('#cfsSubMrListsShell').hide();
		jQuery.sendFormCfs({
			msgElID: 'cfsSubMrMsg'
		,	data: {
				mod: 'mailrelay'
			,	action: 'getLists'
			,	sub_mr_api_host: jQuery('#cfsFormEditForm input[name="sub_mr_api_host"]').val()
			,	sub_mr_api_key: jQuery('#cfsFormEditForm input[name="sub_mr_api_key"]').val()
			}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#cfsSubMrLists').html('');
					var selectedListsIds = cfsForm && cfsForm.params.tpl && cfsForm.params.tpl.sub_mr_lists ? cfsForm.params.tpl.sub_mr_lists : [];
					for(var listId in res.data.lists) {
						var selected = toeInArrayCfs(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#cfsSubMrLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ res.data.lists[ listId ]+ '</option>');
					}
					jQuery('#cfsSubMrListsShell').show();
					jQuery('#cfsSubMrLists').chosen().trigger('chosen:updated');
				}
			}
		});
	}
}

