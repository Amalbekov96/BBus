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

    $result = mysqli_query($conn,"SELECT * FROM Markers");
    $json = [];
    while($row = mysqli_fetch_assoc($result)){
     $json[] = $row;
    }

   $json_encoded = json_encode($json,JSON_NUMERIC_CHECK );

    echo($json_encoded);
    
    http_response_code(205);
}
?>
