<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "analytics";
$pass = "CSE135pass!";
$db   = "cse135_analytics";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!$data) {
    http_response_code(400);
    exit("Invalid JSON");
}

$session = $data['session'] ?? '';
$type    = $data['type'] ?? '';
$url     = $data['url'] ?? '';

$payloadJson = json_encode($data);

$stmt = $conn->prepare(
    "INSERT INTO events (session_id, event_type, url, payload)
     VALUES (?, ?, ?, ?)"
);

$stmt->bind_param("ssss",
    $session,
    $type,
    $url,
    $payloadJson
);

if (!$stmt->execute()) {
    die("Insert failed: " . $stmt->error);
}

$stmt->close();
$conn->close();

http_response_code(204);