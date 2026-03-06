<?php

$host = "localhost";
$user = "analytics";
$password = "CSE135pass!";
$database = "cse135_analytics";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>