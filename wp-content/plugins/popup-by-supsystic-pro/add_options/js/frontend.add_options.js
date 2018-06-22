// Close popup - after any action was done - main option
jQuery(document).bind('ppsAfterPopupsActionDone', function(e, params){
	if(params.popup.params.main.close_on == 'after_action') {
		var closeAfterTime = parseInt(params.popup.params.main.close_on_after_action_time);
		if(isNaN(closeAfterTime) || closeAfterTime < 0)
			closeAfterTime = 1;
		setTimeout(function(){
			ppsClosePopup( params.popup );
		}, closeAfterTime * 1000);	// Seconds to miliseconds
	}
});
// Close popup - after some time it was opened - main option
jQuery(document).bind('ppsAfterPopupsActionShow', function(e, popup){
	if(popup.params.main.close_on == 'after_time') {
		var closeAfterTimeValue = parseInt( popup.params.main.close_on_after_time_value );
		if(!isNaN(closeAfterTimeValue)) {
			setTimeout(function(){
				ppsClosePopup( popup );
			}, closeAfterTimeValue * 1000);
		}
	}
	// Video (Vimeo) extra fullscreen
	if(popup.params.tpl.video_extra_full_screen) {
		_ppsOnVimeoPlay( popup );
	}
});
// Opend popup - after user scrolled down to the bottom or, if there are no scroll - show immediately - main option
var g_ppsOnPageBottomPopups = []
,	g_ppsOnInactivePopups = {}
,	g_ppsOnInactiveIdleTime = 0
,	g_ppsGoogleAnalyticsStatsBinded = false;

jQuery(document).bind('ppsAfterPopupsInit', function(e, popups){
	var bindInactivePopups = false;

	for(var i = 0; i < ppsPopups.length; i++) {
		if(ppsPopups[ i ].params.main.show_on == 'page_bottom') {
			g_ppsOnPageBottomPopups.push( ppsPopups[ i ] );
		}
		if(ppsPopups[ i ].params.main.show_on == 'after_inactive') {
			var inactiveTimeValue = parseInt( ppsPopups[ i ].params.main.show_on_after_inactive_value );
			if(inactiveTimeValue) {
				if(!g_ppsOnInactivePopups[ inactiveTimeValue ]) {
					g_ppsOnInactivePopups[ inactiveTimeValue ] = [];
				}
				g_ppsOnInactivePopups[ inactiveTimeValue ].push( ppsPopups[ i ] );
				bindInactivePopups = true;
			}
		}
		if(ppsPopups[ i ].params.main.show_on == 'after_comment') {
			ppsCheckShowPopup( ppsPopups[ i ] );
		}
		if(ppsPopups[ i ].params.main.show_on == 'link_follow') {
			var hashParams = toeGetHashParams();
			if(hashParams && hashParams.length && toeInArray('ppsShowPopUp_'+ ppsPopups[ i ].id, hashParams) !== -1) {
				if(!_ppsPopupBindDelay(ppsPopups[ i ], 'show_on_link_follow_delay', 'show_on_link_follow_enb_delay')) {
					ppsCheckShowPopup( ppsPopups[ i ] );
				}
			}
		}
		// Build-in page content
		if(ppsPopups[ i ].params.main.show_on == 'build_in_page') {
			_ppsShowBuildInPopup( ppsPopups[ i ] );
		}
		// AdBlock detection
		if(ppsPopups[ i ].params.main.show_on == 'adblock_detected') {
			if(typeof(g_ppsAdBlockDisabled) === 'undefined') {
				ppsCheckShowPopup( ppsPopups[ i ] );
			}
		}
		// Checking for Google Analytics in our PopUps
		if(ppsPopups[ i ].params.tpl.stat_ga_code && ppsPopups[ i ].params.tpl.stat_ga_code != '') {
			_ppsBindGoogleAnalyticsForPopup( ppsPopups[ i ] );
		}
		// Video (Vimeo) extra fullscreen
		if(ppsPopups[ i ].params.tpl.video_extra_full_screen) {
			_ppsBindVideoExtraFullScreen( ppsPopups[ i ] );
		}
		if(ppsPopups[ i ].params.tpl.iframe_display_only) {
			_ppsCheckIFrameDisplayOnly( ppsPopups[ i ] );
		}
	}
	if(g_ppsOnPageBottomPopups.length) {
		_ppsBindPageBottomEvent();
	}
	if(bindInactivePopups) {
		_ppsBindInactivePopups();
	}
});
function _ppsBindPageBottomEvent() {
	var docHt = jQuery(document).height()
	,	wndHt = jQuery(window).height()
	,	renderClb = function(){
		
		for(var i = 0; i < g_ppsOnPageBottomPopups.length; i++) {
			if(!g_ppsOnPageBottomPopups[ i ].is_visible && !g_ppsOnPageBottomPopups[ i ].is_rendered) {
				ppsCheckShowPopup( g_ppsOnPageBottomPopups[ i ] );
			}
		}
	},	checkScrollCheckClb = function(){
		
		if(jQuery(window).scrollTop() + jQuery(window).height() == jQuery(document).height()) {
			renderClb();
		}
	};
	if(docHt > wndHt) {
		jQuery(window).bind('scroll', checkScrollCheckClb);
		jQuery(window).bind('resize', checkScrollCheckClb);
		jQuery(window).bind('orientationchange', checkScrollCheckClb);
	} else {
		renderClb();
	}
}
function _ppsBindInactivePopups() {
	jQuery(window).bind('mousemove keypress cick scroll', function(){
		g_ppsOnInactiveIdleTime = 0;
	});
	setInterval(timerIncrement, 1000); // 1 second
}
function timerIncrement() {
    g_ppsOnInactiveIdleTime += 1;	// Increment for 1 second
	if(g_ppsOnInactivePopups 
		&& g_ppsOnInactivePopups[ g_ppsOnInactiveIdleTime ] 
		&& g_ppsOnInactivePopups[ g_ppsOnInactiveIdleTime ].length
	) {
		for(var i = 0; i < g_ppsOnInactivePopups[ g_ppsOnInactiveIdleTime ].length; i++) {
			if(!g_ppsOnInactivePopups[ g_ppsOnInactiveIdleTime ][ i ].is_visible /*&& !g_ppsOnInactivePopups[ g_ppsOnInactiveIdleTime ][ i ].is_rendered*/) {
				ppsCheckShowPopup( g_ppsOnInactivePopups[ g_ppsOnInactiveIdleTime ][ i ] );
			}
		}
		// Let's show always all inactivity PopUps
		//delete g_ppsOnInactivePopups[ g_ppsOnInactiveIdleTime ];
	}
}
function _ppsShowBuildInPopup( popup ) {
	var shell = ppsGetPopupShell( popup )
	,	buildInShell = jQuery('.ppsBuildInPopup[data-id="'+ popup.id+ '"]');
	popup._notResizeHeight = true;
	buildInShell.html('').append( shell );
	shell.css({
		'top': 0
	,	'left': 0
	,	'position': 'static'
	,	'z-index': 1
	});
	buildInShell.css({
		'position': 'relative'
	,	'padding': '0'
	,	'margin': '0'
	,	'display': 'inline-block'
	});
	ppsCheckShowPopup(popup, {
		ignoreBgOverlay: true
	,	ignorePosition: true
	});
}
function _ppsShowLogoutClb( popup, $shell ) {
	if(typeof(popup._logoutBackcounter) === 'undefined') {
		popup._logoutBackcounter = 10;	// 10 seconds we are waiting for user reaction
	}
	if(popup._logoutBackcounter) {
		__ppsLogoutBackcount( popup, $shell );
		popup._logoutTimeoutId = setTimeout(function(){
			_ppsShowLogoutClb( popup, $shell );
		}, 1000);
		return;
	}
	var logoutUrl = $shell.find('.ppsLogoutUrlShell').text();
	if(logoutUrl) {
		toeRedirect( logoutUrl );
	}
}
function __ppsLogoutBackcount( popup, $shell ) {
	$shell.find('.ppsLogoutBackcounterShell').html( popup._logoutBackcounter-- );
}
function _ppsLogoutResetBackcounter( popup ) {
	if(popup && isNumericPps( popup ))
		popup = ppsGetPopupById( popup );
	popup._logoutBackcounter = 10;	// 10 seconds we are waiting for user reaction
	clearTimeout( popup._logoutTimeoutId );
	ppsClosePopup( popup.id );	// And then just close PopUp - user is still here
}
function _ppsBindGoogleAnalyticsForPopup( popup ) {
	if(g_ppsGoogleAnalyticsStatsBinded) return;
	if(!window.ga) {
		jQuery('head').append('<script async src="https://www.google-analytics.com/analytics.js" />');
		window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
	}
	if(typeof(ga) === 'function') {
		ga('create', popup.params.tpl.stat_ga_code);
		jQuery(document).bind('ppsAfterPopupsStatAdded', function(event, params) {
			_ppsAddGoogleAnaliticsStatForPopup( params );
		});
	}
	g_ppsGoogleAnalyticsStatsBinded = true;
}
function _ppsAddGoogleAnaliticsStatForPopup( params ) {
	ga('send', 'event', 'PopUp '+ params.popup.label, params.action);
}
function _ppsOnVimeoPlay(popup) {
	popup._vimeoPlayer.play();
}
function _ppsBindVideoExtraFullScreen( popup ) {
	if(typeof(Vimeo) == 'undefined') {
		// Wait for a while - and don't wory:)
		setTimeout(function(){
			_ppsBindVideoExtraFullScreen(popup);
		}, 1000);
		return;
	}
	var $shell = ppsGetPopupShell( popup )
	,	$iframe = $shell.find('iframe:first')
	,	needResetSrc = $iframe.attr('src') ? false : true;

	if(needResetSrc) {
		$iframe.attr('src', $iframe.data('original-src'));
	}

	var	player = new Vimeo.Player($iframe.get(0));
	
	var	$closeBtn = $shell.find('.ppsPopupClose').first();
	/*player.on('loaded', function(a, b, c){
		this.getPaused().then(function(paused) {
			this.pause();
		}).catch(function(error) {
			// an error occurred
		});
		this.pause();
	});*/
	/*setTimeout(function(){
		player.pause();
	}, 4000);
	player.pause();*/
	player.on('play', function() {
		_ppsGoVimeoFullScreen($iframe, $closeBtn, player, popup);
    });
	popup._vimeoPlayer = player;
}
function _ppsGoVimeoFullScreen($iframe, $closeBtn, player, popup) {
	if($iframe.data('pps-full-screen')) {
		return;
	}
	$iframe.data('pps-full-screen', 1);
	$iframe.parent().css({
		'position': 'fixed'
	,	'width': '100%'
	,	'height': '100%'
	,	'left': '0'
	,	'top': '0'
	});
	$iframe.parents('.ppsPopupShell:first').css({
		'transform': ''
	});
	$iframe
		.data('prev-width', $iframe.attr('width'))
		.data('prev-height', $iframe.attr('height'))
		.attr('width', '100%').attr('height', '100%');
	$closeBtn.css({
		'position': 'fixed'
	,	'right': '40px'
	,	'top': '10px'
	,	'z-index': '1'
	});
	$closeBtn.click(function(e){
		_ppsOutVimeoFullScreen($iframe, $closeBtn, player, popup);
		return false;
	});
}
function _ppsOutVimeoFullScreen($iframe, $closeBtn, player, popup) {
	if(!$iframe.data('pps-full-screen'))
		return;
	
	$iframe.data('pps-full-screen', 0);
	player.pause();
	
	$iframe.parent().css({
		'position': 'static'
	,	'width': 'auto'
	,	'height': 'auto'
	});
	$iframe
		.attr('width', $iframe.data('prev-width'))
		.attr('height', $iframe.data('prev-height'));
	$closeBtn.attr('style', '');
	$closeBtn.unbind('click', _ppsOutVimeoFullScreen);
}
function _ppsCheckIFrameDisplayOnly( popup ) {
	var $shell = ppsGetPopupShell( popup )
	,	$iframe = $shell.find('iframe:first');

	$iframe.load(function(){
		_ppsIFrameDisplayOnly( popup, $iframe );
		// Second try
		/*$iframe.contents().find('*').each(function(){
			var $this = jQuery(this);
			if($this.prop("tagName") == 'HTML' 
				|| $this.prop("tagName") == 'BODY' 
				|| $this.prop('tagName') == 'LINK') return;
			if(jQuery(this).parents('#main').length) {
				
			} else
				jQuery(this).remove();
		});*/
	});
}
function _ppsIFrameDisplayOnly( popup, $iframe ) {
	var $shell = ppsGetPopupShell( popup )
	,	displaySelector = popup.params.tpl.iframe_display_only;
	
	$iframe = $iframe ? $iframe : $shell.find('iframe:first');
	
	popup.params._iframeDisplayOnlyBinded = true;
	// One shot
	$iframe.contents().find('*').css({
		'visibility': 'hidden'
	,	'width': '0'
	,	'height': '0'

	});
	$iframe.contents().find(''+ displaySelector+ ', '+ displaySelector+ ' *').each(function(){
		jQuery(this).css({
			'visibility': 'visible'
		,	'width': ''
		,	'height': ''
		});
	});
	$iframe.contents().find(displaySelector).parents().each(function(){
		jQuery(this).css({
			'visibility': 'visible'
		,	'width': ''
		,	'height': ''
		,	'margin': '0'
		,	'padding': '0'
		});
	});
}