<?php
    include("../ConexionBD.php");

    $nombre = $_POST['nombre'];

    $query = "INSERT INTO departamentos (Nombre) values ('$nombre')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        // Incidence added successfully, redirect to incidence list
        header('Location: ../Admin/admin_dashboard.php');
        exit;
    } else {
        // Incidence addition failed, redirect back to the add incidence form with an error message
        header('Location: add_incidencia.php?error=failed_to_add_incidencia');
        exit;
    }
?>