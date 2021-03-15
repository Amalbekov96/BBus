var map;
var markers = [];

setInterval(refreshMapa, 3000);

function initialize() {
  var mapOptions = {
      zoom: 12,
      center: new google.maps.LatLng(-25.4848801,-49.2918938),
      mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  var locations = [];

  $.get("getmarkers.php", function(response){
    for(var i = 0; i < response.markers.length; i++) {
      var marker = response.markers[i];
      var myMarker = {
        Data: marker.Data,
        latlng: new google.maps.LatLng(marker.lat, marker.lon),
        hora: marker.hora,
        raio: marker.raio,
        provedor: marker.provedor,
        velocidade: marker.velocidade
      };

      locations.push(myMarker);
      addMapMarker(myMarker);
    }
  },'json');

  markerClusterer = new MarkerClusterer(map, markers, {
    maxZoom: 16,
    gridSize: 60
  });
  map.fitBounds(bounds);
}

function refreshMapa() {
// make sure this one only returns markers that are new and not in the map
$.get("getnewmarkers.php", function(){
 for(var i = 0; i < response.markers.length; i++) {
   var marker = response.markers[i];
   var myMarker = {
     Data: marker.Data,
     latlng: new google.maps.LatLng(marker.lat, marker.lon),
     hora: marker.hora,
     raio: marker.raio,
     provedor: marker.provedor,
     velocidade: marker.velocidade
   };

   locations.push(myMarker);
   addMapMarker(myMarker);
 }, 'json');
}

function addMapMarker(myMarker) {
   var marker = new google.maps.Marker({
      position: myMarker.latlng,
      map:map,
      title:myMarker.hora
    });
    
    markers.push(marker);
    bounds.extend(myMarker.latlng);
    
    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent('<strong>Data: ' + myMarker.Data + '<br>Hora: ' + myMarker.hora + '<br></strong>Velocidade aproximada: ' + myMarker.velocidade + ' K/H<br>Raio aproximado de: ' + myMarker.raio + ' metros <br>Provedor: ' + myMarker.provedor + '<br>Latitude: ' + myMarker.latlng);
        infowindow.open(map, marker);
      }
    })(marker, i));
}
