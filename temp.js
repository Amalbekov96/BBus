  
  function initListeners(){
      google.maps.event.addListener(map, 'click', function(event) {
        
         placeMarker(event.latLng);

         google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
        });
    });
 

    var markers = markersInfo.map(function(location, i) {
       var lab = location.level.toString();
                                  
        
       var markerPointed = new google.maps.Marker({
         position: ({lat: location.lat,lng: location.lng}),
         icon: 'red_trash.png'
      });

      markerPointed.addListener('click', function(){
                                
         if (statewindow) {
            statewindow.close();
          }

          if (location.name == '$sesusername') {
              statewindow= new google.maps.InfoWindow({
           content:
           '<h3> Comment:' + location.comments +
           '<br>Level of Pollution: ' + location.level.toString()  +
           '<br>User:' + location.name +
            '<br>Region:' + location.region + '</h3>'
            + '<button onclick = deletePoint()> Delete your point </button>'
            });
          } else {
                
          statewindow= new google.maps.InfoWindow({
           content: '<h3> Comment:' + location.comments +
           '<br>Level of Pollution: ' + location.level.toString()  +
           '<br>User:' + location.name +
            '<br>Region:' + location.region + '</h3>'
            + '<button onclick = reportPoint()> Mark as cleaned </button>'
          });
                                
        
       }

          statewindow.open(map,markerPointed);

      });
      return markerPointed;
    });
      // Add a marker clusterer to manage the markers.

    var markerCluster = new MarkerClusterer(map, markers, {
imagePath:
  'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m',});

  }
