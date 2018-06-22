jQuery(document).ready(function(){
	_cfsUpdateSubAcLists();
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_cfsUpdateSubAcLists();
	});
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_ac_api_url]"]').change(function(){
		_cfsUpdateSubAcLists();
	});
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_ac_api_key]"]').change(function(){
		_cfsUpdateSubAcLists();
	});
	// This don't work, need to use jquery.on() here, but it is too much processor time for this small feature
	/*jQuery('.cfsAcHelpApiKeyLink').click(function(){
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
function _cfsUpdateSubAcLists() {
	if(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'activecampaign') {
		var apiKey = jQuery.trim(jQuery('#cfsFormEditForm input[name="params[tpl][sub_ac_api_key]"]').val())
		,	apiUrl = jQuery.trim(jQuery('#cfsFormEditForm input[name="params[tpl][sub_ac_api_url]"]').val());
		jQuery('#cfsSubAcListsShell').hide();
		jQuery.sendFormCfs({
			msgElID: 'cfsSubAcMsg'
		,	data: {mod: 'activecampaign', action: 'getLists', api_key: apiKey, api_url: apiUrl}
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#cfsSubAcLists').html('');
					var selectedListsIds = cfsForm && cfsForm.params.tpl && cfsForm.params.tpl.sub_ac_lists ? cfsForm.params.tpl.sub_ac_lists : [];
					for(var i in res.data.lists) {
						var listId = res.data.lists[ i ].id
						,	listName = res.data.lists[ i ].name
						,	selected = toeInArrayCfs(listId, selectedListsIds) ? 'selected="selected"' : '';
						jQuery('#cfsSubAcLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ listName+ '</option>');
					}
					jQuery('#cfsSubAcListsShell').show();
					jQuery('#cfsSubAcLists').chosen().trigger('chosen:updated');
				}
			}
		});
	}
}