<?php
ini_set('display_errors', 'On');
include('common.inc.php');
header("Content-Type: application/json", true);

session_start();

if(!isset($_SESSION['username'])) {
	die(json_encode(array('message' => 'Not Logged In')));
}

$module_name = array_key_exists("name", $_REQUEST) ? $_REQUEST["name"] : 0;
$module_rating = array_key_exists("rating", $_REQUEST) ? $_REQUEST["rating"] : 0;

if (!preg_match('/^.[a-zA-z0-9]+.$/', $module_name))
	die(json_encode(array('message' => 'Problem with module name')));
	
if (!preg_match('/^[0-9]{1}$/', $module_rating))
	die(json_encode(array('message' => 'Problem with module rating')));

if ($result = $mysqli->query("insert into ratings(name, rating) values('$module_name', '$module_rating')")) {
	echo json_encode(array('message' => 'Successfully entered rating'));	
} else {
	die(json_encode(array('message' => 'Problem with database')));	
}

$mysqli->close();
?>