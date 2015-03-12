<?php
ini_set('display_errors', 'On');

$hashed_password = base64_encode(hash('sha256', "penney"));

header("Content-Type: application/json", true);

$list = array();
$item = array(
	"hashed password" => $hashed_password
);
array_push($list, $item);

echo json_encode($list);

?>