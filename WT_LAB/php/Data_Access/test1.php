<?php
// crud.php

// Database connection parameters
$servername = "localhost";
$username   = "root";    // Default XAMPP username
$password   = "";        // Default XAMPP password (empty)
$database   = "test1";   // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Determine the action from the query string (default is "list")
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

if ($action === 'create') {
    // --- CREATE OPERATION ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get data from POST and escape for security
        $name  = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);

        $sql = "INSERT INTO aa1 (name, email) VALUES ('$name', '$email')";
        if ($conn->query($sql) === TRUE) {
            header("Location: crud.php");
            exit;
        } else {
            $error = "Error: " . $conn->error;
        }
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Create New Record</title>
    </head>
    <body>
        <h2>Create New Record</h2>
        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        <form method="post" action="crud.php?action=create">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>
            
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>
            
            <input type="submit" value="Create">
        </form>
        <p><a href="crud.php">Back to List</a></p>
    </body>
    </html>
    <?php
} elseif ($action === 'edit') {
    // --- UPDATE OPERATION ---
    // Get the record ID from the query string
    if (!isset($_GET['id'])) {
        header("Location: crud.php");
        exit;
    }
    $id = intval($_GET['id']);

    // Process form submission to update record
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name  = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);

        $sql = "UPDATE aa1 SET name='$name', email='$email' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            header("Location: crud.php");
            exit;
        } else {
            $error = "Error: " . $conn->error;
        }
    }

    // Fetch the current record data
    $sql = "SELECT * FROM aa1 WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows !== 1) {
        die("Record not found.");
    }
    $row = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Edit Record</title>
    </head>
    <body>
        <h2>Edit Record</h2>
        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        <form method="post" action="crud.php?action=edit&id=<?php echo $id; ?>">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required><br><br>
            
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required><br><br>
            
            <input type="submit" value="Update">
        </form>
        <p><a href="crud.php">Back to List</a></p>
    </body>
    </html>
    <?php
} elseif ($action === 'delete') {
    // --- DELETE OPERATION ---
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $sql = "DELETE FROM aa1 WHERE id = $id";
        $conn->query($sql);
    }
    header("Location: crud.php");
    exit;
} else {
    // --- READ OPERATION (List All Records) ---
    $sql = "SELECT * FROM aa1";
    $result = $conn->query($sql);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>CRUD Interface</title>
        <style>
            table { border-collapse: collapse; width: 60%; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
            a.button { text-decoration: none; padding: 4px 8px; background: #4CAF50; color: white; border-radius: 4px; }
            a.button.delete { background: #f44336; }
        </style>
    </head>
    <body>
        <h2>Records List</h2>
        <p><a class="button" href="crud.php?action=create">Add New Record</a></p>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td>
                        <a class="button" href="crud.php?action=edit&id=<?php echo $row['id']; ?>">Edit</a>
                        <a class="button delete" href="crud.php?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </body>
    </html>
    <?php
}

$conn->close();
?>
