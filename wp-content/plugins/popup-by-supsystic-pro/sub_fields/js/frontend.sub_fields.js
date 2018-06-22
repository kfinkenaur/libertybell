jQuery(document).bind('ppsAfterPopupsInit', function(){
	for(var i = 0; i < ppsPopups.length; i++) {
		if(ppsPopups[ i ].params && ppsPopups[ i ].params.tpl && ppsPopups[ i ].params.tpl.sub_fields) {
			for(var name in ppsPopups[ i ].params.tpl.sub_fields) {
				if(ppsPopups[ i ].params.tpl.sub_fields[ name ] && ppsPopups[ i ].params.tpl.sub_fields[ name ].set_preset) {
					switch( ppsPopups[ i ].params.tpl.sub_fields[ name ].set_preset ) {
						case 'page_title':
							var $shell = ppsGetPopupShell( ppsPopups[ i ] )
							,	$input = $shell.find(':input[name="'+ name+ '"]');
							if($input && $input.size()) {
								$input.val( document.title );
							}
							break;
					}
				}
			}
		}
	}
});