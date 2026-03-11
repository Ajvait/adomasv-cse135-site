<?php
require "auth.php";
?>

<h1>Analytics Dashboard</h1>

<p>Welcome <?php echo htmlspecialchars($_SESSION['user']); ?></p>
<p>Role: <?php echo htmlspecialchars($_SESSION['role']); ?></p>

<ul>
    <li><a href="reports.php">View Reports</a></li>

    <?php if ($_SESSION['role'] === "super_admin" || $_SESSION['role'] === "analyst") { ?>
        <li><a href="charts.php">View Analytics Charts</a></li>
    <?php } ?>

    <?php if ($_SESSION['role'] === "super_admin") { ?>
        <li><a href="manage_users.php">Manage Users</a></li>
    <?php } ?>

    <li><a href="logout.php">Logout</a></li>
</ul>