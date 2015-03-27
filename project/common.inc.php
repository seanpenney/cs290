<?php
$dbhost = 'oniddb.cws.oregonstate.edu';
$dbname = 'penneys-db';
$dbuser = 'penneys-db';
$dbpass = 'RnWlkt9oZX7LcU1n';

$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

if ($mysqli->connect_errno) {
	printf("Connect failed: %s\n", $mysqli->connect_error);
	exit();
}
?>