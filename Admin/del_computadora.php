<?php
include("../ConexionBD.php");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user ID from the POST request
$id = $_POST['id_computadora'];

// Delete the user from the database
$query = "DELETE FROM computadoras WHERE id_computadora = '$id'";
if ($conn->query($query) === TRUE) {
    echo "User deleted successfully";
} else {
    echo "Error deleting user: " . $conn->error;
}

// Close connection
$conn->close();