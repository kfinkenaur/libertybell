jQuery(document).ready(function(){
	_cfsUpdateSubSgLists();
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_cfsUpdateSubSgLists();
	});
	jQuery('#cfsFormEditForm input[name="sub_sg_api_name"]').change(function(){
		_cfsUpdateSubSgLists();
	});
	jQuery('#cfsFormEditForm input[name="sub_sg_api_key"]').change(function(){
		_cfsUpdateSubSgLists();
	});
});
function _cfsUpdateSubSgLists() {
	if(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'sendgrid') {
		jQuery('#cfsSubSgListsShell').hide();
		jQuery.sendFormCfs({
			msgElID: 'cfsSubSgMsg'
		,	data: {
				mod: 'sendgrid'
			,	action: 'getLists'
			,	sub_sg_api_name: jQuery('#cfsFormEditForm input[name="sub_sg_api_name"]').val()
			,	sub_sg_api_key: jQuery('#cfsFormEditForm input[name="sub_sg_api_key"]').val()
			}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#cfsSubSgLists').html('');
					var selectedListsIds = cfsForm && cfsForm.params.tpl && cfsForm.params.tpl.sub_sg_lists ? cfsForm.params.tpl.sub_sg_lists : [];
					for(var listId in res.data.lists) {
						var selected = toeInArrayCfs(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#cfsSubSgLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ res.data.lists[ listId ]+ '</option>');
					}
					jQuery('#cfsSubSgListsShell').show();
					jQuery('#cfsSubSgLists').chosen().trigger('chosen:updated');
				}
			}
		});
	}
}

