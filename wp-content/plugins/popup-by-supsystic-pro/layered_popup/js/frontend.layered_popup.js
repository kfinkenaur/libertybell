var g_ppsOverlayClickLayeredClose = [];
jQuery(document).bind('ppsResize', function(e, params) {
	params = params || {};
	if(parseInt(params.popup.params.tpl.enb_layered)) {
		// For case if it was not defined in admin area for now
		params.popup.params.tpl.layered_pos = params.popup.params.tpl.layered_pos ? params.popup.params.tpl.layered_pos : 'top';
		_ppsLayeredPositionPopup( params );
		params.shell.positioned_outside = true;
	}
});
jQuery(document).bind('ppsBeforePopupsInit', function(e, popups){
	for(var i = 0; i < ppsPopups.length; i++) {
		if(parseInt(ppsPopups[ i ].params.tpl.enb_layered)) {
			ppsPopups[ i ].ignore_background = true;
		}
		if(ppsPopups[ i ].params.main.close_on == 'overlay_click') {
			g_ppsOverlayClickLayeredClose.push( ppsPopups[ i ].id );
		}
	}
	if(g_ppsOverlayClickLayeredClose.length) {
		jQuery(document).click(function(e){
			if(g_ppsOverlayClickLayeredClose 
				&& g_ppsOverlayClickLayeredClose.length 
				&& e.target
			) {
				if(!jQuery(e.target).parents('.ppsPopupShell').size()) {
					for(var i = 0; i < g_ppsOverlayClickLayeredClose.length; i++) {
						var popup = ppsGetPopupById( g_ppsOverlayClickLayeredClose[ i ] );
						if(popup && popup.is_visible) {
							ppsClosePopup( popup );
						}
					}
				}
			}
		});
	}
});
function _ppsLayeredPositionPopup(params) {
	params = params || {};
	var shell = params.shell ? params.shell : ppsGetPopupShell( params.popup );
	if(shell) {
		var shellWidth = shell.width()
		,	shellHeight = shell.height()
		,	newPos = {}
		,	posDetected = false
		,	d = 0;	// Delta
		if( params.popup.params.tpl.enb_layer_rel ) {
			var $clkRel = null;
			if( params.popup.params.tpl.enb_layer_rel_clk ) {
				var clkRel = _ppsGetPopUpClick( params.popup.id );
				if( clkRel ) {
					$clkRel = jQuery( clkRel );
				}
			} else if( params.popup.params.tpl.layer_rel_selectors ) {
				$clkRel = jQuery( params.popup.params.tpl.layer_rel_selectors );
			}
			if($clkRel && $clkRel.size()) {	// Display it relative to the target element
				posDetected = true;
				if( $clkRel.size() > 1 ) {
					$clkRel = $clkRel.first();
				}
				var relPos = $clkRel.offset()
				,	relWidth = $clkRel.width()
				,	relHeight = $clkRel.height();
				switch(params.popup.params.tpl.layered_pos) {
					// Top line
					case 'top_left':
						newPos.top = relPos.top - shellHeight;
						newPos.left = relPos.left - shellWidth;
						break;
					case 'top':
						newPos.top = relPos.top - shellHeight;
						newPos.left = relPos.left - (shellWidth - relWidth) / 2;
						break;
					case 'top_right':
						newPos.top = relPos.top - shellHeight;
						newPos.left = relPos.left + relWidth;
						break;
					// Center line
					case 'center_left':
						newPos.top = relPos.top - (shellHeight - relHeight) / 2;
						newPos.left = relPos.left - shellWidth;
						break;
					case 'center':
						newPos.top = relPos.top - (shellHeight - relHeight) / 2;
						newPos.left = relPos.left - (shellWidth - relWidth) / 2;
						break;
					case 'center_right':
						newPos.top = relPos.top - (shellHeight - relHeight) / 2;
						newPos.left = relPos.left + relWidth;
						break;
					// Bottom line
					case 'bottom_left':
						newPos.top = relPos.top + relHeight;
						newPos.left = relPos.left - shellWidth;
						break;
					case 'bottom':
						newPos.top = relPos.top + relHeight;
						newPos.left = relPos.left - (shellWidth - relWidth) / 2;
						break;
					case 'bottom_right':
						newPos.top = relPos.top + relHeight;
						newPos.left = relPos.left + relWidth;
						break;
				}
				if( newPos.top < 0 ) {
					newPos.top = 0;
				}
				if( newPos.left < 0 ) {
					newPos.left = 0;
				}
				shell.css('position', 'absolute');
			}
		}
		if( !posDetected ) {	// Detect it relative to window
			var wndWidth = params.wndWidth ? params.wndWidth : jQuery(window).width()
			,	wndHeight = params.wndHeight ? params.wndHeight : jQuery(window).height();
			switch(params.popup.params.tpl.layered_pos) {
				// Top line
				case 'top_left':
					newPos.top = d;
					newPos.left = d;
					break;
				case 'top':
					newPos.top = d;
					newPos.left = (wndWidth - shellWidth) / 2;
					break;
				case 'top_right':
					newPos.top = d;
					newPos.right = d;
					break;
				// Center line
				case 'center_left':
					newPos.top = (wndHeight - shellHeight) / 2;
					newPos.left = d;
					break;
				case 'center':
					newPos.top = (wndHeight - shellHeight) / 2;
					newPos.left = (wndWidth - shellWidth) / 2;
					break;
				case 'center_right':
					newPos.top = (wndHeight - shellHeight) / 2;
					newPos.right = d;
					break;
				// Bottom line
				case 'bottom_left':
					newPos.bottom = d;
					newPos.left = d;
					break;
				case 'bottom':
					newPos.bottom = d;
					newPos.left = (wndWidth - shellWidth) / 2;
					break;
				case 'bottom_right':
					newPos.bottom = d;
					newPos.right = d;
					break;
			}
		}
		shell
			.css( newPos )
			.addClass('ppsLayered_'+ params.popup.params.tpl.layered_pos);
	} else {
		console.log('CAN NOT FIND POPUP SHELL TO REPOSITION!');
	}
}