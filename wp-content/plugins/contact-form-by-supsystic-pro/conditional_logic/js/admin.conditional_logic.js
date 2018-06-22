var g_cfsCondLogic = {
	_$mainShell: null
,	_$blockShellEx: null
,	_$condShellEx: null
,	_$logicShellEx: null
,	_ignoreUpdateSortOrder: false
,	_initInternal: function() {
		this._$mainShell = jQuery('#cfsClShell');
		this._$blockShellEx = jQuery('#cfsClBlockShellEx');
		this._$condShellEx = jQuery('#cfsClConditionShellEx');
		this._$logicShellEx = jQuery('#cfsClLogicShellEx');
	}
,	addBlock: function( data, params ) {
		params = params || {};
		this._initInternal();
		var $blockShell = this._$blockShellEx.clone().removeAttr('id');
		this._$mainShell.append( $blockShell );
		if(data) {
			this._fillInBlockData( $blockShell, data );
		}
		this._initBlockShellEvents( $blockShell, params );
		this._clearDisabled( $blockShell );
		this._updateCustSelects( $blockShell );
		if(params.newAdded) {
			this.addCondition( $blockShell );
		} else {	// It will be updated in addCondition() method, else - call it manually here
			this._updateSortOrder({
				main: true
			});
		}
		this._initTooltips( $blockShell );
	}
,	_fillInBlockData: function( $blockShell, data ) {
		for(var key in data) {
			if(typeof(data[ key ]) === 'string') {
				$blockShell.find('[name*="params[cl][]['+ key+ ']"]').val( data[ key ] );
			}
		}
		if(data.cond && data.cond.length) {
			for(var i = 0; i < data.cond.length; i++) {
				this.addCondition( $blockShell, data.cond[ i ] );
			}
		}
		if(data.logic && data.logic.length) {
			for(var i = 0; i < data.logic.length; i++) {
				this.addLogic( $blockShell, data.logic[ i ] );
			}
		}
	}
,	_initBlockShellEvents: function( $blockShell, params ) {
		params = params || {};
		var self = this;
		var $blockToggleBtn = $blockShell.find('.cfsClBlockToggleBtn');
		$blockToggleBtn.click(function(){
			var opened = jQuery(this).data('opened');
			if(opened) {
				$blockShell.find('.cfsClInnerShell').slideUp( g_cfsAnimationSpeed );
				$blockShell.find('.cfsClBlockToggleClose').hide();
				$blockShell.find('.cfsClBlockToggleOpen').show();
			} else {
				$blockShell.find('.cfsClInnerShell').slideDown( g_cfsAnimationSpeed );
				$blockShell.find('.cfsClBlockToggleOpen').hide();
				$blockShell.find('.cfsClBlockToggleClose').show();
			}
			jQuery(this).data('opened', !opened);
			return false;
		});
		if(params.opened || params.newAdded) {
			$blockToggleBtn.click();
		} else {
			$blockToggleBtn.find('.cfsClBlockToggleOpen').show();
		}
		// Remove whole block
		$blockShell.find('.cfsClBlockRemoveBtn').click(function(){
			if(confirm('Do you realy want to remove this condition block?')) {
				$blockShell.animateRemoveCfs(g_cfsAnimationSpeed, function(){
					self._updateSortOrder({
						main: true
					});
				});
			}
			return false;
		});
		// Adding conditions into block
		$blockShell.find('.cfsClAddCondBtn').click(function(){
			self.addCondition( $blockShell );
			return false;
		});
		// Adding logics into block
		$blockShell.find('.cfsClAddLogicBtn').click(function(){
			self.addLogic( $blockShell );
			return false;
		});
	}
,	addCondition: function( $blockShell, data ) {
		var $newCondShell = this._$condShellEx.clone().removeAttr('id')
		,	$conditionsShell = $blockShell.find('.cfsClCondShell');
		$conditionsShell.append( $newCondShell );
		this._fillInFieldsSelects( $newCondShell );
		if(data) {
			for(var key in data) {
				var $input = $newCondShell.find('[name*="[cond][]['+ key+ ']"]');
				if($input && $input.size()) {
					$input.val( data[ key ] );
				}
			}
		}
		this._initConditionShellEvents( $newCondShell );
		this._clearDisabled( $newCondShell );
		this._updateCustSelects( $newCondShell );
		// All other custom selects will be auto width, but select with field name - fixed - 
		// because field names can be loooong - and we need to limit this somehow
		$newCondShell.find('.cfsClFieldSel').next('.chosen-container').css({
			'width': '100px'
		});
		this._updateSortOrder({
			main: true
		,	conditions: $conditionsShell
		});
		this._checkCondNextEq( $conditionsShell );
	}
,	_fillInFieldsSelects: function( $area, fillAll ) {
		// Fill in all fields select
		var fields = g_cfsFieldsFrame.getFieldsList()
		,	$fieldsSel = $area.find('.cfsClFieldSel');
		if(fields) {
			var htmlDelims = 0
			,	googeMaps = 0;
			for(var i = 0; i < fields.length; i++) {
				if(!fillAll && toeInArrayCfs(fields[ i ].html, ['button', 'submit', 'reset', 'recaptcha', 'googlemap', 'htmldelim'])) continue;
				var label = fields[ i ].label ? fields[ i ].label : fields[ i ].placeholder
				,	name = fields[ i ].name;
				if(fields[ i ].html == 'htmldelim') {	// it is without labels or names
					htmlDelims++;
					label = 'HTML / Text Delimiter '+ htmlDelims;
					name = 'htmldelim_'+ htmlDelims;
				} else if(fields[ i ].html == 'googlemap') {	// it is without labels or names
					googeMaps++;
					label = 'Google Map '+ googeMaps;
					name = 'googlemap_'+ googeMaps;
				}
				$fieldsSel.append('<option value="'+ name+ '">'+ label+ '</option>');
			}
		}
	}
,	_initConditionShellEvents: function( $condShell ) {
		var $typeSel = $condShell.find('.cfsClCondTypeSel')
		,	$userType = $condShell.find('.cfsClUserTypeSel')
		,	self = this;
		
		var subTypesSelChangeClb = function( type ) {
			switch(type) {
				case 'user':
					$userType.change();
					break;
			}
		};
		this._fillInFieldsSelects( $condShell );
		// Type change
		$typeSel.change(function(){
			var type = jQuery(this).val();
			$condShell.find('.cfsClCond').hide().filter('[data-type="'+ type+ '"]').show();
			subTypesSelChangeClb(type);
		}).change();
		// User type change
		$userType.change(function(){
			$condShell.find('.cfsClCond[data-user-type]').hide().filter('[data-user-type="'+ jQuery(this).val()+ '"]').show();
		});
		subTypesSelChangeClb($typeSel.val());
		// Remove conditions
		$condShell.find('.cfsClCondRemoveBtn').click(function(){
			if(confirm(toeLangCfs('Are you sure want to remove this condition?'))) {
				var $parentBlock = $condShell.parents('.cfsClBlockShell:first');
				$condShell.animateRemoveCfs(g_cfsAnimationSpeed, function(){
					self._updateSortOrder({
						conditions: $parentBlock
					});
					self._checkCondNextEq( $parentBlock );
				});
			}
			return false;
		});
	}
,	addLogic: function( $blockShell, data ) {
		var $newLogicShell = this._$logicShellEx.clone().removeAttr('id')
		,	$logicsShell = $blockShell.find('.cfsClLogicsShell');
		$logicsShell.append( $newLogicShell );
		this._fillInFieldsSelects( $newLogicShell, true );
		if(data) {
			for(var key in data) {
				var $input = $newLogicShell.find('[name*="[logic][]['+ key+ ']"]');
				if($input && $input.size()) {
					switch($input.attr('type')) {
						case 'checkbox':
							parseInt(data[ key ]) ? $input.prop('checked', 'checked') : $input.removeProp('checked');
							break;
						default:
							$input.val( data[ key ] );
							break;
					}
					
				}
			}
		}
		this._initLogicShellEvents( $newLogicShell );
		this._clearDisabled( $newLogicShell );
		this._updateCustSelects( $newLogicShell );
		this._updateSortOrder({
			main: true
		,	logics: $logicsShell
		});
	}
,	_initLogicShellEvents: function( $logicShell ) {
		var $typeSel = $logicShell.find('.cfsClLogicTypeSel')
		,	$fieldActSel = $logicShell.find('.cfsClFieldActionSel')
		,	self = this;
		
		var subTypesSelChangeClb = function( type ) {
			switch(type) {
				case 'field':
					$fieldActSel.change();
					break;
			}
		};
		// Type change
		$typeSel.change(function(){
			var type = jQuery(this).val();
			$logicShell.find('.cfsClLog').hide().filter('[data-type="'+ type+ '"]').show();
			subTypesSelChangeClb(type);
		}).change();
		// Field action change
		$fieldActSel.change(function(){
			var $logciFieldActs = $logicShell.find('.cfsClLog[data-field-act]')
			,	actVal = jQuery(this).val();
			$logciFieldActs.hide().each(function(){
				var $this = jQuery(this)
				,	fieldActData = $this.data('field-act');
				if(fieldActData && typeof(fieldActData) === 'string') {
					fieldActData = fieldActData.split(',');
					$this.data('field-act', fieldActData);
				}
				if(toeInArrayCfs(actVal, fieldActData)) {
					$this.show();
				}
			});
		});
		subTypesSelChangeClb($typeSel.val());
		// Remove logic
		$logicShell.find('.cfsClLogicRemoveBtn').click(function(){
			if(confirm(toeLangCfs('Are you sure want to remove this action?'))) {
				var $parentBlock = $logicShell.parents('.cfsClBlockShell:first');
				$logicShell.animateRemoveCfs(g_cfsAnimationSpeed, function(){
					self._updateSortOrder({
						logics: $parentBlock
					});
				});
			}
			return false;
		});
	}
,	_clearDisabled: function( $shell ) {
		$shell.find(':input').removeAttr('disabled');
	}
,	_updateCustSelects: function( $shell ) {
		if(jQuery.fn.chosen) {
			var $selects = $shell.find('select');
			$selects.chosen({
				disable_search_threshold: 10
			});
			this._refreshCustSelectsWidth( $selects );
		}
		cfsInitCustomCheckRadio( $shell );
	}
,	_refreshCustSelectsWidth: function( $selects ) {
		$selects.each(function(){
			jQuery(this).next('.chosen-container').css({
				'width': ''
			});
		});
	}
,	_updateSortOrder: function( where ) {
		if(this._ignoreUpdateSortOrder) return;	// Update it outside
		for(var key in where) {
			switch(key) {
				case 'main': case 'all':
					cfsUpdateInputsSortOrder( this._$mainShell.find('.cfsClBlockShell'), 'params[cl]' );
					break;
				case 'conditions':
					cfsUpdateInputsSortOrder( where[ key ].find('.cfsClConditionShell'), '[cond]' );
					break;
				case 'logics':
					cfsUpdateInputsSortOrder( where[ key ].find('.cfsClLogicShell'), '[logic]' );
					break;
			}
		}
		if(where['all']) {
			var self = this;
			this._$mainShell.find('.cfsClBlockShell').each(function(){
				self._updateSortOrder({
					conditions: jQuery(this).find('.cfsClCondShell')
				,	logics: jQuery(this).find('.cfsClLogicsShell')
				});
			});
		}
	}
,	_checkCondNextEq: function( $shell ) {
		var $conditions = $shell.find('.cfsClConditionShell');
		$conditions.find('.cfsClCondNextEqShell').show().last().hide();	// Hide all other next Eq blocks
		if($conditions.size() > 1) {	// And not allow to remove condition - if it is only one
			$conditions.find('.cfsClCondRemoveBtn').show();
		} else {
			$conditions.find('.cfsClCondRemoveBtn').hide();
		}
	}
,	_initTooltips: function( $shell ) {
		cfsInitTooltips( $shell );
	}
};
jQuery(document).bind('cfsAfterFieldsEditFilledIn', function(){
	jQuery('.cfsClAddBlockBtn').click(function(){
		g_cfsCondLogic.addBlock(null, {
			newAdded: true
		});
		return false;
	});
	if(typeof(cfsForm) !== 'undefined' 
		&& cfsForm.params 
		&& cfsForm.params.cl 
		&& cfsForm.params.cl.length
	) {
		g_cfsCondLogic._ignoreUpdateSortOrder = true;
		for(var i = 0; i < cfsForm.params.cl.length; i++) {
			g_cfsCondLogic.addBlock( cfsForm.params.cl[ i ] );
		}
		g_cfsCondLogic._ignoreUpdateSortOrder = false;
		g_cfsCondLogic._updateSortOrder({
			all: true
		});
	}
});