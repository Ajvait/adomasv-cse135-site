<?php

require "auth.php";
require "db.php";

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=analytics_report.html");

$query = "
SELECT id, session_id, event_type, url, created_at
FROM events
ORDER BY created_at DESC
LIMIT 100
";

$result = $conn->query($query);

echo "<h1>Analytics Report</h1>";

echo "<table border='1' cellpadding='5'>";

echo "<tr>
<th>ID</th>
<th>Session</th>
<th>Event</th>
<th>URL</th>
<th>Time</th>
</tr>";

while($row = $result->fetch_assoc()){

echo "<tr>";

echo "<td>".$row["id"]."</td>";
echo "<td>".$row["session_id"]."</td>";
echo "<td>".$row["event_type"]."</td>";
echo "<td>".$row["url"]."</td>";
echo "<td>".$row["created_at"]."</td>";

echo "</tr>";
}

echo "</table>";