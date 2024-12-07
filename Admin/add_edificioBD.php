<?php
include('../ConexionBD.php');

// Validar que los datos sean enviados correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $id_departamento = intval($_POST['id_departamento']); // Asegura que sea un entero válido

    // Verificar que el ID del departamento exista
    $checkQuery = "SELECT id_departamento FROM departamentos WHERE id_departamento = $id_departamento";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Insertar el nuevo edificio
        $query = "INSERT INTO edificios (nombre, id_departamento) VALUES ('$nombre', $id_departamento)";
        if (mysqli_query($conn, $query)) {
            echo "Edificio agregado correctamente.";
        } else {
            echo "Error al agregar el edificio: " . mysqli_error($conn);
        }
    } else {
        echo "El departamento seleccionado no existe.";
    }
} else {
    echo "Método no permitido.";
}

// Cerrar conexión
mysqli_close($conn);
?>
