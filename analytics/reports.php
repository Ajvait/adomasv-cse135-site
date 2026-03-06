<?php
require "auth.php";
require "db.php";

$query = "
SELECT id, session_id, event_type, url, created_at
FROM events
ORDER BY created_at DESC
LIMIT 50
";

$result = $conn->query($query);
?>

<h2>Recent Analytics Events</h2>

<table border="1" cellpadding="5">

<tr>
<th>ID</th>
<th>Session</th>
<th>Event Type</th>
<th>URL</th>
<th>Timestamp</th>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>

<tr>
<td><?php echo $row["id"]; ?></td>
<td><?php echo $row["session_id"]; ?></td>
<td><?php echo $row["event_type"]; ?></td>
<td><?php echo $row["url"]; ?></td>
<td><?php echo $row["created_at"]; ?></td>
</tr>

<?php } ?>

</table>

<br>

<a href="dashboard.php">Back to Dashboard</a>