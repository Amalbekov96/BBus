<?php
session_start();
require_once("config.php");

if (isset($_POST['Submit']))  {

    
  $ip = $_SERVER['REMOTE_ADDR'];
  $username = $_POST['username'];
  $phone_number = $_POST['phone_number'];
  $password = $_POST['password'];
  $con_password = $_POST['confirm_password'];
  $trans_type = $_POST['transport'];
  $line_number =$_POST['line_number'];


  $result = mysqli_query($conn, "SELECT * FROM Users WHERE uname = '$username'");
  $row = mysqli_fetch_assoc($result);

  $message = "Go back";
  $link = 'login.php';

  $prob;
  if(mysqli_num_rows($result)== 0){
      
    if (strlen($username) == 0) {
    $prob = "You didn't input your username"; 
    logError("$ip bypassed HTML and submitted empty username");
    }

    if ($con_password != $password) {
    $prob = "Your password do not match each other !"; 
    logError("$ip bypassed HTML and submitted empty differnet passwords");
    }

    else if (strlen($password) < 6) {
    $prob = "Password must be not less than 6 symbols";
    logError("$ip bypassed HTML and submitted password less than 6 symbols");
    } else {
    $prob = "Registration completed";
    $message = "Back to login";
        
    $username = mysqli_escape_string($conn, $username);
    $password = mysqli_escape_string($conn, $password);
    $region = mysqli_escape_string($conn, $region);
    $line_number = mysqli_escape_string($conn, $line_number);
    $phone_number = mysqli_escape_string($conn, $phone_number);

    mysqli_query($conn, "INSERT into Users (uname, pswd, phone_number,user_type, line_number, trans_type, ip) values ('$username', '$password', '$phone_number', 'Driver', '$line_number', '$trans_type', '$ip');");

    mysqli_query($conn, "UPDATE Users set last_submission = '1970-1-1 11:11:11' where uname = '$username'");
    // logAction($conn, $username, "Created");  
    }

  } else {

    if (strlen($username) == 0) {
    $prob = "You didn't input your username"; 
    logError("$ip bypassed HTML and submitted empty username");
    }
    else if (strlen($password) < 6) {
    $prob = "Password must be not less than 6 symbols";
    logError("$ip bypassed HTML and submitted password less than 6 symbols");
    }

    else if (strlen($row['id']) > 0) {
    $prob = "Username already exists";
    logError("$ip tried to register under an existing username");
    }
    else if (ipVerification($ip) != 0) {
    $prob = "There is already an account tied to this IP adress";
    logError("$ip tried to register for the second time");
    } 
    else if ($con_password != $password) {
    $prob = "Your password do not match each other !"; 
    logError("$ip bypassed HTML and submitted empty differnet passwords");
    }
    else {

    $prob = "Registration completed";
    $message = "Back to login"; 
    $password = trim($password);
    $username = mysqli_escape_string($conn, $username);
    $password = mysqli_escape_string($conn, $password);
    $region = mysqli_escape_string($conn, $region);
    $line_number = mysqli_escape_string($conn, $line_number);
    $phone_number = mysqli_escape_string($conn, $phone_number);
        
        if(mysqli_query($conn, "INSERT into Users (uname, pswd, phone_number,user_type, line_number, trans_type, ip) values ('$username', '$password', '$phone_number', 'Driver', '$line_number', '$trans_type', '$ip');")){
            echo 'error.. The error is '. mysqli_error($conn);
        } else {
            echo 'error.. The error is '. mysqli_error($conn);
        }
        
        
        
    mysqli_query($conn, "UPDATE Users set last_submission = '1970-1-1 11:11:11' where uname = '$username'");
    // logAction($conn, $username, "Created");
    }
  }

  htmlGetBack($prob, $link, $message);  
  exit;
}

    
    
    
    
    
    
    
    

$html = '
<!DOCTYPE html>
   <html lang="en">
   <head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
   <title>Bootstrap Sign up Form with Icons</title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
   <style>
    
    body {
      background-color: rgb(38, 38, 38);
      color: white;
    }

   .signup-form {
       width: 80%;
       justify-content: center;
       align-items: center;
        display:table;
        height 100%;
   }

   .input-group {
      width: 100%;
      vertical-align:middle;
   }


   .input-group-addon {
      width: 60px;
   }

   .vertical-center {
       display:table-cell;
       vertical-align:middle;
   }
    
   </style>
   </head>
   <body>
   <center>
   <div class="signup-form">
       <form action="" method="post">
           <div class="vertical-center">
               <h2>Sign Up</h2>
               <p>Please fill in this form to create driver account!</p>
               <hr>
               <div class="form-group" >
                   <div class="input-group">
                       <span class="input-group-addon"><i class="fa fa-user"></i></span>
                       <input type="text" class="form-control" name="username" placeholder="Username" required="required">
                   </div>
               </div>
               <div class="form-group">
                   <div class="input-group">
                       <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                       <input type="text" class="form-control" name="phone_number" placeholder="Phone number" required="required">
                   </div>
               </div>
    
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-bus"></i></span>
                    <label class="form-control" for="transport">Type of transport:</label>
                    <select class="form-control" name="transport" id="transport">
                      <option value="Troleybus">Troylebus</option>
                      <option value="Bus">Bus</option>
                      <option value="Mini-bus">Mini-bus</option>
                    </select>
                </div>
    <br>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                        <input type="text" class="form-control" name="line_number" placeholder="Bus number" required="required">
                    </div>
                </div>
                
    
               <div class="form-group">
                   <div class="input-group">
                       <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                       <input type="text" class="form-control" name="password" placeholder="Password" required="required">
                   </div>
               </div>
               <div class="form-group">
                   <div class="input-group">
                       <span class="input-group-addon">
                           <i class="fa fa-lock"></i>
                           <i class="fa fa-check"></i>
                       </span>
                       <input type="text" class="form-control" name="confirm_password" placeholder="Confirm Password" required="required">
                   </div>
               </div>
   
               <div class="form-group">
                   <button type="submit" name="Submit" class="btn btn-success btn-lg">Sign Up</button>
                   
               </div>
               <div class="text-center">Already have an account? <a href="./login.php">Login here</a></div>
           </div>
       </form>
   
   </div>
   </center>
   
   <script type="text/javascript">
    document.getElementById("Go_back").onclick = function () {
        location.href = "login.php";
    };
   
   </script>
   </body>
   </html>
';

echo $html;
//htmlGetBack("", "userPage.php", "Go Back");

?>
