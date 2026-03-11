<?php
session_start();
require "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {

        if ($password === $row["password"]) {

            $_SESSION["user"] = $row["username"];
            $_SESSION["role"] = $row["role"];

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Invalid username or password.";
        }

    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Analytics Login</title>
</head>

<body>

<h2>Analytics Login</h2>

<form method="POST">

<label>Username</label><br>
<input type="text" name="username" required><br><br>

<label>Password</label><br>
<input type="password" name="password" required><br><br>

<button type="submit">Login</button>

</form>

<p style="color:red;">
<?php echo htmlspecialchars($error); ?>
</p>

</body>
</html>
