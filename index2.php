
<?php
//header('Content-Type: text/html; charset=utf-8');

//session_start();

require_once ("config.php");

$logout;

if(isset($_GET['logout']) == 1) {
  unset($_SESSION['username']);
  unset($_SESSION['id']);
  session_destroy();
}

$conn;

$userid = isset($_SESSION['id']);

$sesusername;

if(isset($_SESSION['username'])){
    $sesusername = $_SESSION['username'];
}

$_GET['mypoints'] = 'STAR';

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$result = mysqli_query($conn,"SELECT * FROM Markers");


 $json = [];

 while($row = mysqli_fetch_assoc($result)){
   $json[] = $row;
 }

 $json_encoded = json_encode($json,JSON_NUMERIC_CHECK );

//if (!empty($_SESSION)) {

print ("<html>

  <head>
  <title>Bishkek Transportation</title>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

  </head>

<body>
<div style = 'float:right;margin:12px' class='btn-group'>
  <a href='index.php?logout=0' class='btn btn-success' role='button'> Logout</a>
  <a href='AboutUs.php' class='btn btn-Warning' role='button'>How does it work?</a>
</div>
</body>
</html>
");

  $html = "<!DOCTYPE html>
    <head>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
    <meta name='viewport' content='initial-scale=1.0, user-scalable=no' />
    <meta http-equiv='content-type' content='text/html; charset=utf-8'/>
      <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

    <title>From Info Windows to a Database: Saving User-Added Form Data</title>
    <style>
      #map {
        height: 90%;
       width: 89%;
       position: relative;
       left: 5%;
      }
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
    </head>
    <body style='background-color:#ff5050;'>
    <div id='map' height='100%' width='100%' ></div>


    <script>
       
       
       var map;
       var markers = [];
       
       function initMap() {

           map = new google.maps.Map(document.getElementById('map'), {
           zoom: 12,
           center: {lat: 42.8640117, lng: 74.5460088 }
         });
       
       update();
       
       showMarkers();
       }
       
       
       
      //----------------------------------------
    
//       var refreshIntervalId = setInterval('requestPoints()', 4000);
//       alert();
       
       
       function requestPoints() {
//       alert('requestPoint');
       
       $.ajax({url: 'https://web-class.auca.kg/~kushtar/BBus/Markers.php?q=1',
                    dataType: 'json',
                    success: function(position, status){
                        updatePoints(position);
                    }});
       
      
       }
       
       
       

       function updatePoints(position) {
//       alert('updatePosit');
//           console.debug('updating markers');
           var lat;
           var lng;
       
           for (var i=0; i < position.length; i++) {
               lat = position[i].lat;
               lng = position[i].lng;
                
               latlng = new google.maps.LatLng(lat, lng);
       
       
              const marker = new google.maps.Marker({
                  position: latlng,
                  map: map,
                icon: './images/icons/bus.png'
                });
       
            DeleteAllMarkers();
             markers.push(marker);
       
                
              // markers[positions[i].registration].setPosition(position);
       
           };
       
       
           if (positions.length > 1) {
               //map.fitZoom();
           } else {
               map.setCenter (lat, lng);
           }
       }


//--------------------------------------------------------------------

       
       function setMapOnAll(map) {
//       alert('setting markers');
         for (let i = 0; i < markers.length; i++) {
           markers[i].setMap(map);
         }
       }
       
       
//----------------------------------------------------------------
       
       function showMarkers() {
         setMapOnAll(map);
       }
       
//--------------------------------------------------------------
       
      function DeleteAllMarkers() {

        for (let i = 0; i < markers.length; i++) {
          markers[i].setMap(null);
        }
       markers = [];
      }
       
//----------------------------------------------------------------
       
       function update(){
              
              options = {
                enableHighAccuracy: false,
                timeout: 10000,
                maximumAge: 0
              };

              const pos = new Object();
              
              var lat = 9;
              var lng = 9;

//       alert('update');
              navigator.geolocation.watchPosition(
                                                  
//                  function(position){
//                  ShowPosition(position);
//                  }
                ShowPosition
                ,
                () => {
                   error();
                },
                () => {
                      options();
                }
              );
       }
       
       
       
       function ShowPosition(position) {
          
             lat = position.coords.latitude;
             lng = position.coords.longitude;
                            
//           marker = new google.maps.Marker({
//              position: ({lat: lat,lng: lng}),
//              icon: './images/icons/bus.png'
//           });
               
             var url = 'https://web-class.auca.kg/~kushtar/BBus/UpdatePoint.php?comment=' + '144' + '&lat=' + lat + '&lng=' + lng;
                                             
             var xhttp = new XMLHttpRequest();
             
             xhttp.onreadystatechange = function() {
  
             
               if (xhttp.readyState == 4) {
                 if (xhttp.status == 205) {
                                             
                 } else if (xhttp.status == 200) {
             
                 } else {
             
                 }

                 if (xhttp.status == 202) {

                 }
               }

             };
             
             xhttp.open('GET', url, true);
             xhttp.send();
       
//             alert('showPosition');
            requestPoints();
            
          
          }
       
//----------------------------------------------------------------
       

      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request.responseText, request.status);
          }
        };
      }

       //----------------------------------------------------------------------

      function doNothing () {

      }

    </script>
       
     <script src='https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js'>
    </script>

    <script async defer
    src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBlLms-yD7lNgRk3z4LIpv79WvNTP2aY1I&callback=initMap'>
    </script>
</body>
</html>";
  echo $html;

?>
