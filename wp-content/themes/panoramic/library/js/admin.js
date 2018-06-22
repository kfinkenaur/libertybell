/**
 * Panoramic Theme Custom Admin Functionality
 *
 */
( function( $ ) {
	var sliderCategories = variables.sliderCategories.split(',');
	
    $( document ).ready( function() {
    	toggleSliderLinkField( $( '#categorychecklist' ) );
    	toggleSliderLinkCustomField();
    	toggleSliderLinkTargetField();
    	
        $( '#categorychecklist' ).on( 'change', function() {
        	toggleSliderLinkField( $(this) );
        });

        $( '#slider_link_content_container select' ).on( 'change', function() {
        	toggleSliderLinkCustomField();
        	toggleSliderLinkTargetField();
        });
        
        // Check if the add tag / add category form has been submitted
        $('#addtag').each( function(){
	        $submit = $(this).find('#submit');
            
            $submit.on( 'click', function(e) {
            	$('#ajax-response').html('');
            	
            	var $myText = $('#tag-name');

            	$myText.data("value", $myText.val());
            	
            	var submitChecker = setInterval(function() {
            	    var data = $myText.data("value"),
            	        val = $myText.val();

            	    if (data !== val ) {
            	    	resetHeaderImageFields();
            	    	clearInterval(submitChecker);
            	    } else if ( $('#ajax-response .error').length > 0 || $('.form-field.form-invalid').length > 0 ) {
            	    	clearInterval(submitChecker);
            	    }
            	}, 100);
            });
            
        });                
        
    	// Uploading files
    	var file_frame;

    	$.fn.upload_header_image = function( button ) {
    		var button_id = button.attr('id');
    		var field_id = button_id.replace( '_button', '' );

    		// If the media frame already exists, reopen it.
    		if ( file_frame ) {
    		  file_frame.open();
    		  return;
    		}

    		// Create the media frame.
    		file_frame = wp.media.frames.file_frame = wp.media({
    		  title: $( this ).data( 'uploader_title' ),
    		  button: {
    		    text: $( this ).data( 'uploader_button_text' ),
    		  },
    		  multiple: false
    		});

    		// When an image is selected, run a callback.
    		file_frame.on( 'select', function() {
    		  var attachment = file_frame.state().get('selection').first().toJSON();
    		  
    		  $("#"+field_id).val(attachment.id);
    		  $("#header_image_container img").attr('src',attachment.url);
    		  $("#header_image_container img").attr('srcset',attachment.url);
    		  $( '#header_image_container img' ).show();
    		  $( '#' + button_id ).attr( 'id', 'remove_header_image_button' );
    		  $( '#remove_header_image_button' ).text( 'Remove header image' );
    		});

    		// Finally, open the modal
    		file_frame.open();
    	};

    	// On click set header image
    	$('#header_image_container').on( 'click', '#upload_header_image_button', function( event ) {
    		event.preventDefault();
    		$.fn.upload_header_image( $(this) );
    	});

    	// On click remove header image
    	$('#header_image_container').on( 'click', '#remove_header_image_button', function( event ) {
    		event.preventDefault();
    		$( '#upload_header_image' ).val( '' );
    		$( '#header_image_container img' ).attr( 'src', '' );
    		$( '#header_image_container img' ).attr( 'height', 'auto' );
    		$( '#header_image_container img' ).hide();
    		$( this ).attr( 'id', 'upload_header_image_button' );
    		$( '#upload_header_image_button' ).text( 'Set header image' );
    	});        
        
    } );
    
    function resetHeaderImageFields() {
		$( '#upload_header_image' ).val( '' );
		$( '#header_image_container img' ).attr( 'src', '' );
		$( '#header_image_container img' ).attr( 'height', 'auto' );
		$( '#header_image_container img' ).hide();
		$( '#remove_header_image_button' ).attr( 'id', 'upload_header_image_button' );
		$( '#upload_header_image_button' ).text( 'Set header image' );
    }
    
    function toggleSliderLinkField( element ) {
		var isSlide = false;
		
		element.find('li input:checked').each(function() {
			if ( $.inArray( $(this).val(), sliderCategories) > -1 ) {
				isSlide = true;
			}
		});
	
		if ( isSlide ) {
			$( '#slider_link_content_container' ).show();
		} else {
			$( '#slider_link_content_container' ).hide();
		}        	
    }
    
    function toggleSliderLinkCustomField() {
    	if ( $( '#slider_link_content_container select' ).val() == 'custom' ) {
    		$( '#slider_link_custom' ).show();
    	} else {
    		$( '#slider_link_custom' ).hide();
    	}
    }

    function toggleSliderLinkTargetField() {
    	if ( $( '#slider_link_content_container select' ).val() != '' ) {
    		$( '#slider_link_target' ).show();
    	} else {
    		$( '#slider_link_target' ).hide();
    	}
    }
    
} )( jQuery );