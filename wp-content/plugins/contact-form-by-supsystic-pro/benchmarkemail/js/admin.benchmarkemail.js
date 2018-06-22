jQuery(document).ready(function(){
	_cfsUpdateSubBeLists();
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_cfsUpdateSubBeLists();
	});
	jQuery('#cfsFormEditForm').find('[name="sub_be_login"]').change(function(){
		_cfsUpdateSubBeLists();
	});
	jQuery('#cfsFormEditForm').find('[name="sub_be_pass"]').change(function(){
		_cfsUpdateSubBeLists();
	});
	// This don't work, need to use jquery.on() here, but it is too much processor time for this small feature
	/*jQuery('.cfsBeHelpApiKeyLink').click(function(){
		var $dialog = jQuery('<div />').html('<img src="'+ jQuery(this).attr('href')+ '" />').dialog({
			modal:    true
		,	width: 800
		,	height: 333
		,	buttons: {
				OK: function() {
					$dialog.dialog('close');
				}
			}
		,	close: function() {
				$dialog.remove();
			}
		});
		return false;
	});*/
});
function _cfsUpdateSubBeLists() {
	if(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'benchmarkemail') {
		var login = jQuery.trim(jQuery('#cfsFormEditForm input[name="sub_be_login"]').val())
		,	pass = jQuery.trim(jQuery('#cfsFormEditForm input[name="sub_be_pass"]').val());
		jQuery('#cfsSubBeListsShell').hide();
		jQuery.sendFormCfs({
			msgElID: 'cfsSubBeMsg'
		,	data: {mod: 'benchmarkemail', action: 'getLists', sub_be_login: login, sub_be_pass: pass}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#cfsSubBeLists').html('');
					var selectedListsIds = cfsForm && cfsForm.params.tpl && cfsForm.params.tpl.sub_be_lists ? cfsForm.params.tpl.sub_be_lists : [];
					for(var i in res.data.lists) {
						var listId = res.data.lists[ i ].id
						,	listName = res.data.lists[ i ].name
						,	selected = toeInArrayCfs(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#cfsSubBeLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ listName+ '</option>');
					}
					jQuery('#cfsSubBeListsShell').show();
					jQuery('#cfsSubBeLists').chosen().trigger('chosen:updated');
				}
			}
		});
	}
}