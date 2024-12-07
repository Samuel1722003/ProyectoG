<?php
    include('../ConexionBD.php');

    $query = "SELECT 
    i.folio, 
    i.fecha, 
    i.descripcion, 
    i.computadora, 
    i.impresora,
    i.proyector,
    tipo_servicio,
    d.nombre AS nombre_departamento, 
    s.nombre AS nombre_salon,
    u.id_usuario as Usuarioid,
    u.nombre AS nombre_asignado, 
    i.prioridad, 
    i.estatus,
    u.rol as rol_usuario
    FROM incidencias i
    JOIN departamentos d ON i.id_departamento = d.id_departamento
    JOIN salones s ON i.id_salon = s.id_salon
    JOIN usuarios u ON i.asignado_a = u.id_usuario";

    $queryProceso = "SELECT 
    i.folio, 
    i.fecha, 
    i.descripcion, 
    i.computadora, 
    tipo_servicio,
    i.impresora,
    i.proyector,
    d.nombre AS nombre_departamento, 
    s.nombre AS nombre_salon,
    u.id_usuario as Usuarioid,
    u.nombre AS nombre_asignado, 
    i.prioridad, 
    i.estatus,
    u.rol as rol_usuario
    FROM incidencias i
    JOIN departamentos d ON i.id_departamento = d.id_departamento
    JOIN salones s ON i.id_salon = s.id_salon
    JOIN usuarios u ON i.asignado_a = u.id_usuario
    WHERE i.estatus =  'En Proceso'";

    $queryTerminados = "SELECT 
    i.folio, 
    i.fecha, 
    i.descripcion, 
    tipo_servicio,
    i.computadora, 
    i.impresora,
    i.proyector,
    d.nombre AS nombre_departamento, 
    s.nombre AS nombre_salon,
    u.id_usuario as Usuarioid,
    u.nombre AS nombre_asignado, 
    i.prioridad, 
    i.estatus,
    u.rol as rol_usuario
    FROM incidencias i
    JOIN departamentos d ON i.id_departamento = d.id_departamento
    JOIN salones s ON i.id_salon = s.id_salon
    JOIN usuarios u ON i.asignado_a = u.id_usuario
    WHERE i.estatus =  'Terminado'";

    $queryLiberados = "SELECT 
    i.folio, 
    i.fecha, 
    i.descripcion, 
    i.computadora, 
    tipo_servicio,
    i.impresora,
    i.proyector,
    d.nombre AS nombre_departamento, 
    s.nombre AS nombre_salon,
    u.id_usuario as Usuarioid,
    u.nombre AS nombre_asignado, 
    i.prioridad, 
    i.estatus,
    u.rol as rol_usuario
    FROM incidencias i
    JOIN departamentos d ON i.id_departamento = d.id_departamento
    JOIN salones s ON i.id_salon = s.id_salon
    JOIN usuarios u ON i.asignado_a = u.id_usuario
    WHERE i.estatus =  'Liberado'";

    $queryRechazado = "SELECT 
    i.folio, 
    i.fecha, 
    i.descripcion, 
    i.computadora, 
    tipo_servicio,
    i.impresora,
    i.proyector,
    d.nombre AS nombre_departamento, 
    s.nombre AS nombre_salon,
    u.id_usuario as Usuarioid,
    u.nombre AS nombre_asignado, 
    i.prioridad, 
    i.estatus,
    u.rol as rol_usuario
    FROM incidencias i
    JOIN departamentos d ON i.id_departamento = d.id_departamento
    JOIN salones s ON i.id_salon = s.id_salon
    JOIN usuarios u ON i.asignado_a = u.id_usuario
    WHERE i.estatus =  'Rechazado'";

    $queryEnviado = "SELECT 
    i.folio, 
    i.fecha, 
    i.descripcion, 
    i.computadora, 
    tipo_servicio,
    i.impresora,
    i.proyector,
    d.nombre AS nombre_departamento, 
    s.nombre AS nombre_salon,
    u.id_usuario as Usuarioid,
    u.nombre AS nombre_asignado, 
    i.prioridad, 
    i.estatus,
    u.rol as rol_usuario
    FROM incidencias i
    JOIN departamentos d ON i.id_departamento = d.id_departamento
    JOIN salones s ON i.id_salon = s.id_salon
    JOIN usuarios u ON i.asignado_a = u.id_usuario
    WHERE i.estatus =''";


    $query_tecnico = "SELECT 
    i.folio, 
    i.fecha, 
    i.descripcion, 
    i.computadora, 
    tipo_servicio,
    i.impresora,
    i.proyector,
    d.nombre AS nombre_departamento, 
    s.nombre AS nombre_salon, 
    u.nombre AS nombre_asignado, 
    i.prioridad, 
    i.estatus,
    u.rol as rol_usuario
    FROM incidencias i
    JOIN departamentos d ON i.id_departamento = d.id_departamento
    JOIN salones s ON i.id_salon = s.id_salon
    JOIN usuarios u ON i.asignado_a = u.id_usuario
    WHERE u.rol = 'Tecnico'"; 


        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Error en la consulta: " . mysqli_error($conn));
        }
    $incidenciaEnviado = mysqli_query($conn, $queryEnviado);
    $incidenciaRechazado = mysqli_query($conn, $queryRechazado);
    $incidenciaLiberado = mysqli_query($conn, $queryLiberados);
    $incidenciaTerminado = mysqli_query($conn, $queryTerminados);
    $incidenciaProceso = mysqli_query($conn, $queryProceso);
    $ObtenerNombres = mysqli_query($conn, $query);
    $departments = mysqli_query($conn, "SELECT * FROM departamentos");
    $edificios = mysqli_query($conn, "SELECT e.*, d.nombre AS nombre_departamento FROM edificios e JOIN departamentos d ON e.id_departamento = d.id_departamento");
    $salones = mysqli_query($conn, "SELECT s.*, e.nombre as Nombre_edificio FROM salones s,  edificios e WHERE s.id_edificio = e.id_edificio");
    $problemas =  mysqli_query($conn, "SELECT * FROM problemas");

    $usuarios = mysqli_query($conn, "SELECT u.*, d.nombre as nombre_departamento FROM usuarios u inner join departamentos d on  u.id_departamento = d.id_departamento");

    $incidentes = mysqli_query($conn, "SELECT * FROM incidencias");
    $rfc = mysqli_query($conn, "SELECT * FROM rfc");
    $computadoras =  mysqli_query($conn, "SELECT c.*, s.nombre as nombre_salon FROM computadoras c inner join salones s on  c.id_salon = s.id_salon");

    $impresoras =  mysqli_query($conn, "SELECT i.*, s.nombre as nombre_salon FROM impresoras i inner join  salones s on  i.id_salon = s.id_salon");

    $proyectores =  mysqli_query($conn, "SELECT p.*, s.nombre as nombre_salon FROM proyectores p inner join salones s on p.id_salon = s.id_salon");
 
    $rfc = mysqli_query($conn, "
    SELECT r.*, s.nombre AS nombre_salon, d.nombre AS nombre_departamento 
    FROM rfc r
    JOIN salones s ON r.id_salon = s.id_salon 
    JOIN departamentos d ON r.id_departamento = d.id_departamento 
    WHERE r.importe >= 1000
");

    $rfc2 = mysqli_query($conn, "
    SELECT r.*, s.nombre AS nombre_salon, d.nombre AS nombre_departamento 
    FROM rfc r
    JOIN salones s ON r.id_salon = s.id_salon 
    JOIN departamentos d ON r.id_departamento = d.id_departamento 
    WHERE r.importe < 1000
");

$problemas = mysqli_query($conn, "
    SELECT p.*, s.nombre AS nombre_salon, d.nombre AS nombre_departamento 
    FROM problemas p
    JOIN salones s ON p.id_salon = s.id_salon
    JOIN departamentos d ON p.id_departamento = d.id_departamento
");
$problemas1 = mysqli_query($conn, "
    SELECT 
        p.*, 
        s.nombre AS nombre_salon, 
        d.nombre AS nombre_departamento, 
        u.nombre AS nombre_asignado,
        i.descripcion AS descripcion_incidencia,  -- Obtener la descripcion desde la tabla 'incidencias'
        p.tipo_servicio                    -- Tipo de servicio desde la tabla 'problemas'
    FROM problemas p
    JOIN salones s ON p.id_salon = s.id_salon
    JOIN departamentos d ON p.id_departamento = d.id_departamento
    LEFT JOIN usuarios u ON p.id_usuario = u.id_usuario
    LEFT JOIN incidencias i ON p.folio = i.folio  -- Unir la tabla incidencias usando el folio
");


$vitacoraPc = mysqli_query($conn, "Select * from computadoras where id_computadora = id_computadora")



?>