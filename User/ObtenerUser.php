<?php
include("../ConexionBD.php");
session_start();

// Obtener ID del usuario de la sesión
$user_id = $_SESSION['id'];

// Consulta para obtener el nombre del usuario y su departamento
$query = "SELECT u.nombre AS usuario_nombre, d.nombre AS departamento_nombre 
          FROM usuarios u 
          INNER JOIN departamentos d ON u.id_departamento = d.id_departamento 
          WHERE u.id_usuario = ?";

// Usar sentencias preparadas para mayor seguridad
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id); // "i" para tipo entero
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $department_data = $result->fetch_assoc();
    $user_name = $department_data['usuario_nombre'];
    $department_name = $department_data['departamento_nombre'];
} else {
    echo "Usuario no encontrado";
}

// Cerrar la declaración preparada
$stmt->close();
?>
