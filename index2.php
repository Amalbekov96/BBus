<?php
header('Content-Type: text/html; charset=utf-8');
    
session_start();

require_once ("config.php");
header("Content-Type: text/html; Charset=UTF-8");
    
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

//print ("<html>
//
//  <head>
//  </head>
//
//<body>
//<div style = 'float:right;margin:12px' class='btn-group'>
//  <a href='index.php?logout=0' class='btn btn-success' role='button'> Logout</a>
//  <a href='/pages/AboutUs.php' class='btn btn-Warning' role='button'>How does it work?</a>
//</div>
//</body>
//</html>
//");

  print("<!DOCTYPE html>
    <head>

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
      var labels = '12345';

      function initMap() {

        map = new google.maps.Map(document.getElementById('map'), {
           zoom: 10,
            center: {lat: 42.8640117, lng: 74.5460088 }
         });
       
       
        initListeners();
        initWindows();
        createButton();
        saveData()
        
      }

      //----------------------------------------

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

//       //------------------------------------------------------------------------------------------
//
//       function error(err) {
//         console.warn('ERROR(' + err.code + '): ' + err.message);
//       }
//
//       //--------------------------------------------------------------
//
//       function createButton(){
//
//           const locationButton = document.createElement('button');
//           locationButton.textContent = 'show mini-bus';
//           locationButton.classList.add('custom-map-control-button');
//           map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(
//             locationButton
//           );
//
//       locationButton.addEventListener('click', () => {
//          if (navigator.geolocation) {
//                navigator.geolocation.getCurrentPosition(
//              (position) => {
//                const pos = {
//                  lat: position.coords.latitude,
//                  lng: position.coords.longitude,
//                };
//
//                  new google.maps.Marker({
//                   position: pos,
//                   map,
//                 });
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
//           handleLocationError(false, infowindow, map.getCenter());
//          }
//        });
//
//       }
//
//
//    //------------------------------------------------------------------------------------------
//
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
//
//    //---------------------------------------------------------------------------------------------
//
//       function saveData() {
//             var trans_num = document.getElementById('comment').value;
//             var latlng = infowindow.getPosition();
//             var levels = document.getElementsByName('lev');
//             var trans_type = document.getElementById('trans');
//             var level = 3;
//
//            var trans = trans_type.options[trans_type.selectedIndex].text;
//
//               for (var i = 0, length = levels.length; i < length; i++)
//             {
//                if (levels[i].checked)
//                {
//                 level = levels[i].value;
//                 break;
//                }
//             }
//
//           var url = 'http://localhost/BBus/PointPlace.php?comment=' + trans_num + '&level=' + level +'&lat=' + latlng.lat()
// + '&lng=' + latlng.lng() + '&trans=' + trans;
//
//           messagewindow.open(map, marker);
//
//           marker = new google.maps.Marker({
//             position: event.latLng,
//             map: map
//           });
//
//
//         var xhttp = new XMLHttpRequest();
//
//         xhttp.onreadystatechange = function() {
//           if (xhttp.readyState == 4) {
//             if (xhttp.status == 200) {
//             messagewindow.setContent('Successfully saved');
//             messagewindow.open(map);
//             setTimeout(function(){window.location.reload(1);}, 2500);
//             } else if (xhttp.status == 201) {
//                 messagewindow.setContent('Your point placed does not belong to Bishkek');
//                 messagewindow.open(map);
//                 setTimeout(function(){ window.location.reload(1);}, 2500);
//             } else {
//                 messagewindow.setContent('was saved');
//                 messagewindow.open(map);
//                 setTimeout(function(){ window.location.reload(1);}, 2500);
//             }
//
//             if (xhttp.status == 202) {
//                 messagewindow.setContent('You cannot submit now, you are on cooldown, check your office');
//                 messagewindow.open(map);
//                 setTimeout(function(){ window.location.reload(1);}, 2500);
//             }
//           }
//
//         };
//
//          xhttp.open('GET', url, true);
//           xhttp.send();
//
//         infowindow.close();
//
//         downloadUrl(url, function(data, responseCode) {
//           if (responseCode == 200 && data.length <= 1) {
//             infowindow.close();
//           }
//         });
//
//}
//
////------------------------------------------------------------------------------------------

      function initListeners(){

        var markers = markersInfo.map(function(location, i) {
           var lab = location.level.toString();

           var markerPointed = new google.maps.Marker({
             position: ({lat: location.lat,lng: location.lng}),
             icon: 'images/icons/bus.png'
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


          // Add a marker clusterer to manage the markers.

         var markerCluster = new MarkerClusterer(map, markers,
             {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});

      }

//--------------------------------------------------------------------

// function update(){

//   var url;
//   var trans_num = document.getElementById('comment').value;



//     navigator.geolocation.watchPosition(
//       (position) => {
//         const pos = {
//           lat: position.coords.latitude,
//           lng: position.coords.longitude,
//         };

//       url = 'http://localhost/BBus/UpdatePoint.php?comment=' + trans_num + '&lat=' + pos.lat()
//  + '&lng=' + pos.lng();

//       },
//       () => {
//         onError();
//       },
//       timeout: {30000}
//     );



//    var xhttp = new XMLHttpRequest();
 
//    xhttp.onreadystatechange = function() {
//      if (xhttp.readyState == 4) {
//        if (xhttp.status == 200) {
//        messagewindow.setContent('Successfully saved');
//        messagewindow.open(map);
//        } else if (xhttp.status == 201) {
//            messagewindow.setContent('Your point placed does not belong to Bishkek');
//            messagewindow.open(map);
//        } else {
//            messagewindow.setContent('was saved');
//            messagewindow.open(map);
//        }

//        if (xhttp.status == 202) {
//            messagewindow.setContent('You cannot submit now, you are on cooldown, check your office');
//            messagewindow.open(map);
//        }
//      }
 
//    };
 
 
 
//     xhttp.open('GET', url, true);
//      xhttp.send();
 
//    infowindow.close();
 
//    downloadUrl(url, function(data, responseCode) {
//      if (responseCode == 200 && data.length <= 1) {
//        infowindow.close();
//      }
//    });


// }


//--------------------------------------------------------------------
       
//        var markersInfo = $json_encoded;
//
//      function downloadUrl(url, callback) {
//        var request = window.ActiveXObject ?
//            new ActiveXObject('Microsoft.XMLHTTP') :
//            new XMLHttpRequest;
//
//        request.onreadystatechange = function() {
//          if (request.readyState == 4) {
//            request.onreadystatechange = doNothing;
//            callback(request.responseText, request.status);
//          }
//        };
//      }

//-------------------------------------------------------------------------------------------


    // function onError(error) {
    //     alert('code: '    + error.code    + '\n' +
    //           'message: ' + error.message + '\n');
    // }
       
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
</html> ");
    
        
        
        
        
//}
//else {

//  print ("<html>

//   <head>
//   <title>Bishkek Transportation</title>
//   <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
//   <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
//   <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

//   </head>

// <body>
// <div style = 'float:right;margin:12px' class='btn-group'>
//   <a href='login.php' class='btn btn-success' role='button'> Login</a>
//    &nbsp;
//   <a href='regist.php' class='btn btn-success' role='button'> Register </a>
//   &nbsp;
//   <a href='AboutUs.php' class='btn btn-warning' role='button'>How does it work?</a>
// </div>
// </body>
// </html>
// ");

//   $html = "<!DOCTYPE html>
//     <head>
//     <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
//     <meta name='viewport' content='initial-scale=1.0, user-scalable=no' />
//     <meta http-equiv='content-type' content='text/html; charset=utf-8'/>
//       <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
//   <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

//     <title>From Info Windows to a Database: Saving User-Added Form Data</title>
//     <style>
//       #map {
//         height: 90%;
//        width: 89%;
//        position: relative;
//        left: 5%;
//       }
//       html, body {
//         height: 100%;
//         margin: 0;
//         padding: 0;
//       }
//     </style>
//     </head>
//     <body style='background-color:#ff5050;'>
//     <div id='map' height='100%' width='100%' ></div>


//     <script>
//       var map;
//       var marker;
//       var infowindow;
//       var messagewindow;
//       var statewindow = null;
//       var labels = '12345';

//       function initMap() {

//         map = new google.maps.Map(document.getElementById('map'), {
//            zoom: 10,
//             center: {lat: 42.8640117, lng: 74.5460088 }
//          });
       
       
//         initListeners();
//         initWindows();
        
//       }

//       //----------------------------------------

//       function initWindows(){
//         var formStr = `" . FORM_FOR_INPUT . "`;
//         var messageStr = `" . MESSAGE_LOCATION_SAVED . "`
//         infowindow = new google.maps.InfoWindow({
//             content: formStr
//         });
//         messagewindow = new google.maps.InfoWindow({
//           content: document.getElementById('message')
//         });
//       }


       
//        //------------------------------------------------------------------------------------------

//        function createButton(){
       
//            const locationButton = document.createElement('button');
//            locationButton.textContent = 'show mini-bus';
//            locationButton.classList.add('custom-map-control-button');
//            map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(
//              locationButton
//            );
       
//        locationButton.addEventListener('click', () => {
//           if (navigator.geolocation) {
//             navigator.geolocation.getCurrentPosition(
//               (position) => {
//                 const pos = {
//                   lat: position.coords.latitude,
//                   lng: position.coords.longitude,
//                 };

//                   new google.maps.Marker({
//                    position: pos,
//                    map,
//                    title: 'Hello World!',
//                  });

//                 messagewindow.setPosition(pos);
                                                     
//                 infowindow.setPosition(pos);
//                 infowindow.open(map);
//                 map.setCenter(pos);
//               },
//               () => {
//                 handleLocationError(true, infowindow, map.getCenter());
//               }
//             );
//           } else {
//             // Browser doesn't support Geolocation
//             handleLocationError(false, infowindow, map.getCenter());
//           }
//         });
// //
//        }
       
    
//     //------------------------------------------------------------------------------------------
    
//     function handleLocationError(browserHasGeolocation, infowindow, pos) {
//         infowindow.setPosition(pos);
//         infowindow.setContent(
//           browserHasGeolocation
//             ? 'Error: The Geolocation service failed.'
//             : 'Error: Your browser doesnt support geolocation.'
//         );
//         infowindow.open(map);
//       }


//     //-------------------------------------------------------------------------------------------


//     function onError(error) {
//         alert('code: '    + error.code    + '\n' +
//               'message: ' + error.message + '\n');
//     }
             
       
//     //---------------------------------------------------------------------------------------------
       
//        function saveData() {
//              var trans_num = document.getElementById('comment').value;
//              var latlng = infowindow.getPosition();
//              var levels = document.getElementsByName('lev');
//              var trans_type = document.getElementById('trans');
//              var level = 3;
       
//             var trans = trans_type.options[trans_type.selectedIndex].text;
       
//                for (var i = 0, length = levels.length; i < length; i++)
//              {
//                 if (levels[i].checked)
//                 {
//                  level = levels[i].value;
//                  break;
//                 }
//              }
       
//            var url = 'http://localhost/trial/PointPlace.php?comment=' + trans_num + '&level=' + level +'&lat=' + latlng.lat() + '&lng=' + latlng.lng() + '&trans=' + trans;

//            messagewindow.open(map, marker);
       
//            marker = new google.maps.Marker({
//              position: event.latLng,
//              map: map
//            });
       
       
//          var xhttp = new XMLHttpRequest();
       
//          xhttp.onreadystatechange = function() {
//            if (xhttp.readyState == 4) {
//              if (xhttp.status == 205) {
//              messagewindow.setContent('Successfully saved');
//              messagewindow.open(map);
//              setTimeout(function(){window.location.reload(1);}, 2500);
//              } else if (xhttp.status == 201) {
//                  messagewindow.setContent('Your point placed does not belong to Bishkek');
//                  messagewindow.open(map);
//                  setTimeout(function(){ window.location.reload(1);}, 2500);
//              }
//              if (xhttp.status == 202) {
//                  messagewindow.setContent('You cannot submit now, you are on cooldown, check your office');
//                  messagewindow.open(map);
//                  setTimeout(function(){ window.location.reload(1);}, 2500);
//              }
//            }
       
//          };
       
       
       
//         xhttp.open('GET', url, true);
//          xhttp.send();
       
//          infowindow.close();
       
//                downloadUrl(url, function(data, responseCode) {
//                  if (responseCode == 200 && data.length <= 1) {
//                            document.write('man');
//                    infowindow.close();
//                  }
//                });
       
//        }


//       //------------------------------------------------------------------------------------------

       
       
       
//       function initListeners(){
       
      
//         var markers = markersInfo.map(function(location, i) {
//            var lab = location.level.toString();

//            var markerPointed = new google.maps.Marker({
//              position: ({lat: location.lat,lng: location.lng}),
//              icon: 'images/icons/bus.png'
//           });

//           markerPointed.addListener('click', function(){
//              if(statewindow) {
//               statewindow.close();
//              }

//               statewindow = new google.maps.InfoWindow({
//                content:
//                '<h3> Transport type: ' + location.trans_type +
//                '<br> Transport number: ' + location.trans_num +
//                '<br> How full is it: ' + location.level.toString() 
//                + '</h3>'
//               })

//               statewindow.open(map,markerPointed);

//           });
//           return markerPointed;
//         });







//           // Add a marker clusterer to manage the markers.

//          var markerCluster = new MarkerClusterer(map, markers,
//              {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});

//       }



// //--------------------------------------------------------------------
       
//         var markersInfo = $json_encoded;
       
//       function downloadUrl(url, callback) {
//         var request = window.ActiveXObject ?
//             new ActiveXObject('Microsoft.XMLHTTP') :
//             new XMLHttpRequest;
       
//         request.onreadystatechange = function() {
//           if (request.readyState == 4) {
//             request.onreadystatechange = doNothing;
//             callback(request.responseText, request.status);
//           }
//         };
//       }
       
//        //----------------------------------------------------------------------
       
//       function doNothing () {
       
//       }
       
//     </script>
//      <script src='https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js'>
//     </script>

//     <script async defer
//     src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBlLms-yD7lNgRk3z4LIpv79WvNTP2aY1I&callback=initMap'>
//     </script>
// </body>
// </html>";
//}

?>
