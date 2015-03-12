<?php
ini_set('display_errors', 'On');
include('common.inc.php');
session_start();

$username = array_key_exists("username", $_REQUEST) ? $_REQUEST["username"] : 0;
$password = array_key_exists("password", $_REQUEST) ? $_REQUEST["password"] : 0;
$hashed_password = base64_encode(hash('sha256', $password));

header("Content-Type: application/json", true);

if (!preg_match('/^.[a-zA-Z0-9]+.$/', $username))
	die(json_encode(array('message' => 'Problem with username')));

if (!preg_match('/^.[a-zA-Z0-9]+.$/', $password))
	die(json_encode(array('message' => 'Problem with password')));

if ($query = $mysqli->prepare("select uid from users where username = ? and hpassword = ?")) {
	$query->bind_param("ss", $username, $hashed_password);

	$query->execute();
	$result = $query->get_result();
	$row = $result->fetch_object();

	$_SESSION['uid'] = $row->uid;
	$_SESSION['username'] = $username;

	$result->close();
	
	echo json_encode(array('message' => 'Logged in'));	
	
} else {
	die(json_encode(array('message' => 'Problem with database')));
}

$mysqli->close();
?>