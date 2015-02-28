<?php

ini_set('display_errors', 'On');

$dbhost = 'oniddb.cws.oregonstate.edu';
$dbname = 'penneys-db';
$dbuser = 'penneys-db';
$dbpass = 'xSTsLRT7jfXSo5ZM';

$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
	exit();
}

$module_name = array_key_exists("name", $_REQUEST) ? $_REQUEST["name"] : 0;
$module_rating = array_key_exists("rating", $_REQUEST) ? $_REQUEST["rating"] : 0;

if (!preg_match('/^.[a-zA-z0-9]+.$/', $module_name))
	die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
	
if (!preg_match('/^[0-9]{1}$/', $module_rating))
	die(json_encode(array('message' => 'ERROR', 'code' => 1337)));

header("Content-Type: application/json", true);

if ($result = $mysqli->query("insert into ratings(name, rating) values('$module_name', '$module_rating')")) {
	echo json_encode(array('message' => 'success', 'code' => 1337));	
} else {
	die(json_encode(array('message' => 'ERROR', 'code' => 1337)));	
}

$mysqli->close();
?>