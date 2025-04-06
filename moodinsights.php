<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Manually create the DB connection here
$mysqli = new mysqli("localhost", "root", "", "mindmate");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch mood data from the database
$stmt = $mysqli->prepare("SELECT mood, COUNT(*) as count FROM mood_tracker WHERE user_id = ? GROUP BY mood");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$moods = [];
$counts = [];

while ($row = $result->fetch_assoc()) {
    $moods[] = $row['mood'];
    $counts[] = $row['count'];
}

$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mood Insights</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        ul {
            list-style-type: none;
            margin: 10px;
            padding: 0;
        }
        li {
            display: inline;
            margin-right: 20px;
        }
        #chart-container {
            width: 60%;
            height: 400px;
            margin: 40px auto;
        }
        canvas {
            max-height: 100%;
        }
    </style>
</head>
<body>

    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="journal.php">Journal</a></li>
        <li><a href="moodtracker.php">Mood Tracker</a></li>
        <li><a href="affirmations.php">Affirmations</a></li>
        <li><a href="logout.php">Logout</a></li>
        <li><a href="moodinsights.php"><strong>Mood Insights</strong></a></li>
    </ul>

    <div id="chart-container">
        <canvas id="moodChart"></canvas>
    </div>

    <script>
        var ctx = document.getElementById('moodChart').getContext('2d');
        var moodChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($moods); ?>,
                datasets: [{
                    label: 'Mood Frequency',
                    data: <?php echo json_encode($counts); ?>,
                    backgroundColor: [
                        '#f1c40f',
                        '#e74c3c',
                        '#2ecc71',
                        '#9b59b6',
                        '#3498db'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>
