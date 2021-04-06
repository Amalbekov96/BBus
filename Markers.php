<?php
session_start();
require_once ("config.php");
date_default_timezone_set('Asia/Almaty');
header("Content-Type: text/html; Charset=UTF-8");
$ip = $_SERVER['REMOTE_ADDR'];
    

if (!empty($_GET)) {
    
    
    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    
    
    if(isset($_GET['user_id'])) {
        
        $user_id = $_GET['user_id'];
        
        $result = mysqli_query($conn,"SELECT * FROM Markers WHERE user_id = $user_id");
         $json = [];
         while($row = mysqli_fetch_assoc($result)){
          $json[] = $row;
         }

        $json_encoded = json_encode($json,JSON_NUMERIC_CHECK );

         echo($json_encoded);
         
         http_response_code(205);
        
    } else if(isset($_GET['line_number'])){
        
        $line_number = $_GET['line_number'];
        
        $result = mysqli_query($conn,"SELECT * FROM Markers WHERE trans_num = $line_number OR point_type = 'Passenger'");
         $json = [];
        
         while($row = mysqli_fetch_assoc($result)){
          $json[] = $row;
         }

         $json_encoded = json_encode($json,JSON_NUMERIC_CHECK );

         echo($json_encoded);

    } else if(isset($_GET['search_num'])) {
        
        $search_num = $_GET['search_num'];
        
        $result = mysqli_query($conn,"SELECT * FROM Markers WHERE trans_num = $search_num");
         $json = [];
        
         while($row = mysqli_fetch_assoc($result)){
          $json[] = $row;
         }

         $json_encoded = json_encode($json,JSON_NUMERIC_CHECK );

         echo($json_encoded);

    } else if(isset($_GET['user_info'])) {
        
        $user_info = $_SESSION['id'];
        
        $result = mysqli_query($conn,"SELECT * FROM Users WHERE id = $user_info");
         $json = [];
        
         while($row = mysqli_fetch_assoc($result)){
          $json[] = $row;
         }

         $json_encoded = json_encode($json,JSON_NUMERIC_CHECK );

         echo($json_encoded);
    
    } else if(isset($_GET['line'])) {
        
        $line = $_GET['line'];
        
        $result = mysqli_query($conn,"SELECT * FROM `Lines` WHERE lineNumber = $line");
         $json = [];
        
         while($row = mysqli_fetch_assoc($result)){
          $json[] = $row;
         }

         $json_encoded = json_encode($json,JSON_NUMERIC_CHECK );

         echo($json_encoded);
    
    } else {
         $result = mysqli_query($conn,"SELECT * FROM Markers");
         $json = [];
        
         while($row = mysqli_fetch_assoc($result)){
          $json[] = $row;
         }

         $json_encoded = json_encode($json,JSON_NUMERIC_CHECK );

         echo($json_encoded);
    }


} else if(!empty($_POST)){
    
    
    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    
    
    
    if(isset($_POST['user_id'])) { //updating the marker level
        
        if($_POST['type'] == 0) {
            
            $new_level = $_POST['new_level'];
            $user_id = $_POST['user_id'];
            
             if(mysqli_query($conn,"UPDATE Markers SET level=$new_level WHERE user_id=$user_id")) {
                 echo '200';
             } else {
                 echo '201';
             }
             
            mysqli_close($conn);
            
        } else if($_POST['type'] == 1){ // putting a report on the marker and user;
            
            $user_id = $_POST['user_id'];
            
            $result = mysqli_query($conn,"SELECT * FROM Markers where user_id = $user_id");
            
            $row = mysqli_fetch_assoc($result);
            $new_report = $row['report'] + 1;
            
            if(($new_report) > 1){
                if(mysqli_query($conn,"DELETE FROM Markers where user_id = $user_id")){
                    echo 200;
                } else {
                    echo 201;
                }
            } else {
                
                if(mysqli_query($conn,"UPDATE Markers SET report=$new_report WHERE user_id=$user_id")){
                    echo 202;
                } else {
                    echo 203;
                }
            }
           
            $result = mysqli_query($conn,"SELECT * FROM Users where id = $user_id");
            
            $row = mysqli_fetch_assoc($result);
            $new_ureport = $row['user_report'] + 1;
            
            if(($new_ureport) > 3){
                        
                if(mysqli_query($conn,"INSERT INTO BlackList (user_id, added_time) VALUES ($user_id,NOW())")){
                    mysqli_query($conn,"UPDATE Users SET user_report=0 WHERE id=$user_id");
                }
                
            } else {
                mysqli_query($conn,"UPDATE Users SET user_report = $new_ureport WHERE id = $user_id");
            }
        } else if($_POST['type'] == 3){
         
        $del_id = $_POST['user_id'];
            if(mysqli_query($conn,"DELETE FROM Markers WHERE user_id = $del_id"))
            {
                echo 200;
            } else {
                echo 201;
            }
        }
    } else {
        
        if($_POST['type'] == 2){
            if(mysqli_query($conn,"DELETE FROM Markers WHERE TIMESTAMPDIFF(MINUTE,add_time,NOW()) > 54"))
            {
                echo 'yes';
            }
            
        }
    }
}
?>
