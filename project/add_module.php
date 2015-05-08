<?php
ini_set('display_errors', 'On');
include('common.inc.php');
header("Content-Type: application/json", true);

session_start();

if(!isset($_SESSION['username'])) {
	die(json_encode(array('message' => 'Not Logged In')));
}

$module_name = array_key_exists("name", $_REQUEST) ? $_REQUEST["name"] : 0;
$module_url = array_key_exists("url", $_REQUEST) ? $_REQUEST["url"] : 0;
$module_functionality = array_key_exists("functionality", $_REQUEST) ? $_REQUEST["functionality"] : 0;
$module_tag = array_key_exists("tag", $_REQUEST) ? $_REQUEST["tag"] : 0;

if (!preg_match('/^.[a-zA-z0-9\s]+.$/', $module_name))
	die(json_encode(array('message' => 'Problem with module name')));

if ($result = $mysqli->query("insert into modules(name, link, functionality, tag) values('$module_name', '$module_url', '$module_functionality', '$module_tag')")) {
	echo json_encode(array('message' => 'Successfully added module'));	
} else {
	die(json_encode(array('message' => 'Problem with database')));	
}

$mysqli->close();
?>