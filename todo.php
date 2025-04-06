<?php
session_start();
include("db.php");
include("header.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Handle new task submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["task"])) {
    $task = $_POST["task"];
    $stmt = $conn->prepare("INSERT INTO todos (user_id, task) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $task);
    $stmt->execute();
    $stmt->close();
}

// Handle task deletion
if (isset($_GET["delete"])) {
    $task_id = $_GET["delete"];
    $stmt = $conn->prepare("DELETE FROM todos WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch user tasks
$stmt = $conn->prepare("SELECT id, task FROM todos WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>To-Do List</title>
</head>
<body>
    <h2>To-Do List for Mental Wellness</h2>
    <form method="post" action="">
        <input type="text" name="task" placeholder="Enter a new task" required>
        <button type="submit">Add Task</button>
    </form>

    <ul>
        <?php foreach ($tasks as $task): ?>
            <li>
                <?php echo htmlspecialchars($task['task']); ?>
                <a href="?delete=<?php echo $task['id']; ?>" onclick="return confirm('Delete this task?');">[Delete]</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
<?php include("footer.php"); ?>