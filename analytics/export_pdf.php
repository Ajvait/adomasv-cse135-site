<?php

require "auth.php";
require "db.php";

require __DIR__ . "/vendor/autoload.php";

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$query = "
SELECT id, session_id, event_type, url, created_at
FROM events
ORDER BY created_at DESC
LIMIT 100
";

$result = $conn->query($query);

$html = "<h1>Analytics Report</h1>";
$html .= "<table border='1' cellpadding='5'>";
$html .= "<tr>
<th>ID</th>
<th>Session</th>
<th>Event</th>
<th>URL</th>
<th>Time</th>
</tr>";

while($row = $result->fetch_assoc()){

$html .= "<tr>";

$html .= "<td>".$row["id"]."</td>";
$html .= "<td>".$row["session_id"]."</td>";
$html .= "<td>".$row["event_type"]."</td>";
$html .= "<td>".$row["url"]."</td>";
$html .= "<td>".$row["created_at"]."</td>";

$html .= "</tr>";
}

$html .= "</table>";

$dompdf->loadHtml($html);

$dompdf->setPaper("A4","portrait");

$dompdf->render();

$dompdf->stream("analytics_report.pdf");

?>