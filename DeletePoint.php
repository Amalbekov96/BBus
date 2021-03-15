<?php
session_start();
require_once("config.php");
$conn;
//function toFile($mes) {
//    $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
//    fwrite($myfile, $mes);
//    fclose($myfile);
//}


//$user = $_GET['uname'];
$action = $_GET['action'];   // 0 = delete 1 = report
//$lat = round($_GET['lat'],8);
//$lng = round($_GET['lng'],8);

//$user_arr = mysqli_query($conn, "SELECT * from markers where ABS(lng-$lng) < 0.00001 and ABS(lat-$lat) < 0.00001");
//$row=mysqli_fetch_array($user_arr,MYSQLI_ASSOC);
//
//if (empty($row)) {
//    print("point does not exist $lng $lat");
//    logError("$user reported an inexistent point");
//    exit;
//}
//
//$name = $row['name'];

if ($action == 0) {
    
//    if ($name == $_SESSION['username']) {

        $id = $_SESSION['id'];
//        mysqli_query($conn, "DELETE FROM markers WHERE ABS(lng-$lng) < 0.00001 and ABS(lat-$lat) < 0.00001");

    echo $id;
    echo "my name";
        mysqli_query($conn, "DELETE FROM Markers WHERE user_id = $id");

        //htmlGetBack("The point has been successfully deleted","index.php", "Go back");
        http_response_code(200);
//    }
//    else {
//        print ("You cannot delete points that you didn't place");
//        exit;
//    }
}
    
//else if($action == 1) {
//
//    toFile('action = 1');
//    $idreport1 = $row['idreport1'];
//    $idreport2 = $row['idreport2'];
//    $userId = $_SESSION['id'];
//
//    if ($_SESSION['id'] == $idreport1 or $_SESSION['id'] == $idreport2) {
//        htmlGetBack("One person can only report a point once","index.php" , "Go back");
////         http_response_code(201); //201 = user reports twice or more
//
//        header('HTTP/1.1 201 Internal Server Error');
//        if(headers_sent()){
//            toFile(' 201 sent');
//        } else {
//             toFile(' not 201 sent');
//        }
////
//
//        $today;
//        logError("$username($userId) tried to report for the second time");
//        toFile('second time report');
//
//    }
//    else {
//        if ($row['reports'] >= 1) {
//            mysqli_query($conn, "DELETE FROM markers WHERE ABS(lng-$lng) < 0.00001 and ABS(lat-$lat) < 0.00001");
//            htmlGetBack("Treshold for deletion has been reached, point has been deleted","index.php", "Go back");
//            http_response_code(202); //treshhold
//            http_response_code();
//            toFile('reached to be deleted');
//        }
//        else {
//            toFile('reporter');
//            if ($row['reports'] == 1) {
//                mysqli_query($conn, "UPDATE markers SET idreport2 = '$userId', reports = 2 WHERE ABS(lng-$lng) < 0.00001 and ABS(lat-$lat) < 0.00001");
//            }
//            else {
//                mysqli_query($conn, "UPDATE markers SET idreport1 = $userId, reports = 1 WHERE ABS(lng-$lng) < 0.00001 and ABS(lat-$lat) < 0.00001");
//            }
//
//            htmlGetBack("Your report has been saved", "index.php", "Go back");
//            http_response_code(203); // report saved
//            http_response_code();
//        }
//    }
//}
    
?>
