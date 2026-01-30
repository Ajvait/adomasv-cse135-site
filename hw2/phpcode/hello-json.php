<?php
header('Content-Type: application/json');

$response = [
    "greeting"  => "Hello from Adomas Vaitkus!",
    "language"  => "PHP",
    "datetime"  => date("Y-m-d H:i:s"),
    "ip"        => $_SERVER['REMOTE_ADDR']
];

echo json_encode($response, JSON_PRETTY_PRINT);
