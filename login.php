<?php
    session_start();
    require_once("config.php");

    $ip = $_SERVER['REMOTE_ADDR'];
    unset($_SESSION['username']);
    unset($_SESSION['id']);
    
    if(isset($_GET['logout']) == 1) {
      unset($_SESSION['username']);
      unset($_SESSION['id']);
      session_destroy();
    }


   	if (isset($_POST['Submit'])) {
		$conn;
		$username = $_POST['username'];
		$password = $_POST['password'];

		$user_arr = mysqli_query($conn, "SELECT * from Users where uname = '$username' and pswd = '$password'");

		$row=mysqli_fetch_array($user_arr,MYSQLI_ASSOC);
        
        mysqli_query($conn, "DELETE from BlackList where TIMESTAMPDIFF(DAY,DATE(added_time) ,DATE(now())) > 3");
        
        $BlackList = mysqli_query($conn, "SELECT * from BlackList where user_id = '".$row['id']."'");
        $row2=mysqli_fetch_array($BlackList,MYSQLI_ASSOC);

        if(mysqli_num_rows($BlackList) > 0){
            htmlGetBack("You in the Blacklist since '".$row2['added_time']."' for false points, it will last four days!", "login.php", "Go Back");
            logAction($conn, "empty", "empty");
            exit;
        }

		if (strlen($username) == 0 or strlen($password) == 0) {
            htmlGetBack("You have not authorized with username / password", "login.php", "Go Back");
            logAction($conn, "empty", "empty");
            exit;
		} else {

  		if (strlen($row['id']) == 0) {
            htmlGetBack("Incorrect credentials", "login.php", "Go Back");
            logAction($conn, $username, "fail");
            exit;
  		} else {
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
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
     <title>Bootstrap Sign up Form with Icons</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     <link rel="stylesheet" href="css/loginStyle.css">
     </head>
     <body>
     <center>
     <div class="signup-form">
     <div class="vertical-center">
            
         <form action="" method="post">
                <div class="image_div">
                    <img src="images/login_icon.png" alt="Italian Trulli">
                </div>
                 <h2>WELCOME</h2>
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
                         <input type="password" class="form-control" name="password" placeholder="Password" required="required">
                     </div>
                 </div>

                    
                <div class="forgot_pass">
                    <a href="#">Forgot Password</a>
                </div>
                
    
                 <div class="form-group submit">
                    <button type="submit" name="Submit" class="btn btn-info btn-lg">Login</button>
                    &emsp; &emsp;
                </div>
                    

                <div class="w-100 text-center mt-4 ">
                    <p class="mb-0">Dont have an account?</p>
                      <a href="pages/loginPage.html">Sign Up</a>
                  </div>
    
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



         </script>
     </body>
     </html>

    ';
    
//    /                    <a href="userPage.php"><button type="button" class="btn btn-success btn-lg">Guest</button></a>
    //
    //
    //                    <br>
    //                    <br>
    //                    <br>
    //                    <a href="userRegist.php"><button type="button" class="btn btn-success btn-lg">Register as passenger</button></a> <br><br>
    //                    <a href="driverRegist.php"><button type="button" class="btn btn-success btn-lg">Register as driver</button></a>
    
    
    
//    $html = '
//        <!doctype html>
//        <html lang="en">
//          <head>
//
//            <meta charset="utf-8">
//            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
//
//            <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
//
//            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
//            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
//
//            <link rel="stylesheet" href="loginFolders/css/style.css">
//
//            </head>
//            <body>
//
//            <div class="login-wrap py-5">
//
//                <div class="img d-flex align-items-center justify-content-center" style="background-image: url(loginFolders/images/bg.jpg);"></div>
//
//                <h3 class="text-center mb-0">Welcome</h3>
//                <p class="text-center">Sign in by entering the information below</p>
//
//                        <form action="" class="login-form">
//                    <div class="form-group">
//                        <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-user"></span></div>
//                        <input type="text" class="form-control" placeholder="username" required>
//                    </div>
//                <div class="form-group">
//                    <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-lock"></span></div>
//                  <input type="password" class="form-control" placeholder="password" required>
//                </div>
//                <div class="form-group d-md-flex">
//                                <div class="w-100 text-md-right">
//                                    <a href="#">Forgot Password</a>
//                                </div>
//                </div>
//                <div class="form-group">
//                    <button type="submit" name="Submit" class="btn form-control btn-primary rounded submit px-3">Get Started</button>
//                </div>
//              </form>
//
//              <div class="w-100 text-center mt-4 text">
//                <p class="mb-0">Dont have an account?</p>
//                  <a href="#">Sign Up</a>
//              </div>
//
//            </div>
//          <script src="loginFolders/js/jquery.min.js"></script>
//          <script src="loginFolders/js/popper.js"></script>
//          <script src="loginFolders/js/bootstrap.min.js"></script>
//          <script src="loginFolders/js/main.js"></script>
//
//            </body>
//        </html>';
//
//
//
echo $html;
//htmlGetBack("", "index2.php", "Go Back");

?>
