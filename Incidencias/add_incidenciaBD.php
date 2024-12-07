<?php
    include("../ConexionBD.php");
    include("../User/ObtenerUser.php");
    // Recibir datos del formulario   
    $id_solicitante = $user_id;
    $fecha = $_POST['fecha'];
    $departamento = $_POST['departamento'];
    $edificio = $_POST['edificio'];
    $salon = $_POST['salon'];
    $descripcion = $_POST['descripcion'];
    $computadora = $_POST['computadora']; // Obtener el identificador de computadora
    $impresora = $_POST['impresora']; // Obtener el identificador de impresora
    $proyector = $_POST['proyector']; // Obtener el identificador de proyector
    $tipo_servicio = $_POST['tipo_servicio'];
    $user = $user_id;
    // Obtener el ID del departamento
    $query_departamento = "SELECT id_departamento FROM departamentos WHERE nombre = '$departamento'";
    $result_departamento = $conn->query($query_departamento);

    if ($result_departamento->num_rows > 0) {
        $row_departamento = $result_departamento->fetch_assoc();
        $id_departamento = $row_departamento['id_departamento'];
    } else {
        die("Departamento no encontrado.");
    }

    // Obtener el ID del salón
    $query_salon = "SELECT id_salon FROM salones WHERE id_salon = '$salon'";
    $result_salon = $conn->query($query_salon);

    if ($result_salon->num_rows > 0) {
        $row_salon = $result_salon->fetch_assoc();
        $id_salon = $row_salon['id_salon'];
    } else {
        die("Salón no encontrado." . $salon);
    }

    // Consulta para agregar incidencia
    $query = "INSERT INTO incidencias 
    (fecha, id_departamento, descripcion, id_salon, computadora, impresora,proyector, tipo_servicio, solicitante, asignado_a, prioridad, estatus) VALUES 
    ('$fecha', '$id_departamento', '$descripcion', '$id_salon', '$computadora', '$impresora', '$proyector', '$tipo_servicio','$user', '1', NULL, ' ')";

    $result = $conn->query($query);
    if ($result) {
        // Incidencia agregada exitosamente, redirigir a la lista de incidencias
        header('Location: ../User/view_usuario.php');
        exit;
    } else {
        // Falló la adición de la incidencia, redirigir de vuelta al formulario con un mensaje de error
        header('Location: add_incidencia.php?error=failed_to_add_incidencia');
        exit;
    }
?>
