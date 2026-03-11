<?php
require "auth.php";
requireRole(["super_admin"]);
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_user"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    $stmt = $conn->prepare("INSERT INTO users (username,password,role) VALUES (?,?,?)");
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();
}

if (isset($_GET["delete"])) {

    $id = $_GET["delete"];

    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
}

$result = $conn->query("SELECT id, username, role FROM users ORDER BY id ASC");

?>

<h1>Manage Users</h1>

<p>Logged in as: <?php echo $_SESSION["user"]; ?></p>

---

<h2>Create New User</h2>

<form method="POST">

Username<br>
<input type="text" name="username" required><br><br>

Password<br>
<input type="text" name="password" required><br><br>

Role<br>
<select name="role">

<option value="viewer">viewer</option>
<option value="analyst">analyst</option>
<option value="super_admin">super_admin</option>

</select>

<br><br>

<button type="submit" name="add_user">Create User</button>

</form>

---

<h2>Existing Users</h2>

<table border="1" cellpadding="5">

<tr>
<th>ID</th>
<th>Username</th>
<th>Role</th>
<th>Action</th>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>

<tr>

<td><?php echo $row["id"]; ?></td>
<td><?php echo $row["username"]; ?></td>
<td><?php echo $row["role"]; ?></td>

<td>
<a href="manage_users.php?delete=<?php echo $row["id"]; ?>">
Delete
</a>
</td>

</tr>

<?php } ?>

</table>

<br>

<a href="dashboard.php">Back to Dashboard</a>