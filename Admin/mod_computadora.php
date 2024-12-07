<?php
include('../ConexionBD.php');

// Verificar que se reciba un ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_computadora = intval($_GET['id']);

    // Obtener los datos de la computadora
    $query = "SELECT * FROM computadoras WHERE id_computadora = $id_computadora";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Datos cargados en $row
    } else {
        echo "Computadora no encontrada.";
        exit;
    }
} else {
    echo "ID inválido.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Computadora</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background: #ffffff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        .form-container h2 {
            font-size: 24px;
            margin-bottom: 1rem;
            color: #333333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #555555;
        }

        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #cccccc;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn-container {
            text-align: center;
        }

        .btn-submit {
            padding: 0.8rem 1.5rem;
            font-size: 16px;
            font-weight: 500;
            color: #ffffff;
            background-color: #007BFF;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Editar Computadora</h2>
        <form action="mod_computadora.php?id=<?= $id_computadora ?>" method="post">
            <div class="form-group">
                <label for="identificador">Identificador:</label>
                <input type="text" id="identificador" name="identificador" value="<?= htmlspecialchars($row['identificador']) ?>" readonly required>
            </div>
            <div class="form-group">
                <label for="tarjeta_madre">Tarjeta Madre:</label>
                <input type="text" id="tarjeta_madre" name="tarjeta_madre" value="<?= htmlspecialchars($row['tarjeta_madre']) ?>" required>
            </div>
            <div class="form-group">
                <label for="procesador">Procesador:</label>
                <input type="text" id="procesador" name="procesador" value="<?= htmlspecialchars($row['procesador']) ?>" required>
            </div>
            <div class="form-group">
                <label for="ram">RAM (GB):</label>
                <input type="number" id="ram" name="ram" value="<?= intval($row['RAM']) ?>" required>
            </div>
            <div class="form-group">
                <label for="rom">ROM (GB):</label>
                <input type="number" id="rom" name="rom" value="<?= intval($row['ROM']) ?>" required>
            </div>
            <div class="form-group">
                <label for="almacenamiento">Almacenamiento (GB):</label>
                <input type="number" id="almacenamiento" name="almacenamiento" value="<?= intval($row['Almacenamiento']) ?>" required>
            </div>
            <div class="form-group">
                <label for="fecha_compra">Fecha de Compra:</label>
                <input type="date" id="fecha_compra" name="fecha_compra" value="<?= htmlspecialchars($row['fecha_compra']) ?>" readonly required>
            </div>
            <div class="form-group">
                <label for="id_salon">Salón:</label>
                <input type="text" id="id" name="id_salon" value="<?= htmlspecialchars($row['id_salon']) ?>" required>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn-submit">Guardar Cambios</button>
                <a href="Dash.php" class="btn-submit">Regresar</a>
            </div>

        </form>
    </div>
</body>
<?php
include('../ConexionBD.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_computadora = intval($_GET['id']);

    // Escapar y validar los datos del formulario
    $identificador = mysqli_real_escape_string($conn, $_POST['identificador']);
    $tarjeta_madre = mysqli_real_escape_string($conn, $_POST['tarjeta_madre']);
    $procesador = mysqli_real_escape_string($conn, $_POST['procesador']);
    $ram = intval($_POST['ram']);
    $rom = intval($_POST['rom']);
    $almacenamiento = intval($_POST['almacenamiento']);
    $fecha_compra = mysqli_real_escape_string($conn, $_POST['fecha_compra']);
    $id_salon = intval($_POST['id_salon']);

    // Actualizar los datos de la computadora
    $query = "UPDATE computadoras 
              SET identificador = '$identificador', tarjeta_madre = '$tarjeta_madre', 
                  procesador = '$procesador', RAM = $ram, ROM = $rom, 
                  Almacenamiento = $almacenamiento, fecha_compra = '$fecha_compra', 
                  id_salon = $id_salon
              WHERE id_computadora = $id_computadora";

    if (mysqli_query($conn, $query)) {
        echo "Computadora actualizada correctamente.";
    } else {
        echo "Error al actualizar la computadora: " . mysqli_error($conn);
    }
}
?>

</html>
