<?php
include('../ConexionBD.php');
$query = "SELECT id_departamento FROM departamentos WHERE nombre = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $department_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id_departamento = $row['id_departamento'];

    // Obtener los edificios basados en el ID del departamento
    $query2 = "SELECT nombre, id_edificio FROM edificios WHERE id_departamento = ?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("i", $id_departamento);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $edificios = [];
    if ($result2->num_rows > 0) {
        while ($row2 = $result2->fetch_assoc()) {
            $edificios[] = $row2; // Guardamos los edificios en el array
        }
    } else {
        echo "No se encontraron edificios para este departamento.";
    }
} else {
    echo "No se encontró el departamento.";
}
?>

