<?php
include('../ConexionBD.php');
include("../User/ObtenerUser.php");
include('../Admin/Querrys.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <script src="js/script.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/rfc.css">
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
            <a href="#" class="tablinks" onclick="openTab(event, 'rfc')">RFC</a>
            <a href="../index.html">Cerrar Sesión</a>
        </div>
    </div>

    <div id="rfc" class="tabcontent" style="display:block">
        <form method="POST" action="modificar_rfc.php"> <!-- Asegúrate de tener este archivo para manejar el guardado -->
            <table>
                <tr>
                    <th>RFC</th>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Departamento</th>
                    <th>Salón</th>
                    <th>Computadora</th>
                    <th>Impresora</th>
                    <th>Proyector</th>
                    <th>Descripción</th>
                    <th>Importe</th>
                    <th>Prioridad</th>
                    <th>Estatus</th>
                    <th>Acción</th>
                </tr>
                <?php while ($incidente = mysqli_fetch_assoc($rfc)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($incidente['id_rfc']) ?></td>
                        <td><?= htmlspecialchars($incidente['folio']) ?></td>
                        <td><?= htmlspecialchars($incidente['fecha']) ?></td>
                        <td><?= htmlspecialchars($incidente['nombre_departamento']) ?></td>
                        <td><?= htmlspecialchars($incidente['nombre_salon']) ?></td>
                        <td><?= htmlspecialchars($incidente['computadora']) ?></td>
                        <td><?= htmlspecialchars($incidente['impresora']) ?></td>
                        <td><?= htmlspecialchars($incidente['proyector']) ?></td>
                        <td><?= htmlspecialchars($incidente['descripcion']) ?></td>
                        <td><?= htmlspecialchars($incidente['importe']) ?></td>
                        <td><?= htmlspecialchars($incidente['prioridad']) ?></td>

                        <!-- Select para el estatus -->
                        <td>
                            <select name="estatus[<?= htmlspecialchars($incidente['folio']) ?>]">
                                <option value="Pendiente" <?= ($incidente['estatus'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="Aprobado" <?= ($incidente['estatus'] == 'Aprobado') ? 'selected' : ''; ?>>Aprobado</option>
                                <option value="Rechazado" <?= ($incidente['estatus'] == 'Rechazado') ? 'selected' : ''; ?>>Rechazado</option>
                            </select>
                        </td>

                        <!-- Botón de modificar para cada fila -->
                        <td>
                            <button type="submit" name="folio" value="<?= htmlspecialchars($incidente['folio']) ?>">Modificar</button>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </form>
    </div>
</body>
</html>
