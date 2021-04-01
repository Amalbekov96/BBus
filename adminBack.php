<?php
session_start();
require_once ("config.php");
date_default_timezone_set('Asia/Almaty');
header("Content-Type: text/html; Charset=UTF-8");

if (!empty($_GET)) {
   
    
    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    if(isset($_GET['type'])){
        $type = (int)$_GET['type'];
        if($type == 0){
             $result = mysqli_query($conn,"SELECT * FROM `Lines`");
             $json = [];
            
             while($row = mysqli_fetch_assoc($result)){
              $json[] = $row;
             }
            
             $json_encoded = json_encode($json,JSON_NUMERIC_CHECK );

             echo($json_encoded);
        } else if($type == 1){
            $result = mysqli_query($conn,"SELECT * FROM `Users`");
             $json = [];
            
             while($row = mysqli_fetch_assoc($result)){
              $json[] = $row;
             }
            
             $json_encoded = json_encode($json,JSON_NUMERIC_CHECK );

             echo($json_encoded);
        }
        
    } else {
        if(isset($_GET['search_num'])) {
            
            $search_num = $_GET['search_num'];
           
            $result = mysqli_query($conn,"SELECT * FROM `Lines` WHERE lineNumber = $search_num");
             $json = [];
            
             while($row = mysqli_fetch_assoc($result)){
              $json[] = $row;
             }

             $json_encoded = json_encode($json,JSON_NUMERIC_CHECK );

             echo($json_encoded);
            
        } else if(isset($_GET['user_search'])){
            $search_num = (string)$_GET['user_search'];
            
            $result = mysqli_query($conn,"SELECT * FROM Users WHERE TRIM(uname) = '$search_num'");
             $json = [];
            
             while($row = mysqli_fetch_assoc($result)){
              $json[] = $row;
             }

             $json_encoded = json_encode($json,JSON_NUMERIC_CHECK );

             echo($json_encoded);
        }
    }
} else {
    if($_POST['type'] == 1){

        $lineNumber = $_POST['lineNumber'];
        if(mysqli_query($conn,"DELETE FROM `Lines` WHERE lineNumber = $lineNumber")){
            echo("ok");
        }
    } else if($_POST['type'] == 2){

        $line_number = $_POST['line_number'];
        $trans_type = $_POST['trans_type'];
        $points_str = $_POST['points_str'];
        
        if(mysqli_query($conn,"INSERT INTO `Lines` (lineNumber, addDate, trans_type, coordinates) VALUES ($line_number, NOW(), '$trans_type', '$points_str')")){
            echo 200;
        } else {
            echo 201;
        }
    } else if($_POST['type'] == 3){
        $userId = $_POST['lineNumber'];
        if(mysqli_query($conn,"DELETE FROM `Users` WHERE id = $userId")){
            echo("ok");
        }
    }
}

   
?>
