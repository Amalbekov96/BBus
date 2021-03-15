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
//
//print ("<html>
//
//  <head>
//  <title>Bishkek Transportation</title>
//  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
//  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
//  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
//  <link rel='manifest' href='/manifest.json'>
//
//  </head>
//
//<body>
//<div style = 'float:right;margin:12px' class='btn-group'>
//  <a href='index.php?logout=0' class='btn btn-success' role='button'> Logout</a>
//  <a href='AboutUs.php' class='btn btn-Warning' role='button'>How does it work?</a>
//</div>
//</body>
//</html>
//");
    
    
print('<!DOCTYPE html>
<html>
<head>
    <link rel="apple-touch-icon" href="../BBus/images/icons/App_Icon_192.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>B Mini-Bus</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link href="../BBus/manifest.json" rel="manifest">
      <script src="../BBus/sw.js"></script>
      <script src="../BBus/app.js"></script>
      <meta name = "theme-color" content="#FFE1C4">
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
      
  <button onclick="AddPoint()" type="button" class="btn btn-success btn-circle btn-xl" > Add Point </button>
  <button onclick="DelPoint()" type="button" class="btn btn-success btn-circle btn-xl"> Del Point </button>
      
  <a class="navbar-brand" href="#">BBus</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mx-auto">
      <li class="nav-item active">
        <a class="nav-link" href="./index2.php">Drivers</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="./pages/AboutUs.html">About</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="./pages/userPage.php">Passengers</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="./pages/adminPage.php">Admin page</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="./login.php">login</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="./login.php">logout</a>
      </li>
    </ul>
    <form class="form-inline">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-light my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
</body>
</html>');
    
      
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
       transition: margin-left .5s;
       padding: 16px;
        height: 86%;
       width: 100%;
       position:absolute;
      }
    
    
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
       
       .button {
         background-color: #4CAF50;
         border: none;
         color: white;
         padding: 20px;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         font-size: 16px;
         margin: 4px 2px;
       }

       .button {border-radius: 50%;}
    
    
    </style>
    </head>
    

    <div id='map' height='100%' width='100%' >
    </div>

    
    

    
    <script>
       
       
       var map;
       var markers = [];
       var statewindow = null;
       var infowindow = null;
       var messagewindow = null;
       var userIsOnline = new Boolean(null);
       
      
      //((42.58693188208796, 74.31966169698354), (43.14093974178246, 74.81404646260854))
      
       function initMap() {
      var zoom = 12;
            map = new google.maps.Map(document.getElementById('map'), {
            zoom: zoom,
            center: {lat: 42.8640117, lng: 74.5460088 },
            restriction: {
              latLngBounds: {
                north: 74.31966169698354,
                south: 42.58693188208796,//42.58693188208796
                east: 74.81404646260854,  //43.14093974178246
                west: 43.14093974178246,
              }
            },
            zoomControl: true,
//            minZoom: (zoom - 3),
//            maxZoom: (zoom + 3),
            zoomControlOptions: {
              position: google.maps.ControlPosition.RIGHT_CENTER,
            },
            mapTypeControl: false,
            scaleControl: true,
            scaleControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
            },
            streetViewControl: false,
            rotateControl: true,
            rotateControlOptions: {
              position: google.maps.ControlPosition.LEFT_CENTER,
            },
            fullscreenControl: false,
//            gestureHandling: 'cooperative',
         });
//       alert('tema');
            update();
        }

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
           
        statewindow = new google.maps.InfoWindow({
          content: document.getElementById('message')
        });
       }
       
//---------------------------------------------------------------------
       
      function createButton(){

          initWindows();
          
          var locationButton = document.createElement('button');
          locationButton.textContent = 'show mini-bus';
          locationButton.classList.add('custom-map-control-button');
       
           var DeleteButton = document.createElement('button');
           DeleteButton.textContent = 'take me off map';
           DeleteButton.classList.add('custom-map-control-button');
       
          map.controls[google.maps.ControlPosition.TOP_CENTER].push(
            locationButton
          );
       
           map.controls[google.maps.ControlPosition.TOP_CENTER].push(
                DeleteButton
           );
       
      locationButton.addEventListener('click', () => {
                                
             if (navigator.geolocation) {
               navigator.geolocation.getCurrentPosition(
                 (position) => {
                   const pos = {
                     lat: position.coords.latitude,
                     lng: position.coords.longitude,
                   };

                   messagewindow.setPosition(pos);
                   infowindow.setPosition(pos);
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
       });
       
       
       
       DeleteButton.addEventListener('click', () => {
                                     
                if (navigator.geolocation) {
                  navigator.geolocation.getCurrentPosition(
                    (position) => {
                      const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };

                  messagewindow.setPosition(pos);
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
                                     
                var url = 'https://web-class.auca.kg/~kushtar/BBus/DeletePoint.php?action=0';
                                     
                 var xhttp = new XMLHttpRequest();
                                     
                 xhttp.onreadystatechange = function() {
                   if (xhttp.readyState == 4) {
                     if (xhttp.status == 200) {
                                     
                     messagewindow.setContent('Successfully deleted');
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
                 
                                     
          });
      }
//--------------------------------------------------------------------------------------
      
function AddPoint(){
        
       if (navigator.geolocation) {
         navigator.geolocation.getCurrentPosition(
           (position) => {
             const pos = {
               lat: position.coords.latitude,
               lng: position.coords.longitude,
             };

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
}
       
//------------------------------------------------------------------------------------------
      
function DelPoint(){
      
      initWindows();
      
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          (position) => {
            const pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude,
          };

        messagewindow.setPosition(pos);
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
                           
      var url = 'https://web-class.auca.kg/~kushtar/BBus/DeletePoint.php?action=0';
                           
       var xhttp = new XMLHttpRequest();
                           
       xhttp.onreadystatechange = function() {
         if (xhttp.readyState == 4) {
           if (xhttp.status == 200) {
                           
           messagewindow.setContent('Successfully deleted');
           messagewindow.open(map);
           setTimeout(function(){messagewindow.close()}, 4000);
           
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
       
                 
               markers.map(function(location, i) {
                           
                  var lab = location.level.toString();

                  var markerPointed = new google.maps.Marker({
                    position: ({lat: location.lat,lng: location.lng}),
                    map: map,
                    icon: './images/icons/bus.png'
                                                             
                 });

                                        alert('in map');

                 markerPointed.addListener('click', function(){

                    if (statewindow) {
                       statewindow.close();
                     }

                     if (location.name == '$sesusername') {
                         statewindow= new google.maps.InfoWindow({
                      content:
                     '<br>Transport type: ' + location.trans_type +
                     '<br>Number :' + location.region + '</h3>' +
                     '<br>Direction :' +
                     '<br>Level of Pollution: ' + location.level.toString()  +
                     '<button onclick = deletePoint()> Delete your point </button>'
                       });
                     } else {

                     statewindow= new google.maps.InfoWindow({
                      content:
                      '<br>Transport type: ' + location.trans_type +
                      '<br>Number :' + location.trans_num + '</h3>' +
                      '<br>Direction :' +
                      '<br>Level of Pollution: ' + location.level.toString()  +
                       + '<button onclick = reportPoint()> Report fake bus </button>'
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
                   cache: false,
                   success: function(position, status){
                       updatePoints(position);
                   }});
      }

//-----------------------------------
      function updatePoints(position) {

          var lat;
          var lng;
          
       // initListeners();
          
        DeleteAllMarkers();
       
          for (var i=0; i < position.length; i++) {
              lat = position[i].lat;
              lng = position[i].lng;
               
              latlng = new google.maps.LatLng(lat, lng);
                
             const marker = new google.maps.Marker({
                 position: latlng,
                 icon: './images/icons/bus.png',
                 label: { color: '#00aaff', fontWeight: 'bold', fontSize: '14px', text: position[i].trans_num.toString() },
                 map: map
                
             });
//            createButton();
       
            markers.push(marker);
               
             // markers[positions[i].registration].setPosition(position);
      
          };
            showMarkers();
          
          if (position.length > 1) {
              //map.fitZoom();
          } else {
              map.setCenter (lat, lng);
          }
      }

       
//----------------------------------------------------------------
       
       function update(){
              
              options = {
                enableHighAccuracy: true,
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
       
//     <script src='https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js'>
//    </script>

    <script async defer
    src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBlLms-yD7lNgRk3z4LIpv79WvNTP2aY1I&callback=initMap'>
    </script>
    
</body>
</html>";
  echo $html;

?>
