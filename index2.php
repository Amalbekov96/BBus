<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
  
require_once ("config.php");


//$logout;
//
//if(isset($_GET['logout']) == 1) {
//  unset($_SESSION['username']);
//  unset($_SESSION['id']);
//  session_destroy();
//}

$conn;

$userid = $_SESSION['id'];
    
     
    
$sesusername;

if(isset($_SESSION['username'])){
    
    $sesusername = $_SESSION['username'];
    echo $userid;
    echo $sesusername;
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
       var statewindow = null;
       var infowindow = null;
       var messagewindow = null;
       var userIsOnline = new Boolean(null);
       
       
       
       function initMap() {

           map = new google.maps.Map(document.getElementById('map'), {
           zoom: 12,
           center: {lat: 42.8640117, lng: 74.5460088 }
         });
//       alert('tema');
       
       if(userIsOnline == false){
            createButton();
       }

               update();
        
           
            
//       initListeners();
       }
       
       
       
      //----------------------------------------
    
//       var refreshIntervalId = setInterval('requestPoints()', 4000);
//       alert();
       

//--------------------------------------------------------------------
       
       function initWindows(){
         var formStr = `" . FORM_FOR_INPUT . "`;
         var messageStr = `" . MESSAGE_LOCATION_SAVED . "`
         infowindow = new google.maps.InfoWindow({
             content: formStr
         });
         messagewindow = new google.maps.InfoWindow({
           content: document.getElementById('message')
         });
       }
       
//---------------------------------------------------------------------
       
       
      function createButton(){

          initWindows();
          
          
          var locationButton = document.createElement('button');
          locationButton.textContent = 'show mini-bus';
          locationButton.classList.add('custom-map-control-button');
       
          map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(
            locationButton
          );
       
      locationButton.addEventListener('click', () => {
                                      
//         if(userIsOnline == false){
                                      
             if (navigator.geolocation) {
               navigator.geolocation.getCurrentPosition(
                 (position) => {
                   const pos = {
                     lat: position.coords.latitude,
                     lng: position.coords.longitude,
                   };

    //                  new google.maps.Marker({
    //                   position: pos,
    //                   map,
    //                   title: 'Hello World!',
    //                 });

                   messagewindow.setPosition(pos);

                   infowindow.setPosition(pos);
    //
                   infowindow.open(map);
                   map.setCenter(pos);
                                                        
                 },
                 () => {
                   handleLocationError(true, infowindow, map.getCenter());
                 }
               );
             } else {
               // Browser doesn't support Geolocation
               handleLocationError(false, infowindow, map.getCenter());
             }
//            } else {
//                  alert('you are already online');
//            }
                                      
       });
       
      }
       
       
//---------------------------------------------------------------------------------------------
       
      function saveData() {
            var trans_num = document.getElementById('comment').value;
            var latlng = infowindow.getPosition();
            var levels = document.getElementsByName('lev');
            var trans_type = document.getElementById('trans');
            var level = 3;

           var trans = trans_type.options[trans_type.selectedIndex].text;

              for (var i = 0, length = levels.length; i < length; i++)
            {
               if (levels[i].checked)
               {
                level = levels[i].value;
                break;
               }
            }
       

          var url = 'https://web-class.auca.kg/~kushtar/BBus/PointPlace.php?comment=' + trans_num + '&level=' + level +'&lat=' + latlng.lat() + '&lng=' + latlng.lng() + '&trans=' + trans;
       
       
          marker = new google.maps.Marker({
            position: event.latLng,
            map: map,
            icon:'./images/icons/bus.png'
          });

        messagewindow.open(map);
       
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
          if (xhttp.readyState == 4) {
            if (xhttp.status == 200) {
            messagewindow.setContent('Successfully saved');
            messagewindow.open(map);
            setTimeout(function(){messagewindow.close()}, 2500);
            
            userIsOnline = new Boolean(true);
       
            } else if (xhttp.status == 201) {
                messagewindow.setContent('Your point placed does not belong to Bishkek');
                messagewindow.open(map);
                setTimeout(function(){ window.location.reload(1);}, 2500);
            }
            if (xhttp.status == 202) {
                messagewindow.setContent('You cannot submit now, you are on cooldown, check your office');
                messagewindow.open(map);
                setTimeout(function(){ window.location.reload(1);}, 2500);
            }
          }

        };

       
       xhttp.open('GET', url, true);
        xhttp.send();
        
        infowindow.close();
        
       

              downloadUrl(url, function(data, responseCode) {
                if (responseCode == 200 && data.length <= 1) {
                  infowindow.close();
                }
              });

      }
       
       
       
//---------------------------------------------------------------------
       
             function initListeners(){
//                 google.maps.event.addListener(map, 'click', function(event) {
//
//                    placeMarker(event.latLng);
//
//                    google.maps.event.addListener(marker, 'click', function() {
//                       infowindow.open(map, marker);
//                   });
//               });
       
       
               var markers = markersInfo.map(function(location, i) {
                  var lab = location.level.toString();

                  var markerPointed = new google.maps.Marker({
                    position: ({lat: location.lat,lng: location.lng}),
                    map: map,
                    icon: './images/icons/bus.png'
                                                             
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
                       +
                     '<button onclick = deletePoint()> Delete your point </button>'
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
       
//               var markerCluster = new MarkerClusterer(map, markers, {
//           imagePath:
//             'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m',});
       
             }
       
//----------------------------------------------------------------------
       
       
       
//------------------------------------------------------------------------

       
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
       
      function requestPoints() {
//       alert('requestPoint');
      
      $.ajax({url: 'https://web-class.auca.kg/~kushtar/BBus/Markers.php?q=1',
                   dataType: 'json',
                   success: function(position, status){
                       updatePoints(position);
                   }});
      }

//-----------------------------------
      function updatePoints(position) {

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
            showMarkers();

//            createButton();
               
             // markers[positions[i].registration].setPosition(position);
      
          };
      
      
          if (positions.length > 1) {
              //map.fitZoom();
          } else {
              map.setCenter (lat, lng);
          }
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
//            var UserId = echo json_encode($userid);
//            
//            alert(UserId);

             var url = 'https://web-class.auca.kg/~kushtar/BBus/UpdatePoint.php?lat=' + lat + '&lng=' + lng;
                                             
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
