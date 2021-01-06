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
		htmlGetBack("You have not authorized with username / password", "index.php", "Go Back");
		logAction($conn, "empty", "empty");
		exit;
		}
		else {

  		if (strlen($row['id']) == 0) {
  		htmlGetBack("Incorrect credentials", "index.php", "Go Back");
  		logAction($conn, $username, "fail");
  		exit;
  		}
  		else {	
  		$_SESSION['username'] = $username;
  		$_SESSION['id'] = $row['id'];
  		logAction($conn, $username, "login");
  		echo "<script>window.location = 'index.php';</script>";
  		}
  	}   		
  }

$html = '
<!DOCTYPE html>
<html lang="en">

<head>

    <style>
    .font-robo {
      font-family: "Roboto", "Arial", "Helvetica Neue", sans-serif;
    }

    /* ==========================================================================
       #GRID
       ========================================================================== */
    .row {
      display: -webkit-box;
      display: -webkit-flex;
      display: -moz-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-flex-wrap: wrap;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
    }

    .row-space {
      -webkit-box-pack: justify;
      -webkit-justify-content: space-between;
      -moz-box-pack: justify;
      -ms-flex-pack: justify;
      justify-content: space-between;
    }

    .col-2 {
      width: -webkit-calc((100% - 60px) / 2);
      width: -moz-calc((100% - 60px) / 2);
      width: calc((100% - 60px) / 2);
    }

    @media (max-width: 767px) {
      .col-2 {
        width: 100%;
      }
    }

    /* ==========================================================================
       #BOX-SIZING
       ========================================================================== */
    /**
     * More sensible default box-sizing:
     * css-tricks.com/inheriting-box-sizing-probably-slightly-better-best-practice
     */
    html {
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
    }

    * {
      padding: 0;
      margin: 0;
    }

    *, *:before, *:after {
      -webkit-box-sizing: inherit;
      -moz-box-sizing: inherit;
      box-sizing: inherit;
    }

    /* ==========================================================================
       #RESET
       ========================================================================== */
    /**
     * A very simple reset that sits on top of Normalize.css.
     */
    body,
    h1, h2, h3, h4, h5, h6,
    blockquote, p, pre,
    dl, dd, ol, ul,
    figure,
    hr,
    fieldset, legend {
      margin: 0;
      padding: 0;
    }

    /**
     * Remove trailing margins from nested lists.
     */
    li > ol,
    li > ul {
      margin-bottom: 0;
    }

    /**
     * Remove default table spacing.
     */
    table {
      border-collapse: collapse;
      border-spacing: 0;
    }

    /**
     * 1. Reset Chrome and Firefox behaviour which sets a `min-width: min-content;`
     *    on fieldsets.
     */
    fieldset {
      min-width: 0;
      /* [1] */
      border: 0;
    }

    button {
      outline: none;
      background: none;
      border: none;
    }

    /* ==========================================================================
       #PAGE WRAPPER
       ========================================================================== */
    .page-wrapper {
      min-height: 100vh;
    }

    body {
      font-family: "Roboto", "Arial", "Helvetica Neue", sans-serif;
      font-weight: 400;
      font-size: 14px;
    }

    h1, h2, h3, h4, h5, h6 {
      font-weight: 400;
    }

    h1 {
      font-size: 36px;
    }

    h2 {
      font-size: 30px;
    }

    h3 {
      font-size: 24px;
    }

    h4 {
      font-size: 18px;
    }

    h5 {
      font-size: 15px;
    }

    h6 {
      font-size: 13px;
    }

    /* ==========================================================================
       #BACKGROUND
       ========================================================================== */
    .bg-blue {
      background: #2c6ed5;
    }

    .bg-red {
      background: #fa4251;
    }

    /* ==========================================================================
       #SPACING
       ========================================================================== */
    .p-t-100 {
      padding-top: 100px;
    }

    .p-t-180 {
      padding-top: 180px;
    }

    .p-t-20 {
      padding-top: 20px;
    }

    .p-t-30 {
      padding-top: 30px;
    }

    .p-b-100 {
      padding-bottom: 100px;
    }

    /* ==========================================================================
       #WRAPPER
       ========================================================================== */
    .wrapper {
      margin: 0 auto;
    }

    .wrapper--w960 {
      max-width: 960px;
    }

    .wrapper--w680 {
      max-width: 680px;
    }

    /* ==========================================================================
       #BUTTON
       ========================================================================== */
    .btn {
      line-height: 40px;
      display: inline-block;
      padding: 0 25px;
      cursor: pointer;
      color: #fff;
      font-family: "Roboto", "Arial", "Helvetica Neue", sans-serif;
      -webkit-transition: all 0.4s ease;
      -o-transition: all 0.4s ease;
      -moz-transition: all 0.4s ease;
      transition: all 0.4s ease;
      font-size: 14px;
      font-weight: 700;
    }

    .btn--radius {
      -webkit-border-radius: 3px;
      -moz-border-radius: 3px;
      border-radius: 3px;
    }

    .btn--green {
      background: #57b846;
    }

    .btn--green:hover {
      background: #4dae3c;
    }


    .btn2 {

      position: absolute;
      top: 82%;
      left: 75%;

      line-height: 40px;
      display: inline-block;
      padding: 0 25px;
      cursor: pointer;
      color: #fff;
      font-family: "Roboto", "Arial", "Helvetica Neue", sans-serif;
      -webkit-transition: all 0.4s ease;
      -o-transition: all 0.4s ease;
      -moz-transition: all 0.4s ease;
      transition: all 0.4s ease;
      font-size: 14px;
      font-weight: 700;
    }


    .btn2--radius {
      -webkit-border-radius: 3px;
      -moz-border-radius: 3px;
      border-radius: 3px;
    }

    .btn2--green {
      background: #ffa500;
    }

    .btn2--green:hover {
      background: #ff6600;
    }


    .btn3 {

      position: absolute;
      top: 82%;
      left: 66%;

      line-height: 40px;
      display: inline-block;
      padding: 0 25px;
      cursor: pointer;
      color: #fff;
      font-family: "Roboto", "Arial", "Helvetica Neue", sans-serif;
      -webkit-transition: all 0.4s ease;
      -o-transition: all 0.4s ease;
      -moz-transition: all 0.4s ease;
      transition: all 0.4s ease;
      font-size: 14px;
      font-weight: 700;
    }


    .btn3--radius {
      -webkit-border-radius: 3px;
      -moz-border-radius: 3px;
      border-radius: 3px;
    }

    .btn3--green {
      background: #57b846;
    }

    .btn3--green:hover {
      background: #4dae3c;
    }


  .btn4 {

      position: absolute;
      top: 82%;
      left: 58%;

      line-height: 40px;
      display: inline-block;
      padding: 0 25px;
      cursor: pointer;
      color: #fff;
      font-family: "Roboto", "Arial", "Helvetica Neue", sans-serif;
      -webkit-transition: all 0.4s ease;
      -o-transition: all 0.4s ease;
      -moz-transition: all 0.4s ease;
      transition: all 0.4s ease;
      font-size: 14px;
      font-weight: 700;
    }


    .btn4--radius {
      -webkit-border-radius: 3px;
      -moz-border-radius: 3px;
      border-radius: 3px;
    }

    .btn4--green {
      background: #57b846;
    }

    .btn4--green:hover {
      background: #4dae3c;
    }



    /* ==========================================================================
       #FORM
       ========================================================================== */
    input {
      outline: none;
      margin: 0;
      border: none;
      -webkit-box-shadow: none;
      -moz-box-shadow: none;
      box-shadow: none;
      width: 100%;
      font-size: 14px;
      font-family: inherit;
    }

    /* input group 1 */
    /* end input group 1 */
    .input-group {
      position: relative;
      margin-bottom: 32px;
      border-bottom: 1px solid #e5e5e5;
    }

    .input-icon {
      position: absolute;
      font-size: 18px;
      color: #ccc;
      right: 8px;
      top: 50%;
      -webkit-transform: translateY(-50%);
      -moz-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
      -o-transform: translateY(-50%);
      transform: translateY(-50%);
      cursor: pointer;
    }

    .input--style-2 {
      padding: 9px 0;
      color: #666;
      font-size: 16px;
      font-weight: 500;
    }

    .input--style-2::-webkit-input-placeholder {
      /* WebKit, Blink, Edge */
      color: #808080;
    }

    .input--style-2:-moz-placeholder {
      /* Mozilla Firefox 4 to 18 */
      color: #808080;
      opacity: 1;
    }

    .input--style-2::-moz-placeholder {
      /* Mozilla Firefox 19+ */
      color: #808080;
      opacity: 1;
    }

    .input--style-2:-ms-input-placeholder {
      /* Internet Explorer 10-11 */
      color: #808080;
    }

    .input--style-2:-ms-input-placeholder {
      /* Microsoft Edge */
      color: #808080;
    }

    /* ==========================================================================
       #SELECT2
       ========================================================================== */
    .select--no-search .select2-search {
      display: none !important;
    }

    .rs-select2 .select2-container {
      width: 100% !important;
      outline: none;
    }

    .rs-select2 .select2-container .select2-selection--single {
      outline: none;
      border: none;
      height: 36px;
    }

    .rs-select2 .select2-container .select2-selection--single .select2-selection__rendered {
      line-height: 36px;
      padding-left: 0;
      color: #808080;
      font-size: 16px;
      font-family: inherit;
      font-weight: 500;
    }

    .rs-select2 .select2-container .select2-selection--single .select2-selection__arrow {
      height: 34px;
      right: 4px;
      display: -webkit-box;
      display: -webkit-flex;
      display: -moz-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-pack: center;
      -webkit-justify-content: center;
      -moz-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      -webkit-box-align: center;
      -webkit-align-items: center;
      -moz-box-align: center;
      -ms-flex-align: center;
      align-items: center;
    }

    .rs-select2 .select2-container .select2-selection--single .select2-selection__arrow b {
      display: none;
    }

    .rs-select2 .select2-container .select2-selection--single .select2-selection__arrow:after {
      font-family: "Material-Design-Iconic-Font";
      content: "\f2f9";
      font-size: 18px;
      color: #ccc;
      -webkit-transition: all 0.4s ease;
      -o-transition: all 0.4s ease;
      -moz-transition: all 0.4s ease;
      transition: all 0.4s ease;
    }

    .rs-select2 .select2-container.select2-container--open .select2-selection--single .select2-selection__arrow::after {
      -webkit-transform: rotate(-180deg);
      -moz-transform: rotate(-180deg);
      -ms-transform: rotate(-180deg);
      -o-transform: rotate(-180deg);
      transform: rotate(-180deg);
    }

    .select2-container--open .select2-dropdown--below {
      border: none;
      -webkit-border-radius: 3px;
      -moz-border-radius: 3px;
      border-radius: 3px;
      -webkit-box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.15);
      -moz-box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.15);
      box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.15);
      border: 1px solid #e0e0e0;
      margin-top: 5px;
      overflow: hidden;
    }

    /* ==========================================================================
       #TITLE
       ========================================================================== */

    .title {
      text-transform: uppercase;
      font-weight: 700;
      margin-bottom: 37px;
    }

    /* ==========================================================================
       #CARD
       ========================================================================== */
    .card {
      overflow: hidden;
      -webkit-border-radius: 3px;
      -moz-border-radius: 3px;
      border-radius: 3px;
      background: #fff;
    }

    .card-2 {
      -webkit-box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.15);
      -moz-box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.15);
      box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.15);
      -webkit-border-radius: 10px;
      -moz-border-radius: 10px;
      border-radius: 10px;
      width: 100%;
      display: table;
    }

    .card-2 .card-heading {
      background: url("../images/bg-heading-02.jpg") top left/cover no-repeat;
      width: 29.1%;
      display: table-cell;
    }

    .card-2 .card-body {
      display: table-cell;
      padding: 80px 90px;
      padding-bottom: 88px;
    }

    @media (max-width: 767px) {
      .card-2 {
        display: block;
      }
      .card-2 .card-heading {
        width: 100%;
        display: block;
        padding-top: 300px;
        background-position: left center;
      }
      .card-2 .card-body {
        display: block;
        padding: 60px 50px;
      }
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

    <div class="page-wrapper bg-red p-t-180 p-b-100 font-robo">
        <div class="wrapper wrapper--w960">
            <div class="card card-2">
                <div class="card-heading"></div>
                <div class="card-body">

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
                    <button id="Register" class="btn3 btn3--radius btn3--green">Register</button>
                    <button id="Guest" class="btn4 btn4--radius btn3--green">Guest</button>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
      document.getElementById("Go_back").onclick = function () {
          location.href = "index.php";
      };

      document.getElementById("Register").onclick = function () {
          location.href = "regist.php";
      };

      document.getElementById("Guest").onclick = function () {
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
