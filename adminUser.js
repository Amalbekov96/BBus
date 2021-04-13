

var search_num = '';

function userMain(){
    $('#save').remove();
    $('#map').html('');
    $('#mainCon').html('');
    
    userSearchFunc();
    
    document.getElementById("user_btn").addEventListener("click", function(){
        if(document.getElementById("search_user")){
           console.log('user');
           userSearchFunc();
        }
    });
}

//-------------------------------------------------------------------------------------

function userSearchFunc(){
    search_num = document.getElementById('search_user').value;
    requestUsers();
}

//----------------------------------------------------------------------------------------
function delUser(userId){
    
    var formData = {
            lineNumber: userId
            ,type: 3
         };

     $.ajax({
             type: 'POST',
             url: 'https://web-class.auca.kg/~kushtar/BBus/adminBack.php',
             data: formData,
             dataType: 'json',
             cache: false,
             success: function (result, status) {
          }
     });
    
    requestUsers();
}

//----------------------------------------------------------------------------------------
function printLines(data){
     
     $("#map").append( "<div id='mainCon' class='container' style='height:100%; overflow:auto;'></div>" );
     $('#mainCon').html('');
    
    for (var i=0; i < data.length; i++) {
        
        $("#mainCon").append("<div class='row align-items-center' style='border:1px solid black;'>" +
                               "<div class='col-3 text-center' style='font-size: 100%'>"+ '0' + data[i].phone_number + "</div>" +
                                "<div class='col-7'>" +
                                    "Id: " + data[i].id + "<br>" +
                                    "User Type: " + data[i].user_type + "<br>" +
                                    "password: <br>" + data[i].pswd + "<br>" +
                                    "Reported count: " + data[i].user_report +
                                "</div>" +
                               "<div class='col-2'>" +
                                    "<button type='button' onclick='delUser("+ data[i].id + ")' class='btn btn-link'> <i class='fas fa-trash-alt'></i></button>" +
                               "</div>" +
                               "</div>"
                               );
    }
    
}

//----------------------------------------------------------------------------------------
function requestUsers() {
    
      $('#mainCon').empty();
      if(search_num == ''){
          console.log(search_num);
            $.ajax({url: 'https://web-class.auca.kg/~kushtar/BBus/adminBack.php?type=1',
               dataType: 'json',
               cache: false,
               success: function(data, status){
                   console.log(data);
                 printLines(data);
               }});
              
      } else {
            console.log(search_num);
            $.ajax({url: 'https://web-class.auca.kg/~kushtar/BBus/adminBack.php?user_search='+ search_num,
              dataType: 'json',
              cache: false,
              success: function(data, status){
                   console.log(status);
                printLines(data);
              }});
      }
    
}
