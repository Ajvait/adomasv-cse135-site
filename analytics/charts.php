<?php
require "auth.php";
require "db.php";

$query = "
SELECT event_type, COUNT(*) AS total
FROM events
GROUP BY event_type
ORDER BY total DESC
";

$result = $conn->query($query);

$labels = [];
$data = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row["event_type"];
    $data[] = $row["total"];
}
?>

<h2>Event Type Distribution</h2>

<canvas id="eventChart" width="400" height="200"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('eventChart');

new Chart(ctx, {

    type: 'pie',

    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Event Count',
            data: <?php echo json_encode($data); ?>
        }]
    }

});

</script>

<br>

<a href="dashboard.php">Back to Dashboard</a>