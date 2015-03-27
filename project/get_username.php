<?php
ini_set('display_errors', 'On');
session_start();

header("Content-Type: application/json", true);

echo empty($_SESSION['username']) ? json_encode(array('message' => 'Not logged in')) : json_encode(array('message' => 'Welcome, ' . $_SESSION['username']));
?>