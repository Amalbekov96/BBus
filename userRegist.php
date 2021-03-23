<?php
session_start();
require_once("config.php");

if (isset($_POST['Submit']))  {
    
    echo 'yes';

  $ip = $_SERVER['REMOTE_ADDR'];
  $username = $_POST['username'];
  $phone_number = $_POST['phone_number'];
  $password = $_POST['password'];
  $con_password = $_POST['confirm_password'];

  $result = mysqli_query($conn, "SELECT * FROM Users WHERE uname = '$username' OR phone_number = '$phone_number'");
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
    
    $password = trim($password);
    $username = mysqli_escape_string($conn, $username);
    $password = mysqli_escape_string($conn, $password);
    
        
    mysqli_query($conn, "INSERT into Users (uname, pswd, phone_number, user_type, ip) values ('$username', '$password', '$phone_number', 'Passenger', '$ip');");
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
      
    else if ($username == $row['name']) {
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
    else if ($phone_number == $row['phone_number']) {
        $prob = "There is already user using this phone number: " . $phone_number ;
    logError("$ip bypassed HTML and submited the same phone number!");
    }
    else {

    $prob = "Registration completed";
    $message = "Back to login"; 
    $password = trim($password);
    $username = mysqli_escape_string($conn, $username);
    $password = mysqli_escape_string($conn, $password);
    mysqli_query($conn, "INSERT into Users (uname, pswd, phone_number, user_type, ip) values ('$username', '$password', '$phone_number', 'Passenger', '$ip');");
    mysqli_query($conn, "UPDATE Users set last_submission = '1970-1-1 11:11:11' where uname = '$username'");
    // logAction($conn, $username, "Created");  
    }
  }

  htmlGetBack($prob, $link, $message);
  exit;
}


//$html = '
//<!DOCTYPE html>
//<html lang="en">
//
//<head>
//
//    <style>
//    .font-robo {
//      font-family: "Roboto", "Arial", "Helvetica Neue", sans-serif;
//    }
//
//    </style>
//
//
//</head>
//
//<body>
//
//
//    <h2 class="title">Passenger registretion </h2>
//    <form action="" method="POST">
//
//
//        <div class="input-group">
//            <input class="input--style-2" type="text" placeholder="Username" name="name">
//        </div>
//
//        <div class="input-group">
//            <input class="input--style-2" type="text" placeholder="Phone number" name="phone_number">
//        </div>
//
//        <div class="input-group">
//            <input class="input--style-2" type="password" placeholder="Password" name="password">
//        </div>
//
//        <div class="input-group">
//            <input class="input--style-2" type="password" placeholder="Confirm password" name="con_password">
//        </div>
//
//        <div class="p-t-30">
//            <button class="btn btn--radius btn--green" type="submit" value ="Submit" name="Submit" id="submit" >Register</button>
//        </div>
//    </form>
//
//    <button id="Go_back" class="btn2 btn--radius btn2--green">Go Back</button>
//
//
//    <script type="text/javascript">
//      document.getElementById("Go_back").onclick = function () {
//          location.href = "index.php";
//      };
//
//    </script>
//
//</body>
//</html>
//<!-- end document-->
//';
    
    
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
                <p>Please fill in this form to create passenger account!</p>
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
    
                     <button id="Go_back" class="btn btn-success btn-lg">Go Back</button>
    
                    
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
//htmlGetBack("", "index.php", "Go Back");

?>
