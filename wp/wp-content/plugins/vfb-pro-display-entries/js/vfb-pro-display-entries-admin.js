jQuery(document).ready(function($) {
		
	$( document ).on( 'change', '#vfb-display-entries-forms', function(){
		var id = $( this ).prop( 'value' ),
			count = vfb_display_entries_count( id );
		
		$( '#vfb-display-entries-shortcode' ).val( '[vfb-display-entries id=' + id + ']' );
		$( '#vfb-display-entries-template-tag' ).val( '<?php vfb_display_entries( \'id=' + id + '\' ); ?>' );
		
		$( '#vfb-display-entries-fields' ).html( 'Loading...' );
		
		$.get( ajaxurl,
			{
				action: 'vfb_display_entries_load_options',
				id: id,
				count: count,
				page: pagenow
			}
		).done( function( response ) {
			$( '#vfb-display-entries-fields' ).html( response );
		}).fail( function( response ) {
			$( '#vfb-display-entries-fields' ).html( 'Error loading entry fields.' );
		});
	});
	
	$( document ).on( 'change', '.vfb-display-entries-vals', function(){
		vfb_check_entries_vals();
	});
	
	$( '#vfb-display-entries-select-all' ).click( function( e ) {
		e.preventDefault();
		
		$( '#vfb-display-entries-fields input[type="checkbox"]' ).prop( 'checked', true );
		
		vfb_check_entries_vals();
	});
	
	$( '#vfb-export-entries-rows' ).change( function(){
		var id = $( '#vfb-display-entries-forms' ).val();
		
		var page = $( this ).val();
		
		$( '#vfb-display-entries-fields' ).html( 'Loading...' );
		
		$( '#vfb-display-entries-shortcode' ).val( '[vfb-display-entries id=' + id + ' page=' + page + ']' );
		$( '#vfb-display-entries-template-tag' ).val( '<?php vfb_display_entries( \'id=' + id + '&page=' + page + '\' ); ?>' );
		
		$.get( ajaxurl,
			{
				action: 'vfb_display_entries_load_options',
				id: id,
				offset: page,
				page: pagenow
			}
		).done( function( response ) {
			$( '#vfb-display-entries-fields' ).html( response );
		}).fail( function( response ) {
			$( '#vfb-display-entries-fields' ).html( 'Error loading entry fields.' );
		});
	});
	
	function vfb_check_entries_vals() {
		var checked = $( '.vfb-display-entries-vals:checked' ),
			vals = [], temp;
		
		checked.each( function( i, value ){
			temp = $( value ).val();
			
			// Encode double quotes
			temp = temp.replace( /"/g, '&quot;' );
			
			vals[ i ] = temp;
		});
		
		var fields = vals.join( ', ' ),		
			shortcode = $( '#vfb-display-entries-shortcode' ).val(),
			template_tag = $( '#vfb-display-entries-template-tag' ).val();
		
		if ( shortcode.match( /fields=".+"/ ) )
			shortcode = shortcode.replace( /fields="(.+)"/, 'fields="' + fields + '"' );
		else
			shortcode = shortcode.replace( /id=(\d+)/, 'id=$1' + ' fields="' + fields + '"' );
		
		$( '#vfb-display-entries-shortcode' ).val( shortcode );
		
		if ( template_tag.match( /fields=".+"/ ) )
			template_tag = template_tag.replace( /fields="(.+)"/, 'fields="' + fields + '"' );
		else
			template_tag = template_tag.replace( /id=(\d+)/, 'id=$1' + '&fields="' + fields + '"' );
		
		$( '#vfb-display-entries-template-tag' ).val( template_tag );
	}
	
	function vfb_display_entries_count( id ) {
		 var count = '';
		 
		 $.ajax( ajaxurl, {
			 async: false,
			 data:
			 {
				action: 'vfb_display_entries_entries_count',
				id: id,
				page: pagenow
			 }
		}).done( function( response ) {
			if ( response > 1000 ) {
				
				$( '#vfb-export-entries-rows' ).empty();
				
				var num_pages = Math.ceil( parseInt( response ) / 1000 );
				
				for ( var i = 1; i <= num_pages; i++ ) {
					$( '#vfb-export-entries-rows' ).append( $( '<option></option>' ).attr( 'value', i ).text( i ) );
				}
				
				$( '#vfb-export-entries-pages' ).show();
			}
			else {
				$( '#vfb-export-entries-pages' ).hide();
			}
			
			count = response;
		}).fail( function( response ) {
		});
		
		return count;
	}
});