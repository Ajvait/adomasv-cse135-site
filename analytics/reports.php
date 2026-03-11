<?php

require_once "auth.php";
require_once "db.php";

requireLogin();

/* Save Analyst Comment */

if(isset($_POST['comment'])){

$comment = $_POST['comment'];

$sql = "INSERT INTO comments (report,comment)
VALUES('traffic','$comment')";

$conn->query($sql);

}

/* TRAFFIC DATA */

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

/* PAGE POPULARITY */

$page_labels = [];
$page_data = [];

$sql = "
SELECT page, COUNT(*) as views
FROM events
GROUP BY page
ORDER BY views DESC
";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

$page_labels[] = $row['page'];
$page_data[] = $row['views'];

}

/* EVENT TYPES */

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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<h1>Analytics Reports</h1>

<p>Logged in as: <?php echo $_SESSION['user']; ?></p>

<a href="dashboard.php">Dashboard</a> |
<a href="logout.php">Logout</a>

<hr>

<!-- TRAFFIC REPORT -->

<h2>Traffic Report</h2>

<canvas id="trafficChart"></canvas>

<script>

new Chart(document.getElementById("trafficChart"),{

type:'line',

data:{
labels:<?php echo json_encode($traffic_labels); ?>,
datasets:[{
label:"Visitors Per Day",
data:<?php echo json_encode($traffic_data); ?>,
borderWidth:2
}]
}

});

</script>

<table border="1">

<tr>
<th>Date</th>
<th>Visitors</th>
</tr>

<?php

$sql = "
SELECT DATE(created_at) as day, COUNT(*) as total
FROM events
GROUP BY DATE(created_at)
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

<!-- PAGE POPULARITY -->

<h2>Page Popularity Report</h2>

<canvas id="pageChart"></canvas>

<script>

new Chart(document.getElementById("pageChart"),{

type:'bar',

data:{
labels:<?php echo json_encode($page_labels); ?>,
datasets:[{
label:"Page Views",
data:<?php echo json_encode($page_data); ?>
}]
}

});

</script>

<table border="1">

<tr>
<th>Page</th>
<th>Views</th>
</tr>

<?php

$sql = "
SELECT page, COUNT(*) as views
FROM events
GROUP BY page
ORDER BY views DESC
";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

echo "<tr>";
echo "<td>".$row['page']."</td>";
echo "<td>".$row['views']."</td>";
echo "</tr>";

}

?>

</table>

<hr>

<!-- EVENT TYPE REPORT -->

<h2>Event Type Report</h2>

<canvas id="eventChart"></canvas>

<script>

new Chart(document.getElementById("eventChart"),{

type:'pie',

data:{
labels:<?php echo json_encode($event_labels); ?>,
datasets:[{
data:<?php echo json_encode($event_data); ?>
}]
}

});

</script>

<hr>

<h3>Analyst Comments</h3>

<form method="POST">

<textarea name="comment" rows="4" cols="60"></textarea><br><br>

<button type="submit">Save Comment</button>

</form>

<br>

<?php

$result = $conn->query("SELECT * FROM comments ORDER BY created_at DESC");

while($row = $result->fetch_assoc()){

echo "<p>".$row['comment']."</p>";

}

?>