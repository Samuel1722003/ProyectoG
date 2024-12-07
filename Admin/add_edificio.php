<?php
    include("../ConexionBD.php");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style_edificio.css">
    <script src="https://kit.fontawesome.com/73e64c23ef.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Edificios</title>
</head>
<body>
<form action="add_edificioBD.php" method="post">
    <section>
        <div class="contenedor">
            <div class="formulario">
                <h2>Agregar Edificio</h2>
                <div class="input-contenedor">
                    <i class="fa-solid fa-building"></i>
                    <input type="text" required name="nombre">  
                    <label>Nombre</label>
                </div>
                <div class="input-contenedor">
                    <select required name="id_departamento">
                        <?php
                        include('../ConexionBD.php');

                        // Consulta SQL para obtener los departamentos
                        $query = "SELECT id_departamento, nombre FROM departamentos";
                        $result = mysqli_query($conn, $query);

                        // Poblar el combo box con los departamentos
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['id_departamento'] . "'>" . $row['nombre'] . "</option>";
                        }

                        // Cerrar conexión
                        mysqli_close($conn);
                        ?>
                    </select>
                </div>
                <div>
                    <button type="submit">Agregar</button>
                </div>
            </div>
        </div>
    </section>
</form>

</body>
</html>
