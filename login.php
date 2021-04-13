<?php
    session_start();
    require_once("config.php");

    $ip = $_SERVER['REMOTE_ADDR'];
    unset($_SESSION['phone_number']);
    unset($_SESSION['id']);
    
    if(isset($_GET['logout']) == 1) {
      unset($_SESSION['phone_number']);
      unset($_SESSION['id']);
      session_destroy();
    }
    
if(isset($_POST['submit']))  {
    
    $result = mysqli_query($conn, "SELECT * from Users where ip = '$ip'");
    
        $row = mysqli_fetch_assoc($result);
        $json_encoded = json_encode($row['phone_number'],JSON_NUMERIC_CHECK);
       
          if (isset($_POST['submit'])) {
              $conn;
              $phone_number = $_POST['phone_number'];
              $password = $_POST['password'];
              $user_arr = mysqli_query($conn, "SELECT * from Users where phone_number = '$phone_number' and pswd = '$password'");

              $row=mysqli_fetch_array($user_arr,MYSQLI_ASSOC);
              
              mysqli_query($conn, "DELETE from BlackList where TIMESTAMPDIFF(DAY,DATE(added_time) ,DATE(now())) > 3");
              
              $BlackList = mysqli_query($conn, "SELECT * from BlackList where user_id = '".$row['id']."'");
              $row2=mysqli_fetch_array($BlackList,MYSQLI_ASSOC);

              if(mysqli_num_rows($BlackList) > 0){
                  htmlGetBack("You in the Blacklist since '".$row2['added_time']."' for false points, it will last four days!", "login.php", "Go Back");
                  logAction($conn, "empty", "empty");
                  exit;
              }

              if (strlen($phone_number) == 0 or strlen($password) == 0) {
                  htmlGetBack("You have not authorized with password", "login.php", "Go Back");
                  logAction($conn, "empty", "empty");
                  exit;
              } else {

              if (strlen($row['id']) == 0) {
                  htmlGetBack("Incorrect credentials", "login.php", "Go Back");
                  logAction($conn, $phone_number, "fail");
                  exit;
              } else {
                  
                  $_SESSION['phone_number'] = $phone_number;
                  $_SESSION['id'] = $row['id'];
                  logAction($conn, $phone_number, "login");
                  echo "<script>window.location = 'userPage.php';</script>";
              }
          }
        }
}
    $re = mysqli_query($conn, "SELECT * from Users where ip = '$ip'");
    
    if(mysqli_num_rows($re) != 0){
        
        $result = mysqli_query($conn, "SELECT * from Users where ip = '$ip'");
    
        $row = mysqli_fetch_assoc($result);
        $json_encoded = json_encode($row['phone_number'],JSON_NUMERIC_CHECK);
       
        print("
             <!DOCTYPE html>
             <html lang='en'>
             <head>
             <meta charset='utf-8'>
             <meta http-equiv='X-UA-Compatible' content='IE=edge'>
             <meta name='viewport' content='width=device-width, initial-scale=1'>
             <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet'>
             <title>Bootstrap Sign up Form with Icons</title>
             <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
             <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
             <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
             <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
             <link rel='stylesheet' href='css/loginStyle.css'>
             </head>
             <body>
             <center>
             <div class='signup-form'>
             <div class='vertical-center'>
                    
                 <form action='' method='post'>
                        <div class='image_div'>
                            <img src='images/login_icon.png' alt='Italian Trulli'>
                        </div>
                         <h2>WELCOME</h2>
                         <hr>
                         <div class='form-group' >
                             <div class='input-group'>
                                 <span class='input-group-addon'><i class='fa fa-user'></i></span>
                                 <input type='text' class='form-control' id='phone_number' name='phone_number' placeholder='Phone Number' required='required'>
                             </div>
                         </div>

                         <div class='form-group'>
                             <div class='input-group'>
                                 <span class='input-group-addon'><i class='fa fa-lock'></i></span>
                                 <input type='password' class='form-control' name='password' placeholder='Password' required='required'>
                             </div>
                         </div>

                            
                        <div class='forgot_pass'>
                            <a href='#'>Forgot Password</a>
                        </div>
                        
            
                         <div class='form-group submit'>
                            <button type='submit' name='submit' class='btn btn-info btn-lg'>Login</button>
                            &emsp; &emsp;
                        </div>
                            

                        <div class='w-100 text-center mt-4 '>
                            <p class='mb-0'>Dont have an account?</p>
                              <a href='pages/loginPage.html'>Sign Up</a>
                          </div>
            
                         </div>
                 </form>




             </div>
             </div>
             </center>

                 <script type='text/javascript'>
              
                     $('#phone_number').val('0' + $json_encoded);
              
                    setInputFilter(document.getElementById('phone_number'), function(value) {
                    return /^-?\d*$/.test(value); });

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
            
                 </script>
             </body>
             </html>"
              );
        

        

    } else {
        
        
        
        print("
             <!DOCTYPE html>
             <html lang='en'>
             <head>
             <meta charset='utf-8'>
             <meta http-equiv='X-UA-Compatible' content='IE=edge'>
             <meta name='viewport' content='width=device-width, initial-scale=1'>
             <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet'>
             <title>Bootstrap Sign up Form with Icons</title>
             <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
             <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
             <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'></script>
             <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
             <link rel='stylesheet' href='css/loginStyle.css'>
             </head>
             <body>
             <center>
             <div class='signup-form'>
             <div class='vertical-center'>
                    
                 <form action=' method='post'>
                        <div class='image_div'>
                            <img src='images/login_icon.png' alt='Italian Trulli'>
                        </div>
                         <h2>WELCOME</h2>
                         <hr>
                         <div class='form-group' >
                             <div class='input-group'>
                                 <span class='input-group-addon'><i class='fa fa-user'></i></span>
                                 <input type='text' class='form-control' id='phone_number' name='phone_number' placeholder='Phone Number' required='required'>
                             </div>
                         </div>

                         <div class='form-group'>
                             <div class='input-group'>
                                 <span class='input-group-addon'><i class='fa fa-lock'></i></span>
                                 <input type='password' class='form-control' name='password' placeholder='Password' required='required'>
                             </div>
                         </div>

                            
                        <div class='forgot_pass'>
                            <a href='#'>Forgot Password</a>
                        </div>
                        
            
                         <div class='form-group submit'>
                            <button type='submit' name='Submit' class='btn btn-info btn-lg'>Login</button>
                            &emsp; &emsp;
                        </div>
                            

                        <div class='w-100 text-center mt-4 '>
                            <p class='mb-0'>Dont have an account?</p>
                              <a href='pages/loginPage.html'>Sign Up</a>
                          </div>
            
                         </div>
                 </form>




             </div>
             </div>
             </center>

                 <script type='text/javascript'>
              
                    setInputFilter(document.getElementById('phone_number'), function(value) {
                    return /^-?\d*$/.test(value); });

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
            
                 </script>
             </body>
             </html>"
              );

    }


?>
