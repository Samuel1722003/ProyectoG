<?php
include('../ConexionBD.php');
include("../User/ObtenerUser.php");

// Inicializar la variable para los datos de la computadora
$computadora = null;

// Verificar si se ha enviado el identificador de la computadora
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['identificador'])) {
    $identificador = $_POST['identificador'];

    // Consulta para obtener los datos de la computadora
    $query = "SELECT * FROM computadoras WHERE identificador = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $identificador);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $computadora = $result->fetch_assoc();
    } else {
        $computadora = null;
    }
    $stmt->close();
}

// Procesar la actualización y la inserción en la bitácora
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambio'])) {
    // Recibir datos del formulario de manera segura
    $id_computadora = $_POST['id_computadora'];
    $tarjeta_madre = $_POST['tarjeta_madre'];
    $procesador = $_POST['almacenamiento']; // Aquí se puede cambiar si la variable está mal asignada
    $ram = isset($_POST['RAM']) ? $_POST['RAM'] : ''; // Verificación si 'RAM' está definida
    $rom = isset($_POST['ROM']) ? $_POST['ROM'] : ''; // Verificación si 'ROM' está definida
    $almacenamiento = $_POST['almacenamiento'];
    $descripcion = $_POST['descripcion'];
    $cambio = $_POST['cambio'];
    $tecnico = isset($_POST['tecnico']) ? $_POST['tecnico'] : ''; // Obtener el nombre del técnico
    $fecha = date('Y-m-d H:i:s'); // Fecha actual en el formato adecuado

    // Actualizar los datos de la computadora
    $updateQuery = "UPDATE computadoras SET tarjeta_madre = ?, procesador = ?, RAM = ?, ROM = ?, Almacenamiento = ? WHERE id_computadora = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sssssi", $tarjeta_madre, $procesador, $ram, $rom, $almacenamiento, $id_computadora);

    if ($updateStmt->execute()) {
        // Insertar en la bitácora
        $insertQuery = "INSERT INTO vitacora (id_pc, descripcion, cambio, tecnico, fecha) VALUES (?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("sssss", $id_computadora, $descripcion, $cambio, $tecnico, $fecha);

        if ($insertStmt->execute()) {
            echo "<script>alert('Actualización y bitácora guardadas exitosamente.');</script>";
        } else {
            echo "<script>alert('Error al guardar en la bitácora.');</script>";
        }
        $insertStmt->close();
    } else {
        echo "<script>alert('Error al actualizar la computadora.');</script>";
    }
    $updateStmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/view_computadora.css">
    <title>Formulario de Computadora</title>
    <style>
        .container {
            width: 50%;
            margin: auto;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input, textarea, button {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
<div class="container">
    <?php if ($computadora): ?>
        <h1>Formulario de Bitácora - Computadora</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="identificador">ID</label>
                <input type="text" name="id_computadora" id="identificador" value="<?= htmlspecialchars($computadora['id_computadora']) ?>" readonly>
            </div>
            <div class="form-group">
                <label for="identificador">Identificador</label>
                <input type="text" name="identificador" id="identificador" value="<?= htmlspecialchars($computadora['identificador']) ?>" readonly>
            </div>
            <div class="form-group">
                <label for="salon">Salón</label>
                <input type="text" name="salon" id="salon" value="<?= htmlspecialchars($computadora['id_salon']) ?>" readonly>
            </div>
            <div class="form-group">
                <label for="tarjeta_madre">Tarjeta Madre</label>
                <input type="text" name="tarjeta_madre" id="tarjeta_madre" value="<?= htmlspecialchars($computadora['tarjeta_madre']) ?>" >
            </div>
            <div class="form-group">
                <label for="almacenamiento">Procesador</label>
                <input type="text" name="almacenamiento" id="almacenamiento" value="<?= htmlspecialchars($computadora['procesador']) ?>" >
            </div>
            <div class="form-group">
                <label for="ram">RAM</label>
                <input type="text" name="RAM" id="ram" value="<?= htmlspecialchars($computadora['RAM']) ?>">
            </div>
            <div class="form-group">
                <label for="rom">ROM</label>
                <input type="text" name="ROM" id="rom" value="<?= htmlspecialchars($computadora['ROM']) ?>">
            </div>
            <div class="form-group">
                <label for="almacenamiento">Almacenamiento</label>
                <input type="text" name="almacenamiento" id="almacenamiento" value="<?= htmlspecialchars($computadora['Almacenamiento']) ?>" >
            </div>
            <div class="form-group">
                <label for="tecnico">Nombre del Técnico</label>
                <input type="text" name="tecnico" id="tecnico" placeholder="Ingrese el nombre del técnico" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" placeholder="Describe el incidente" required></textarea>
            </div>
            <div class="form-group">
                <label for="cambio">Cambio Realizado</label>
                <textarea name="cambio" id="cambio" placeholder="Describe el cambio realizado detalladamente" required></textarea>
            </div>
            <button type="submit">Guardar en Bitácora</button>
        </form>
        <button onclick="history.back()">Regresar</button>
    <?php else: ?>
        <h1>Búsqueda de Computadora</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="identificador">Identificador de Computadora</label>
                <input type="text" name="identificador" id="identificador" required placeholder="Ingrese el identificador">
            </div>
            <button type="submit">Buscar</button>
        </form>
        <button onclick="history.back()">Regresar</button>
    <?php endif; ?>
</div>
</body>
</html>
