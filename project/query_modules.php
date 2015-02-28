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
	die(json_encode(array('message' => 'ERROR', 'code' => 1337)));

$list = array();
if ($result = $mysqli->query("select * from modules where name = " . "'" . $module_name . "'")) {
	while ($obj = $result->fetch_object()) {
		$new_result = $mysqli->query("select avg(rating) as rating_average from ratings where name = " . "'" . $module_name . "'");
		$new_obj = $new_result->fetch_object();
		$item = array(
			"name" => $obj->name,
			"link" => $obj->link,
			"functionality" => $obj->functionality,
			"tag" => $obj->tag,
			"rating" => number_format((float)$new_obj->rating_average, 2, '.', '')
		);
		array_push($list, $item);
	}
	$result->close();
}

header("Content-Type: application/json", true);
if (empty($list)) {
	die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
}
else {
	echo json_encode($list);
}
$mysqli->close();
?>