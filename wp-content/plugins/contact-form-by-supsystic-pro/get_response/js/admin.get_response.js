jQuery(document).ready(function(){
	_cfsUpdateSubGrLists();
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_cfsUpdateSubGrLists();
	});
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_gr_api_key]"]').change(function(){
		_cfsUpdateSubGrLists();
	});
});
function _cfsUpdateSubGrLists() {
	if(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'get_response') {
		var apiKey = jQuery.trim(jQuery('#cfsFormEditForm input[name="params[tpl][sub_gr_api_key]"]').val());
		jQuery('#cfsSubGrListsShell').hide();
		jQuery.sendFormCfs({
			msgElID: 'cfsSubGrMsg'
		,	data: {mod: 'get_response', action: 'getLists', api_key: apiKey}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#cfsSubGrLists').html('');
					var selectedListsIds = cfsForm && cfsForm.params.tpl && cfsForm.params.tpl.sub_gr_lists ? cfsForm.params.tpl.sub_gr_lists : [];
					for(var i in res.data.lists) {
						var listId = res.data.lists[ i ].id
						,	listName = res.data.lists[ i ].name
						,	selected = toeInArrayCfs(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#cfsSubGrLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ listName+ '</option>');
					}
					jQuery('#cfsSubGrListsShell').show();
					jQuery('#cfsSubGrLists').chosen().trigger('chosen:updated');
				}
			}
		});
	}
}