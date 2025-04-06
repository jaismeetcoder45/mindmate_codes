<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'header.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entry = mysqli_real_escape_string($conn, $_POST['entry']);
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO journal (user_id, entry) VALUES ('$user_id', '$entry')";
    mysqli_query($conn, $query);
}
?>

<h2>My Journal</h2>

<form method="POST">
    <textarea name="entry" rows="6" cols="50" placeholder="Write your thoughts..." required></textarea><br><br>
    <input type="submit" value="Save Entry">
</form>

<h3>Previous Entries</h3>

<?php
$user_id = $_SESSION['user_id'];
$result = mysqli_query($conn, "SELECT * FROM journal WHERE user_id='$user_id' ORDER BY created_at DESC");

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;'>";
        echo "<strong>Date:</strong> " . $row['created_at'] . "<br>";
        echo "<strong>Entry:</strong><br>" . nl2br(htmlspecialchars($row['entry']));
        echo "</div>";
    }
} else {
    echo "<p>No journal entries yet.</p>";
}
?>

<?php include 'footer.php'; ?>