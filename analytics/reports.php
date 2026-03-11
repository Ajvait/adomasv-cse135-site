<?php

require_once "auth.php";
require_once "db.php";

/* -----------------------------
   TRAFFIC DATA (events per day)
------------------------------*/

$traffic_labels = [];
$traffic_data = [];

$sql = "
SELECT DATE(created_at) as day, COUNT(*) as total
FROM events
GROUP BY DATE(created_at)
ORDER BY day
";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
    $traffic_labels[] = $row['day'];
    $traffic_data[] = $row['total'];
}


/* -----------------------------
   PAGE POPULARITY (by URL)
------------------------------*/

$page_labels = [];
$page_data = [];

$sql = "
SELECT url, COUNT(*) as views
FROM events
GROUP BY url
ORDER BY views DESC
";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
    $page_labels[] = $row['url'];
    $page_data[] = $row['views'];
}


/* -----------------------------
   EVENT TYPE REPORT
------------------------------*/

$event_labels = [];
$event_data = [];

$sql = "
SELECT event_type, COUNT(*) as total
FROM events
GROUP BY event_type
";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
    $event_labels[] = $row['event_type'];
    $event_data[] = $row['total'];
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

<!-- =========================
     TRAFFIC REPORT
========================= -->

<h2>Traffic Report</h2>

<canvas id="trafficChart"></canvas>

<script>

new Chart(document.getElementById("trafficChart"),{

type:'line',

data:{
labels: <?php echo json_encode($traffic_labels); ?>,
datasets:[{
label:"Events Per Day",
data: <?php echo json_encode($traffic_data); ?>,
borderWidth:2
}]
}

});

</script>

<table border="1">

<tr>
<th>Date</th>
<th>Events</th>
</tr>

<?php

$sql = "
SELECT DATE(created_at) as day, COUNT(*) as total
FROM events
GROUP BY DATE(created_at)
ORDER BY day
";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

echo "<tr>";
echo "<td>".$row['day']."</td>";
echo "<td>".$row['total']."</td>";
echo "</tr>";

}

?>

</table>


<hr>

<!-- =========================
     PAGE POPULARITY REPORT
========================= -->

<h2>Page Popularity Report</h2>

<canvas id="pageChart"></canvas>

<script>

new Chart(document.getElementById("pageChart"),{

type:'bar',

data:{
labels: <?php echo json_encode($page_labels); ?>,
datasets:[{
label:"Events Per Page",
data: <?php echo json_encode($page_data); ?>
}]
}

});

</script>

<table border="1">

<tr>
<th>URL</th>
<th>Events</th>
</tr>

<?php

$sql = "
SELECT url, COUNT(*) as views
FROM events
GROUP BY url
ORDER BY views DESC
";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

echo "<tr>";
echo "<td>".$row['url']."</td>";
echo "<td>".$row['views']."</td>";
echo "</tr>";

}

?>

</table>


<hr>

<!-- =========================
     EVENT TYPE REPORT
========================= -->

<h2>Event Type Report</h2>

<canvas id="eventChart"></canvas>

<script>

new Chart(document.getElementById("eventChart"),{

type:'pie',

data:{
labels: <?php echo json_encode($event_labels); ?>,
datasets:[{
data: <?php echo json_encode($event_data); ?>
}]
}

});

</script>

<table border="1">

<tr>
<th>Event Type</th>
<th>Total</th>
</tr>

<?php

$sql = "
SELECT event_type, COUNT(*) as total
FROM events
GROUP BY event_type
";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

echo "<tr>";
echo "<td>".$row['event_type']."</td>";
echo "<td>".$row['total']."</td>";
echo "</tr>";

}

?>

</table>


</body>
</html>