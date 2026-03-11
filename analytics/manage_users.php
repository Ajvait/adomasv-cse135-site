<?php
require "auth.php";
requireRole(["super_admin"]);
require "db.php";

$query = "SELECT id, username, role FROM users ORDER BY id ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
</head>
<body>

<h1>Manage Users</h1>

<p>Logged in as: <?php echo htmlspecialchars($_SESSION["user"]); ?></p>
<p>Role: <?php echo htmlspecialchars($_SESSION["role"]); ?></p>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row["id"]); ?></td>
        <td><?php echo htmlspecialchars($row["username"]); ?></td>
        <td><?php echo htmlspecialchars($row["role"]); ?></td>
    </tr>
    <?php } ?>
</table>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>