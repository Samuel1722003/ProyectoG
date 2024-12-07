<?php
include('../ConexionBD.php'); // Asegúrate de tener la conexión aquí

if (isset($_POST['folio']) && isset($_POST['estatus'])) {
    $folio = $_POST['folio'];
    $estatus = $_POST['estatus'][$folio]; // Obtén el estatus correspondiente al folio

    // Prepara y ejecuta la actualización
    $query = "UPDATE rfc SET estatus = ? WHERE folio = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $estatus, $folio);

    if ($stmt->execute()) {
        echo "<script>alert('Estatus actualizado correctamente');</script>";
    } else {
        echo "<script>alert('Error al actualizar el estatus');</script>";
    }

    // Cierra la conexión
    $stmt->close();

    // Redirige a la página de RFC
    echo "<script>window.location.href='view_rfc.php';</script>";
} else {
    echo "<script>alert('No se recibieron los datos necesarios');</script>";
    echo "<script>window.location.href='nombre_de_tu_pagina.php';</script>";
}
