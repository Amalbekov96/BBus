<?php
    session_start();
    require_once("config.php");

    $ip = $_SERVER['REMOTE_ADDR'];
    unset($_SESSION['username']);
    unset($_SESSION['id']);

   	if (isset($_POST['submit'])) {
		$conn;
		$username = $_POST['username'];
		$password = $_POST['password'];


		$user_arr = mysqli_query($conn, "SELECT * from Users where uname = '$username' and pswd = '$password'");

		$row=mysqli_fetch_array($user_arr,MYSQLI_ASSOC);

		if (strlen($username) == 0 or strlen($password) == 0) {
		htmlGetBack("You have not authorized with username / password", "index2.php", "Go Back");
		logAction($conn, "empty", "empty");
		exit;
		}
		else {

  		if (strlen($row['id']) == 0) {
  		htmlGetBack("Incorrect credentials", "index2.php", "Go Back");
  		logAction($conn, $username, "fail");
  		exit;
  		}
  		else {	
  		$_SESSION['username'] = $username;
  		$_SESSION['id'] = $row['id'];
  		logAction($conn, $username, "login");
  		echo "<script>window.location = 'userPage.php';</script>";
  		}
  	}   		
  }


$html = '
<!DOCTYPE html>
<html lang="en">

<head>

    <style>
    
    </style>
    
</head>
    
<body>

    <h2 class="title">Login</h2>
    <form action="" method="POST">
        <div class="input-group">
            <input class="input--style-2" type="text" placeholder="Username" name="username">
        </div>

        <div class="input-group">
            <input class="input--style-2" type="password" placeholder="password" name="password">
        </div>

        <div class="p-t-30">
            <button class="btn btn--radius btn--green" type="submit" value ="Submit" name="submit" id="submit" >Login</button>
        </div>
    </form>

    <button id="Go_back" class="btn2 btn--radius btn2--green">Go Back</button>
    <button id="UserRegister" class="btn3 btn3--radius btn3--green">Register as passenger</button>
    <button id="DriverRegister" class="btn3 btn3--radius btn3--green">Register as driver</button>
    <button id="Guest" class="btn4 btn4--radius btn3--green">Guest</button>



    <script type="text/javascript">
      document.getElementById("Go_back").onclick = function () {
          location.href = "index2.php";
      };

      document.getElementById("UserRegister").onclick = function () {
          location.href = "userRegist.php";
      };
    
        document.getElementById("DriverRegister").onclick = function () {
            location.href = "driverRegist.php";
        };

      document.getElementById("Guest").onclick = function () {
      location.href = "index2.php";
      };
    </script>

</body>

</html>
<!-- end document-->
';

echo $html;
htmlGetBack("", "index2.php", "Go Back");

?>
