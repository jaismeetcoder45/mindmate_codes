<?php
session_start();
session_unset();
session_destroy();
?>

<?php include 'header.php'; ?>

<h2>You have been logged out successfully.</h2>
<p><a href="login.php">Log in again</a></p>

<?php include 'footer.php'; ?>