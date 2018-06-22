jQuery(document).ready(function($) {
	$( '.vfb-display-entries' ).each( function() {
		var id = $( this ).prop( 'id' ),
			new_id = parseInt( id.replace(/vfb-display-entries-/, '') );
		
		$( '#vfb-display-entries-' + new_id ).dataTable({
			'bJQueryUI' : true,
			'sPaginationType' : 'full_numbers',
			'sScrollX' : '100%'
		});
	});
});