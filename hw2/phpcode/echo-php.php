<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$method     = $_SERVER['REQUEST_METHOD'];
$ip         = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$host       = $_SERVER['HTTP_HOST'] ?? '';
$datetime   = date("Y-m-d H:i:s");

$content_type = $_SERVER['CONTENT_TYPE'] ?? '';

$input_data = [];

if ($method === 'GET') {
    $input_data = $_GET;
}

elseif ($method === 'POST') {
    if (str_contains($content_type, 'application/json')) {
        $raw = file_get_contents("php://input");
        $input_data = json_decode($raw, true) ?? [];
    } else {
        $input_data = $_POST;
    }
}

elseif ($method === 'PUT' || $method === 'DELETE') {
    $raw = file_get_contents("php://input");

    if (str_contains($content_type, 'application/json')) {
        $input_data = json_decode($raw, true) ?? [];
    } else {
        parse_str($raw, $input_data);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Echo – PHP</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    pre {
      background: #f4f4f4;
      padding: 10px;
      border: 1px solid #ccc;
    }
  </style>
</head>
<body>

<h1>Echo (PHP)</h1>

<h2>Request Information</h2>
<ul>
  <li><strong>Method:</strong> <?php echo htmlspecialchars($method); ?></li>
  <li><strong>Host:</strong> <?php echo htmlspecialchars($host); ?></li>
  <li><strong>Date & Time:</strong> <?php echo $datetime; ?></li>
  <li><strong>User Agent:</strong> <?php echo htmlspecialchars($user_agent); ?></li>
  <li><strong>IP Address:</strong> <?php echo htmlspecialchars($ip); ?></li>
</ul>

<h2>Received Data</h2>

<pre><?php echo htmlspecialchars(print_r($input_data, true)); ?></pre>

</body>
</html>
