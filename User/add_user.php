<?php
   include('../ConexionBD.php');
    // Receive form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['rol'];
    $nombre = $_POST['username'];
    $departament = $_POST['departamento'];

    // Hash the password for security
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Query to add user
    $query = "INSERT INTO usuarios (nombre, correo, password, rol, id_departamento) VALUES ('$nombre', '$email', '$password','$role','$departament')";
    $result = $conn->query($query);

    if ($result) {
        // User added successfully, redirect to user list
        echo 'El valoe de Email es:'. $email;
        header('Location: ../Admin/Dash.php');
        exit;
    } else {
        // User addition failed, redirect back to the add user form with an error message
        header('Location: add_user.php?error=failed_to_add_user');
        exit;
    }

?>