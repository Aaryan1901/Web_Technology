<?php
session_start();
session_destroy(); // Destroy session
echo "Session cleared. <a href='session_creation.php'>Go back</a>";
?>
