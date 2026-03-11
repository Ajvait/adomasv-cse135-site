<?php
require "auth.php";
?>

<h1>Analytics Dashboard</h1>

<p>Welcome <?php echo $_SESSION['user']; ?></p>
<p>Role: <?php echo $_SESSION['role']; ?></p>

<ul>
    <li><a href="reports.php">View Raw Event Table</a></li>
    <li><a href="charts.php">View Analytics Charts</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>