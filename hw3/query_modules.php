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

if (!preg_match('/^.[a-zA-z0-9]+.$/', $module_name))
	echo "Invalid name";

$list = array();
if ($result = $mysqli->query("select * from modules where name = " . "'" . $module_name . "'")) {
	while ($obj = $result->fetch_object()) {
		$item = array(
			"name" => $obj->name,
			"link" => $obj->link,
			"functionality" => $obj->functionality,
			"tag" => $obj->tag,
			"rating" => $obj->rating
		);
		array_push($list, $item);
	}
	$result->close();
}

header("Content-Type: application/json", true);
echo json_encode($list);

$mysqli->close();
?>