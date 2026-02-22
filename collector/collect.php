<?php

header("Access-Control-Allow-Origin: https://test.adomasvcse135.site");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

$host = "localhost";
$user = "analytics";
$pass = "CSE135pass!";
$db   = "cse135_analytics";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    http_response_code(500);
    die("DB connection failed");
}

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if ($data) {
    $stmt = $conn->prepare(
        "INSERT INTO events (session, type, url, timestamp, payload)
         VALUES (?, ?, ?, ?, ?)"
    );

    $payloadJson = json_encode($data);

    $stmt->bind_param(
        "sssss",
        $data['session'],
        $data['type'],
        $data['url'],
        $data['timestamp'],
        $payloadJson
    );

    $stmt->execute();
    $stmt->close();
}

$conn->close();
http_response_code(204);