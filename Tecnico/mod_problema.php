<?php
include('../ConexionBD.php'); 

// Verificar si el id_problema se ha enviado
if (isset($_POST['folio'])) {
    $folio = $_POST['folio'];

    // Consulta para obtener los datos del problema usando el folio
    $query = "SELECT p.*, s.nombre AS nombre_salon, d.nombre AS nombre_departamento, u.nombre AS nombre_asignado 
              FROM problemas p
              JOIN salones s ON p.id_salon = s.id_salon
              JOIN departamentos d ON p.id_departamento = d.id_departamento
              LEFT JOIN usuarios u ON p.id_usuario = u.id_usuario
              WHERE p.folio = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $folio);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $incidente = $result->fetch_assoc();
    } else {
        // Si no se encuentra la incidencia, redirigir o mostrar un error
        echo "<script>alert('No se encontró el folio en la base de datos.');</script>";
        exit;
    }
}

// Verificar si el formulario de modificación ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['descripcion']) && isset($_POST['estatus'])) {
    $descripcion = $_POST['descripcion'];
    $estatus = $_POST['estatus'];

    // Actualizar la descripción y el estatus en la base de datos
    $updateQuery = "UPDATE problemas SET descripcion = ?, estatus = ? WHERE folio = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sss", $descripcion, $estatus, $folio);

    if ($updateStmt->execute()) {
        echo "<script>alert('Problema actualizado exitosamente.');</script>";
    } else {
        echo "<script>alert('Error al actualizar el problema.');</script>";
    }
    $updateStmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/view_rfc.css">
    <title>Modificar Problema</title>
</head>
<body>
    <div class="container">
        <form action="mod_problema.php" method="POST">
            <h2>Modificar Incidencia</h2>

            <div class="form-group">
                <label for="folio">Folio</label>
                <input type="text" name="folio" id="folio" value="<?= htmlspecialchars($incidente['folio']) ?>" readonly>
            </div>

            <div class="form-group">
                <label for="nombre_salon">Salón</label>
                <input type="text" name="nombre_salon" id="nombre_salon" value="<?= htmlspecialchars($incidente['nombre_salon']) ?>" readonly>
            </div>

            <div class="form-group">
                <label for="nombre_departamento">Departamento</label>
                <input type="text" name="nombre_departamento" id="nombre_departamento" value="<?= htmlspecialchars($incidente['nombre_departamento']) ?>" readonly>
            </div>

            <div class="form-group">
                <label for="computadora">Computadora</label>
                <input type="text" name="computadora" id="computadora" value="<?= htmlspecialchars($incidente['computadora']) ?>" readonly>
            </div>

            <div class="form-group">
                <label for="proyector">Proyector</label>
                <input type="text" name="proyector" id="proyector" value="<?= htmlspecialchars($incidente['proyector']) ?>" readonly>
            </div>

            <div class="form-group">
                <label for="impresora">Impresora</label>
                <input type="text" name="impresora" id="impresora" value="<?= htmlspecialchars($incidente['impresora']) ?>" readonly>
            </div>

            <div class="form-group">
                <label for="nombre_asignado">Asignado a</label>
                <input type="text" name="nombre_asignado" id="nombre_asignado" value="<?= htmlspecialchars($incidente['nombre_asignado']) ?>" readonly>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" style="width: 100%; height: 100px;" placeholder="Descripción"><?= htmlspecialchars($incidente['descripcion']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="estatus">Estatus</label>
                <select name="estatus" id="estatus">
                    <option value="Pendiente" <?= $incidente['estatus'] === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="Terminado" <?= $incidente['estatus'] === 'Terminado' ? 'selected' : '' ?>>Terminado</option>
                </select>
            </div>

            <button type="submit">Actualizar</button>
        </form><br>

        <a href="View_tecnico.php"><button onclick="history.back()">Regresar</button></a> <!-- Botón para regresar -->
    </div>
</body>
</html>
