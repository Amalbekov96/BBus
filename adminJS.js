//
//
//var driv_input =
//                  "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />"+
//                  "  <style>"+
//                   " input[type=button], input[type=button], input[type=reset] {"+
//                   "   background-color: #4CAF50;" +
//                    "  border: none;" +
//                    "  color: white;" +
//                    "  padding: 16px 32px;" +
//                    "  text-decoration: none;" +
//                    "  margin: 4px 2px;" +
//                    "  cursor: pointer;" +
//                   " }" +
//                   " </style>" +
//                   " <div id=form action='' method='POST'>" +
//                   "  <table>" +
//                  " Were is it going? <br>" +
//                  " <input type='radio' name='Drivedir' value='city'> To City &nbsp; &nbsp;" +
//                  " <input type='radio' name='Drivedir' value='contryside'> To Countryside &nbsp; &nbsp;" +
//                  " <br> " +
//                  " <tr><td><input id='save' type='button' style='margin-top:5px' class='btn btn-primary' value='Save'" + "onclick='saveData()'></td></tr>"+
//                 " </table>"+
//                "</div>";
//
//var pass_input =
//                '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> ' +
//                '    <style> ' +
//                '        input[type="button"], input[type="button"], input[type="reset"] { ' +
//                '          background-color: "#4CAF50"; ' +
//                '          border: "none"; ' +
//                '          color: "white"; ' +
//                '          padding: "16px 32px"; ' +
//                '          text-decoration: "none"; ' +
//                '          margin: "4px 2px"; ' +
//                '          cursor: "pointer"; ' +
//                '        } ' +
//                '    </style> ' +
//                '    <div id=form action="" method="POST"> ' +
//                '     <table> ' +
//                '    <tr> ' +
//                '    <label for="cars">Type of Transportation:</label> <br> ' +
//                '    <select name="trans_type" id="trans_type"> ' +
//                '      <option value="Troleibus">Troleibus</option> ' +
//                '      <option value="Bus">Bus</option> ' +
//                '      <option value="Mini-bus">Mini-bus</option> ' +
//                '    </select> ' +
//                '    <br> ' +
//                '    <tr> <td><br> ' +
//                '     Transportation number: <br><textarea id="trans_num"  style="resize:none" name="trans_num" rows="1" cols="10" maxlength="4"> </textarea> ' +
//                '     </td></tr> ' +
//                '    <td> ' +
//                '   <br> ' +
//                '   Were is it going? <br> ' +
//                '   <input type="radio" name="Passdir" value="city"> To City &nbsp; &nbsp; ' +
//                '   <input type="radio" name="Passdir" value="contryside"> To Countryside &nbsp; &nbsp; ' +
//                '   <br> ' +
//                '    <br> ' +
//                '    How full is it? <br> ' +
//                '    <input type="radio" name="lev" value="0"> 20% &nbsp; &nbsp; ' +
//                '    <input type="radio" name="lev" value="1"> 60% &nbsp; &nbsp; ' +
//                '    <input type="radio" name="lev" value="3"> 100% &nbsp; &nbsp; ' +
//                '    <br> ' +
//                '    </td></tr> ' +
//                '    <tr><td><input id="save" type="button" style="margin-top:5px" class="btn btn-primary" value="Save" ' + 'onclick=saveData()></td></tr> ' +
//                ' </table> ' +
//                ' </div>';


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
    
    requestPoints();
    
    document.getElementById("point_btn").addEventListener("click", function(){
        
      if(document.getElementById("search_point")){
         console.log('point');
         searchFunc();
      }
        
    });
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
      search_num = document.getElementById('search_point').value;
      requestPoints();
      }
      
//--------------------------------------------------------------------
//
function initWindows(){
      
     var Pass_formStr = "pass_input";
     var Driv_formStr = "driv_input";
     var messageStr = "MESSAGE_LOCATION_SAVED ";
      
    setTimeout(doNothing, 1000);
    
      infowindow = new google.maps.InfoWindow({
          content: Driv_formStr
      });


     messagewindow = new google.maps.InfoWindow({
       content: messageStr
     });
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
                                 
               if (statewindow) {
                  statewindow.close();
                 }
                                       
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
                                    '<br>Level :' + position[i].level +
                                    '<br>Type of User :' + position[i].point_type +
                                    '<br>User ID :' + position[i].user_id +
                                    '<br>User ID :' + position[i].name +
                                    '<br>' +
                            '</div>' +
                            '</div>' +
                            '<button type=button onclick = reportFake('+ position[i].user_id +',' + position[i].lat + ',' + position[i].lng +')> Delete </button>' +
                        '</body>' +
                         '</html>'
                      });
                             
                                 
                statewindow.open(map, location);
                    
             });
       
                                
            return location;
         });
            
          showMarkers();
   }
      
        
//---------------------------------------------------------------------
            
      function reportFake(user_id, lat, lng)
      {
          
            statewindow.close();
            initWindows();
              var formData = {
                      user_id: user_id
                      ,type: 3
                   };
      
               $.ajax({
                       type: 'POST',
                       url: 'https://web-class.auca.kg/~kushtar/BBus/Markers.php',
                       data: formData,
                       dataType: 'text',
                       cache: false,
                       success: function (result, status) {
                            
                          if(result == 200){
                              messagewindow.setContent('Marker is deleted!');
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
          
            setTimeout(requestPoints, 1000);
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
