<?php
session_start();
require_once ("config.php");
date_default_timezone_set('Asia/Almaty');
header("Content-Type: text/html; Charset=UTF-8");

$ip = $_SERVER['REMOTE_ADDR'];
// if (empty($_SESSION)) {
// htmlGetBack("Anouthorized users cannot view this page","index.php" ,"Go back" );
// logError("$ip tried to access this page without authorizing");
// exit;
// }
    
    

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    
    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    
    
  $point_type = $_POST['point_type'];
  $id = $_SESSION['id'];
  $lat = number_format((float)$_POST['lat'], 8, '.', '');// need to sanitize any USER INPUT
  $lon = number_format((float)$_POST['lng'], 8, '.', ''); // need to sanitize any USER INPUT
  $line_number = $_POST['line_number'];
  $trans_type = $_POST['trans_type'];
  $direct = $_POST['direct'];
  $username = $_SESSION['username'];
  $level = $_POST['lev'];

     $user_check = mysqli_query($conn, "SELECT * FROM Markers WHERE user_id = '$id'");

     
    
    if(mysqli_num_rows($user_check) > 0){
        echo 203;
        logError("Tried to locate two busses");
    }
     
     $pointLocation = new pointLocation();
     $user_arr = mysqli_query($conn, "SELECT * from Users where uname = '$username'");
     $row = mysqli_fetch_array($user_arr,MYSQLI_ASSOC);
     $user_type = $row['user_type'];
     

    $points = array("$lat $lon");
    $bishkek;
    $inBish = "inside";
    foreach($points as $key => $point) {
        $inBish = $pointLocation->pointInPolygon($point, $bishkek);
    }
    if($inBish == "outside") {
        $message = "Your point placed does not belong to Bishkek";
        echo 201;

    logError("$username ($id) tried to submit a point outside of Bishkek: $lat $lon");
        $link = "index.php";
        $message2 = "Try again";
        htmlGetBack($message, $link, $message2);
    }
    else {
        $sverdlov; $oktyabr; $lenin; $pervomay;
        $region;
        foreach($points as $key => $point) {
        $region = $pointLocation->pointInPolygon($point, $sverdlov);
        }
        if($region == "inside") {
            $region = "sverdlov";
        }
        else {
            foreach($points as $key => $point) {
            $region = $pointLocation->pointInPolygon($point, $lenin);
        }
            if ($region == "inside") {
                $region = "lenin";
            }
            else {
                foreach($points as $key => $point) {
                $region = $pointLocation->pointInPolygon($point, $oktyabr);
            }
                if ($region == "inside") {
                $region = "oktyabr";
                }
                else {
                    foreach($points as $key => $point) {
                    $region = $pointLocation->pointInPolygon($point, $pervomay);
                    }
                    if ($region == "inside") {
                    $region = "pervomay";
                    }
                    else {
                        $region = "undefined";
                        $today;
                        logError("Point belongs to bishkek, but not to any region: $lat $lon");
                    }
                }
            }
        }

     
//        $last = DateTime::createFromFormat ( "Y-m-d H:i:s", $row["lastSubmission"]);
//        $available = date_add($last, date_interval_create_from_date_string('30 minutes'));
        $now = new Datetime();

//        if ($available > $now) {
//        $link = 'index.php';
//        $message = "Go back";
//        print("You cannot submit now, your next submission is available on ");
//        http_response_code(202);
//        exit;
//        echo date_format($available, 'Y-m-d H:i:s');
//        logError("$username($id) tried to submit before his allowance");
//        htmlGetBack("", $link, $message);
//        }
//        else {
//
        
            if($point_type == 'Driver'){
                $level = 0;
                $sql = "INSERT INTO Markers (name, user_id, region, lat, lng, direct, point_type, add_time, trans_type, trans_num, level) VALUES ('".$username."', '".$id."', '".$region."', '".$lat."', '".$lon."', '".$direct."', '".$point_type."', NOW(), '".$trans_type."', '".$line_number."', '".$level."')";

                mysqli_query($conn, "UPDATE Users set last_submission = NOW() where id = '$id'");
               
                if (mysqli_query($conn, $sql)) {

                    echo '200'; exit;

                }
                else {
                    echo '202'; exit;
                    
                //logError(mysqli_error($conn));
                }
            } else {
                
//                echo $username;
//                echo $id;
//                echo $region;
//                echo $lat;
//                echo $lon;
//                echo $direct;
//                echo $point_type;
//                echo $trans_type;
//                echo $line_number;
//                echo $level;
                
                    $sql = "INSERT INTO Markers (name, user_id, region, lat, lng, direct, point_type, add_time, trans_type, trans_num, level) VALUES ('".$username."', '".$id."', '".$region."', '".$lat."', '".$lon."', '".$direct."', '".$point_type."', NOW(), '".$trans_type."', '".$line_number."', '".$level."')";

                    mysqli_query($conn, "UPDATE Users set last_submission = NOW() where id = '$id'");
                   
                    if (mysqli_query($conn, $sql)) {

                        echo '200'; exit;
                    }
                    else {
                        echo '202' exit;
                        
    //                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    //logError(mysqli_error($conn));
                    }
                
            }
//        }
    }
    

} else {
    
}

?> 
