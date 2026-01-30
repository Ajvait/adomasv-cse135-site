<?php
$team_name = "Adomas Vaitkus";
$language  = "PHP";
$date_time = date("Y-m-d H:i:s");
$user_ip   = $_SERVER['REMOTE_ADDR'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hello HTML – PHP</title>
</head>
<body>

  <h1>Hello from <?php echo htmlspecialchars($team_name); ?>!</h1>

  <p><strong>Language:</strong> <?php echo $language; ?></p>
  <p><strong>Date & Time:</strong> <?php echo $date_time; ?></p>
  <p><strong>Your IP Address:</strong> <?php echo htmlspecialchars($user_ip); ?></p>

</body>
</html>
