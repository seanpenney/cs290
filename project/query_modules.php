<?php
ini_set('display_errors', 'On');
include('common.inc.php');
header("Content-Type: application/json", true);

$module_name = array_key_exists("name", $_REQUEST) ? $_REQUEST["name"] : 0;

if (!preg_match('/^.[a-zA-z0-9 ]+.$/', $module_name))
	die(json_encode(array('message' => 'Problem with name')));

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
		$new_result->close();
		array_push($list, $item);
	}
	$result->close();
}

if (empty($list)) {
	die(json_encode(array('message' => 'ERROR')));
}
else {
	echo json_encode($list);
}
$mysqli->close();
?>