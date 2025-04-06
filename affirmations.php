<?php include 'header.php'; ?>

<h2>Daily Affirmation</h2>

<?php
// Array of affirmations
$affirmations = [
    "You are enough just as you are.",
    "Every day is a fresh start.",
    "You are strong, capable, and resilient.",
    "Your mind is calm, your soul is peaceful.",
    "You grow through what you go through.",
    "Breathe in peace, breathe out stress.",
    "You are doing better than you think.",
    "Your potential is limitless."
];

// Pick a random affirmation
$random_affirmation = $affirmations[array_rand($affirmations)];

// Display it
echo "<div style='margin-top: 20px; font-size: 1.2em; font-weight: bold; color: #2c3e50;'>$random_affirmation</div>";
?>

<!-- Optional Refresh Button -->
<form method="POST" style="margin-top: 20px;">
    <input type="submit" value="Show Another" style="padding: 8px 16px; background-color: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer;">
</form>

<?php include 'footer.php'; ?>