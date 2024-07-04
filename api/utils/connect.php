<?php

$hostname = 'localhost';
$server_username = 'root';
$server_password = '';
$database = 'voting_portal';


$conn = new MySQLi($hostname, $server_username, $server_password);

// Use the $conn mysql object to create a database if not exist
$sql = "CREATE DATABASE IF NOT EXISTS $database";
$conn->query($sql);

// Add the database to the $conn object
$conn->select_db($database);

?>