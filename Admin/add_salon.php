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
    <title>Agregar Salones</title>
</head>
<body>
    <form action="add_salonBD.php" method="post">
        <section>
            <div class="contenedor">
                <div class="formulario">
                    <h2>Agregar Salón</h2>
                    <div class="input-contenedor">
                        <label for="nombre">Nombre del Salón</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="input-contenedor">
                        <label for="id_edificio">Edificio</label>
                        <select id="id_edificio" name="id_edificio" required>
                            <?php
                            include('../ConexionBD.php');
                            $query = "SELECT id_edificio, nombre FROM edificios";
                            $result = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['id_edificio'] . "'>" . $row['nombre'] . "</option>";
                            }

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
