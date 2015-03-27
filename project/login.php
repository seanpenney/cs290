<?php
ini_set('display_errors', 'On');
include('common.inc.php');
header("Content-Type: application/json", true);
session_start();

$username = array_key_exists("username", $_POST) ? $_POST["username"] : 0;
$password = array_key_exists("password", $_POST) ? $_POST["password"] : 0;
$hashed_password = base64_encode(hash('sha256', $password));

if (!preg_match('/^.[a-zA-Z0-9]+.$/', $username))
	die(json_encode(array('message' => 'Problem with username')));

if (!preg_match('/^.[a-zA-Z0-9]+.$/', $password))
	die(json_encode(array('message' => 'Problem with password')));

if ($query = $mysqli->prepare("select uid from users where hpassword = ? and username = ?")) {
	$query->bind_param("ss", $hashed_password, $username);

	$query->execute();
	$result = $query->get_result();
	$row = $result->fetch_object();
	
	if (empty($row)) {
		die(json_encode(array('message' => 'Problem with database')));		
	}
	else {
		$_SESSION['username'] = $username;

		$result->close();
		
		echo json_encode(array('message' => 'Logged in'));
	}
	
} else {
	die(json_encode(array('message' => 'Problem with database')));
}

$mysqli->close();
?>