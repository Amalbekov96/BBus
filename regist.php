<?php
session_start();
require_once("config.php");

if (isset($_POST['Submit']))  {

  $ip = $_SERVER['REMOTE_ADDR'];
  $username = $_POST['name'];
  $phone_number = $_POST['phone_number'];
  $password = $_POST['password'];
  $con_password = $_POST['con_password'];

  $result = mysqli_query($conn, "SELECT * FROM Users WHERE uname = '$username'");
  $row = mysqli_fetch_assoc($result);

  $message = "Go back";
  $link = 'index.php';

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

    mysqli_query($conn, "INSERT into Users (uname, pswd, phone_number, ip) values ('$username', '$password', '$phone_number', '$ip');");
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

      echo "yes";

    $prob = "Registration completed";
    $message = "Back to login"; 
    $password = trim($password);
    $username = mysqli_escape_string($conn, $username);
    $password = mysqli_escape_string($conn, $password);
    $region = mysqli_escape_string($conn, $region);
    mysqli_query($conn, "INSERT into Users (uname, pswd, phone_number, ip) values ('$username', '$password', '$phone_number', '$ip');");
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


    

    <style>
    .font-robo {
      font-family: "Roboto", "Arial", "Helvetica Neue", sans-serif;
    }

    </style>


    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Au Register Forms by Colorlib</title>

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="ccs/main.css" type="text/css" rel="stylesheet" media="all">

</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <a class="navbar-brand" href="#">BBus</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item active">
            <a class="nav-link" href="./index2.html">Geust</a>
          </li>
        <li class="nav-item active">
          <a class="nav-link" href="./login.html">login</a>
        </li>
        </ul>
      </div>
    </nav>
    


    <div class="page-wrapper bg-red p-t-180 p-b-100 font-robo">
        <div class="wrapper wrapper--w960">
            <div class="card card-2">
                <div class="card-heading"></div>
                <div class="card-body">

                    <h2 class="title">Registretion form</h2>
                    <form action="" method="POST">


                        <div class="input-group">
                            <input class="input--style-2" type="text" placeholder="Username" name="name">
                        </div>

                        <div class="input-group">
                            <input class="input--style-2" type="text" placeholder="Phone number" name="phone_number">
                        </div>

                        <div class="input-group">
                            <input class="input--style-2" type="password" placeholder="Password" name="password">
                        </div>

                        <div class="input-group">
                            <input class="input--style-2" type="password" placeholder="Confirm password" name="con_password">
                        </div>

                        <div class="p-t-30">
                            <button class="btn btn--radius btn--green" type="submit" value ="Submit" name="Submit" id="submit" >Register</button>
                        </div>
                    </form>

                    <button id="Go_back" class="btn2 btn--radius btn2--green">Go Back</button>


                </div>
            </div>
        </div>
    </div>



    <script type="text/javascript">
      document.getElementById("Go_back").onclick = function () {
          location.href = "index.php";
      };

    </script>


    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="js/global.js"></script>


</body>
</html>
<!-- end document-->
';

echo $html;
htmlGetBack("", "index.php", "Go Back");

?>
