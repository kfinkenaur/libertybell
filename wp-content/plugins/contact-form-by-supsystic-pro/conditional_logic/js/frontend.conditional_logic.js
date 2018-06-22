var g_cfsConditionalLogics = [];
jQuery(document).bind('cfsAfterFormInit', function(event, form){
	var conditionalLogics = form.getParam('cl');
	if(conditionalLogics && conditionalLogics.length) {
		g_cfsConditionalLogics.push({
			fid: form.get('id')
		,	condLogics: new cfsConditionalLogics( conditionalLogics, form )
		});
	}
});
jQuery(document).bind('cfsAfterFormSubmitSuccess', function(event, form){
	if(g_cfsConditionalLogics && g_cfsConditionalLogics.length) {
		var fid = form.get('id');
		for(var i = 0; i < g_cfsConditionalLogics.length; i++) {
			if(g_cfsConditionalLogics[ i ].fid == fid 
				&& g_cfsConditionalLogics[ i ].condLogics
			) {
				g_cfsConditionalLogics[ i ].condLogics.checkAfterSubmitRedirect();
			}
		}
	}
});
function cfsConditionalLogics( conditionalLogics, form ) {
	this._cl = [];
	// For each of conditional logic - we will create conditional logic object
	for(var i = 0; i < conditionalLogics.length; i++) {
		this._cl.push( new cfsCl( conditionalLogics[ i ], form, this ) );
	}
}
cfsConditionalLogics.prototype.update = function() {
	for(var i = 0; i < this._cl.length; i++) {
		this._cl[ i ].checkConditions();
	}
};
cfsConditionalLogics.prototype.checkAfterSubmitRedirect = function() {
	for(var i = 0; i < this._cl.length; i++) {
		var redirects = this._cl[ i ].getRedirects();
		// Yes, here we can have several redirects, but make all of them have no sense - so redirect only to first record
		if(redirects && redirects.length && redirects[ 0 ])
			toeRedirect( redirects[ 0 ] );
	}
};
/**
 * Conditional Logic separate object
 * @param {object} data Conditional logic data
 * @param {object} form Form object where we apply our logics
 */
function cfsCl( data, form, fullConditionalLogic ) {
	this._data = data;
	this._$ = form.getShell();
	this._formId = form.get('id');
	this._fullConditionalLogic = fullConditionalLogic;
	this._redirects = [];
	this._logicsInProgress = {};
	this.init();
}
cfsCl.prototype._addRedirect = function( url ) {
	if(!toeInArrayCfs( url, this._redirects ))
		this._redirects.push( url );
};
cfsCl.prototype._removeRedirect = function( url ) {
	if(this._redirects && this._redirects.length) {
		for(var i = 0; i < this._redirects.length; i++) {
			if(this._redirects[ i ] == url) {
				this._redirects.splice( i , 1 );
				return;
			}
		}
	}
};
cfsCl.prototype.getRedirects = function() {
	return this._redirects;
};
cfsCl.prototype.init = function() {
	var self = this;
	this.flushShowFields();
	// Bind conditions
	if(this._data.cond && this._data.cond.length) {
		for(var i = 0; i < this._data.cond.length; i++) {
			switch(this._data.cond[ i ].type) {
				case 'field':
					var $fieldShell = this._getFieldShells( this._data.cond[ i ].field );
					if($fieldShell) {
						$fieldShell.find(':input').bind('change keyup', function(){
							self._fullConditionalLogic.update();
						});
						this.checkConditions();
					}
					break;
				case 'user':
					this.checkConditions();
					break;
			}
		}
	}
};
cfsCl.prototype._getFieldShells = function( fields ) {
	if(!fields) return false;
	var fieldsArr = typeof(fields) === 'string' ? [ fields ] : fields
	,	$fieldShells = null;
	for(var i = 0; i < fieldsArr.length; i++) {
		var $inputShell = this._$.find('.cfsFieldCol[data-name="'+ fieldsArr[ i ]+ '"]');
		$fieldShells = $fieldShells ? $fieldShells.add( $inputShell ) : $inputShell;
	}
	return $fieldShells;
};
cfsCl.prototype.hideFields = function( fields ) {
	if(!fields) return;
	var $fieldShells = this._getFieldShells( fields )
	,	self = this;
	$fieldShells.hide().addClass('cfsClHidden').each(function(){
		var $parentRow = jQuery(this).parents('.cfsFieldsRow:first');
		if($parentRow && $parentRow.size() && !$parentRow.data('recomputed')) {
			var $cols = $parentRow.find('.cfsFieldCol')
			,	colsNum = $cols ? $cols.size() : 0;
			if(colsNum == 1) {
				$parentRow.hide();
			} else {
				self._recomputeBootsrapClasses( $parentRow );
			}
			$parentRow.data('recomputed', 1);
		}
	});
};
cfsCl.prototype.showFields = function( fields ) {
	if(!fields) return;
	var $fieldShells = this._getFieldShells( fields )
	,	self = this;
	$fieldShells.show().removeClass('cfsClHidden').each(function(){
		var $parentRow = jQuery(this).parents('.cfsFieldsRow:first');
		if($parentRow && $parentRow.size() && $parentRow.data('recomputed')) {
			var $cols = $parentRow.find('.cfsFieldCol')
			,	colsNum = $cols ? $cols.size() : 0;
			if(colsNum == 1) {
				$parentRow.show();
			} else {
				self._recomputeBootsrapClasses( $parentRow );
			}
			$parentRow.data('recomputed', 0);
		}
	});
};
cfsCl.prototype._recomputeBootsrapClasses = function( $row ) {
	var $visibleCols = $row.find('.cfsFieldCol:not(.cfsClHidden)')
	,	colsNum = $visibleCols.size()
	,	bsClassNum = colsNum > 12 ? 1 : (12 / colsNum);;
	$visibleCols.each(function(){
		jQuery(this).attr('class', jQuery(this).attr('class').replace(/(col\-\w{2}\-)(\d{1,2})/, '$1'+ bsClassNum));
	});
};
cfsCl.prototype.prefillFields = function( fields, value ) {
	if(!fields) return;
	var $fieldShells = this._getFieldShells( fields );
	$fieldShells.find(':input').val( value );
};
cfsCl.prototype.addToFields = function( fields, value, substruct, makePatternReplace ) {
	if(!fields) return;
	var $fieldShells = this._getFieldShells( fields )
	,	$inputs = $fieldShells.find(':input')
	,	addNum = toNumberCsf( value );
	if(addNum && $inputs && $inputs.size()) {
		$inputs.each(function(){
			var $this = jQuery(this)
			,	numVal = makePatternReplace ? toNumberCurrencyCfs( $this.val() ) : toNumberCsf( $this.val() );
			if(makePatternReplace && numVal) {
				numVal = numVal.num;
			}
			if(!numVal) numVal = 0;
			var finalVal = (substruct ? (numVal - addNum) : (numVal + addNum));
			if(makePatternReplace) {
				makePatternReplace.num = finalVal;
				finalVal = numberCurrencyToStrCfs( makePatternReplace );
			}
			$this.val( finalVal ).data('prev-val', numVal);
		});
	}
};
cfsCl.prototype.substructFromFields = function( fields, value ) {
	this.addToFields( fields, value, true );	// Ha:)
};
cfsCl.prototype.addCurrencyToFields = function( fields, value, substruct ) {
	if(!fields) return;
	var addNumCurency = toNumberCurrencyCfs( value );
	
	if(addNumCurency && addNumCurency.num) {
		this.addToFields( fields, addNumCurency.num, substruct, addNumCurency );
	}
};
cfsCl.prototype.substructCurrencyFromFields = function( fields, value ) {
	this.addCurrencyToFields( fields, value, true );	// "Ha" one more time - I made it again:)
};
cfsCl.prototype._getCfData = function( key ) {
	var data = typeof(window['cfsClData_'+ this._formId]) === 'undefined' ? false : window['cfsClData_'+ this._formId];
	return (key && data) ? data[ key ] : data;
};

cfsCl.prototype._getUserCountry = function() {
	return this._getCfData('country');
};
cfsCl.prototype._getUserLang = function() {
	return this._getCfData('lang');
};
cfsCl.prototype.checkConditions = function() {
	var totalApplied = []
	,	haveApplied = false
	,	mustApply = false;
	if(this._data.cond && this._data.cond.length) {
		for(var i = 0; i < this._data.cond.length; i++) {
			var applied = false;
			switch(this._data.cond[ i ].type) {
				case 'field':
					var $fieldShell = this._getFieldShells( this._data.cond[ i ].field );
					if($fieldShell) {
						var $input = $fieldShell.find(':input');
						if($input && $input.size()) {
							switch($input.attr('type')) {
								case 'radio': case 'checkbox':
									$input = $fieldShell.find(':input:checked');
									break;
							}
							
							var value = $input.val();
							switch( this._data.cond[ i ].field_eq ) {
								case 'eq':
									applied = (value == this._data.cond[ i ].field_eq_to);
									break;
								case 'like':
									applied = (value 
										&& this._data.cond[ i ].field_eq_to 
										&& (new RegExp( this._data.cond[ i ].field_eq_to )).test( value ));
									break;
								case 'more': case 'less':
									var numValue = parseFloat(value)
									,	numEqTo = parseFloat( this._data.cond[ i ].field_eq_to );
									if(!isNaN(numValue) && !isNaN(numEqTo)) {
										applied = this._data.cond[ i ].field_eq == 'more' 
											? numValue > numEqTo : numValue < numEqTo;
									}
									break;
							}
						}
					}
					break;
				case 'user':
					switch( this._data.cond[ i ].user_type ) {
						case 'country':
							var userCountry = this._getUserCountry();
							if(userCountry 
								&& this._data.cond[ i ].user_country 
								&& toeInArrayCfs(userCountry, this._data.cond[ i ].user_country)
							) {
								applied = true;
							}
							break;
						case 'lang':
							var userLang = this._getUserLang();
							if(userLang
								&& this._data.cond[ i ].user_lang
								&& toeInArrayCfs(userLang, this._data.cond[ i ].user_lang)
							) {
								applied = true;
							}
							break;
						case 'url':
							var url = window.location.href;
							if(url
								&& this._data.cond[ i ].url_eq_to
							) {
								switch(this._data.cond[ i ].url_eq) {
									case 'eq':
										applied = (url == this._data.cond[ i ].url_eq_to);
										break;
									case 'like':
										applied = (new RegExp(this._data.cond[ i ].url_eq_to).test(url));
										break;
								}
							}
							break;
					}
					break;
			}
			// Show us that there was at least on applied condition
			if(applied) haveApplied = true;
			totalApplied.push({
				applied: applied
			,	next_eq: this._data.cond[ i ].next_eq
			});
		}
		if(haveApplied) {	// If we have at least one true conditions - let's check them all
			if(totalApplied.length > 1) {
				mustApply = totalApplied[ 0 ].applied;
				for(var i = 1; i < totalApplied.length; i++) {
					switch(totalApplied[ i - 1 ].next_eq) {
						case 'or':
							mustApply = mustApply || totalApplied[ i ].applied;
							break;
						case 'and':
							mustApply = mustApply && totalApplied[ i ].applied;
							break;
					}
				}
			} else {	// There are only one condition, and it's - true, so just run all logics
				mustApply = true;
			}
			if(mustApply) {
				this.runLogic();
			}
		}
	}
	if(!mustApply) {
		this.flushLogic();
	}
};
cfsCl.prototype.runLogic = function() {
	if(this._data.logic && this._data.logic.length) {
		for(var i = 0; i < this._data.logic.length; i++) {
			if(this._isLogicInProgress( i )) continue;
			switch(this._data.logic[ i ].type) {
				case 'field':
					switch(this._data.logic[ i ].field_act) {
						case 'show':
							this.showFields( this._data.logic[ i ].fields );
							break;
						case 'hide':
							this.hideFields( this._data.logic[ i ].fields );
							break;
						case 'prefill':
							this.prefillFields( this._data.logic[ i ].fields, this._data.logic[ i ].field_prefill );
							break;
						case 'add':
							this.addToFields( this._data.logic[ i ].fields, this._data.logic[ i ].field_prefill );
							break;
						case 'substruct':
							this.substructFromFields( this._data.logic[ i ].fields, this._data.logic[ i ].field_prefill );
							break;
						case 'add_currency':
							this.addCurrencyToFields( this._data.logic[ i ].fields, this._data.logic[ i ].field_prefill );
							break;
						case 'substruct_currency':
							this.substructCurrencyFromFields( this._data.logic[ i ].fields, this._data.logic[ i ].field_prefill );
							break;
					}
					break;
				case 'redirect':
					if(parseInt( this._data.logic[ i ].redirect_after_submit )) {	// Remember this redirect - to do it after form submit
						this._addRedirect( this._data.logic[ i ].redirect_url );
					} else
						toeRedirect( this._data.logic[ i ].redirect_url );
					break;
			}
			this._addLogicToProgress( i );
		}
		this._saveRunLogics();
	}
};
cfsCl.prototype._saveRunLogics = function() {
	var $cl = this._$.find('[name="fields[cfs_cl_save_321]"]');
	if(!$cl || !$cl.size()) {
		this._$.find('form').append('<input type="hidden" name="fields[cfs_cl_save_321]" value="" />');
		$cl = this._$.find('[name="fields[cfs_cl_save_321]"]');	// Name of this field was set to this to not duplicate it by users
	}
	if( this._logicsInProgress ) {
		var values = [];
		for(var id in this._logicsInProgress) {
			values.push(id+ '='+ this._logicsInProgress[ id ]);
		}
		$cl.val( values.join('|') );
	} else {
		$cl.val('');
	}
};
cfsCl.prototype._isLogicInProgress = function( id ) {
	return this._logicsInProgress[ id ];
};
cfsCl.prototype._addLogicToProgress = function( id ) {
	this._logicsInProgress[ id ] = 1;
};
cfsCl.prototype._removeLogicFromProgress = function( id ) {
	this._logicsInProgress[ id ] = 0;
};
cfsCl.prototype.flushLogic = function() {
	// Check fields, that need to be visible after some conditions
	if(this._data.logic && this._data.logic.length) {
		for(var i = 0; i < this._data.logic.length; i++) {
			if(!this._isLogicInProgress( i )) continue;
			switch(this._data.logic[ i ].type) {
				case 'field':
					switch( this._data.logic[ i ].field_act ) {	// Set fields invisible before they need to be show, and vise-versa
						case 'show':
							this.hideFields( this._data.logic[ i ].fields );
							break;
						case 'hide':
							this.showFields( this._data.logic[ i ].fields );
							break;
						case 'add':
							this.substructFromFields( this._data.logic[ i ].fields, this._data.logic[ i ].field_prefill );
							break;
						case 'substruct':
							this.addToFields( this._data.logic[ i ].fields, this._data.logic[ i ].field_prefill );
							break;
						case 'add_currency':
							this.substructCurrencyFromFields( this._data.logic[ i ].fields, this._data.logic[ i ].field_prefill );
							break;
						case 'substruct_currency':
							this.addCurrencyToFields( this._data.logic[ i ].fields, this._data.logic[ i ].field_prefill );
							break;
					}
					break
				case 'redirect':
					if(parseInt( this._data.logic[ i ].redirect_after_submit )) {	// Remember this redirect - to do it after form submit
						this._removeRedirect( this._data.logic[ i ].redirect_url );
					}
					break;
			}
			this._removeLogicFromProgress( i );
		}
		this._saveRunLogics();
	}
};
/**
 * If required - will hide fields that need to be hidden.
 * This is duplicationg part of flushLogic() method, but it need to be like this.
 */
cfsCl.prototype.flushShowFields = function() {
	// Check fields, that need to be visible after only some conditions
	if(this._data.logic && this._data.logic.length) {
		for(var i = 0; i < this._data.logic.length; i++) {
			if(this._data.logic[ i ].type == 'field') {
				switch( this._data.logic[ i ].field_act ) {	// Set fields invisible before they need to be show, and vise-versa
					case 'show':
						this.hideFields( this._data.logic[ i ].fields );
						break;
				}
			}
		}
	}
};