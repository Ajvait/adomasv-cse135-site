<?php
// environment.php
// CSE 135 HW2 – Environment Variables (PHP)

// Disable caching (matches Perl reference behavior)
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Environment Variables – PHP</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 6px 10px;
      text-align: left;
      font-family: monospace;
      vertical-align: top;
    }
    th {
      background-color: #f4f4f4;
    }
  </style>
</head>
<body>

  <h1>Environment Variables (PHP)</h1>

  <table>
    <tr>
      <th>Variable</th>
      <th>Value</th>
    </tr>

    <?php foreach ($_SERVER as $key => $value): ?>
      <tr>
        <td><?php echo htmlspecialchars($key); ?></td>
        <td><?php echo htmlspecialchars((string)$value); ?></td>
      </tr>
    <?php endforeach; ?>

  </table>

</body>
</html>
