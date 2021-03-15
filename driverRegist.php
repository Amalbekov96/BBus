<?php
session_start();
require_once("config.php");

if (isset($_POST['Submit']))  {

  $ip = $_SERVER['REMOTE_ADDR'];
  $username = $_POST['name'];
  $phone_number = $_POST['phone_number'];
  $password = $_POST['password'];
  $con_password = $_POST['con_password'];
  $trans_type = $_POST['transport'];
  $line_number =$_POST['line_number'];


  $result = mysqli_query($conn, "SELECT * FROM Users WHERE uname = '$username'");
  $row = mysqli_fetch_assoc($result);

  $message = "Go back";
  $link = 'userPage.php';

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


    

    <style>
    .font-robo {
      font-family: "Roboto", "Arial", "Helvetica Neue", sans-serif;
    }

    </style>

</head>

<body>

        <h2 class="title">Driver registretion</h2>
        <form action="" method="POST">


            <div class="input-group">
                <input class="input--style-2" type="text" placeholder="Username" name="name">
            </div>

            <div class="input-group">
                <input class="input--style-2" type="text" placeholder="Phone number" name="phone_number">
            </div>
            
            <div class="input-group">
                <label class="input--style-2" for="transport">Type of transport:</label>
                <select class="input--style-2" name="transport" id="transport">
                  <option value="Troylebus">Troylebus</option>
                  <option value="Bus">Bus</option>
                  <option value="Mini-bus">Mini-bus</option>
                </select>
            </div>
            
            <div class="input-group">
                <input class="input--style-2" type="text" placeholder="line number" name="line_number">
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



    <script type="text/javascript">
      document.getElementById("Go_back").onclick = function () {
          location.href = "login.php";
      };

    </script>


</body>
</html>
<!-- end document-->
';

echo $html;
htmlGetBack("", "userPage.php", "Go Back");

?>
