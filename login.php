<?php
    session_start();
    require_once("config.php");

    $ip = $_SERVER['REMOTE_ADDR'];
    unset($_SESSION['username']);
    unset($_SESSION['id']);

   	if (isset($_POST['Submit'])) {
		$conn;
		$username = $_POST['username'];
		$password = $_POST['password'];


		$user_arr = mysqli_query($conn, "SELECT * from Users where uname = '$username' and pswd = '$password'");

		$row=mysqli_fetch_array($user_arr,MYSQLI_ASSOC);

		if (strlen($username) == 0 or strlen($password) == 0) {
		htmlGetBack("You have not authorized with username / password", "login.php", "Go Back");
		logAction($conn, "empty", "empty");
		exit;
		}
		else {

  		if (strlen($row['id']) == 0) {
  		htmlGetBack("Incorrect credentials", "login.php", "Go Back");
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

//
//$html = '
//<!DOCTYPE html>
//<html lang="en">
//
//<head>
//
//    <style>
//
//    </style>
//
//</head>
//
//<body>
//
//    <h2 class="title">Login</h2>
//    <form action="" method="POST">
//        <div class="input-group">
//            <input class="input--style-2" type="text" placeholder="Username" name="username">
//        </div>
//
//        <div class="input-group">
//            <input class="input--style-2" type="password" placeholder="password" name="password">
//        </div>
//
//        <div class="p-t-30">
//            <button class="btn btn--radius btn--green" type="submit" value ="Submit" name="submit" id="submit" >Login</button>
//        </div>
//    </form>
//
//    <button id="Go_back" class="btn2 btn--radius btn2--green">Go Back</button>
//    <button id="UserRegister" class="btn3 btn3--radius btn3--green">Register as passenger</button>
//    <button id="DriverRegister" class="btn3 btn3--radius btn3--green">Register as driver</button>
//    <button id="Guest" class="btn4 btn4--radius btn3--green">Guest</button>
//
//
//
//    <script type="text/javascript">
//      document.getElementById("Go_back").onclick = function () {
//          location.href = "index2.php";
//      };
//
//      document.getElementById("UserRegister").onclick = function () {
//          location.href = "userRegist.php";
//      };
//
//        document.getElementById("DriverRegister").onclick = function () {
//            location.href = "driverRegist.php";
//        };
//
//      document.getElementById("Guest").onclick = function () {
//      location.href = "index2.php";
//      };
//    </script>
//
//</body>
//
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
     <div class="vertical-center">
    
         <form action="" method="post">
             
                 <h2>Login to your account</h2>
                 <hr>
                 <div class="form-group" >
                     <div class="input-group">
                         <span class="input-group-addon"><i class="fa fa-user"></i></span>
                         <input type="text" class="form-control" name="username" placeholder="Username" required="required">
                     </div>
                 </div>

                 <div class="form-group">
                     <div class="input-group">
                         <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                         <input type="text" class="form-control" name="password" placeholder="Password" required="required">
                     </div>
                 </div>
     
                 <div class="form-group">
                    <button type="submit" name="Submit" class="btn btn-success btn-lg">Login</button>
                    &emsp; &emsp;
    
                    <a href="userPage.php"><button type="button" class="btn btn-success btn-lg">Guest</button></a>
    
                    
                    <br>
                    <br>
                    <br>
                    <a href="userRegist.php"><button type="button" class="btn btn-success btn-lg">Register as passenger</button></a> <br><br>
                    <a href="driverRegist.php"><button type="button" class="btn btn-success btn-lg">Register as driver</button></a>
                 </div>
         </form>
    

    
        
     </div>
     </div>
     </center>
     
         <script type="text/javascript">
    
           document.getElementById("Go_back").onclick = function () {
               location.href = "userPage.php";
           };
     
           document.getElementById("UserRegister").onclick = function () {
               location.href = "userRegist.php";
           };
     
             document.getElementById("DriverRegister").onclick = function () {
                 location.href = "driverRegist.php";
             };
     
//           document.getElementById("Guest").onclick = function () {
//           location.href = "userPage.php";
//           };
    
         </script>
     </body>
     </html>
    
    ';
    
echo $html;
//htmlGetBack("", "index2.php", "Go Back");

?>
