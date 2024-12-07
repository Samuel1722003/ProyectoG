<?php
include("ObtenerUser.php");
include("../ConexionBD.php");

// Manejar la actualización de la calificación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $folio = $_POST['submit'];
    $nuevaCalificacion = $_POST['calif'];

    // Obtener el ID del técnico asignado a la incidencia
    $getIncidenciaQuery = "SELECT asignado_a FROM incidencias WHERE folio = ?";
    $stmt = $conn->prepare($getIncidenciaQuery);
    $stmt->bind_param("i", $folio);
    $stmt->execute();
    $stmt->bind_result($tecnico_id);
    $stmt->fetch();
    $stmt->close();

    // Obtener todas las calificaciones de incidencias para este técnico
    $getCalificacionesQuery = "SELECT calificacion FROM usuarios WHERE id_usuario = ? AND calificacion IS NOT NULL";
    $stmt = $conn->prepare($getCalificacionesQuery);
    $stmt->bind_param("i", $tecnico_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Sumar todas las calificaciones y contar cuántas hay
    $totalCalificaciones = 0;
    $numCalificaciones = 0;
    while ($row = $result->fetch_assoc()) {
        $totalCalificaciones += $row['calificacion'];
        $numCalificaciones++;
    }
    $stmt->close();

    // Incluir la nueva calificación en el total de calificaciones
    $totalCalificaciones += $nuevaCalificacion;
    $numCalificaciones++;  // Añadir la nueva calificación

    // Calcular el promedio de calificación sobre 5
    if ($numCalificaciones > 0) {
        $promedioCalificacion = $totalCalificaciones / $numCalificaciones;
    } else {
        $promedioCalificacion = 0;
    }

    // Actualizar la calificación promedio del técnico en la tabla usuarios
    $updateUsuarioQuery = "UPDATE usuarios SET calificacion = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($updateUsuarioQuery);
    $stmt->bind_param("di", $promedioCalificacion, $tecnico_id);

    if ($stmt->execute()) {
        $successMessage = "Calificación actualizada exitosamente. Promedio actualizado.";
    } else {
        $errorMessage = "Error al actualizar la calificación del técnico.";
    }
    $stmt->close();
}

// Consulta para obtener incidencias del usuario
$queryIncidencias = "
SELECT 
    i.folio, 
    i.fecha, 
    d.nombre AS nombre_departamento, 
    s.nombre AS nombre_salon, 
    i.computadora, 
    i.impresora, 
    i.proyector, 
    i.tipo_servicio, 
    u.nombre AS asignado_tecnico, -- Nombre del técnico asignado
    solicitante.nombre AS solicitante_nombre, -- Nombre del solicitante
    i.descripcion, 
    i.prioridad, 
    i.estatus 
FROM incidencias i
LEFT JOIN departamentos d ON i.id_departamento = d.id_departamento
LEFT JOIN salones s ON i.id_salon = s.id_salon
LEFT JOIN usuarios solicitante ON i.solicitante = solicitante.id_usuario -- Unión para el solicitante
LEFT JOIN usuarios u ON i.asignado_a = u.id_usuario -- Unión para el técnico asignado
WHERE i.solicitante = ?";

$stmt = $conn->prepare($queryIncidencias);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$incidencias = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/viewUser.css">
    <title>Soporte Escolar</title>
    <script>
        // Función para mostrar u ocultar la sección "Servicios"
        function openTab(evt, tabName) {
            var tabs = document.getElementsByClassName("tablinks-tab");
            for (var i = 0; i < tabs.length; i++) {
                tabs[i].style.display = "none";
            }
            document.getElementById(tabName).style.display = "block";
        }
    </script>
</head>
<body>

<div class="header">
    <div class="logo-user">
        <img src="../imagen/logoTec.png" alt="Logo Escolar"> <!-- Logo -->
        <div class="user-info">
            <h2><?php echo htmlspecialchars($user_name); ?></h2>
            <p>Departamento: <?php echo htmlspecialchars($department_name); ?></p>
        </div>
    </div>
    <div class="nav-options">
        <a href="../Incidencias/add_incidencias.php">Crear Incidencia</a>
        <a href="#" class="tablinks" onclick="openTab(event, 'Servicios')">Servicio</a>
        <a href="../index.html">Cerrar Sesión</a>
    </div>
</div>

<?php if (isset($successMessage)): ?>
    <p style="color: green;"><?= htmlspecialchars($successMessage) ?></p>
<?php endif; ?>

<?php if (isset($errorMessage)): ?>
    <p style="color: red;"><?= htmlspecialchars($errorMessage) ?></p>
<?php endif; ?>

<!-- Formulario para modificar incidencias -->
<form action="" method="POST">
    <div id="Servicios" class="tablinks-tab" style="display:none">
        <table>
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Departamento</th>
                    <th>Salón</th>
                    <th>Computadora</th>
                    <th>Impresora</th>
                    <th>Proyector</th>
                    <th>Tipo de servicio</th>
                    <th>Técnico</th>
                    <th>Solicitante</th>
                    <th>Descripción</th>
                    <th>Calificación 1 mal 5 excelente</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($incidente = $incidencias->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($incidente['folio']) ?></td>
                        <td><?= htmlspecialchars($incidente['fecha']) ?></td>
                        <td><?= htmlspecialchars($incidente['nombre_departamento']) ?></td>
                        <td><?= htmlspecialchars($incidente['nombre_salon']) ?></td>
                        <td><?= htmlspecialchars($incidente['computadora']) ?></td>
                        <td><?= htmlspecialchars($incidente['impresora']) ?></td>
                        <td><?= htmlspecialchars($incidente['proyector']) ?></td>
                        <td><?= htmlspecialchars($incidente['tipo_servicio']) ?></td>
                        <td><?= htmlspecialchars($incidente['asignado_tecnico']) ?></td>
                        <td><?= htmlspecialchars($incidente['solicitante_nombre']) ?></td>
                        <td><?= htmlspecialchars($incidente['descripcion']) ?></td>
                        <td>
                            <select name="calif" id="calif_<?= htmlspecialchars($incidente['folio']) ?>">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </td>
                        <td>
                            <button 
                                type="submit" 
                                name="submit" 
                                value="<?= htmlspecialchars($incidente['folio']) ?>">
                                Modificar
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</form>

</body>
</html>
