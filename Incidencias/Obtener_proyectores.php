<?php
// Habilitar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../ConexionBD.php'); // Asegúrate de que la conexión está correcta

try {
    // Verificar si se envió el ID del salón
    if (isset($_POST['id_salon'])) {
        $id_salon = $_POST['id_salon'];

        // Consultar los proyectores asociados al salón
        $sql = "SELECT id_proyector, identificador FROM proyectores WHERE id_salon = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_salon);
        $stmt->execute();
        $result = $stmt->get_result();

        // Generar las opciones en formato HTML
        if ($result->num_rows > 0) {
            $options = '<option value="">Selecciona un proyector</option>'; // Opción inicial
            while ($row = $result->fetch_assoc()) {
                $options .= '<option value="' . htmlspecialchars($row['identificador']) . '">' . htmlspecialchars($row['identificador']) . ' (ID: ' . htmlspecialchars($row['id_proyector']) . ')</option>'; // Opción por proyector
            }
        } else {
            $options = '<option value="">No hay proyectores disponibles</option>'; // Mensaje si no hay proyectores
        }

        echo $options; // Retornar las opciones al AJAX
        $stmt->close();
    } else {
        echo '<option value="">Error: ID de salón no proporcionado</option>'; // Mensaje si no se recibe ID
    }
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage(); // Manejo de errores
}
?>
