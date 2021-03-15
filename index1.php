
<?php
//header('Content-Type: text/html; charset=utf-8');

//session_start();

require_once ("config.php");
//header("Content-Type: text/html; Charset=UTF-8");

$logout;
//
//if(isset($_GET['logout']) == 1) {
//  unset($_SESSION['username']);
//  unset($_SESSION['id']);
//  session_destroy();
//}

$conn;
//
//$userid = isset($_SESSION['id']);
//
//$sesusername;
//
//if(isset($_SESSION['username'])){
//    $sesusername = $_SESSION['username'];
//}
//
//$_GET['mypoints'] = 'STAR';
//
//if (!$conn) {
//  die("Connection failed: " . mysqli_connect_error());
//}

//$result = mysqli_query($conn,"SELECT * FROM Markers");
//
//
// $json = [];
//                            
// while($row = mysqli_fetch_assoc($result)){
//   $json[] = $row;
// }
//                            
// $json_encoded = json_encode($json,JSON_NUMERIC_CHECK );


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
      var marker;
      var infowindow;
      var messagewindow;
      var statewindow = null;
      var isOnline = false;
      var labels = '12345';
       var trans_num = 000;
       var MarkerArray = [];
       
       
      function initMap() {

        map = new google.maps.Map(document.getElementById('map'), {
           zoom: 11,
            center: {lat: 42.8640117, lng: 74.5460088 }
         });
       
    
//       setInterval(function (){initListeners();}, 5000);
        initListeners();
//        initWindows();
//        createButton();
//        update();
            getMarkers();
      }
       
      

      //----------------------------------------
    
       

//      function initWindows(){
//        var formStr = `" . FORM_FOR_INPUT . "`;
//        var messageStr = `" . MESSAGE_LOCATION_SAVED . "`
//        infowindow = new google.maps.InfoWindow({
//            content: formStr
//        });
//        messagewindow = new google.maps.InfoWindow({
//          content: document.getElementById('message')
//        });
//      }
       
       //------------------------------------------------------------------------------------------
       
//       function error(err) {
//         console.warn('ERROR(' + err.code + '): ' + err.message);
//       }
//
       //--------------------------------------------------------------

//       function createButton(){
//
//           const locationButton = document.createElement('button');
//           locationButton.textContent = 'show mini-bus';
//           locationButton.classList.add('custom-map-control-button');
//           map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(
//             locationButton
//           );
//
//
//
//       locationButton.addEventListener('click', () => {
//
//          if (navigator.geolocation) {
//                navigator.geolocation.getCurrentPosition(
//              (position) => {
//                const pos = {
//                  lat: position.coords.latitude,
//                  lng: position.coords.longitude,
//                };
//
//                MarkerArray.push([position.coords.latitude, position.coords.longitude]);
//                isOnline = true;
////                  new google.maps.Marker({
////                   position: pos,
////                   map,
////                 });
//
//                messagewindow.setPosition(pos);
//
//                infowindow.setPosition(pos);
//                infowindow.open(map);
//                map.setCenter(pos);
//              },
//              () => {
//                handleLocationError(true, infowindow, map.getCenter());
//              }
//            );
//          } else {
//            // Browser doesn't support Geolocation
//            handleLocationError(false, infowindow, map.getCenter());
//          }
//
//        });
//
//
////
//       }
       
    
    //------------------------------------------------------------------------------------------
    
//    function handleLocationError(browserHasGeolocation, infowindow, pos) {
//        infowindow.setPosition(pos);
//        infowindow.setContent(
//          browserHasGeolocation
//            ? 'Error: The Geolocation service failed.'
//            : 'Error: Your browser doesnt support geolocation.'
//        );
//        infowindow.open(map);
//      }
//
      //------------------------------------------------------------------------------------------
       var markersInfo = $json_encoded;
       
       function isLocationFree(search) {
         for (var i = 0, l = lookup.length; i < l; i++) {
           if (lookup[i][0] === search[0] && lookup[i][1] === search[1]) {
             return false;
           }
         }
         return true;
       }

       //-------------------------------------------------------------------------------------------------
      function initListeners(){

        var markers = markersInfo.map(function(location, i) {

//        var tempPoint = [location.lat, location.lng];
//
//        if(isLocationFree(tempPoint)){
//
           var markerPointed = new google.maps.Marker({
             position: ({lat: location.lat,lng: location.lng}),
             icon: './images/icons/bus.png'
              });

              markerPointed.addListener('click', function(){
                 if(statewindow) {
                  statewindow.close();
                 }

                  statewindow = new google.maps.InfoWindow({
                   content:
                   '<h3> Transport type: ' + location.trans_type +
                   '<br> Transport number: ' + location.trans_num +
                   '<br> How full is it: ' + location.level.toString()
                   + '</h3>'
                  })

                  statewindow.open(map,markerPointed);

              });

              return markerPointed;
            });
//           } else {
//                return;
//           }
          // Add a marker clusterer to manage the markers.
      }
       
//--------------------------------------------------------------------
       
//       function update(){
//
//              options = {
//                enableHighAccuracy: false,
//                timeout: 5000,
//                maximumAge: 0
//              };
//
//              const pos = new Object();
//
//              var lat = 9;
//              var lng = 9;
//
//              navigator.geolocation.watchPosition(
//                ShowPosition
//                ,
//                () => {
//                   error();
//                },
//                () => {
//                      options();
//                }
//              );
//       }
       
//--------------------------------------------------------------------
       
//var i = 0;
//    function ShowPosition(position)
//       {
//
//
//
//                  lat = position.coords.latitude;
//                  lng = position.coords.longitude;
//       //           alert(lat);
//
//
//                new_marker = new google.maps.Marker({
//                   position: ({lat: lat,lng: lng}),
//                   icon: './images/icons/bus.png'
//                });
//
//                 MarkerArray.push([lat, lng]);
//
//                  var url = 'https://web-class.auca.kg/~kushtar/BBus/UpdatePoint.php?comment=' + trans_num + '&lat=' + lat + '&lng=' + lng;
//
//
//                  var xhttp = new XMLHttpRequest();
//
//                  xhttp.onreadystatechange = function() {
//
//
//                    if (xhttp.readyState == 4) {
//                      if (xhttp.status == 205) {
//
//                      } else if (xhttp.status == 200) {
//
//                      } else {
//
//                      }
//
//                      if (xhttp.status == 202) {
//
//                      }
//                    }
//
//                  };
//
//                  xhttp.open('GET', url, true);
//                  xhttp.send();
//
//
//       }
//--------------------------------------------------------------------
       
       function getMarkers(){
       
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText);
                    alert('my name is Joe');
                        
              }
            };
            xhttp.open('GET', 'https://web-class.auca.kg/~kushtar/BBus/Markers.php', TRUE);
            xhttp.send();
       
       
//            $.ajax({ //Process the form using $.ajax()
//                type      : 'POST', //Method type
//                url       : 'process.php', //Your form processing file URL
//                data      : postForm, //Forms name
//                dataType  : 'json',
//                success   : function(data) {
//                                if (!data.success) { //If fails
//                                    if (data.errors.name) { //Returned if any error from process.php
//                                        $('.throw_error').fadeIn(1000).html(data.errors.name); //Throw relevant error
//                                    }
//                                }
//                                else {
//                                        $('#success').fadeIn(1000).append('<p>' + data.posted + '</p>'); //If successful, than throw a success message
//                                    }
//                                }
//            });
//
       }
       

//--------------------------------------------------------------
   function error(err) {
     console.warn('ERROR(' + err.code + '): ' + err.message);
   }

//--------------------------------------------------------------------
       
      var markersInfo = $json_encoded;
       
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
