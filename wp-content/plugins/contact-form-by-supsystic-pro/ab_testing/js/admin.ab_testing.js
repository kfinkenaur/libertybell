jQuery(document).ready(function(){
	// Fallback for case if library was not loaded
	if(!jQuery.fn.jqGrid) {
		return;
	}
	var tblId = 'cfsAbFormTbl';
	jQuery('#'+ tblId).jqGrid({ 
		url: cfsAbTblDataUrl
	,	datatype: 'json'
	,	autowidth: true
	,	shrinkToFit: true
	,	colNames:[toeLangCfs('ID'), toeLangCfs('Label'), toeLangCfs('Views'), toeLangCfs('Unique Views'), toeLangCfs('Actions'), toeLangCfs('Conversion'), toeLangCfs('Active')]
	,	colModel:[
			{name: 'id', index: 'id', searchoptions: {sopt: ['eq']}, width: '30', align: 'center'}
		,	{name: 'label', index: 'label', searchoptions: {sopt: ['eq']}, align: 'center'}
		,	{name: 'views', index: 'views', searchoptions: {sopt: ['eq']}, align: 'center'}
		,	{name: 'unique_views', index: 'unique_views', searchoptions: {sopt: ['eq']}, align: 'center'}
		,	{name: 'actions', index: 'actions', searchoptions: {sopt: ['eq']}, align: 'center'}
		,	{name: 'conversion', index: 'conversion', searchoptions: {sopt: ['eq']}, align: 'center'}
		,	{name: 'active', index: 'active', searchoptions: {sopt: ['eq']}, align: 'center'}
		]
	,	rowNum: 10
	,	rowList: [10, 20, 30, 1000]
	,	pager: '#'+ tblId+ 'Nav'
	,	sortname: 'id'
	,	viewrecords: true
	,	sortorder: 'desc'
	,	jsonReader: { repeatitems : false, id: '0' }
	,	caption: toeLangCfs('Current Form')
	,	height: '100%' 
	,	emptyrecords: toeLangCfs('You have no Forms for now.')
	,	multiselect: true
	,	onSelectRow: function(rowid, e) {
			var tblId = jQuery(this).attr('id')
			,	selectedRowIds = jQuery('#'+ tblId).jqGrid ('getGridParam', 'selarrrow')
			,	totalRows = jQuery('#'+ tblId).getGridParam('reccount')
			,	totalRowsSelected = selectedRowIds.length;
			if(totalRowsSelected) {
				jQuery('#cfsAbFormRemoveGroupBtn').removeAttr('disabled');
				if(totalRowsSelected == totalRows) {
					jQuery('#cb_'+ tblId).prop('indeterminate', false);
					jQuery('#cb_'+ tblId).attr('checked', 'checked');
				} else {
					jQuery('#cb_'+ tblId).prop('indeterminate', true);
				}
			} else {
				jQuery('#cfsAbFormRemoveGroupBtn').attr('disabled', 'disabled');
				jQuery('#cb_'+ tblId).prop('indeterminate', false);
				jQuery('#cb_'+ tblId).removeAttr('checked');
			}
			cfsCheckUpdateArea('#gview_'+ tblId);
		}
	,	gridComplete: function(a, b, c) {
			var tblId = jQuery(this).attr('id');
			jQuery('#cfsAbFormRemoveGroupBtn').attr('disabled', 'disabled');
			jQuery('#cb_'+ tblId).prop('indeterminate', false);
			jQuery('#cb_'+ tblId).removeAttr('checked');
			if(jQuery('#'+ tblId).jqGrid('getGridParam', 'records'))	// If we have at least one row - allow to clear whole list
				jQuery('#cfsAbClearBtn').removeAttr('disabled');
			else
				jQuery('#cfsAbClearBtn').attr('disabled', 'disabled');
			// Custom checkbox manipulation
			cfsInitCustomCheckRadio('#gview_'+ tblId);
			cfsCheckUpdateArea('#gview_'+ tblId);
		}
	,	loadComplete: function() {
			var tblId = jQuery(this).attr('id');
			if (this.p.reccount === 0) {
				jQuery('#gbox_'+ tblId).hide();
				jQuery('.'+ tblId+ 'Btn').hide();
				jQuery('#'+ tblId+ 'EmptyMsg').show();
			} else {
				jQuery('#gbox_'+ tblId).show();
				jQuery('.'+ tblId+ 'Btn').show();
				jQuery('#'+ tblId+ 'EmptyMsg').hide();
			}
		}
	});
	jQuery('#'+ tblId+ 'NavShell').append( jQuery('#'+ tblId+ 'Nav') );
	jQuery('#'+ tblId+ 'Nav').find('.ui-pg-table td:first').remove();
	jQuery('#'+ tblId+ '').jqGrid('navGrid', '#'+ tblId+ 'Nav', {edit: false, add: false, del: false});
	// Disabled sticky for this table header
	jQuery('#gview_'+ tblId).find('.ui-jqgrid-hdiv').addClass('sticky-ignore');
	jQuery('#cb_'+ tblId+ '').change(function(){
		jQuery(this).attr('checked') 
			? jQuery('#cfsAbFormRemoveGroupBtn').removeAttr('disabled')
			: jQuery('#cfsAbFormRemoveGroupBtn').attr('disabled', 'disabled');
		cfsCheckUpdateArea('#gview_'+ tblId);
	});
	jQuery('#cfsAbFormRemoveGroupBtn').click(function(){
		if(jQuery(this).attr('disabled')) return false;
		var selectedRowIds = jQuery('#cfsAbFormTbl').jqGrid ('getGridParam', 'selarrrow')
		,	listIds = [];
		for(var i in selectedRowIds) {
			var rowData = jQuery('#cfsAbFormTbl').jqGrid('getRowData', selectedRowIds[ i ]);
			listIds.push( rowData.id );
		}
		var confirmMsg = listIds.length > 1
			? toeLangCfs('Are you sur want to remove '+ listIds.length+ ' Test Forms?')
			: toeLangCfs('Are you sure want to remove "'+ cfsGetGridColDataById(listIds[0], 'label', 'cfsAbFormTbl')+ '" Test Form?')
		if(confirm(confirmMsg)) {
			jQuery.sendFormCfs({
				btn: this
			,	data: {mod: 'forms', action: 'removeGroup', listIds: listIds}
			,	onSuccess: function(res) {
					if(!res.error) {
						jQuery('#cfsAbFormTbl').trigger( 'reloadGrid' );
					}
				}
			});
		}
		return false;
	});
	jQuery('#cfsAbClearBtn').click(function(){
		if(confirm(toeLangCfs('Clear whole Test list?'))) {
			jQuery.sendFormCfs({
				btn: this
			,	data: {mod: 'ab_testing', action: 'clear', base_id: cfsForm.id}
			,	onSuccess: function(res) {
					if(!res.error) {
						jQuery('#cfsAbFormTbl').trigger( 'reloadGrid' );
					}
				}
			});
		}
		return false;
	});
	cfsAbInitAddNewDialog();
	jQuery(document).bind('cfsFormAbTesting_tabSwitch', function(){
		jQuery('#cfsAbFormTbl').setGridWidth( jQuery('#gbox_cfsAbFormTbl').parent().width(), true ); //Back to original width
	});
});
function cfsAbInitAddNewDialog() {
	var $container = jQuery('#cfsAbAddNewWnd').dialog({
		modal:    true
	,	autoOpen: false
	,	width: 460
	,	height: 180
	,	buttons:  {
			OK: function() {
				jQuery('#cfsAbAddNewForm').submit();
			}
		,	Cancel: function() {
				$container.dialog('close');
			}
		}
	});
	jQuery('.cfsAbAddNew').click(function(){
		$container.dialog('open');
		return false;
	});
	jQuery('#cfsAbAddNewForm').submit(function(){
		jQuery(this).sendFormCfs({
			msgElID: 'cfsAbAddNewMsg'
		,	onSuccess: function(res) {
				if(!res.error) {
					jQuery('#cfsAbAddNewForm [name=label]').val('');
					jQuery('#cfsAbFormTbl').trigger( 'reloadGrid' );
					$container.dialog('close');
				}
			}
		});
		return false;
	});
}
