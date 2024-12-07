<?php
include("../User/ObtenerUser.php");
include("../ConexionBD.php");
include("Querrys.php");

// Verificar si se recibe el id_computadora
if (isset($_GET['id_computadora'])) {
    $id_computadora = $_GET['id_computadora'];
    
    // Consulta para obtener los registros de la tabla vitacora con el id_computadora
    $query = "SELECT * FROM vitacora WHERE id_pc = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_computadora);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Si no se recibe el id_computadora, redirigir o mostrar un mensaje
    echo "<script>alert('ID de computadora no proporcionado.'); window.location.href='index.html';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/bitacora.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora de Computadora</title>
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
            <a href="../index.html">Cerrar Sesión</a>
        </div>
    </div>

    <div class="container">
        <h1>Bitácora de la Computadora ID: <?php echo htmlspecialchars($id_computadora); ?></h1>
        
        <?php if ($result->num_rows > 0): ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID PC</th>
                        <th>Descripción</th>
                        <th>Cambio Realizado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id_pc']); ?></td>
                            <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($row['cambio']); ?></td>
                            <td><?php echo htmlspecialchars($row['tecnico']); ?></td>
                            <td><?php echo htmlspecialchars($row['fecha']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No se encontraron registros para esta computadora.</p>
        <?php endif; ?>
    </div>
</body>
</html>
