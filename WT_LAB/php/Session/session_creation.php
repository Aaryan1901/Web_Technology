<?php
session_start(); // Start session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store form data in session
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["email"] = $_POST["email"];
    echo "Session data saved successfully! <a href='session_view.php'>View Session Data</a>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Session Creation</title>
</head>
<body>
    <h2>Enter Your Details</h2>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        <input type="submit" value="Save to Session">
    </form>
</body>
</html>
