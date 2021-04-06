
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
                '    <label for="cars">Type of Transportation:</label> <br> ' +
                '    <select name="trans_type" id="trans_type"> ' +
                '      <option value="Troleibus">Troleibus</option> ' +
                '      <option value="Bus">Bus</option> ' +
                '      <option value="Mini-bus">Mini-bus</option> ' +
                '    </select> ' +
                '    <label for="cars">Line number:</label> <br> ' +
                '     <input type="text" id="trans_num"  name="trans_num" maxlength="4"> </input> ' +
                '    </td></tr> ' +
                ' <br>        ' +
                '    <tr><td><input id="save" type="button" style="margin-top:5px" class="btn btn-primary" value="Save" ' + 'onclick=saveData()></td></tr> ' +
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
    var points = [];
    var counter = 0;
      
function initMap() {
     $('#addLine').remove();
    
    $('#map').html('');
    
   
    
    if(document.getElementById("save")){
        
        
    } else {

        var r= $('<button type="button" id="save" class="btn btn-dark btn-circle btn-xl"><i class="fas fa-check"></i></button>');
         $("body").append(r);

         $('#save').css({ "background-color": 'dark',
                             "width": '70px',
                             "height": '70px',
                             "padding": '10px 16px',
                             "border-radius": '35px',
                             "font-size": '24px',
                             "line-height": '1.33',
                             "position": 'relative',
                             "float": 'left',
                             "bottom": '-66%'
                           });
    }
    
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
    clickableIcons: true
    //            gestureHandling: 'cooperative',
    });
    

    showRoute();
    
    document.getElementById("save").addEventListener("click", function(){
        $('#save').remove();
        showDetails();
        
        google.maps.event.addListener(infowindow, 'closeclick', function () {
            var r= $('<button type="button" id="save" class="btn btn-dark btn-circle btn-xl"><i class="fas fa-check"></i></button>');
             $("body").append(r);

             $('#save').css({ "background-color": 'dark',
                                 "width": '70px',
                                 "height": '70px',
                                 "padding": '10px 16px',
                                 "border-radius": '35px',
                                 "font-size": '24px',
                                 "line-height": '1.33',
                                 "position": 'relative',
                                 "float": 'left',
                                 "bottom": '-66%'
                               });
            points = [];
            initMap();
        });
    });
    
}


function main() {
    $('#save').remove();
    $('#map').html('');
    $('#mainCon').html('');
    
    if(document.getElementById("addLine")){
        
        
    } else {

        var r= $('<button type="button" id="addLine" class="btn btn-dark btn-circle btn-xl"><i class="fas fa-plus"></i></button>');
            $("body").append(r);

            $('#addLine').css({ "background-color": 'dark',
                                "width": '70px',
                                "height": '70px',
                                "padding": '10px 16px',
                                "border-radius": '35px',
                                "font-size": '24px',
                                "line-height": '1.33',
                                "position": 'relative',
                                "float": 'left',
                                "bottom": '-66%'
                              });
    }
    
   
    document.getElementById("addLine").addEventListener("click", function(){
        
        $('#addLine').remove();
        initMap();
    });
    
    document.getElementById("line_btn").addEventListener("click", function(){
        if(document.getElementById("search_line")){
           searchLineFunc();
        }
        
    });
    
    searchLineFunc();

}

//--------------------------------------------------------------------

function showDetails() {
    infowindow = new google.maps.InfoWindow({
          content:pass_input,
        });
    
    infowindow.setPosition(new google.maps.LatLng(points[points.length - 1].lat(),points[points.length - 1].lng()));
    infowindow.open(map);
}

//---------------------------------------------------------------------

function printLines(data){
     
     $("#map").append( "<div id='mainCon' class='container' style='height:100%; overflow:auto;'></div>" );
     $('#mainCon').html('');
    
    for (var i=0; i < data.length; i++) {
        
        $("#mainCon").append("<div class='row align-items-center' style='border:1px solid black'>" +
                               "<div class='col-3 text-center' style='font-size: 250%'>"+ data[i].lineNumber +"</div>" +
                               "<div class='col-7'> Count: "+ data[i].transNumber +"<br> Added time:" + data[i].addDate + "</div>" +
                               "<div class='col-2'>" +
                                    "<button type='button' onclick='delLine("+ data[i].lineNumber + ")' class='btn btn-link'> <i class='fas fa-trash-alt'></i></button>" +
                               "</div>" +
                               "</div>"
                               );
    }
    
}

//--------------------------------------------------------------------

function delLine(lineNumber){
    
    var formData = {
            lineNumber: lineNumber
            ,type: 1
         };

     $.ajax({
             type: 'POST',
             url: 'https://web-class.auca.kg/~kushtar/BBus/adminBack.php',
             data: formData,
             dataType: 'json',
             cache: false,
             success: function (result, status) {
                alert(result);
                
          }
     });
    
    requestPoints();
}

//--------------------------------------------------------------------

function drawLine(){
    
    const flightPath = new google.maps.Polyline({
      path: points,
      geodesic: true,
      strokeColor: "#FF0000",
      strokeOpacity: 1.0,
      strokeWeight: 2,
    });
    flightPath.setMap(null);
    flightPath.setMap(map);
}

//--------------------------------------------------------------------

function showRoute(){
    map.addListener("click", (event) => {
        points.push(event.latLng);
        drawLine();
    });
}

//--------------------------------------------------------------------
      function searchLineFunc(){
      search_num = document.getElementById('search_line').value;
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
       
function floatToString(num) {
    return num.toFixed(Math.max(1, num.toString().substr(num.toString().indexOf(".")+1).length));
}

//---------------------------------------------------------------------------------------------
 function saveData() {
    var line_number = document.getElementById('trans_num').value;
    var transports = document.getElementById('trans_type');
    var trans_type = transports.options[transports.selectedIndex].text;

     
     var points_str = "";
     for (var i = 0; i < points.length-1; i++)
     {
         points_str += floatToString(points[i].lat());
         points_str += ',';
         points_str += floatToString(points[i+1].lng());
         points_str += ',';
     }
          
      var formData = {
         line_number: line_number
         ,trans_type: trans_type
         ,points_str: points_str
         ,type: 2
      };
      
      $.ajax({
              type: 'POST',
              url: 'https://web-class.auca.kg/~kushtar/BBus/adminBack.php',
              data: formData,
              dataType: 'text',
              cache: false,
              success: function (result, status) {
               }
          });
           
        console.log(points_str);
        infowindow.close();
        points = [];
        main();

         
    }

//----------------------------------------------------------------
       
      function requestPoints() {

          $('#mainCon').empty();
          if(search_num == ''){
              
                $.ajax({url: 'https://web-class.auca.kg/~kushtar/BBus/adminBack.php?type=0',
                   dataType: 'json',
                   success: function(data, status){
                     printLines(data);
                   }});
                  
          } else {
                $.ajax({url: 'https://web-class.auca.kg/~kushtar/BBus/adminBack.php?search_num='+ search_num,
                  dataType: 'json',
                  success: function(data, status){
                    printLines(data);
                  }});
          }
        
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
