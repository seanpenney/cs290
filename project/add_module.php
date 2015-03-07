<?php

ini_set('display_errors', 'On');
include('common.inc.php');

$module_name = array_key_exists("name", $_REQUEST) ? $_REQUEST["name"] : 0;
$module_url = array_key_exists("url", $_REQUEST) ? $_REQUEST["url"] : 0;
$module_functionality = array_key_exists("functionality", $_REQUEST) ? $_REQUEST["functionality"] : 0;
$module_tag = array_key_exists("tag", $_REQUEST) ? $_REQUEST["tag"] : 0;

if (!preg_match('/^.[a-zA-z0-9]+.$/', $module_name))
	die(json_encode(array('message' => 'ERROR', 'code' => 1337)));

header("Content-Type: application/json", true);

if ($result = $mysqli->query("insert into modules(name, link, functionality, tag, rating) values('$module_name', '$module_url', '$module_functionality', '$module_tag', 10)")) {
	echo json_encode(array('message' => 'success', 'code' => 1337));	
} else {
	die(json_encode(array('message' => 'ERROR', 'code' => 1337)));	
}

$mysqli->close();
?>