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