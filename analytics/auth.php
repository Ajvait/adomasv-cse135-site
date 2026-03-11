<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

function requireRole($roles) {

    if (!isset($_SESSION['role'])) {
        header("Location: login.php");
        exit();
    }

    if (!in_array($_SESSION['role'], $roles)) {

        echo "<h2>Access Denied</h2>";
        echo "<p>Your role does not have permission to view this page.</p>";
        echo '<br><a href="dashboard.php">Back to Dashboard</a>';
        exit();
    }
}
?>