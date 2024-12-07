<?php
include("../ConexionBD.php");

// Obtener datos enviados desde el formulario principal
if (isset($_POST['submit'])) {
    $folio = $_POST['submit'];

    // Consulta para obtener la información del técnico asignado y la calificación actual
    $query = "
        SELECT 
            u.id_usuario, 
            u.nombre AS tecnico_nombre, 
            u.calificacion 
        FROM incidencias i
        LEFT JOIN usuarios u ON i.asignado_a = u.id_usuario
        WHERE i.folio = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $folio);
    $stmt->execute();
    $resultado = $stmt->get_result()->fetch_assoc();

    if (!$resultado) {
        echo "No se encontró información para este folio.";
        exit;
    }
} else {
    echo "No se recibió información del formulario.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Calificación</title>
</head>
<body>
    <h1>Actualizar Calificación del Técnico</h1>
    <form action="actualizar_calificacion.php" method="POST">
        <p><strong>Nombre del Técnico:</strong> <?= htmlspecialchars($resultado['tecnico_nombre']) ?></p>
        <p><strong>Calificación Actual:</strong> <?= htmlspecialchars($resultado['calificacion']) ?></p>
        <input type="hidden" name="id_tecnico" value="<?= htmlspecialchars($resultado['id_usuario']) ?>">
        <label for="nueva_calificacion">Nueva Calificación (1-5):</label>
        <select name="nueva_calificacion" id="nueva_calificacion">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <br><br>
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>
