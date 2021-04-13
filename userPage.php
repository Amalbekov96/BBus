<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
    
require_once ('./config.php');
    
    
if (!isset($_SESSION['id'])) {
    htmlGetBack("You have not loged in", "login.php", "Go Back");
    logAction($conn, "empty", "empty");
    exit;
}

$conn;

$userid = $_SESSION['id'];
$phone_number;

    
if(isset($_SESSION['phone_number'])){
    $phone_number = $_SESSION['phone_number'];
    $loged = array("is_loged"=>1);
    $loged_encoded = json_encode($loged);
}
    
    
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
 $result = mysqli_query($conn,"SELECT * FROM Users WHERE phone_number = '$phone_number'");
    
    $json = [];
    while($row = mysqli_fetch_assoc($result)){
      $json[] = $row;
    }

    $row_encoded = json_encode($json);
    
    
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
      
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

       <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

  
</head>
<body>
      
      

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
      
  <a class="navbar-brand" href="#">Bishkek Online Transport</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mx-auto">
      
      <li class="nav-item">
             <a class="nav-link" href="./userRegist.php">Register as Passenger</a>
      </li>
      
      <li class="nav-item ">
        <a class="nav-link" href="./driverRegist.php">Register as Driver</a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="./pages/AboutUs.html">About</a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="./adminLogin.php">Admin page</a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="./login.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./login.php?logout=1">Logout</a>
      </li>
    </ul>
  </div>
</nav>

   
      <div class="container bg-dark text-white fixed-bottom">
          
        <div class="row bg-white">
            <div class="input-group">
                 <input type="search" id="search_num" placeholder="Search" maxlength="3"  class="form-control">
                 <span class="input-group-btn">
                   <button class="btn btn-default w-100" id="search_btn" onclick="searchFunc()" name="search_btn" type="button" >
                       <i class="fa fa-search"></i>
                   </button>
                 </span>
            </div>
        </div>
        
        <div class="row">
            <div class="btn-group-lg d-flex w-100" role="group" aria-label="group">
                     <button type="button" id="addButton" class="btn btn-dark text-white w-100"><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Add Point</button>
                     <button type="button" id="delButton" class="btn btn-dark text-white w-100"><i class="fas fa-trash-alt" aria-hidden="true"></i> Delete Point</button>
            </div>
         </div>
      </div>

</body>
</html>');
      
// <button class="btn btn-default" type="button" onclick="inputClear()">X</button>
      
  $html = "<!DOCTYPE html>
    <head>
    <meta name='viewport' content='initial-scale=1.0, user-scalable=no' />
    <meta http-equiv='content-type' content='text/html; charset=utf-8'/>
        
    
    <style>
    
      #map {
       transition: margin-left .5s;
       padding: 1px;
        height: 89%;
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
    

    <div id='map' height='90%' width='100%' >
    </div>


      

      <script src='https://maps.googleapis.com/maps/api/js?libraries=geometry&key=AIzaSyBlLms-yD7lNgRk3z4LIpv79WvNTP2aY1I&callback=initMap' async defer >
      </script>
      
    
    <script>
       
       
    var map;
    var markers = [];
    var userID = null;
    var statewindow = null;
    var infowindow = null;
    var messagewindow = null;
    var userIsOnline = new Boolean(null);
    var loged = 0;
    var update_id;
    var user_info = $row_encoded;
      var search_num = '';
    
      
function initMap() {
    statewindow = new google.maps.InfoWindow({
          content:'',
        });
    var zoom = 12;
    map = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: {lat: 42.8640117, lng: 74.5460088 },
//    restriction: {
//        latLngBounds: {
//        north: 74.31966169698354,
//        south: 42.58693188208796,//42.58693188208796
//        east: 74.81404646260854,  //43.14093974178246
//        west: 43.14093974178246,
//        }
//    },
    zoomControl: false,
    //            minZoom: (zoom - 3),
    //            maxZoom: (zoom + 3),
//    zoomControlOptions: {
//      position: google.maps.ControlPosition.RIGHT_CENTER
//    },
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
    clickableIcons: false
    //            gestureHandling: 'cooperative',
    });
    
    document.getElementById('delButton').addEventListener('click', DelPoint);
    document.getElementById('addButton').addEventListener('click', AddPoint);
      
    setInputFilter(document.getElementById('search_num'), function(value) {
    return /^-?\d*$/.test(value); });
    searchFunc();
    update();

}

//--------------------------------------------------------------------
      function searchFunc(){
      search_num = document.getElementById('search_num').value;
      getLines();
      }
//--------------------------------------------------------------------

      function setInputFilter(textbox, inputFilter) {
        ['input', 'keydown', 'keyup', 'mousedown', 'mouseup', 'select', 'contextmenu', 'drop'].forEach(function(event) {
          textbox.addEventListener(event, function() {
            if (inputFilter(this.value)) {
              this.oldValue = this.value;
              this.oldSelectionStart = this.selectionStart;
              this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty('oldValue')) {
              this.value = this.oldValue;
              this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
              this.value = '';
            }
          });
        });
      }
      
//--------------------------------------------------------------------
       
function initWindows(){
      
     var Pass_formStr = `" . PASSENGER_INPUT . "`;
     var Driv_formStr = `" . DRIVER_INPUT . "`;
     var messageStr = `" . MESSAGE_LOCATION_SAVED . "`;
      

      
      if( user_info[0].user_type == 'Driver'){
          infowindow = new google.maps.InfoWindow({
              content: Driv_formStr
          });
      
      } else {
          infowindow = new google.maps.InfoWindow({
              content: Pass_formStr
          });
      }

     messagewindow = new google.maps.InfoWindow({
       content: document.getElementById('message')
     });
}


//--------------------------------------------------------------------------------------
      
function AddPoint(){
      
   navigator.geolocation.clearWatch(update_id);
      
   initWindows()
    
  options = {
    enableHighAccuracy: false,
    timeout: 5000,
    maximumAge: 20000
  };
      
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
       },
       () => {
          options();
       }
     );
      
   } else {
     // Browser doesn't support Geolocation
     handleLocationError(false, infowindow, map.getCenter());
   }
      
      update();
}
       
//------------------------------------------------------------------------------------------
      
function DelPoint(){
      navigator.geolocation.clearWatch(update_id);
      
    if (confirm('Are you sure you want to delete your point?')) {
        initWindows();
          const options = {
            enableHighAccuracy: false,
            timeout: 5000,
            maximumAge: 20000
          };
              
          
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
              },
            () => {
               options();
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
               setTimeout(function(){messagewindow.close()}, 2000);
               
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
          
        update();
      
    } else {
        infowindow.close();
        update();
    }
}
      
      
      
       
//---------------------------------------------------------------------------------------------
       
 function saveData() {
      
      var user_info = $row_encoded;
      var latlng;
      var trans_type;
      var direct;
      var directions;
      var line_number;
      var level;
    
      
      if(user_info[0].user_type == 'Driver'){

            line_number = user_info[0].line_number;
            latlng = infowindow.getPosition();
            trans_type = user_info[0].trans_type;
            direct;
            directions = document.getElementsByName('Drivedir');
            
            for (var i = 0, length = directions.length; i < length; i++)
            {
                if (directions[i].checked)
                {
                 direct = directions[i].value;
                 break;
                }
            }
      
      } else {
            
            line_number = document.getElementById('trans_num').value;
            latlng = infowindow.getPosition();
            var levels = document.getElementsByName('lev');
            directions = document.getElementsByName('Passdir');
            var transports = document.getElementById('trans_type');
            trans_type = transports.options[transports.selectedIndex].text;

            for (var i = 0, length = levels.length; i < length; i++)
            {
                 if (levels[i].checked)
                 {
                  level = levels[i].value;
                  break;
                 }
            }

            for (var i = 0, length = directions.length; i < length; i++)
            {
                if (directions[i].checked)
                {
                    direct = directions[i].value;
                    break;
                }
            }
      
      }
              
    
      var formData = {
         line_number: line_number
         ,lat: latlng.lat()
         ,lng: latlng.lng()
         ,trans_type: trans_type
         ,direct: direct
         ,point_type: user_info[0].user_type
         ,lev: level
      };
      
      
      $.ajax({
              type: 'POST',
              url: 'https://web-class.auca.kg/~kushtar/BBus/PointPlace.php',
              data: formData,
              dataType: 'text',
              cache: false,
              success: function (result, status) {
                 if(result == 200){
                     messagewindow.setContent('Successfully saved');
                    messagewindow.open(map);
                    setTimeout(function(){messagewindow.close()}, 2000);
                 } else if(result == 201){
                     messagewindow.setContent('Your point placed does not belong to Bishkek');
                     messagewindow.open(map);
                     setTimeoutll(function(){messagewindow.close()}, 2000);
                 } else if(result == 202){
                    messagewindow.setContent('You cannot submit now, you are on cooldown, check your office');
                    messagewindow.open(map);
                    setTimeout(function(){messagewindow.close()}, 2000);
                 } else if(result == 203){
                    messagewindow.setContent('There were some kind of error!');
                    messagewindow.open(map);
                    setTimeout(function(){messagewindow.close()}, 2000);
                 }
               }
                 
          });
           

        infowindow.close();
        
      }
     
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
          markerTimeCheck();

          if(user_info[0].user_type == 'Driver'){
                    
                var line_num = user_info[0].line_number;
                
                
                $.ajax({url: 'https://web-class.auca.kg/~kushtar/BBus/Markers.php?line_number='+ line_num,
                dataType: 'json',
                success: function(position, status){
                  updatePoints(position);
                }});
          
          } else {
          
              if(search_num == ''){
                
                    $.ajax({url: 'https://web-class.auca.kg/~kushtar/BBus/Markers.php?type=1',
                       dataType: 'json',
                       success: function(position, status){
                         updatePoints(position);
                       }});
                      
              } else {
                    //to get the Points from db
                    $.ajax({url: 'https://web-class.auca.kg/~kushtar/BBus/Markers.php?search_num='+ search_num,
                      dataType: 'json',
                      success: function(position, status){
                        updatePoints(position);
                      }});
              }
        }
    }

//-------------------------------------------------------------
      /// to get the lines from the db
      function getLines(){
            
            $.ajax({url: 'https://web-class.auca.kg/~kushtar/BBus/Markers.php?line='+ search_num,
            dataType: 'json',
            success: function(position, status){
              showLines(position);
            }});
      }
      
//-------------------------------------------------------------
      var flightPath;
      function showLines(position){
          
          if(position.length != 0){
                var lines = position[0].coordinates.split(',');
                
                var lineCor = [];
                for (var i = 0; i < (lines.length - 1); i += 2){
                      lineCor.push(new google.maps.LatLng(parseFloat(lines[i]), parseFloat(lines[i + 1])));
                      
                }
                
              
      
                if(lineCor.length != 0){
                      flightPath = new google.maps.Polyline({
                      path: lineCor,
                      geodesic: true,
                      strokeColor: '#FF0000',
                      strokeOpacity: 1.0,
                      strokeWeight: 2,
                    });
      
                    flightPath.setMap(map);
                }
          } else {
              if(flightPath != null){
                flightPath.setMap(null);
              }
              
          }
      }
      

//-------------------------------------------------------------
      
      var curUserLat;
      var curUserLng;
      
      
      function updatePoints(position) {
          var lat;
          var lng;
      
        DeleteAllMarkers();
        
       
          for (var i=0; i < position.length; i++) {
              lat = position[i].lat;
              lng = position[i].lng;
            
      
              latlng = new google.maps.LatLng(lat, lng);
      
              var icon_path;
              if(position[i].trans_type == 'Troleibus') {
              
                  icon_path = './images/icons/marker_icons/Troleybus_';
                  if(position[i].level == 0){
                    icon_path += '1';
                  } else if(position[i].level == 1){
                    icon_path += '2';
                  } else {
                    icon_path += '3';
                  }
              } else if(position[i].trans_type == 'Mini-bus') {
                  icon_path = './images/icons/marker_icons/Mini-bus_';
                  if(position[i].level == 0){
                    icon_path += '1';
                  } else if(position[i].level == 1){
                    icon_path += '2';
                  } else {
                    icon_path += '3';
                  }
              
              } else {
                 icon_path = './images/icons/marker_icons/Bus_';
                 if(position[i].level == 0){
                   icon_path += '1';
                 } else if(position[i].level == 1){
                   icon_path += '2';
                 } else {
                   icon_path += '3';
                 }
              
              }
      
            ;
    
           var time = Math.abs(new Date() - new Date(position[i].add_time))/60000;
          time = parseInt(time);
          var color;
          if(time < 1){
            time = 'online';
            color = '#66ff66';
          } else if(time >= 1 && time <= 7){
            time += ' min';
            color = '#ff9933';
          } else {
            time += ' min';
            color = '#ff0000';
          }
      
           var icon = {
                url: icon_path,
                scaledSize: new google.maps.Size(50, 50),
                labelOrigin: new google.maps.Point(25, 10),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(11, 40)
            };
            
           var label = {
              color: color,
              fontWeight: 'bold',
              fontSize: '12px',
              text: time
            }
      
             var marker = new google.maps.Marker({
                 position: latlng,
                 icon: icon,
                 label: label,
                 title: icon_path
             });

            markers.push(marker);
           };
      
            
          markers = markers.map(function(location, i) {
                                
            location.addListener('click', function(){
              
               navigator.geolocation.clearWatch(update_id);
               
                                 
               if (statewindow) {
                  statewindow.close();
                 }
                                 
                if (position[i].phone_number == '$phone_number') {

                     statewindow= new google.maps.InfoWindow({
                         content:
                        '<div style= width:100%; height:100%>' +
                            '<div style= float:center class = display: inline-block;>' +
                                    '<img src=' + markers[i].getTitle() + ' width=100px height=100px>' +
                                    '<br>Number :' + position[i].trans_num.toString() +
                                    '<br>Direction :' + position[i].direct +
                            '</div>' +
                        '</div>'
                    });
                                 
                } else if (user_info.length == 0) {
    
                    statewindow= new google.maps.InfoWindow({
                         content:
                            '<div style= width:100%; height:100%>' +
                               '<div style= float:center class = display: inline-block;>' +
                                       '<img src=' + markers[i].getTitle() + ' width=100px height=100px>' +
                                       '<br>Number :' + position[i].trans_num.toString() +
                                       '<br>Direction :' + position[i].direct +
                               '</div>' +
                           '</div>'
                        });
                                 
                 } else {
                    var userPos = new google.maps.LatLng(curUserLat, curUserLng);
                    var marPos = new google.maps.LatLng(position[i].lat, position[i].lng);
                    var distance = google.maps.geometry.spherical.computeDistanceBetween(userPos, marPos);
                                 
                      if(distance < 11150){
                          
                          statewindow= new google.maps.InfoWindow({
                              content:
                           '<!DOCTYPE html>' +
                           '<html lang=en>' +
                           '<head>' +
                           '</head>' +
                           '<body>' +
                           '<div style= width:100%; height:100%>' +
                                '<div style= float:center class = display: inline-block;>' +
                                        '<img src=' + markers[i].getTitle() + ' width=100px height=100px>' +
                                        '<br>Line Number :' + position[i].trans_num +
                                        '<br>Direction :' + position[i].direct +
                                        '<br>' +
                                        'How full is it? <br>' +
                                '</div>' +
                                '</div>' +
                                   '<form>' +
                                        '<input type=radio id=new_lev1 name=new_lev value=0> 20% &nbsp; &nbsp;' +
                                        '<input type=radio id=new_lev1 name=new_lev value=1> 60% &nbsp; &nbsp;' +
                                        '<input type=radio id=new_lev1 name=new_lev value=3> 100% &nbsp; &nbsp;' +
                                        '<br>' +
                                   '</form>' +
                                    '<br>' +
                                '<button type=button onclick = levelChange(' +position[i].user_id +')> Change </button> &emsp;&emsp;&emsp;&emsp;' +
                                '<button type=button onclick = reportFake('+ position[i].user_id +',' + position[i].lat + ',' + position[i].lng +')> Fake </button>' +
                            '</body>' +
                             '</html>'
                          });
                                 
                     } else {
                         statewindow= new google.maps.InfoWindow({
                              content:
                                '<!DOCTYPE html>' +
                                '<html lang=en>' +
                                '<title> Transport information</title>' +
                                '<div style= width:100%; height:100%>' +
                                    '<div style= float:center class = display: inline-block;>' +
                                            '<img src=' + markers[i].getTitle() + ' width=100px height=100px>' +
                                            '<br>Number :' + position[i].trans_num.toString() +
                                            '<br>Direction :' + position[i].direct +
                                    '</div>' +
                                '</div>' +
                                '</html>'
                             });
                     }
                 }
                                 
                statewindow.open(map, location);
                    
                google.maps.event.addListener(statewindow,'closeclick',function(){
                   update();
                });
                                 
             });
       
                                
            return location;
         });
      
          
             showMarkers();
      
   }
      
//--------------------------------------------------------------------
      
      
      
      function levelChange(user_id, lat, lng){
    
      var new_level;
      index = document.getElementsByName('new_lev');
      
      for (var i = 0, length = index.length; i < length; i++)
      {
          if (index[i].checked)
          {
           new_level = index[i].value;
           break;
          }
      }

      
      statewindow.close();

        var formData = {
                user_id: user_id
                ,new_level: new_level
                ,type: 0
             };

             $.ajax({
                     type: 'POST',
                     url: 'https://web-class.auca.kg/~kushtar/BBus/Markers.php',
                     data: formData,
                     dataType: 'text',
                     cache: false,
                     success: function (result, status) {
    
                  }
             });
      setTimeout(update, 1000);
      }
                 
//---------------------------------------------------------------------
            
      function reportFake(user_id, lat, lng)
      {
      
            statewindow.close();

              var formData = {
                      user_id: user_id
                      ,type: 1
                   };
      
               $.ajax({
                       type: 'POST',
                       url: 'https://web-class.auca.kg/~kushtar/BBus/Markers.php',
                       data: formData,
                       dataType: 'text',
                       cache: false,
                       success: function (result, status) {
                          if(result == 200){
                              messagewindow.setContent('Report has deleted Marker!');
                              messagewindow.setPosition(new google.maps.LatLng(lat, lng));
                             messagewindow.open(map);
                             setTimeout(function(){messagewindow.close()}, 4000);
                          } else if(result == 201){
                              messagewindow.setContent('There was some issue!');
                              messagewindow.setPosition(new google.maps.LatLng(lat, lng));
                              messagewindow.open(map);
                              setTimeoutll(function(){messagewindow.close()}, 2000);
                          }
                    }
               });
            setTimeout(update, 1000);
      }

//----------------------------------------------------------------
      
      function markerTimeCheck()
      {
      
            var formData = {type: 2};
            
             $.ajax({
                     type: 'POST',
                     url: 'https://web-class.auca.kg/~kushtar/BBus/Markers.php',
                     data: formData,
                     dataType: 'text',
                     cache: false,
                     success: function (result, status) {
                  }
             });
      }
       
//--------------------------------------------------------------
       
function update(){
      
  setTimeout(doNothing, 7000);
      
  options = {
    enableHighAccuracy: false,
    timeout: 2000,
    maximumAge: 20000
  };

  const pos = new Object();
  
  var lat = 9;
  var lng = 9;

  
      
  update_id = navigator.geolocation.watchPosition(
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
     
      curUserLat = position.coords.latitude;
      curUserLng = position.coords.longitude;

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
            
      //---------------------------------------------------------------------
             

      
      function doNothing () {

      }

    </script>
      

    
</body>
</html>";
  echo $html;

?>
