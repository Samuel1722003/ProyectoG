<?php
include('../ConexionBD.php');
include("../User/ObtenerUser.php");

// Inicializar la variable para el incidente
$incidente = null;

// Verificar si se ha enviado el folio
if (isset($_POST['folio_rfc'])) {
    $folio = $_POST['folio_rfc'];

    // Consulta a la base de datos para obtener los detalles de la incidencia
    $query = "SELECT i.*, s.id_salon, d.id_departamento 
              FROM incidencias i 
              JOIN salones s ON i.id_salon = s.id_salon 
              JOIN departamentos d ON i.id_departamento = d.id_departamento
              WHERE i.folio = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $folio);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró algún resultado
    if ($result->num_rows > 0) {
        // Obtener los datos de la incidencia
        $incidente = $result->fetch_assoc();
    } else {
        // Manejar el caso en que no se encuentra el folio
        $incidente = null;
    }
}

// Procesar la inserción del RFC
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['importe'])) {
    // Obtener datos del formulario
    $folio = $_POST['folio'];
    $fecha = $_POST['fecha'];
    $departamento = $_POST['id_departamento'];
    $salon = $_POST['id_salon'];
    $computadora = $_POST['computadora'];
    $proyector = $_POST['proyector'];
    $impresora = $_POST['impresora'];
    $tipo_servicio = $_POST['tipo_servicio'];
    $prioridad = $_POST['prioridad'];
    $importe = $_POST['importe'];
    $descripcion = $_POST['descripcion'];
    

    // Verificar si ya existe un registro con el mismo folio
    $checkQuery = "SELECT COUNT(*) FROM rfc WHERE folio = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("i", $folio);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $exists = $checkResult->fetch_row()[0] > 0;

    if ($exists) {
        // Mensaje de error si ya existe el folio
        echo "<script>alert('El folio $folio ya existe en la base de datos.');</script>";
    } else {
        // Insertar nuevo registro si no existe
        $insertQuery = "INSERT INTO rfc (folio, fecha, id_departamento, id_salon, computadora, proyector, impresora, tipo_servicio, prioridad, importe, descripcion) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("issssssssis", $folio, $fecha, $departamento, $salon, $computadora, $proyector, $impresora, $tipo_servicio, $prioridad, $importe, $descripcion);

        if ($insertStmt->execute()) {
            // Mensaje de éxito
            echo "<script>alert('RFC guardado exitosamente.');</script>";
        } else {
            // Mensaje de error al guardar
            echo "<script>alert('Error al guardar el RFC.');</script>";
        }

        // Cerrar la declaración de inserción
        $insertStmt->close();
    }

    // Cerrar la declaración de verificación
    $checkStmt->close();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/view_rfc.css">
    <title>Formulario RFC</title>
    <style>
        /* Tu estilo aquí, como el anterior */
    </style>
</head>
<body>
<div class="container">
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

            <div class="form-group">
                <label for="prioridad">Prioridad</label>
                <input type="text" name="prioridad" id="prioridad" value="<?= htmlspecialchars($incidente['prioridad']) ?>" readonly>
            </div>

            <div class="form-group">
                <label for="importe">Importe</label>
                <input type="text" name="importe" id="importe" required placeholder="Importe">
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="" placeholder="Descripción"></textarea>
            </div>

            <button type="submit">Guardar RFC</button>
            <input type="hidden" name="folio_rfc" value="<?= htmlspecialchars($folio) ?>"> <!-- Campo oculto para el folio -->
        </form>
        <button onclick="history.back()">Regresar</button> <!-- Botón para regresar -->
    <?php else: ?>
        <p>No se encontraron datos para el folio especificado.</p>
    <?php endif; ?>
</div>

</body>
</html>
