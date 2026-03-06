<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Your login credentials
    $validUser = "adomasv";
    $validPass = "AjvUCSD@W26";

    if ($username === $validUser && $password === $validPass) {

        $_SESSION["user"] = $username;

        header("Location: dashboard.php");
        exit();

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