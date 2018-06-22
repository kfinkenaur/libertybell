jQuery(document).ready(function($) {
	
	var field_ids = [], hidden_ids = $( '.vfb-payment-field-ids' );
	
	// If options exist on the page, don't add to the Assign Prices drop down
	if ( hidden_ids.length ) {
		$( hidden_ids ).each( function(){
			field_ids.push( $( this ).val() );
		});
	}
	
	// !Assign Prices drop down
	$( document ).on( 'change', '#vfb-payment-fields', function(){
		var id = $( this ).prop( 'value' ),
			form = $( 'input[name="form_id"]' ).prop( 'value' ),
			that = $( this );
		
		if ( id == '' )
			return;
		
		// Build array of already selected IDs
		field_ids.push( id );
		
		display_options( id, $( '.vfb-payment-assign-prices-header' ) );
		
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			async: true,
			cache: false,
			dataType: 'html',
			data: {
				action: 'vfb_payments_price_fields',
				field_id: field_ids,
				form_id: form,
				page: pagenow
			},
			success: function( response ) {
				that.html( response );
			},
			error: function( xhr,textStatus,e ) {
				alert( xhr + ' ' + textStatus + ' ' + e );
				return; 
			}
		});
	});
	
	// !Display field options
	function display_options( id, element ) {
		
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			async: true,
			cache: false,
			dataType: 'html',
			data: {
				action: 'vfb_payments_price_fields_options',
				field_id: id,
				page: pagenow
			},
			success: function( response ) {
				element.before( response );
			},
			error: function( xhr,textStatus,e ) {
				alert( xhr + ' ' + textStatus + ' ' + e );
				return; 
			}
		});
	}
	
	$( document ).on( 'click', '.vfb-payment-remove-field', function( e ) {
		e.preventDefault();
		
		var data = new Array(),
			form = $( 'input[name="form_id"]' ).prop( 'value' ),
			parent = $( this ).parents( '.vfb-pricing-fields-container' ),
			href = $( this ).attr( 'href' ), url = href.split( '&' );
		
		for ( var i = 0; i < url.length; i++ ) {
			// break each pair at the first "=" to obtain the argname and value
			var pos      = url[i].indexOf( '=' );
			var argname  = url[i].substring( 0, pos );
			var value    = url[i].substring( pos + 1 );
			
			data[ argname ] = value;
		}
		
		var field_id = data['field'];
		
		// Get index of field ID in array
		var index = field_ids.indexOf( field_id );
		
		// Remove from array if field is found
		if ( index !== -1 )
			field_ids.splice( index, 1 );
		
		// Remove the pricing field box
		parent.fadeOut( 350, function() {
			$( this ).remove();
		});
		
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			async: true,
			cache: false,
			dataType: 'html',
			data: {
				action: 'vfb_payments_price_fields',
				field_id: field_ids,
				form_id: form,
				page: pagenow
			},
			success: function( response ) {
				$( '#vfb-payment-fields' ).html( response );
			},
			error: function( xhr,textStatus,e ) {
				alert( xhr + ' ' + textStatus + ' ' + e );
				return; 
			}
		});
	});
	
	// !Toggle hidden payment options
	$( document ).on( 'change', '.vfb-payment-toggles', function() {
		var id = $( this ).prop( 'id' ),
			options = '.' + id + '-options';
		
		if ( $( this ).is( ':checked' ) ) {
			$( options ).show();
			$( options + ' :input' ).prop( 'disabled', false );
		}
		else {
			$( options ).hide();
			$( options + ' :input' ).prop( 'disabled', true );
		}
	});
	
	$( '#vfb-pro-payments-form' ).validate();
	
	$.validator.addMethod( 'vfb-clean-currency', function(value, element) {
		return this.optional(element) || /^[0-9\.\,\-]*$/i.test(value);
	}, 'Special characters not allowed' );
});