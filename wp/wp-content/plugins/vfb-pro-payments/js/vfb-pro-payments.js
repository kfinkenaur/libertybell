jQuery(document).ready(function($) {


	// !Only run conditional rules if settings exist
	if( window.VfbPrices ) {
		var obj = $.parseJSON( VfbPrices.prices );
		var selectors = [];

		vfb_prices( obj );

		$( obj ).each( function(){
			selectors.push( '[name^=vfb-' + this.id + ']' );
		});

		$( selectors.join(',') ).change( function(){
			vfb_prices( obj );
		});
	}

	// !Handle the running total
	function vfb_prices( obj ) {
		var priced = 0, items = [], hidden = [], form_id = '';

		$( obj ).each( function( j ){
			var field_id = this.id, prices = this.prices,
				id_attr = $( '[name^=vfb-' + field_id + ']' ).parents( 'li' ).prop( 'id' ),
				input = $( '[name^=vfb-' + field_id + ']' );

			// Get the form ID
			form_id = $( '[name^=vfb-' + field_id + ']' ).parents( 'form' ).prop( 'id' );

			// Radio
			if ( input.is( '[type=radio]' ) ) {
				// The index of the checked item
				var index = input.index( input.filter( ':checked' ) );

				// If an index is returned
				if ( index != -1 ) {
					var value = input.filter( ':checked' ).val(),
						price = parseFloat( prices[ index ] );

					// Add to total price
					priced += price;

					// Build output for line item
					var output = '<div class="vfb-payment-item"><span class="vfb-payment-item-name">' + value + '</span><span class="vfb-payment-item-price">' + price.toFixed(2) + '</span></div>';

					// Add line item to array
					items.push( output );

					// Building hidden inputs
					hidden.push( {
					    'name' : value,
					    'price' : price.toFixed(2)
				    } );
				}
			}
			// Checkboxes
			else if ( input.is( '[type=checkbox]' ) ) {
				// Continue if there are options to work with
				if ( input.length > 0 ) {
			    	for ( var i = 0; i < input.length; i++ ) {
			    		if ( $( input[ i ] ).is( ':checked' ) ) {

			    			var value = $( input[i] ).val(),
			    				price = parseFloat( prices[ i ] );

			    			// Add to total price
			    			priced += price;

			    			// Build output for line item
			    			var output = '<div class="vfb-payment-item"><span class="vfb-payment-item-name">' + value + '</span><span class="vfb-payment-item-price">' + price.toFixed(2) + '</span></div>';

			    			// Add line item to array
			    			items.push( output );

			    			// Building hidden inputs
			    			hidden.push( {
							    'name' : value,
							    'price' : price.toFixed(2)
						    } );
			    		}
			    	}
			    }
			}
			// Selects
			else if ( input.is( 'select' ) ) {
				// Save the value and index
				var value = input.val(),
					index = input.prop( 'selectedIndex' ),
					price = parseFloat( prices[ index ] );

				// Add to total price
				priced += price;

				// Build output for line item
				var output = '<div class="vfb-payment-item"><span class="vfb-payment-item-name">' + value + '</span><span class="vfb-payment-item-price">' + price.toFixed(2) + '</span></div>';

				// Add line item to array
				items.push( output );

			    // Building hidden inputs
			    hidden.push( {
				    'name' : value,
				    'price' : price.toFixed(2)
			    } );
			}
			// Currency
			else if ( input.is( '[type=text]' ) ) {
				if ( input.val() ) {
					var price = parseFloat( input.val() ),
						value = $( '#' + id_attr ).children( 'label' ).text();

					// Add to total price
					priced += price;

					// Build output for line item
					var output = '<div class="vfb-payment-item"><span class="vfb-payment-item-name">' + value + '</span><span class="vfb-payment-item-price">' + price.toFixed(2) + '</span></div>';

					// Add line item to array
					items.push( output );

					// Building hidden inputs
					hidden.push( {
					    'name' : value,
					    'price' : price.toFixed(2)
				    } );
				}
			}
		});

		// Total Price
		$( '.vfb-total' ).text( priced.toFixed(2) );

		// Price Items
		$( '.vfb-payment-items' ).html( items );

		// Hidden inputs for PayPal
		vfb_prices_hidden_inputs( form_id, hidden );

		// Totals hidden inputs for PayPal
		vfb_total_hidden_input( form_id, priced.toFixed(2) );
	}

	function vfb_prices_hidden_inputs( form_id, prices ) {
		var input_name = '', input_amt = '', index = 1;

		$( prices ).each( function( i ){
			var name = this.name, price = this.price;

			input_name += '<input type="hidden" name="item_name_' + index + '" value="' + name + '">';
			input_amt  += '<input type="hidden" name="amount_' + index + '" value="' + price + '">';

			index++;
		});

		// Dynamically add hidden inputs to form
		$( '#' + form_id + ' .vfb-payment-hidden-inputs' ).html( input_name + input_amt );
	}

	function vfb_total_hidden_input( form_id, total ) {
		var totals = '<input type="hidden" name="a3" value="' + total + '">';

		// Dynamically add hidden total to form
		$( '#' + form_id + ' .vfb-payment-hidden-totals' ).html( totals );
	}

	// !Running Total
	if ( $( '.vfb-payment-total-container' ).length > 0 ) {

		var sidebar = $( '.vfb-payment-total-container' ),
			offset = sidebar.offset(),
			topMargin = 50,
			original_left = sidebar.position().left;

	    // Update when scrolling
	    $( window ).on( 'scroll', function() {

		    var scroll_from_top = $( window ).scrollTop(),
				new_left = sidebar.offset().left,
	        	sidebar_width = sidebar.width(),
				form_height = $('.visual-form-builder-container').outerHeight();

			// Only scroll div when it has been reached and if not further than last item
	        if ( ( scroll_from_top > offset.top )  ) {
	        	if ( scroll_from_top > form_height )
	        		sidebar.css({'position' : 'absolute', 'top' : 'auto', 'bottom' : 50, 'left' : original_left });
	        	else
	        		sidebar.css({'position' : 'fixed', 'top' : topMargin, 'bottom' : 'auto', 'left' : new_left, 'width' : sidebar_width });
			}
			else {
				sidebar.css({'position' : 'absolute', 'top' : 0, 'bottom' : 'auto', 'left' : original_left });
	        }

	    });
	}
});