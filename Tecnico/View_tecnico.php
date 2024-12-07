<?php
include("../User/ObtenerUser.php");
include("../ConexionBD.php");
include("../Admin/Querrys.php");

// Query para obtener incidencias asignadas al técnico
$queryIncidencias = "SELECT 
    i.folio, 
    i.fecha, 
    i.descripcion, 
    i.computadora, 
    i.impresora,
    i.proyector,
    d.nombre AS nombre_departamento, 
    s.nombre AS nombre_salon, 
    u.id_usuario AS Usuarioid, 
    u.nombre AS nombre_asignado, 
    i.prioridad, 
    i.estatus 
FROM incidencias i 
JOIN departamentos d ON i.id_departamento = d.id_departamento 
JOIN salones s ON i.id_salon = s.id_salon 
JOIN usuarios u ON i.asignado_a = u.id_usuario 
WHERE i.asignado_a = $user_id"; // Filtrando por el usuario actual

$ObtenerNombres = mysqli_query($conn, $queryIncidencias);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="css/view_tec.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soporte Escolar</title>
</head>

<body>
    <div class="header">
        <div class="logo-user">
            <img src="../imagen/logoTec.png" alt="Logo Escolar">
            <div class="user-info">
                <h2><?php echo htmlspecialchars($user_name); ?></h2>
                <p>Departamento: <?php echo htmlspecialchars($department_name); ?></p>
            </div>
        </div>
        <div class="nav-options">
            <a href="#" class="tablinks" onclick="openTab(event, 'incidentes')">Incidencias</a>
            <a href="#" class="tablinks" onclick="openTab(event, 'problemas')">Problemas</a>
            <a href="../index.html">Cerrar Sesión</a>
        </div>
    </div>

    <form action="mod_insidencia.php" method="POST">
        <div id="incidentes" class="tabcontent" style="display:none">
            <table>
                <tr>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Departamento</th>
                    <th>Salón</th>
                    <th>computadora</th>
                    <th>Proyector</th>
                    <th>Impresora</th>
                    <th>Asignado a</th>
                    <th>Tiempo De servicio</th>
                    <th>Prioridad</th>
                    <th>Estatus</th>
                    <th>Acción</th>
                </tr>
                <?php while ($incidente = mysqli_fetch_assoc($ObtenerNombres)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($incidente['folio']) ?></td>
                        <td><?= htmlspecialchars($incidente['fecha']) ?></td>
                        <td><?= htmlspecialchars($incidente['descripcion']) ?></td>
                        <td><?= htmlspecialchars($incidente['nombre_departamento'] ?? 'No disponible') ?></td>
                        <td><?= htmlspecialchars($incidente['nombre_salon'] ?? 'No disponible') ?></td>
                        <td><?= htmlspecialchars($incidente['computadora']) ?></td>
                        <td><?= htmlspecialchars($incidente['proyector']) ?></td>
                        <td><?= htmlspecialchars($incidente['impresora']) ?></td>
                        <td>
                            <?php
                            // Ya tenemos el nombre del técnico en la consulta, solo se muestra aquí
                            echo htmlspecialchars($incidente['nombre_asignado'] ?? 'No asignado');
                            ?>
                        </td>
                        <td>
                            <select name="tiempo" id="">
                                <option value="1 hora">1 horas</option>
                                <option value="2 horas">2 horas</option>
                                <option value="4 horas">4 horas</option>
                                <option value="6 horas">6 horas</option>
                            </select>
                        </td>

                        <!-- Mostrar la prioridad -->
                        <td><?= htmlspecialchars($incidente['prioridad']) ?></td>

                        <!-- Select para el estatus -->
                        <td>
                            <select name="estatus">
                                <option value="En proceso" <?= $incidente['estatus'] == 'En proceso' ? 'selected' : '' ?>>En
                                    Proceso</option>
                                <option value="Terminado" <?= $incidente['estatus'] == 'Terminado' ? 'selected' : '' ?>>
                                    Terminado</option>
                                <option value="Liberado" <?= $incidente['estatus'] == 'Liberado' ? 'selected' : '' ?>>Liberado
                                </option>
                                <option value="Rechazado" <?= $incidente['estatus'] == 'Rechazado' ? 'selected' : '' ?>>
                                    Rechazado</option>
                            </select>
                        </td>

                        <!-- Botón de modificar para cada fila -->
                        <td>
                            <button type="submit" name="folio" value="<?= htmlspecialchars($incidente['folio']) ?>">Modificar</button>
                            <button type="submit" formaction="../Tecnico/agrega_rfc.php" name="folio_rfc" value="<?= htmlspecialchars($incidente['folio']) ?>">RFC</button>
                            <button type="submit" formaction="../Tecnico/mod_computadora.php" name="folio_rfc" value="<?= htmlspecialchars($incidente['computadora']) ?>">PC</button>

                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </form>
             
    <form action="mod_problema.php" method ="post">
        <div id="problemas" class="tabcontent" style="display:none">
            <table>
                <tr>
                    <th>Problema</th>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Departamento</th>
                    <th>Salón</th>
                    <th>computadora</th>
                    <th>Proyector</th>
                    <th>Impresora</th>
                    <th>Asignado a</th>
                    <th>Tipo Servicio</th>
                    <th>Problema</th>
                    <th>Solucion</th>
                    <th>Estatus</th>
                    <th>Accion</th>
                </tr>
                <?php while ($incidente = mysqli_fetch_assoc($problemas1)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($incidente['id_problema']) ?></td>
                        <td><?= htmlspecialchars($incidente['folio']) ?></td>
                        <td><?= htmlspecialchars($incidente['fecha']) ?></td>
                        <td><?= htmlspecialchars($incidente['nombre_departamento'] ?? 'No disponible') ?></td>
                        <td><?= htmlspecialchars($incidente['nombre_salon'] ?? 'No disponible') ?></td>
                        <td><?= htmlspecialchars($incidente['computadora']) ?></td>
                        <td><?= htmlspecialchars($incidente['proyector']) ?></td>
                        <td><?= htmlspecialchars($incidente['impresora']) ?></td>
                        <td>
                            <?php
                            // Ya tenemos el nombre del técnico en la consulta, solo se muestra aquí
                            echo htmlspecialchars($incidente['nombre_asignado'] ?? 'No asignado');
                            ?>
                        </td>
                        <td><?= htmlspecialchars($incidente['tipo_servicio']) ?></td>
                        <td><?= htmlspecialchars($incidente['descripcion_incidencia']) ?></td>
                        <td><?= htmlspecialchars($incidente['descripcion']) ?></td>
                        <td><?= htmlspecialchars($incidente['estatus']) ?></td>
                        <td>
                            <button type="submit" name="folio" value="<?= htmlspecialchars($incidente['folio']) ?>">Modificar</button>
                        </td>
                        
                    </tr>
                <?php } ?>
            </table>
        </div>
    </form>
    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");

            // Obtener la pestaña que queremos mostrar/ocultar
            var currentTab = document.getElementById(tabName);

            // Si la pestaña ya está visible, la ocultamos
            if (currentTab.style.display === "block") {
                currentTab.style.display = "none";
                evt.currentTarget.className = evt.currentTarget.className.replace(" active", "");
                return;
            }

            // Ocultar todo el contenido de las pestañas
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Remover la clase "active" de todos los enlaces
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Mostrar la pestaña seleccionada
            currentTab.style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
</body>

</html>