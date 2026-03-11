<?php
require "auth.php";
require "db.php";

/* ---------------------------
   RAW EVENT TABLE (original)
----------------------------*/

$query = "
SELECT id, session_id, event_type, url, created_at
FROM events
ORDER BY created_at DESC
LIMIT 50
";

$result = $conn->query($query);


/* ---------------------------
   TRAFFIC DATA (per day)
----------------------------*/

$traffic_labels = [];
$traffic_data = [];

$sql = "
SELECT DATE(created_at) as day, COUNT(*) as total
FROM events
GROUP BY DATE(created_at)
ORDER BY day
";

$resultTraffic = $conn->query($sql);

while ($row = $resultTraffic->fetch_assoc()) {
    $traffic_labels[] = $row["day"];
    $traffic_data[] = $row["total"];
}


/* ---------------------------
   PAGE POPULARITY
----------------------------*/

$page_labels = [];
$page_data = [];

$sql = "
SELECT url, COUNT(*) as views
FROM events
GROUP BY url
ORDER BY views DESC
";

$resultPages = $conn->query($sql);

while ($row = $resultPages->fetch_assoc()) {
    $page_labels[] = $row["url"];
    $page_data[] = $row["views"];
}


/* ---------------------------
   EVENT TYPES
----------------------------*/

$event_labels = [];
$event_data = [];

$sql = "
SELECT event_type, COUNT(*) as total
FROM events
GROUP BY event_type
ORDER BY total DESC
";

$resultEvents = $conn->query($sql);

while ($row = $resultEvents->fetch_assoc()) {
    $event_labels[] = $row["event_type"];
    $event_data[] = $row["total"];
}

?>

<!DOCTYPE html>
<html>

<head>
<title>Analytics Reports</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

<h1>Analytics Reports</h1>

<a href="dashboard.php">Dashboard</a> |
<a href="logout.php">Logout</a>

<hr>

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

<hr>

<h2>Traffic Report</h2>

<canvas id="trafficChart" width="400" height="200"></canvas>

<script>

new Chart(document.getElementById('trafficChart'), {

type: 'line',

data: {
labels: <?php echo json_encode($traffic_labels); ?>,
datasets: [{
label: 'Events Per Day',
data: <?php echo json_encode($traffic_data); ?>,
borderWidth: 2
}]
}

});

</script>

<hr>

<h2>Page Popularity Report</h2>

<canvas id="pageChart" width="400" height="200"></canvas>

<script>

new Chart(document.getElementById('pageChart'), {

type: 'bar',

data: {
labels: <?php echo json_encode($page_labels); ?>,
datasets: [{
label: 'Events Per Page',
data: <?php echo json_encode($page_data); ?>
}]
}

});

</script>

<hr>

<h2>Event Type Report</h2>

<canvas id="eventChart" width="400" height="200"></canvas>

<script>

new Chart(document.getElementById('eventChart'), {

type: 'pie',

data: {
labels: <?php echo json_encode($event_labels); ?>,
datasets: [{
data: <?php echo json_encode($event_data); ?>
}]
}

});

</script>

</body>
</html>