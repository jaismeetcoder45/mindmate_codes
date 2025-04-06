 <?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<?php include 'header.php'; ?>

<h2>Welcome to the Dashboard</h2>
<p>Hello, <?php echo $_SESSION['user']; ?>! You are successfully logged in.</p>

<a href="logout.php">Logout</a>


<?php include 'footer.php'; ?>