var geocoder;
var map;
var marker;

var mapZoom = 15;


function initMap(map_id,lat, lng) {
        var latLng = new google.maps.LatLng(lat,lng) ;
                
        var mapOptions = {
          zoom: mapZoom,
          center: latLng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById(map_id), mapOptions);
        
        marker = new google.maps.Marker({
            map: map,
            position: latLng
        });        
}    
    
function codeAddress() {
    jQuery('.invalid_geodata').hide();
    geocoder = new google.maps.Geocoder();
    var address = jQuery("#wpl_streetAddress").val()+', '+jQuery("#wpl_postalCode").val()+' '+jQuery("#wpl_addressLocality").val();
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        var mapOptions = {
          zoom: mapZoom,
          center: results[0].geometry.location,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map-canvas_admin"), mapOptions);
        if (marker)
            marker.setMap(null);
        marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
        
        jQuery("#wpl_latitude").val(results[0].geometry.location.lat());
        jQuery("#wpl_longitude").val(results[0].geometry.location.lng());
        
      } else {
        jQuery('.invalid_geodata').show();
        jQuery("#wpl_latitude").val("");
        jQuery("#wpl_longitude").val("");
        if (marker) {
            marker.setMap(null);  
        }
      }
    });
}

jQuery(document).ready(function () {
    
    if ( jQuery('#wpl_latitude').val())
        initMap('map-canvas_admin',jQuery('#wpl_latitude').val(),jQuery('#wpl_longitude').val());
    jQuery('#checkAddress').click(function() {
        codeAddress();
        return false;
    });
    
    jQuery('.wpl_level1').prepend('----');
    jQuery('.wpl_level2').prepend('--------');
    
    
    //autocomplete in the admin
    if (jQuery('input#wpl_name.ui-autocomplete-input').length > 0) {
        jQuery('input#wpl_name.ui-autocomplete-input').autocomplete({
            //source: avaiableTags,
            //source: WPL.locationsajaxurl,
            source: function(request, response) {
                jQuery.ajax({
                    url: WPL.locationsajaxurl,
                    dataType: "json",
                    data: {
                        term: request.term,
                        exclude: function () { 
                                            var ids = new Array();
                                            jQuery(".active_locations").each(function() {
                                                //console.log(jQuery(this).val());
                                                ids.push(jQuery(this).val());
                                            });
                                            return ids;
                        }
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function( event, ui ){
                //ajax call to get new location
                jQuery.post(WPL.ajaxurl, {  action: 'wpl_get_location', 
                                            location_id: ui.item.location_id, 
                                        }, function(response) {
                                            jQuery('#wpl_locations_admin').append(response);
                                            console.log(ui.item);
                                            initMap('map-canvas_'+ui.item.location_id, ui.item.latitude,ui.item.longitude);
                                            jQuery('input#wpl_name').val('');
                });
            },
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
        html_val = "<a>" + item.label + '<br><span style="font-size:11px"><em>'+ item.street + ', ' + item.town+"</em></span></a>";
            return jQuery( "<li></li>" ).data( "item.autocomplete", item ).append(html_val).appendTo( ul );	
            //man könnte allet hier ranhängen...
        };
    }
    
    //dynamic input functionality
    jQuery('.dynamic_input').each(function() {
        var dynamic_input = jQuery(this);
        dynamic_input.find('.add_entity').click(function() {
            var added_entity = jQuery(dynamic_input.find('.entity_template').clone());
            added_entity.removeClass('entity_template');
            added_entity.find('input').prop('disabled', false);
            jQuery(this).before(added_entity.show());            
            added_entity.find('.del').click(function() {
                jQuery(this).parent().remove();
                return false;
            });   
            return false; 
        });
        
    });
    
    jQuery('.dynamic_input .del').click(function() {
        jQuery(this).parent().remove();
        return false;
    });  

    var custom_uploader;
    jQuery('#upload_logo_button').click(function(e) {
 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: wpl_lang.select_image,
            library : { type : 'image'},
            button: {
                text: wpl_lang.select_image
            },
            multiple: false,
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            var data = {
                    action: 'get_wpl_logo_url',
                    wpl_logo_id: attachment.id
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            jQuery.post(ajaxurl, data, function(response) {
                
                jQuery('#wpl_logo').val(response);

                            
                if (jQuery('#wpl_logo_preview').length < 1)
                    jQuery('.wpl_logo').append('<br/><img id="wpl_logo_preview" src="'+response+'" />');
                else
                    jQuery('#wpl_logo_preview').attr('src', response);
                    
                jQuery('#remove_logo_button').show();    
            });
            


        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });
    
    jQuery('#remove_logo_button').click(function() {
        jQuery('#wpl_logo_preview').remove();
        jQuery('#wpl_logo').val('');
        jQuery(this).hide();
        
        return false;
    });    

});