<?php

session_start();
require_once "db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";

$result = $conn->query($sql);

if($result->num_rows == 1){

$row = $result->fetch_assoc();

$_SESSION['user'] = $row['username'];
$_SESSION['role'] = $row['role'];

header("Location: dashboard.php");
exit();

}
else{

$error = "Invalid login";

}

}

?>

<h2>Analytics Login</h2>

<form method="POST">

Username:<br>
<input type="text" name="username"><br><br>

Password:<br>
<input type="password" name="password"><br><br>

<button type="submit">Login</button>

</form>

<?php
if(isset($error)){
echo $error;
}
?>