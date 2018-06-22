jQuery(document).ready(function(){
	_cfsUpdateSubIcLists();
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_cfsUpdateSubIcLists();
	});
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_ic_app_id]"]').change(function(){
		_cfsUpdateSubIcLists();
	});
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_ic_app_user]"]').change(function(){
		_cfsUpdateSubIcLists();
	});
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_ic_app_pass]"]').change(function(){
		_cfsUpdateSubIcLists();
	});
});
function _cfsUpdateSubIcLists() {
	if(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'icontact') {
		var appId = jQuery.trim(jQuery('#cfsFormEditForm input[name="params[tpl][sub_ic_app_id]"]').val())
		,	appUser = jQuery.trim(jQuery('#cfsFormEditForm input[name="params[tpl][sub_ic_app_user]"]').val())
		,	appPass = jQuery.trim(jQuery('#cfsFormEditForm input[name="params[tpl][sub_ic_app_pass]"]').val());
		jQuery('#cfsSubIcListsShell').hide();
		jQuery.sendFormCfs({
			msgElID: 'cfsSubIcMsg'
		,	data: {mod: 'icontact', action: 'getLists', app_id: appId, app_user: appUser, app_pass: appPass}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#cfsSubIcLists').html('');
					var selectedListsIds = cfsForm && cfsForm.params.tpl && cfsForm.params.tpl.sub_ic_lists ? cfsForm.params.tpl.sub_ic_lists : [];
					for(var i in res.data.lists) {
						var listId = res.data.lists[ i ].id
						,	listName = res.data.lists[ i ].name
						,	selected = toeInArrayCfs(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#cfsSubIcLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ listName+ '</option>');
					}
					jQuery('#cfsSubIcListsShell').show();
					jQuery('#cfsSubIcLists').chosen().trigger('chosen:updated');
				}
			}
		});
	}
}