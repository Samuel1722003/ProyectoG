<?php
include("../User/ObtenerUser.php");
include("../ConexionBD.php");
include("Querrys.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <script src="js/Dash.js"></script>
    <link rel="stylesheet" href="css/Dashboard.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soporte Escolar</title>
</head>

<body>
    <div class="header">
        <div class="logo-user">
            <img src="../imagen/logoTec.png" alt="Logo Escolar"> <!-- Reemplaza con la ruta de tu logo -->
            <div class="user-info">
                <h2><?php echo $user_name; ?></h2>
                <p>Departamento: <?php echo $department_name; ?></p>
            </div>
        </div>
        <div>
            <div class="nav-options" id="menu">
                <a href="#" class="tablinks" onclick="openTab(event, 'departamentos')">Departamentos</a>
                <a href="#" class="tablinks" onclick="openTab(event, 'edificios')">Edificios</a>
                <a href="#" class="tablinks" onclick="openTab(event, 'salones')">Salones</a>
                <a href="#" class="tablinks" onclick="openTab(event, 'usuarios')">Usuarios</a>
                <a href="#" class="tablinks" onclick="openTab(event, 'incidentes')">Incidencias</a>
                <a href="#" class="tablinks" onclick="openTab(event, 'equipos')">Equipos</a>
                <a href="#" class="tablinks" onclick="openTab(event, 'rfc')">RFC</a>
                <a href="#" class="tablinks" onclick="openTab(event, 'problematica')">Problemas</a>
                <a href="../index.html">Cerrar Sesión</a>
            </div>
        </div>
    </div>
    <div id="problematica" class="tabcontent" style="display:none">
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
                    </tr>
                <?php } ?>
            </table>
        
    </div>
    <div id="rfc" class="tabcontent" style="display:none">
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
            <?php while ($incidente = mysqli_fetch_assoc($rfc2)) { ?>
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
    <div id="equipos" class="tabcontent" style="display:none">
        <div class="header-container">
            <div class="inner-nav">
                <button class="tablinks" onclick="openEquipmentTab(event, 'computadoras')">Computadoras</button>
                <button class="tablinks" onclick="openEquipmentTab(event, 'impresoras')">Impresoras</button>
                <button class="tablinks" onclick="openEquipmentTab(event, 'proyectores')">Proyectores</button>
            </div>
        </div>
        <div id="impresoras" class="equipment-tab" style="display:none">
            <div class="header-container">
                <a href="add_computadoras.html"><button class="buttonA">Agregar Impresoras</button></a>
            </div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Salon</th>
                    <th>Identificador</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Tipo</th>
                    <th>Capacidad de papel</th>
                    <th>Fecha de Compra</th>
                    <th>Acción</th>
                </tr>
                <?php while ($impresora = mysqli_fetch_assoc($impresoras)) { ?>
                    <tr>
                        <td><?= $impresora['id_impresora'] ?></td>
                        <td><?= $impresora['nombre_salon'] ?></td>
                        <td><?= $impresora['identificador'] ?></td>
                        <td><?= $impresora['marca'] ?></td>
                        <td><?= $impresora['modelo'] ?></td>
                        <td><?= $impresora['tipo'] ?></td>
                        <td><?= $impresora['capacidad_papel'] ?></td>
                        <td><?= $impresora['fecha_compra'] ?></td>
                        <td>
                            <a href="del_impresora.php?id=<?= $impresora['id_impresora'] ?>"><button>Eliminar</button></a>
                            <a href="mod_impresora.php?id=<?= $impresora['id_impresora'] ?>"><button>Modificar</button></a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <div id="proyectores" class="equipment-tab" style="display:none">
            <div class="header-container">
                <a href="add_computadoras.html"><button class="buttonA">Agregar Proyectores</button></a>
            </div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Salon</th>
                    <th>Identificador</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Resolucion</th>
                    <th>Tipo de lente</th>
                    <th>Fecha de Compra</th>
                    <th>Acción</th>
                </tr>
                <?php while ($proyector = mysqli_fetch_assoc($proyectores)) { ?>
                    <tr>
                        <td><?= $proyector['id_proyector'] ?></td>
                        <td><?= $proyector['nombre_salon'] ?></td>
                        <td><?= $proyector['identificador'] ?></td>
                        <td><?= $proyector['marca'] ?></td>
                        <td><?= $proyector['modelo'] ?></td>
                        <td><?= $proyector['resolucion'] ?></td>
                        <td><?= $proyector['tipo_lente'] ?></td>
                        <td><?= $proyector['fecha_compra'] ?></td>
                        <td>
                            <a href="del_proyector.php?id=<?= $proyector['id_proyector'] ?>"><button>Eliminar</button></a>
                            <a href="del_proyector.php?id=<?= $proyector['id_proyector'] ?>"><button>Modificar</button></a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <div id="computadoras" class="equipment-tab">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Salón</th>
                    <th>Identificador</th>
                    <th>Tarjeta Madre</th>
                    <th>RAM</th>
                    <th>ROM</th>
                    <th>Almacenamiento</th>
                    <th>Fecha de Compra</th>
                    <th>Acción</th>
                </tr>
                <?php while ($compus = mysqli_fetch_assoc($computadoras)) { ?>
                    <tr>
                        <td><?= $compus['id_computadora'] ?></td>
                        <td><?= $compus['nombre_salon'] ?></td>
                        <td><?= $compus['identificador'] ?></td>
                        <td><?= $compus['tarjeta_madre'] ?></td>
                        <td><?= $compus['procesador'] ?></td>
                        <td><?= $compus['RAM'] ?></td>
                        <td><?= $compus['ROM'] ?></td>
                        <td><?= $compus['fecha_compra'] ?></td>
                        <td>
                            <a href="bitacoraPc.php?id_computadora=<?= $compus['id_computadora'] ?>"><button>Bitácora</button></a>
                            <a href="del_computadora.php?id=<?= $compus['id_computadora'] ?>"><button>Eliminar</button></a>
                            <a href="mod_computadora.php?id=<?= $compus['id_computadora'] ?>"><button>Modificar</button></a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    </div>
    <div id="departamentos" class="tabcontent">
        <div class="header-container">
            <a href="add_departamento.html"><button class="buttonA">Agregar Departamentos</button></a>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acción</th>
            </tr>
            <?php while ($department = mysqli_fetch_assoc($departments)) { ?>
                <tr>
                    <td><?= $department['id_departamento'] ?></td>
                    <td><?= $department['Nombre'] ?></td>
                    <td>
                        <a href="del_departamento.php?id=<?= $department['id_departamento'] ?>">
                            <button>Eliminar</button>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div id="salones" class="tabcontent" style="display:none">
        <div class="header-container">
            <a href="add_salon.php"><button class="buttonA">Agregar Salones</button></a>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Nombre Edificio</th> <!-- Cambiado a nombre del edificio -->
                <th>Acción</th>
            </tr>
            <?php while ($salon = mysqli_fetch_assoc($salones)) { ?>
                <tr>
                    <td><?= $salon['id_salon'] ?></td>
                    <td><?= $salon['nombre'] ?></td>
                    <td><?= $salon['Nombre_edificio'] ?></td> <!-- Aquí accedes al nombre del edificio -->
                    <td>
                        <a href="del_salon.php?id=<?= $salon['id_salon'] ?>">
                            <button>Eliminar</button>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div id="edificios" class="tabcontent" style="display:none">
        <div class="header-container">
            <a href="add_edificio.php"><button class="buttonA">Agregar Edificios</button></a>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Nombre Departamento</th> <!-- Cambiado a nombre del departamento -->
                <th>Acción</th>
            </tr>
            <?php
            while ($edificio = mysqli_fetch_assoc($edificios)) { ?>
                <tr>
                    <td><?= $edificio['id_edificio'] ?></td>
                    <td><?= $edificio['nombre'] ?></td>
                    <td><?= $edificio['nombre_departamento'] ?></td>
                    <td>
                        <a href="del_edificio.php?id=<?= $edificio['id_edificio'] ?>">
                            <button>Eliminar</button>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div id="usuarios" class="tabcontent" style="display:none">
        <div class="header-container">
            <a href="../User/add_usuario.php"><button class="buttonA">Agregar Usuario</button></a>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Password</th>
                <th>Role</th>
                <th>Nombre departamento</th>
                <th>Acciones</th>
            </tr>
            <?php while ($usuario = mysqli_fetch_assoc($usuarios)) { ?>
                <tr>
                    <td><?= $usuario['id_usuario'] ?></td>
                    <td><?= $usuario['nombre'] ?></td>
                    <td><?= $usuario['correo'] ?></td>
                    <td><?= $usuario['password'] ?></td>
                    <td><?= $usuario['rol'] ?></td>
                    <td><?= $usuario['nombre_departamento'] ?></td>
                    <td>
                        <button>Eliminar</button>
                        <button>Modificar</button>
                    </td>

                </tr>
            <?php } ?>
        </table>
    </div>
    <div id="incidentes" class="tabcontent" style="display:none">
        <div class="header-container">
            <div class="inner-nav">
                <button class="tablinks" onclick="openIncidenciasTab(event, 'enviados')">Enviados</button>
                <button class="tablinks" onclick="openIncidenciasTab(event, 'en_proceso')">En Proceso</button>
                <button class="tablinks" onclick="openIncidenciasTab(event, 'terminados')">Terminados</button>
                <button class="tablinks" onclick="openIncidenciasTab(event, 'liberados')">Liberados</button>
                <button class="tablinks" onclick="openIncidenciasTab(event, 'rechazados')">Rechazados</button>
                <button class="tablinks" onclick="openIncidenciasTab(event, 'todos')">Todos</button>
            </div>
        </div>
        <form action="../Incidencias/actualizar_incidencia.php" method="POST">
            <div id="todos" class="incidencias-tab" style="display:none">
                <table>
                    <tr>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Departamento</th>
                        <th>Salón</th>
                        <th>Computadora</th>
                        <th>Impresora</th>
                        <th>Proyector</th>
                        <th>Tipo de servicio</th>
                        <th>Asignado a</th>
                        <th>Descripción</th>
                        <th>Prioridad</th>
                        <th>Estatus</th>
                        <th>Accion</th>
                    </tr>
                    <?php while ($incidente = mysqli_fetch_assoc($ObtenerNombres)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($incidente['folio']) ?></td>
                            <td><?= htmlspecialchars($incidente['fecha']) ?></td>
                            <td><?= htmlspecialchars($incidente['nombre_departamento']) ?></td>
                            <td><?= htmlspecialchars($incidente['nombre_salon']) ?></td>
                            <td><?= htmlspecialchars($incidente['computadora']) ?></td>
                            <td><?= htmlspecialchars($incidente['impresora']) ?></td>
                            <td><?= htmlspecialchars($incidente['proyector']) ?></td>
                            <td><?= htmlspecialchars($incidente['tipo_servicio']) ?></td>
                            <td><?= htmlspecialchars($incidente['nombre_asignado']) ?></td>
                            <td><?= htmlspecialchars($incidente['descripcion']) ?></td>
                            <td><?= htmlspecialchars($incidente['prioridad']) ?></td>
                            <td><?= htmlspecialchars($incidente['estatus']) ?></td>
                            <td>
                                <button type="submit" formaction="agrega_problema.php" name="folio_rfc" value="<?= htmlspecialchars($incidente['folio']) ?>">Problema</button>
                            </td>
                        </tr>
                    <?php } ?>
                    
                </table>
            </div>
        </form>

        <form action="../Incidencias/actualizar_incidencia.php" method="POST">
            <div id="enviados" class="incidencias-tab" style="display:none">
                <table>
                    <tr>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Departamento</th>
                        <th>Salón</th>
                        <th>Computadora</th>
                        <th>Impresora</th>
                        <th>Proyector</th>
                        <th>Tipo de servicio</th>
                        <th>Asignado a</th>
                        <th>Descripción</th>
                        <th>Prioridad</th>
                        <th>Estatus</th>
                        <th>Acción</th>
                    </tr>
                    <?php while ($incidente = mysqli_fetch_assoc($incidenciaEnviado)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($incidente['folio']) ?></td>
                            <td><?= htmlspecialchars($incidente['fecha']) ?></td>
                            <td><?= htmlspecialchars($incidente['nombre_departamento']) ?></td>
                            <td><?= htmlspecialchars($incidente['nombre_salon']) ?></td>
                            <td><?= htmlspecialchars($incidente['computadora']) ?></td>
                            <td><?= htmlspecialchars($incidente['impresora']) ?></td>
                            <td><?= htmlspecialchars($incidente['proyector']) ?></td>
                            <td><?= htmlspecialchars($incidente['tipo_servicio']) ?></td>


                            <!-- Select para el técnico -->
                            <?php
                            // Consulta para obtener técnicos antes del inicio del bucle
                            $listaTecnicos = mysqli_query($conn, "SELECT nombre, id_usuario FROM usuarios WHERE rol = 'Tecnico'");
                            $tecnicosArray = mysqli_fetch_all($listaTecnicos, MYSQLI_ASSOC);
                            ?>
                            <td>
                                <select name="asignado_a[<?= htmlspecialchars($incidente['folio']) ?>]">
                                    <!-- Usando el folio -->
                                    <option value="">Selecciona un técnico</option> <!-- Opción predeterminada -->
                                    <?php foreach ($tecnicosArray as $tecnico) { ?>
                                        <option value="<?= htmlspecialchars($tecnico['id_usuario']); ?>">
                                            <?= htmlspecialchars($tecnico['nombre']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td><?= htmlspecialchars($incidente['descripcion']) ?></td>
                            <!-- Select para la prioridad -->
                            <td>
                                <select name="prioridad[<?= htmlspecialchars($incidente['folio']) ?>]">
                                    <option value="Alto">Alta</option>
                                    <option value="Medio">Media</option>
                                    <option value="Bajo">Baja</option>
                                </select>
                            </td>

                            <!-- Select para el estatus -->
                            <td>
                                <select name="estatus[<?= htmlspecialchars($incidente['folio']) ?>]">
                                    <option value="En proceso">En Proceso</option>
                                    <option value="Terminado">Terminado</option>
                                    <option value="Liberado">Liberado</option>
                                    <option value="Rechazado">Rechazado</option>
                                </select>
                            </td>

                            <!-- Botón de modificar para cada fila -->
                            <td>
                                <button type="submit" name="folio"
                                    value="<?= htmlspecialchars($incidente['folio']) ?>">Modificar</button>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </form>

        <form action="../Incidencias/actualizar_incidencia.php" method="POST">
            <div id="liberados" class="incidencias-tab" style="display:none">
                <table>
                    <tr>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Departamento</th>
                        <th>Salón</th>
                        <th>Computadora</th>
                        <th>Impresora</th>
                        <th>Proyector</th>
                        <th>Tipo de servicio</th>
                        <th>Asignado a</th>
                        <th>Descripción</th>
                        <th>Prioridad</th>
                        <th>Estatus</th>
                    </tr>
                    <?php while ($incidente = mysqli_fetch_assoc($incidenciaLiberado)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($incidente['folio']) ?></td>
                            <td><?= htmlspecialchars($incidente['fecha']) ?></td>
                            <td><?= htmlspecialchars($incidente['nombre_departamento']) ?></td>
                            <td><?= htmlspecialchars($incidente['nombre_salon']) ?></td>
                            <td><?= htmlspecialchars($incidente['computadora']) ?></td>
                            <td><?= htmlspecialchars($incidente['impresora']) ?></td>
                            <td><?= htmlspecialchars($incidente['proyector']) ?></td>
                            <td><?= htmlspecialchars($incidente['tipo_servicio']) ?></td>
                            <td><?= htmlspecialchars($incidente['nombre_asignado']) ?></td>
                            <td><?= htmlspecialchars($incidente['descripcion']) ?></td>
                            <td><?= htmlspecialchars($incidente['prioridad']) ?></td>
                            <td><?= htmlspecialchars($incidente['estatus']) ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </form>
        <form action="../Incidencias/actualizar_incidencia.php" method="POST">
            <div id="terminados" class="incidencias-tab" style="display:none">
                <table>
                    <tr>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Departamento</th>
                        <th>Salón</th>
                        <th>Computadora</th>
                        <th>Impresora</th>
                        <th>Proyector</th>
                        <th>Tipo de servicio</th>
                        <th>Asignado a</th>
                        <th>Descripción</th>
                        <th>Prioridad</th>
                        <th>Estatus</th>
                    </tr>
                    <?php while ($incidente = mysqli_fetch_assoc($incidenciaTerminado)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($incidente['folio']) ?></td>
                            <td><?= htmlspecialchars($incidente['fecha']) ?></td>
                            <td><?= htmlspecialchars($incidente['nombre_departamento']) ?></td>
                            <td><?= htmlspecialchars($incidente['nombre_salon']) ?></td>
                            <td><?= htmlspecialchars($incidente['computadora']) ?></td>
                            <td><?= htmlspecialchars($incidente['impresora']) ?></td>
                            <td><?= htmlspecialchars($incidente['proyector']) ?></td>
                            <td><?= htmlspecialchars($incidente['tipo_servicio']) ?></td>
                            <td><?= htmlspecialchars($incidente['nombre_asignado']) ?></td>
                            <td><?= htmlspecialchars($incidente['descripcion']) ?></td>
                            <td><?= htmlspecialchars($incidente['prioridad']) ?></td>
                            <td><?= htmlspecialchars($incidente['estatus']) ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </form>

        <form action="../Incidencias/actualizar_incidencia.php" method="POST">
            <div id="en_proceso" class="incidencias-tab" style="display:none">
            <table>
                    <tr>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Departamento</th>
                        <th>Salón</th>
                        <th>Computadora</th>
                        <th>Impresora</th>
                        <th>Proyector</th>
                        <th>Tipo de servicio</th>
                        <th>Asignado a</th>
                        <th>Descripción</th>
                        <th>Prioridad</th>
                        <th>Estatus</th>
                    </tr>
                    <?php while ($incidente = mysqli_fetch_assoc($incidenciaProceso)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($incidente['folio']) ?></td>
                            <td><?= htmlspecialchars($incidente['fecha']) ?></td>
                            <td><?= htmlspecialchars($incidente['nombre_departamento']) ?></td>
                            <td><?= htmlspecialchars($incidente['nombre_salon']) ?></td>
                            <td><?= htmlspecialchars($incidente['computadora']) ?></td>
                            <td><?= htmlspecialchars($incidente['impresora']) ?></td>
                            <td><?= htmlspecialchars($incidente['proyector']) ?></td>
                            <td><?= htmlspecialchars($incidente['tipo_servicio']) ?></td>
                            <td><?= htmlspecialchars($incidente['nombre_asignado']) ?></td>
                            <td><?= htmlspecialchars($incidente['descripcion']) ?></td>
                            <td><?= htmlspecialchars($incidente['prioridad']) ?></td>
                            <td><?= htmlspecialchars($incidente['estatus']) ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </form>

        <form action="../Incidencias/ActualizaRechazado.php" method="POST">
            <div id="rechazados" class="incidencias-tab" style="display:none">
            <table>
                    <tr>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Departamento</th>
                        <th>Salón</th>
                        <th>Computadora</th>
                        <th>Impresora</th>
                        <th>Proyector</th>
                        <th>Tipo de servicio</th>
                        <th>Asignado a</th>
                        <th>Descripción</th>
                        <th>Prioridad</th>
                        <th>Estatus</th>
                        <th>Accion</th>
                    </tr>
                    <?php while ($incidente = mysqli_fetch_assoc($incidenciaRechazado)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($incidente['folio']) ?></td>
                            <td><?= htmlspecialchars($incidente['fecha']) ?></td>
                            <td><?= htmlspecialchars($incidente['nombre_departamento']) ?></td>
                            <td><?= htmlspecialchars($incidente['nombre_salon']) ?></td>
                            <td><?= htmlspecialchars($incidente['computadora']) ?></td>
                            <td><?= htmlspecialchars($incidente['impresora']) ?></td>
                            <td><?= htmlspecialchars($incidente['proyector']) ?></td>
                            <td><?= htmlspecialchars($incidente['tipo_servicio']) ?></td>
                            <td>
                                <?php
                                // Consulta para obtener técnicos antes del inicio del bucle
                                $listaTecnicos = mysqli_query($conn, "SELECT nombre, id_usuario FROM usuarios WHERE rol = 'Tecnico'");
                                $tecnicosArray = mysqli_fetch_all($listaTecnicos, MYSQLI_ASSOC);
                                ?>
                                <select name="asignado_a[<?= htmlspecialchars($incidente['folio']) ?>]">
                                    <!-- Usando el folio -->
                                    <option value="">Selecciona un técnico</option> <!-- Opción predeterminada -->
                                    <?php foreach ($tecnicosArray as $tecnico) { ?>
                                        <option value="<?= htmlspecialchars($tecnico['id_usuario']); ?>"
                                            <?= isset($incidente['asignado_a']) && $incidente['asignado_a'] === $tecnico['id_usuario'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($tecnico['nombre']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td><?= htmlspecialchars($incidente['descripcion']) ?></td>
                            <td><?= htmlspecialchars($incidente['prioridad']) ?></td>
                            <td>
                                <select name="estatus[<?= htmlspecialchars($incidente['folio']) ?>]" required>
                                    <option value="">Selecciona un estatus</option>
                                    <option value="En proceso" <?= $incidente['estatus'] === 'En proceso' ? 'selected' : '' ?>>
                                        En Proceso</option>
                                    <option value="Terminado" <?= $incidente['estatus'] === 'Terminado' ? 'selected' : '' ?>>
                                        Terminado</option>
                                    <option value="Liberado" <?= $incidente['estatus'] === 'Liberado' ? 'selected' : '' ?>>
                                        Liberado</option>
                                    <option value="Rechazado" <?= $incidente['estatus'] === 'Rechazado' ? 'selected' : '' ?>>
                                        Rechazado</option>
                                </select>
                            </td>
                            <td>
                                <button type="submit" name="folio"
                                    value="<?= htmlspecialchars($incidente['folio']) ?>">Modificar</button>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </form>

</body>

</html>