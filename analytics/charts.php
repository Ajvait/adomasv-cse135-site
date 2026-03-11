<?php

require_once "auth.php";
require_once "db.php";

requireLogin();

$labels = [];
$data = [];

$sql = "
SELECT DATE(created_at) as day, COUNT(*) as total
FROM events
GROUP BY DATE(created_at)
ORDER BY day
";

$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

$labels[] = $row['day'];
$data[] = $row['total'];

}

?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<h2>Traffic Chart</h2>

<canvas id="trafficChart"></canvas>

<script>

const labels = <?php echo json_encode($labels); ?>;
const data = <?php echo json_encode($data); ?>;

const ctx = document.getElementById('trafficChart');

new Chart(ctx,{

type:'line',

data:{
labels:labels,
datasets:[{
label:'Visitors per Day',
data:data,
borderWidth:2
}]
}

});

</script>