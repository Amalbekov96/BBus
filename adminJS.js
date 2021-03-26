    

var driv_input =
                  "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />"+
                  "  <style>"+
                   " input[type=button], input[type=button], input[type=reset] {"+
                   "   background-color: #4CAF50;"+
                    "  border: none;"+
                    "  color: white;"+
                    "  padding: 16px 32px;"+
                    "  text-decoration: none;"+
                    "  margin: 4px 2px;"+
                    "  cursor: pointer;"+
                   " }"+
                   " </style>"+
                   " <div id=form action='' method='POST'>"+
                   "  <table>"+
                  " Were is it going? <br>"+
                  " <input type='radio' name='Drivedir' value='city'> To City &nbsp; &nbsp;"+
                  " <input type='radio' name='Drivedir' value='contryside'> To Countryside &nbsp; &nbsp;"+
                  " <br> " +
                  " <tr><td><input id='save' type='button' style='margin-top:5px' class='btn btn-primary' value='Save'" + "onclick='saveData()'></td></tr>"+
                 " </table>"+
                "</div>";

    var pass_input =
                '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> ' +
                '    <style> ' +
                '        input[type="button"], input[type="button"], input[type="reset"] { ' +
                '          background-color: "#4CAF50"; ' +
                '          border: "none"; ' +
                '          color: "white"; ' +
                '          padding: "16px 32px"; ' +
                '          text-decoration: "none"; ' +
                '          margin: "4px 2px"; ' +
                '          cursor: "pointer"; ' +
                '        } ' +
                '    </style> ' +
                '    <div id=form action="" method="POST"> ' +
                '     <table> ' +
                '    <tr> ' +
                '    <label for="cars">Type of Transportation:</label> <br> ' +
                '    <select name="trans_type" id="trans_type"> ' +
                '      <option value="Troleibus">Troleibus</option> ' +
                '      <option value="Bus">Bus</option> ' +
                '      <option value="Mini-bus">Mini-bus</option> ' +
                '    </select> ' +
                '    <br> ' +
                '    <tr> <td><br> ' +
                '     Transportation number: <br><textarea id="trans_num"  style="resize:none" name="trans_num" rows="1" cols="10" maxlength="4"> </textarea> ' +
                '     </td></tr> ' +
                '    <td> ' +
                '   <br> ' +
                '   Were is it going? <br> ' +
                '   <input type="radio" name="Passdir" value="city"> To City &nbsp; &nbsp; ' +
                '   <input type="radio" name="Passdir" value="contryside"> To Countryside &nbsp; &nbsp; ' +
                '   <br> ' +
                '    <br> ' +
                '    How full is it? <br> ' +
                '    <input type="radio" name="lev" value="0"> 20% &nbsp; &nbsp; ' +
                '    <input type="radio" name="lev" value="1"> 60% &nbsp; &nbsp; ' +
                '    <input type="radio" name="lev" value="3"> 100% &nbsp; &nbsp; ' +
                '    <br> ' +
                '    </td></tr> ' +
                '    <tr><td><input id="save" type="button" style="margin-top:5px" class="btn btn-primary" value="Save" ' + 'onclick=saveData()></td></tr> ' +
                ' </table> ' +
                ' </div>';



    var map;
    var markers = [];
    var userID = null;
    var statewindow = null;
    var infowindow = null;
    var messagewindow = null;
    var userIsOnline = new Boolean(null);
    var loged = 0;
    var update_id;
    var user_info;
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
    
    
    
    
    getUserInfo();
    
    document.getElementById('delButton').addEventListener('click', DelPoint);
    document.getElementById('addButton').addEventListener('click', AddPoint);

    setInputFilter(document.getElementById('search_num'), function(value) {
    return /^-?\d*$/.test(value); });
    
    
    update();
    //searchFunc();
}

//--------------------------------------------------------------------

    function getUserInfo()
    {
        $.ajax({url: 'https://web-class.auca.kg/~kushtar/BBus/Markers.php?user_info=1',
        dataType: 'json',
        success: function(response, status){
               user_info = response;
        }});
    }

//--------------------------------------------------------------------
      function searchFunc(){
      search_num = document.getElementById('search_num').value;
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
      
     var Pass_formStr = pass_input;
     var Driv_formStr = driv_input;
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
}
      
      
      
       
//---------------------------------------------------------------------------------------------
       
 function saveData() {
      
//      var user_info = user_info;
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
                    $.ajax({url: 'https://web-class.auca.kg/~kushtar/BBus/Markers.php?search_num='+ search_num,
                      dataType: 'json',
                      success: function(position, status){
                        updatePoints(position);
                      }});
              }
        }
    }

//-------------------------------------------------------------
      
      var curUserLat;
      var curUserLng;
      
      
      function updatePoints(position) {
//      alert(position);
     // alert(' status ' + status);
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
                                 
                if (position[i].name == '$sesusername') {

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
                                 
                } else if (user_info.length === 0) {
    
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
         
       
          if (position.length > 1) {
              //map.fitZoom();
          } else {
              map.setCenter (lat, lng);
          }
      
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
                   // alert(result);
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
