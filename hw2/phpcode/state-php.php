<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

session_start();

if (!isset($_SESSION['visits'])) {
    $_SESSION['visits'] = 0;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['clear'])) {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['visits'] = 0;
        $message = "Session cleared.";
    }

    elseif (isset($_POST['username'])) {
        $_SESSION['username'] = $_POST['username'];
        $message = "Data saved.";
    }
}

$_SESSION['visits']++;

$username = $_SESSION['username'] ?? "(not set)";
$visits   = $_SESSION['visits'];
$session_id = session_id();
$datetime = date("Y-m-d H:i:s");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>State – PHP</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    .box {
      border: 1px solid #ccc;
      padding: 12px;
      margin-bottom: 20px;
      background: #f9f9f9;
    }
  </style>
</head>
<body>

<h1>State Demo (PHP)</h1>

<?php if ($message): ?>
  <p><strong><?php echo htmlspecialchars($message); ?></strong></p>
<?php endif; ?>

<div class="box">
  <h2>Current Session State</h2>
  <ul>
    <li><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></li>
    <li><strong>Visits:</strong> <?php echo $visits; ?></li>
    <li><strong>Session ID:</strong> <?php echo htmlspecialchars($session_id); ?></li>
    <li><strong>Date & Time:</strong> <?php echo $datetime; ?></li>
  </ul>
</div>

<div class="box">
  <h2>Set State</h2>
  <form method="POST">
    <label>
      Username:
      <input type="text" name="username">
    </label>
    <br><br>
    <button type="submit">Save</button>
  </form>
</div>

<div class="box">
  <h2>Clear State</h2>
  <form method="POST">
    <input type="hidden" name="clear" value="1">
    <button type="submit">Clear Session</button>
  </form>
</div>

</body>
</html>
