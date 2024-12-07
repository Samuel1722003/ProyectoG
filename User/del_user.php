<?php
// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'gestion';

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user ID from the POST request
$id = $_POST['id'];

// Delete the user from the database
$query = "DELETE FROM usuarios WHERE id = '$id'";
if ($conn->query($query) === TRUE) {
    echo "User deleted successfully";
} else {
    echo "Error deleting user: " . $conn->error;
}

// Close connection
$conn->close();
?>