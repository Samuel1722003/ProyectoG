<?php
include('../ConexionBD.php');

// Validar que los datos sean enviados correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escapar y validar los datos recibidos
    $nombre_salon = mysqli_real_escape_string($conn, $_POST['nombre']);
    $id_edificio = intval($_POST['id_edificio']); // Asegura que sea un entero válido

    // Verificar que el ID del edificio exista
    $checkQuery = "SELECT id_edificio FROM edificios WHERE id_edificio = $id_edificio";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Insertar el nuevo salón
        $query = "INSERT INTO salones (nombre, id_edificio) VALUES ('$nombre_salon', $id_edificio)";
        if (mysqli_query($conn, $query)) {
            echo "Salón agregado correctamente.";
        } else {
            echo "Error al agregar el salón: " . mysqli_error($conn);
        }
    } else {
        echo "El edificio seleccionado no existe.";
    }
} else {
    echo "Método no permitido.";
}

// Cerrar conexión
mysqli_close($conn);
?>
