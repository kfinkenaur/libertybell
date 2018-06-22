jQuery(document).ready(function(){
	_cfsUpdateSubCkLists();
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_cfsUpdateSubCkLists();
	});
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_ck_api_key]"]').change(function(){
		_cfsUpdateSubCkLists();
	});
});
function _cfsUpdateSubCkLists() {
	if(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'convertkit') {
		var apiKey = jQuery.trim(jQuery('#cfsFormEditForm input[name="params[tpl][sub_ck_api_key]"]').val());
		jQuery('#cfsSubCkListsShell').hide();
		jQuery.sendFormCfs({
			msgElID: 'cfsSubCkMsg'
		,	data: {mod: 'convertkit', action: 'getLists', api_key: apiKey}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#cfsSubCkLists').html('');
					var selectedListsIds = cfsForm && cfsForm.params.tpl && cfsForm.params.tpl.sub_ic_lists ? cfsForm.params.tpl.sub_ic_lists : [];
					for(var i in res.data.lists) {
						var listId = res.data.lists[ i ].id
						,	listName = res.data.lists[ i ].name
						,	selected = toeInArrayCfs(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#cfsSubCkLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ listName+ '</option>');
					}
					jQuery('#cfsSubCkListsShell').show();
					jQuery('#cfsSubCkLists').chosen().trigger('chosen:updated');
				}
			}
		});
	}
}