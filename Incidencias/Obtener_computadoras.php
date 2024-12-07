<?php
// Habilitar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../ConexionBD.php');

try {
    if (isset($_POST['id_salon'])) {
        $id_salon = $_POST['id_salon'];

        $sql = "SELECT id_computadora, identificador FROM computadoras WHERE id_salon = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_salon);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $options = '<option value="">Selecciona una computadora</option>';
            while ($row = $result->fetch_assoc()) {
                $options .= '<option value="' . htmlspecialchars($row['identificador']) . '">' . htmlspecialchars($row['identificador']) . ' (ID: ' . htmlspecialchars($row['id_computadora']) . ')</option>';
            }
        } else {
            $options = '<option value="">No tiene computadoras</option>'; // Mensaje si no hay computadoras
        }

        echo $options;
        $stmt->close();
    } else {
        echo '<option value="">Error: ID de salón no proporcionado</option>';
    }
    $conn->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
