jQuery(document).ready(function($) {

	$( '#vfb-form-design-enable' ).change( function(){
		if ( $( this ).is( ':checked' ) )
			$( '.form-design-types' ).show();
		else {
			$( '.form-design-types' ).hide();
			$( '.vfb-form-design-themes-container' ).hide();
			$( '.vfb-form-design-custom-container' ).hide();
			$( '.vfb-design-types-options' ).prop( 'checked', false );
		}
	});

	$( '.vfb-design-types-options' ).change( function(){
		if ( 'themes' == $( this ).val() ) {
			$( '.vfb-form-design-themes-container' ).show();
			$( '.vfb-form-design-custom-container' ).hide();
		}
		else if ( 'custom' == $( this ).val() ) {
			$( '.vfb-form-design-custom-container' ).show();
			$( '.vfb-form-design-themes-container' ).hide();
		}
	});

	// !Create color pickers
	$( '.vfb-form-colorPicker' ).each( function() {
		var $this = $( this ),
			id = $this.attr( 'id' ),
			vfb_color = $( '#' + id );
			//new_id = '#vfb-' + id.replace(/picker-/, '');


		vfb_color.wpColorPicker({
            change: function(event, ui) {
                vfb_color.css( 'background-color', ui.color.toString() );
            },
            clear: function() {
                vfb_color.css( 'background-color', '' );
            }
        });
	});

	// !Tab in textareas
	$( '#vfb-design-custom-css' ).bind( 'keydown.vfb_InsertTab', function(e) {
		var el = e.target, selStart, selEnd, val, scroll, sel;

		// escape key
		if ( e.keyCode == 27 ) {
			$( el ).data('vfb-tab-out', true);
			return;
		}

		// tab key
		if ( e.keyCode != 9 || e.ctrlKey || e.altKey || e.shiftKey )
			return;

		if ( $( el ).data( 'vfb-tab-out' ) ) {
			$( el ).data( 'vfb-tab-out', false);
			return;
		}

		selStart  = el.selectionStart;
		selEnd    = el.selectionEnd;
		val       = el.value;

		try {
			this.lastKey = 9; // not a standard DOM property, lastKey is to help stop Opera tab event. See blur handler below.
		} catch(err) {}

		if ( document.selection ) {
			el.focus();
			sel = document.selection.createRange();
			sel.text = '\t';
		} else if ( selStart >= 0 ) {
			scroll = this.scrollTop;
			el.value = val.substring( 0, selStart ).concat( '\t', val.substring( selEnd ) );
			el.selectionStart = el.selectionEnd = selStart + 1;
			this.scrollTop = scroll;
		}

		if ( e.stopPropagation )
			e.stopPropagation();
		if ( e.preventDefault )
			e.preventDefault();
	});

	$( '#vfb-design-custom-css' ).bind( 'blur.vfb_InsertTab', function(e) {
		if ( this.lastKey && 9 == this.lastKey )
			this.focus();
	});

	// !Copy settings
	$( document ).on( 'submit', '#vfb-form-design-copy-settings', function(e){
		e.preventDefault();

		var d = $( this ).closest( 'form' ).serialize();

		$.post( ajaxurl,
			{
				action: 'vfb_form_designer_copy_settings_save',
				data: d,
				page: pagenow
			}
		).done( function( response ) {
			tb_remove();
		});
	});

	$( '#vfb-design-width-type' ).change( function(){
		var val = $( this ).val();

		if ( 'auto' == val )
			$( '#vfb-design-width-length' ).hide();
		else
			$( '#vfb-design-width-length' ).show();
	});

	// !iFrame resize
	$(function(){

	    var iFrames = $( '#vfb-design-custom-preview iframe' ),
	    	manualOffset = 20;

		function iResize() {

			for (var i = 0, j = iFrames.length; i < j; i++) {
			  iFrames[i].style.height = manualOffset + iFrames[i].contentWindow.document.body.offsetHeight + 'px';
			}
		}

    	iFrames.load(function() {
		   this.style.height = manualOffset + this.contentWindow.document.body.offsetHeight + 'px';
		});
    });
});