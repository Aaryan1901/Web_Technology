<?php
// Include the database connection file
include 'db.php';

// Check if action is passed in the request
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Create (Save) Operation
    if ($action == 'save' && isset($_POST['name']) && isset($_POST['email'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];

        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);

        if ($stmt->execute()) {
            echo "Data saved successfully!";
        } else {
            echo "Error saving data!";
        }

        $stmt->close();
    }

    // Update Operation
    if ($action == 'update' && isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];

        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $email, $id);

        if ($stmt->execute()) {
            echo "Data updated successfully!";
        } else {
            echo "Error updating data!";
        }

        $stmt->close();
    }

    // Delete Operation
    if ($action == 'delete' && isset($_POST['id'])) {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "User deleted successfully!";
        } else {
            echo "Error deleting user!";
        }

        $stmt->close();
    }
} elseif (isset($_GET['action']) && $_GET['action'] == 'load') {
    // Read Operation (Load data)
    $result = $conn->query("SELECT * FROM users");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<input type='text' id='name-" . $row['id'] . "' value='" . $row['name'] . "'>";
            echo "<input type='email' id='email-" . $row['id'] . "' value='" . $row['email'] . "'>";
            echo "<button class='button-update' onclick='updateData(" . $row['id'] . ")'>Update</button>";
            echo "<button class='button-delete' onclick='deleteData(" . $row['id'] . ")'>Delete</button>";
            echo "</div><br>";
        }
    } else {
        echo "No users found.";
    }
}

$conn->close();
?>
