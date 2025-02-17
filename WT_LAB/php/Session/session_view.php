<?php
session_start(); // Start session

if (isset($_SESSION["username"]) && isset($_SESSION["email"])) {
    echo "<h2>Session Data</h2>";
    echo "Username: " . $_SESSION["username"] . "<br>";
    echo "Email: " . $_SESSION["email"] . "<br>";
    echo "<br><a href='session_destroy.php'>Clear Session</a>";
} else {
    echo "No session data found. <a href='session_creation.php'>Enter Data</a>";
}
?>
