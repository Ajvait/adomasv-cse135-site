<?php
require "auth.php";
requireRole(["super_admin","analyst"]);
require "db.php";

$eventQuery = "
SELECT event_type, COUNT(*) AS total
FROM events
GROUP BY event_type
ORDER BY total DESC
";

$eventResult = $conn->query($eventQuery);

$eventLabels = [];
$eventData = [];

while ($row = $eventResult->fetch_assoc()) {
    $eventLabels[] = $row["event_type"];
    $eventData[] = $row["total"];
}


$pageQuery = "
SELECT url, COUNT(*) AS visits
FROM events
GROUP BY url
ORDER BY visits DESC
LIMIT 10
";

$pageResult = $conn->query($pageQuery);

$pageLabels = [];
$pageData = [];

while ($row = $pageResult->fetch_assoc()) {
    $pageLabels[] = $row["url"];
    $pageData[] = $row["visits"];
}


$sessionQuery = "
SELECT session_id, COUNT(*) AS events
FROM events
GROUP BY session_id
ORDER BY events DESC
LIMIT 10
";

$sessionResult = $conn->query($sessionQuery);

$sessionLabels = [];
$sessionData = [];

while ($row = $sessionResult->fetch_assoc()) {
    $sessionLabels[] = $row["session_id"];
    $sessionData[] = $row["events"];
}
?>

<h1>Analytics Charts</h1>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<h2>Event Type Distribution</h2>

<canvas id="eventChart" width="400" height="200"></canvas>

<script>
new Chart(document.getElementById("eventChart"), {

    type: "pie",

    data: {
        labels: <?php echo json_encode($eventLabels); ?>,
        datasets: [{
            label: "Event Count",
            data: <?php echo json_encode($eventData); ?>,
            backgroundColor: ["red","blue","green","orange","purple"]
        }]
    }

});
</script>

<h3>Event Type Table</h3>

<table border="1" cellpadding="5">
<tr>
<th>Event Type</th>
<th>Total Events</th>
</tr>

<?php
$eventResult = $conn->query($eventQuery);
while ($row = $eventResult->fetch_assoc()) {
?>
<tr>
<td><?php echo $row["event_type"]; ?></td>
<td><?php echo $row["total"]; ?></td>
</tr>
<?php } ?>
</table>

<p>
<b>Analyst Comment:</b> Mouse movement events happen most frequently because they are triggered continuously as users move their cursor across the page. Click events are fewer but represent intentional interactions with page elements. This is important to note when bots are entering the page and not using mouse movements.
</p>
<hr>

<h2>Page Popularity</h2>

<canvas id="pageChart" width="400" height="200"></canvas>

<script>
new Chart(document.getElementById("pageChart"), {

    type: "bar",

    data: {
        labels: <?php echo json_encode($pageLabels); ?>,
        datasets: [{
            label: "Page Visits",
            data: <?php echo json_encode($pageData); ?>,
            backgroundColor: "rgba(54,162,235,0.6)"
        }]
    }

});
</script>

<h3>Page Popularity Table</h3>

<table border="1" cellpadding="5">
<tr>
<th>URL</th>
<th>Visits</th>
</tr>

<?php
$pageResult = $conn->query($pageQuery);
while ($row = $pageResult->fetch_assoc()) {
?>
<tr>
<td><?php echo $row["url"]; ?></td>
<td><?php echo $row["visits"]; ?></td>
</tr>
<?php } ?>
</table>

<p><b>Analyst Comment:</b> Pages with higher event counts indicate areas where users spend more time interacting. The homepage typically generates the most activity because users start their sessions there.</p>

<hr>

<h2>Session Activity</h2>

<canvas id="sessionChart" width="400" height="200"></canvas>

<script>
new Chart(document.getElementById("sessionChart"), {

    type: "bar",

    data: {
        labels: <?php echo json_encode($sessionLabels); ?>,
        datasets: [{
            label: "Events Per Session",
            data: <?php echo json_encode($sessionData); ?>,
            backgroundColor: "rgba(255,99,132,0.6)"
        }]
    }

});
</script>

<h3>Session Activity Table</h3>

<table border="1" cellpadding="5">
<tr>
<th>Session ID</th>
<th>Events</th>
</tr>

<?php
$sessionResult = $conn->query($sessionQuery);
while ($row = $sessionResult->fetch_assoc()) {
?>
<tr>
<td><?php echo $row["session_id"]; ?></td>
<td><?php echo $row["events"]; ?></td>
</tr>
<?php } ?>
</table>

<p><b>Analyst Comment:</b> Sessions with higher event counts likely represent users who spent more time interacting with the site. Sessions with fewer events may indicate short visits or quick exits.</p>

<br>

<a href="dashboard.php">Back to Dashboard</a>