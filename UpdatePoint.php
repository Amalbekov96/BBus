<?php
session_start();
require_once ("config.php");
date_default_timezone_set('Asia/Almaty');
header("Content-Type: text/html; Charset=UTF-8");
$ip = $_SERVER['REMOTE_ADDR'];

$id = $_SESSION['id'];
$username = $_SESSION['username'];



    
if (!empty($_GET)) {

    if (!$conn) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
//    $id = $_SESSION['id'];
	$lat = number_format((float)$_GET['lat'], 8, '.', '');// need to sanitize any USER INPUT
	$lng = number_format((float)$_GET['lng'], 8, '.', ''); // need to sanitize any USER INPUT

	//$id = $_GET['id'];
    
    echo $lat;

	$sql = "UPDATE Markers SET lat = $lat, lng = $lng WHERE user_id = $id";

		mysqli_query($conn, "UPDATE Users set last_submission = now() where id = '$id'");

	if (mysqli_query($conn, $sql)) {

		http_response_code(205);
    } else {
		http_response_code(200);
		logError(mysqli_error($conn));
	}
}
?>
