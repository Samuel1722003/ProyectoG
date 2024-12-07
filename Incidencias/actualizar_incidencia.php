<?php
include("../ConexionBD.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el folio del incidente
    $folio = $_POST['folio'];

    // Verificar que el folio no esté vacío
    if (empty($folio)) {
        die("El folio no se ha proporcionado.");
    }

    // Obtener los datos del formulario
    $asignado_a = $_POST['asignado_a'][$folio]; // Obtiene el técnico asignado
    $prioridad = $_POST['prioridad'][$folio]; // Obtiene la prioridad
    $estatus = $_POST['estatus'][$folio]; // Obtiene el estatus

    // Verificar si se han recibido los datos correctamente
    if (empty($asignado_a) || empty($prioridad) || empty($estatus)) {
        die("Uno o más campos están vacíos.");
    }

    // Preparar la consulta para actualizar los datos de la incidencia
    $query = "UPDATE incidencias 
              SET asignado_a = ?, prioridad = ?, estatus = ? 
              WHERE folio = ?";

    // Preparar la declaración
    if ($stmt = $conn->prepare($query)) {
        // Enlazar parámetros
        $stmt->bind_param("sssi", $asignado_a, $prioridad, $estatus, $folio);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                // Redirigir a la página Dash.php en caso de éxito
                header('Location: ../Admin/Dash.php');
                exit();
            } else {
                echo "No se actualizó ninguna fila. Posiblemente no hubo cambios.";
            }
        } else {
            echo "Error al actualizar la incidencia: " . $stmt->error;
        }
        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
} else {
    echo "Método de solicitud no permitido.";
}

// Cerrar la conexión
$conn->close();
?>
