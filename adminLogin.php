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


        $user_arr = mysqli_query($conn, "SELECT * from Admins where name = '$username' and password = '$password'");

        $row=mysqli_fetch_array($user_arr,MYSQLI_ASSOC);

        if (strlen($username) == 0 or strlen($password) == 0) {
        htmlGetBack("You have not authorized with username / password", "adminLogin.php", "Go Back");
        logAction($conn, "empty", "empty");
        exit;
        }
        else {
          if (strlen($row['ID']) == 0) {
          htmlGetBack("Incorrect credentials", "adminLogin.php", "Go Back");
          logAction($conn, $username, "fail");
          exit;
          }
          else {
          $_SESSION['username'] = $username;
          $_SESSION['id'] = $row['id'];
          logAction($conn, $username, "login");
          echo "<script>window.location = 'adminPage.html';</script>";
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
     <style>

     .signup-form {
         width: 80%;
         justify-content: center;
         align-items: center;
          display:table;
          height 100%;
     }


    .col-centered {
      display: block;
      margin-left: auto;
      margin-right: auto;
    }
    
    .vertical-center{
        margin: 0 auto;
        width:80% /* value of your choice which suits your alignment */
    }
    
     </style>
     </head>
     <body>
     <center>
     <div class="signup-form col-centered">
     <div class="vertical-center">
    
         <form action="" method="post">
             
                 <h2>Login as Admin</h2>
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
    
                 </div>
         </form>
    

    
        
     </div>
     </div>
     </center>
     
         <script type="text/javascript">
    
           document.getElementById("Go_back").onclick = function () {
               location.href = "userPage.html";
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
