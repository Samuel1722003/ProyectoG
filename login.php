<?php
include("ConexionBD.php");

// Receive form data
$email = $_POST['email'];
$password = $_POST['password'];

// Query to check if email and password exist in the database
$query = "SELECT * FROM usuarios WHERE correo = '$email' AND password = '$password'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Login successful, retrieve user's role
    $user_data = $result->fetch_assoc();
    $user_role = $user_data['rol'];
    session_start();
    // Store user's name and department in session
    $_SESSION['id'] = $user_data['id_usuario'];
    $_SESSION['nombre'] = $user_data['nombre'];
    

    // Redirect to role-specific page
    if ($user_role == 'Admin' ) {
        header('Location: Admin/Dash.php');
        exit;
    } else {
        header('Location: index.html');
    }
    if ($user_role == 'Usuario') {
        header('Location: User/view_usuario.php');
        exit;
    } else {
        header('Location: index.html');
    }
    if ($user_role == 'Tecnico') {
        header('Location: Tecnico/View_tecnico.php');
        exit;
    } else {
        header('Location: index.html');
    }
    if ($user_role == 'Jefe') {
        header('Location: RFC/view_rfc.php');
        exit;
    } else {
        header('Location: index.html');
    }
}

$conn->close();
?>