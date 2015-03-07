<?php

ini_set('display_errors', 'On');
include('common.inc.php');

$module_tag = array_key_exists("tag", $_REQUEST) ? $_REQUEST["tag"] : 0;

if (!preg_match('/^.[a-zA-z0-9\s]+.$/', $module_tag))
	die(json_encode(array('message' => 'ERROR', 'code' => 1336)));

$list = array();
if ($result = $mysqli->query("select * from modules where tag = " . "'" . $module_tag . "'")) {
	while ($obj = $result->fetch_object()) {
		$new_result = $mysqli->query("select avg(rating) as rating_average from ratings where name = " . "'" . $obj->name . "'");
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