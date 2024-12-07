<?php
// obtener_salones.php
include("../ConexionBD.php");

if (isset($_POST['edificio_id'])) {
    $edificio_id = $_POST['edificio_id'];

    // Consulta para obtener los salones del edificio seleccionado
    $query = "SELECT id_salon, nombre FROM salones WHERE id_edificio = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $edificio_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Crear las opciones para el select de salones
        echo '<option value="">Selecciona un salón</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['id_salon'] . '">' . htmlspecialchars($row['nombre']) . '</option>';
        }
    } else {
        echo '<option value="">No se encontraron salones</option>';
    }

    // Cerrar la declaración
    $stmt->close();
}
?>
