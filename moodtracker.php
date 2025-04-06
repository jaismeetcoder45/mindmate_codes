<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'header.php';

// Handle mood submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mood = mysqli_real_escape_string($conn, $_POST['mood']);
    $user_id = $_SESSION['user_id'];
    $query = "INSERT INTO mood_tracker (user_id, mood) VALUES ('$user_id', '$mood')";
    mysqli_query($conn, $query);
}
?>

<h2>Mood Tracker</h2>

<form method="POST">
    <label>How are you feeling today?</label><br><br>
    <select name="mood" required>
        <option value="">-- Select Mood --</option>
        <option value="Happy">Happy</option>
        <option value="Sad">Sad</option>
        <option value="Angry">Angry</option>
        <option value="Calm">Calm</option>
        <option value="Anxious">Anxious</option>
    </select>
    <input type="submit" value="Submit Mood">
</form>

<h3>Your Mood History</h3>

<?php
$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT * FROM mood_tracker WHERE user_id='$user_id' ORDER BY created_at DESC");

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;'>";
        echo "<strong>Date:</strong> " . $row['created_at'] . "<br>";
        echo "<strong>Mood:</strong> " . $row['mood'];
        echo "</div>";
    }
} else {
    echo "<p>No mood records found yet.</p>";
}

include 'footer.php';
?>