<?php

require_once "auth.php";

requireLogin();

?>

<h1>Analytics Dashboard</h1>

<p>Welcome <?php echo $_SESSION['user']; ?></p>

<hr>

<a href="reports.php">View Reports</a><br><br>

<a href="charts.php">View Charts</a><br><br>

<a href="logout.php">Logout</a>