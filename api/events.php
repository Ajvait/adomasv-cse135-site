<?php

header("Content-Type: application/json; charset=utf-8");

$host = "localhost";
$user = "analytics";
$pass = "CSE135pass!";
$db   = "cse135_analytics";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(["error" => "DB connection failed"]);
  exit;
}

$method = $_SERVER["REQUEST_METHOD"];
$id = isset($_GET["id"]) ? intval($_GET["id"]) : null;

function readJsonBody() {
  $raw = file_get_contents("php://input");
  $data = json_decode($raw, true);
  return is_array($data) ? $data : null;
}

if ($method === "GET") {
  if ($id) {
    $stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    echo json_encode($row ? $row : []);
    $stmt->close();
  } else {
    $res = $conn->query("SELECT * FROM events ORDER BY id DESC LIMIT 200");
    $rows = [];
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    echo json_encode($rows);
  }
  $conn->close();
  exit;
}

if ($method === "POST") {
  $data = readJsonBody();
  if (!$data) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid JSON body"]);
    $conn->close();
    exit;
  }

  $session_id = $data["session_id"] ?? "";
  $event_type = $data["event_type"] ?? "";
  $url        = $data["url"] ?? "";
  $payload    = json_encode($data["payload"] ?? $data);

  $stmt = $conn->prepare("INSERT INTO events (session_id, event_type, url, payload) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $session_id, $event_type, $url, $payload);
  $ok = $stmt->execute();
  if (!$ok) {
    http_response_code(500);
    echo json_encode(["error" => $stmt->error]);
  } else {
    echo json_encode(["ok" => true, "id" => $stmt->insert_id]);
  }
  $stmt->close();
  $conn->close();
  exit;
}

if ($method === "PUT") {
  if (!$id) {
    http_response_code(400);
    echo json_encode(["error" => "PUT requires ?id=..."]);
    $conn->close();
    exit;
  }

  $data = readJsonBody();
  if (!$data) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid JSON body"]);
    $conn->close();
    exit;
  }

  $session_id = $data["session_id"] ?? "";
  $event_type = $data["event_type"] ?? "";
  $url        = $data["url"] ?? "";
  $payload    = json_encode($data["payload"] ?? $data);

  $stmt = $conn->prepare("UPDATE events SET session_id=?, event_type=?, url=?, payload=? WHERE id=?");
  $stmt->bind_param("ssssi", $session_id, $event_type, $url, $payload, $id);
  $ok = $stmt->execute();
  if (!$ok) {
    http_response_code(500);
    echo json_encode(["error" => $stmt->error]);
  } else {
    echo json_encode(["ok" => true, "updated" => $stmt->affected_rows]);
  }
  $stmt->close();
  $conn->close();
  exit;
}

if ($method === "DELETE") {
  if (!$id) {
    http_response_code(400);
    echo json_encode(["error" => "DELETE requires ?id=..."]);
    $conn->close();
    exit;
  }

  $stmt = $conn->prepare("DELETE FROM events WHERE id=?");
  $stmt->bind_param("i", $id);
  $ok = $stmt->execute();
  if (!$ok) {
    http_response_code(500);
    echo json_encode(["error" => $stmt->error]);
  } else {
    echo json_encode(["ok" => true, "deleted" => $stmt->affected_rows]);
  }
  $stmt->close();
  $conn->close();
  exit;
}

http_response_code(405);
echo json_encode(["error" => "Method not allowed"]);
$conn->close();