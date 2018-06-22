jQuery(document).ready(function(){
	_cfsUpdateMailchimpLists();
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').change(function(){
		_cfsUpdateMailchimpLists();
	});
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_mailchimp_api_key]"]').change(function(){
		_cfsUpdateMailchimpLists();
	});
	jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_mailchimp_lists][]"]').change(function(){
		_cfsUpdateMailchimpGroups( jQuery(this).val() );
	});
	jQuery('#cfsMailchimpGroups').change(function(){
		var groups = jQuery(this).val();
		if(groups && groups != '' && groups.length) {
			var $groupsFull = jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_mailchimp_groups_full]"]')
			,	fullArr = [];
			for(var i = 0; i < groups.length; i++) {
				fullArr.push(groups[ i ]+ ':'+ jQuery(this).find('option[value="'+ groups[ i ]+ '"]').html());
			}
			$groupsFull.val(fullArr.join(';'));
		}
	});
	jQuery('#cfsFormEditForm [name="params[tpl][sub_dsbl_dbl_opt_id]"]').change(function(){
		jQuery(this).prop('checked')
			? jQuery('#cfsSubMcSendWelcome').slideDown( g_cfsAnimationSpeed )
			: jQuery('#cfsSubMcSendWelcome').slideUp( g_cfsAnimationSpeed );
	}).change();
});
function _cfsUpdateMailchimpLists() {
	if(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'mailchimp') {
		var key = _cfsGetMailchimpKey();
		if(key && key != '') {
			jQuery('#cfsMailchimpListsShell').hide();
			jQuery('#cfsMailchimpNoApiKey').hide();
			jQuery.sendFormCfs({
				msgElID: 'cfsMailchimpMsg'
			,	data: {mod: 'mailchimp', action: 'getLists', key: key}
			,	onSuccess: function(res) {
					if(!res.error) {
						jQuery('#cfsMailchimpLists').html('');
						var selectedListsIds = cfsForm && cfsForm.params.tpl && cfsForm.params.tpl.sub_mailchimp_lists ? cfsForm.params.tpl.sub_mailchimp_lists : [];
						for(var listId in res.data.lists) {
							var selected = toeInArrayCfs(listId, selectedListsIds) ? 'selected="selected"' : '';
							jQuery('#cfsMailchimpLists').append('<option '+ selected+ ' value="'+ listId+ '">'+ res.data.lists[ listId ]+ '</option>');
						}
						jQuery('#cfsMailchimpListsShell').show();
						jQuery('#cfsMailchimpLists').chosen().trigger('chosen:updated');
						if(selectedListsIds && selectedListsIds.length)
							_cfsUpdateMailchimpGroups( selectedListsIds );
					}
				}
			});
		} else {
			jQuery('#cfsMailchimpNoApiKey').show();
			jQuery('#cfsMailchimpListsShell').hide();
		}
	}
}
function _cfsUpdateMailchimpGroups(listIds) {
	if(jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_dest]"]').val() == 'mailchimp') {
		var key = _cfsGetMailchimpKey();
		if(key && key != '') {
			jQuery('#cfsMailchimpGroupsShell').hide();
			jQuery('#cfsMailchimpGroupsNoApiKey').hide();
			jQuery.sendFormCfs({
				msgElID: 'cfsMailchimpGroupsMsg'
			,	data: {mod: 'mailchimp', action: 'getGroups', key: key, listIds: listIds}
			,	onSuccess: function(res) {
					if(!res.error) {
						jQuery('#cfsMailchimpGroups').html('');
						var selectedGroupsIds = cfsForm && cfsForm.params.tpl && cfsForm.params.tpl.sub_mailchimp_groups ? cfsForm.params.tpl.sub_mailchimp_groups : [];
						if(res.data.groups && res.data.groups != {}) {
							for(var groupId in res.data.groups) {
								var selected = toeInArrayCfs(groupId, selectedGroupsIds) ? 'selected="selected"' : '';
								jQuery('#cfsMailchimpGroups').append('<option '+ selected+ ' value="'+ groupId+ '">'+ res.data.groups[ groupId ]+ '</option>');
							}
						}
						jQuery('#cfsMailchimpGroupsShell').show();
						jQuery('#cfsMailchimpGroups').chosen().trigger('chosen:updated').trigger('change');
					}
				}
			});
		} else {
			jQuery('#cfsMailchimpGroupsNoApiKey').show();
			jQuery('#cfsMailchimpGroupsShell').hide();
		}
	}
}
function _cfsGetMailchimpKey() {
	return jQuery.trim( jQuery('#cfsFormEditForm').find('[name="params[tpl][sub_mailchimp_api_key]"]').val() );
}