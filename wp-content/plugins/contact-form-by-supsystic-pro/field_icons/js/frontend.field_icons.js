jQuery(document).bind('cfsAfterFormInit', function( event, form ){
	var fields = form.getFields();
	if(fields) {
		for(var i = 0; i < fields.length; i++) {
			if(fields[ i ] && fields[ i ].icon_class) {
				if(toeInArrayCfs(fields[ i ].html, ['submit', 'button'])) continue;
				var inputName = fields[ i ].name;
				// Yeh, files is without icons for now, but for future programmers - who will add that feature and can see error here - good luck:)
				if(fields[ i ].html == 'file') {
					inputName += '_file';
				}
				var $input = form.getFieldInput( fields[ i ].name );
				if($input && $input.size()) {
					var $icon = $input.parents('.cfsFieldShell:first').find('.cfsFieldIcon')
					,	inputPos = {}
					,	iconWidth = $icon.width()
					,	iconHeight = $icon.height()
					,	paddPlus = 5
					,	paddTop = 0
					,	inputType = $input.tagName()
					,	inpHeight = 0;
							
					if(inputType == 'INPUT') {
						inputType = $input.attr('type');
					}
					inputType = inputType.toUpperCase();
					switch( inputType ) {
						case 'SELECT': case 'CHECKBOX': case 'RADIO':
							var $parentShell = $input.parents('.cfsListSelect:first');
							if(!$parentShell || !$parentShell.size()) {
								$parentShell = $input.parents('.cfsCheck');
							}
							if($input.size() > 1) {
								$input = $input.filter(':first');
							}
							var baseParentDisplay = '';
							if(inputType == 'SELECT') {
								baseParentDisplay = $parentShell.css('display');
								if(baseParentDisplay == 'inline') {
									$parentShell.css('display', 'block');	// Make it block for a while - to calc correct sizes
								}
							}
							paddTop = parseInt($parentShell.css('padding-top'));
							inputPos = $parentShell.offset();

							$input.css('margin-left', iconWidth + 2 * paddPlus);
							paddTop += Math.round(($parentShell.height() - iconHeight) / 2);
							if(baseParentDisplay 
								&& baseParentDisplay != '' 
								&& baseParentDisplay == 'inline'
							) {
								$parentShell.css('display', baseParentDisplay);
							}
							break;
						default:
							inpHeight = $input.height()
							paddTop = parseInt($input.css('padding-top'));
							// posit it in the top of textarea fields
							if(!toeInArrayCfs(inputType, ['TEXTAREA'])) {
								paddTop += Math.round((inpHeight - iconHeight) / 2);	// Position it in the middle of the field by height
							}
							inputPos = $input.offset();
							$input.css('padding-left', iconWidth + 2 * paddPlus);
							break;
					}
					$icon.offset({
						top: inputPos.top + (paddTop ? paddTop : 0)
					,	left: inputPos.left + paddPlus
					});
				} else
					console.log('NOT FOUND!!!', fields[ i ].name);
			}
		}
	}
});