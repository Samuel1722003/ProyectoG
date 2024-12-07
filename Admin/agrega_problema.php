<?php
include('../ConexionBD.php');
include("../User/ObtenerUser.php");

$mensaje = ""; // Variable para mensaje de éxito o error

// Inicializar la variable para el incidente
$incidente = null;

// Verificar si se ha enviado el folio al cargar la página
if (isset($_POST['folio_rfc']) || isset($_POST['folio'])) {
    $folio = $_POST['folio_rfc'] ?? $_POST['folio']; // Obtener el folio enviado

    // Consulta para obtener los detalles de la incidencia
    $query = "
    SELECT i.*, s.id_salon, s.nombre AS nombre_salon, 
           d.id_departamento, d.nombre AS nombre_departamento, 
           u.id_usuario, u.nombre AS nombre_usuario 
    FROM incidencias i
    JOIN salones s ON i.id_salon = s.id_salon
    JOIN departamentos d ON i.id_departamento = d.id_departamento
    JOIN usuarios u ON i.asignado_a = u.id_usuario
    WHERE i.folio = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $folio);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $incidente = $result->fetch_assoc();
    } else {
        $mensaje = "No se encontraron datos para el folio especificado.";
    }
}

// Procesar la inserción del RFC si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['folio'])) {
    // Obtener datos del formulario
    $folio = $_POST['folio'];
    $fecha = $_POST['fecha'];
    $departamento = $_POST['id_departamento'];
    $salon = $_POST['id_salon'];
    $computadora = $_POST['computadora'];
    $proyector = $_POST['proyector'];
    $impresora = $_POST['impresora'];
    $tipo_servicio = $_POST['tipo_servicio'];
    $usuario = $_POST['id_usuario'];

    // Consulta de inserción (deja descripcion como NULL)
    $insertQuery = "INSERT INTO problemas (folio, fecha, id_departamento, id_salon, id_usuario, computadora, proyector, impresora, tipo_servicio, descripcion) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NULL)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("sssssssss", $folio, $fecha, $departamento, $salon, $usuario, $computadora, $proyector, $impresora, $tipo_servicio);

    // Ejecutar inserción y verificar resultado
    if ($insertStmt->execute()) {
        $mensaje = "Problema guardado exitosamente.";
    } else {
        $mensaje = "Error al guardar el Problema: " . $insertStmt->error;
    }

    $insertStmt->close();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/viewP.css">
    <title>Formulario RFC</title>
</head>
<body>
<div class="container">
    <?php if ($mensaje): ?>
        <p style="color: green;"><?= htmlspecialchars($mensaje) ?></p> <!-- Mensaje de éxito o error -->
    <?php endif; ?>

    <?php if ($incidente): ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="folio">Folio</label>
                <input type="text" name="folio" id="folio" value="<?= htmlspecialchars($incidente['folio']) ?>" readonly>
            </div>

            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" id="fecha" value="<?= htmlspecialchars($incidente['fecha']) ?>" readonly>
            </div>

            <div class="form-group">
                <label for="departamento">ID Departamento</label>
                <input type="text" name="id_departamento" id="departamento" value="<?= htmlspecialchars($incidente['id_departamento']) ?>" readonly>
            </div>

            <div class="form-group">
                <label for="salon">ID Salón</label>
                <input type="text" name="id_salon" id="salon" value="<?= htmlspecialchars($incidente['id_salon']) ?>" readonly>
            </div>

            <div class="form-group">
                <label for="usuario">Asignado a</label>
                <input type="text" name="id_usuario" id="usuario" value="<?= htmlspecialchars($incidente['id_usuario']) ?>" readonly>
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
                <label for="tipo_servicio">Tipo de Servicio</label>
                <input type="text" name="tipo_servicio" id="tipo_servicio" value="<?= htmlspecialchars($incidente['tipo_servicio']) ?>" readonly>
            </div>

            <button type="submit">Guardar Problema</button>
            <input type="hidden" name="folio_rfc" value="<?= htmlspecialchars($folio) ?>">
        </form><br>
        <a href="Dash.php"><button>Regresar</button></a>
        
    <?php else: ?>
        <p>No se encontraron datos para el folio especificado.</p>
    <?php endif; ?>
</div>
</body>
</html>
