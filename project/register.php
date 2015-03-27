<?php
ini_set('display_errors', 'On');
include('common.inc.php');
header("Content-Type: application/json", true);
session_start();

$username = array_key_exists("username", $_REQUEST) ? $_REQUEST["username"] : 0;
$password = array_key_exists("password", $_REQUEST) ? $_REQUEST["password"] : 0;
$hashed_password = base64_encode(hash('sha256', $password));

if (!preg_match('/^.[a-zA-Z0-9]+.$/', $username))
	die(json_encode(array('message' => 'Problem with username')));

if (!preg_match('/^.[a-zA-Z0-9]+.$/', $password))
	die(json_encode(array('message' => 'Problem with password')));

$mysqli->query('create table if not exists users(uid integer not null auto_increment, username varchar(256) unique, hpassword varchar(256), primary key(uid))');

if ($query = $mysqli->prepare("insert into users(username, hpassword) values(?, ?)")) {
	$query->bind_param("ss", $username, $hashed_password);

	if ($query->execute()){
		$_SESSION['username'] = $username;
		die(json_encode(array('message' => 'Registered')));
	}
	else {
		die(json_encode(array('message' => 'Could not register')));
	}

} else {
	die(json_encode(array('message' => 'Problem with database')));
}

$mysqli->close();
?>