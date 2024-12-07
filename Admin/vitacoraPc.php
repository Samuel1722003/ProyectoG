<?php
include("../User/ObtenerUser.php");
include("../ConexionBD.php");
include("../Admin/Querrys.php");

// Obtener el ID de la computadora desde el parámetro GET
$id_computadora = $_GET['id'] ?? null;

if ($id_computadora) {
    // Consulta para obtener los datos de la computadora
    $queryPc = "SELECT * FROM computadoras WHERE id_computadora = ?";
    $stmt = $conn->prepare($queryPc);
    $stmt->bind_param("i", $id_computadora);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Obtener los datos de la computadora
        $pc = $resultado->fetch_assoc();
    } else {
        die("No se encontró la computadora con ID: $id_computadora");
    }

    $stmt->close();
} else {
    die("ID de computadora no especificado.");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="css/vitacora.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Prerellenado</title>
</head>

<body>
    <!-- Encabezado -->
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

    <!-- Formulario Prerellenado -->
    <div class="content">
        <h1>Formulario de Vitacora para Computadora</h1>
        <form method="POST" action="guardarVitacora.php">
            <!-- Campo oculto para el ID de la computadora -->
            <input type="hidden" name="id_computadora" value="<?= htmlspecialchars($pc['id_computadora']); ?>">

            <label for="salon">Salón:</label>
            <input type="text" id="salon" name="salon" value="<?= htmlspecialchars($pc['salon']); ?>" readonly><br><br>

            <label for="identificador">Identificador:</label>
            <input type="text" id="identificador" name="identificador" value="<?= htmlspecialchars($pc['identificador']); ?>" readonly><br><br>

            <label for="tarjeta_madre">Tarjeta Madre:</label>
            <input type="text" id="tarjeta_madre" name="tarjeta_madre" value="<?= htmlspecialchars($pc['tarjeta_madre']); ?>" readonly><br><br>

            <label for="ram">RAM:</label>
            <input type="text" id="ram" name="ram" value="<?= htmlspecialchars($pc['ram']); ?>" readonly><br><br>

            <label for="rom">ROM:</label>
            <input type="text" id="rom" name="rom" value="<?= htmlspecialchars($pc['rom']); ?>" readonly><br><br>

            <label for="almacenamiento">Almacenamiento:</label>
            <input type="text" id="almacenamiento" name="almacenamiento" value="<?= htmlspecialchars($pc['almacenamiento']); ?>" readonly><br><br>

            <label for="fecha_compra">Fecha de Compra:</label>
            <input type="text" id="fecha_compra" name="fecha_compra" value="<?= htmlspecialchars($pc['fecha_compra']); ?>" readonly><br><br>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea><br><br>

            <label for="cambio">Cambio:</label>
            <textarea id="cambio" name="cambio" required></textarea><br><br>

            <button type="submit">Guardar en Vitacora</button>
        </form>
    </div>
</body>

</html>
