jQuery(document).ready(function(){
	_cfsUpdateSubMemLists();
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_cfsUpdateSubMemLists();
	});
	jQuery('#cfsFormEditForm input[name="params[tpl][sub_mem_acc_id]"]').change(function(){
		_cfsUpdateSubMemLists();
	});
	jQuery('#cfsFormEditForm input[name="params[tpl][sub_mem_pud_key]"]').change(function(){
		_cfsUpdateSubMemLists();
	});
	jQuery('#cfsFormEditForm input[name="params[tpl][sub_mem_priv_key]"]').change(function(){
		_cfsUpdateSubMemLists();
	});
});
function _cfsUpdateSubMemLists() {
	if(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'myemma') {
		jQuery('#cfsSubMemListsShell').hide();
		jQuery.sendFormCfs({
			msgElID: 'cfsSubMemMsg'
		,	data: {
				mod: 'myemma'
			,	action: 'getLists'
			,	sub_mem_acc_id: jQuery('#cfsFormEditForm input[name="params[tpl][sub_mem_acc_id]"]').val()
			,	sub_mem_pud_key: jQuery('#cfsFormEditForm input[name="params[tpl][sub_mem_pud_key]"]').val()
			,	sub_mem_priv_key: jQuery('#cfsFormEditForm input[name="params[tpl][sub_mem_priv_key]"]').val()
			}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#cfsSubMemLists').html('');
					var selectedListsIds = cfsForm && cfsForm.params.tpl && cfsForm.params.tpl.sub_mem_lists ? cfsForm.params.tpl.sub_mem_lists : [];
					for(var listId in res.data.lists) {
						var selected = toeInArrayCfs(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#cfsSubMemLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ res.data.lists[ listId ]+ '</option>');
					}
					jQuery('#cfsSubMemListsShell').show();
					jQuery('#cfsSubMemLists').chosen().trigger('chosen:updated');
				}
			}
		});
	}
}

