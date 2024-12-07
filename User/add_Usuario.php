<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/Style_add_user.css">
    <script src="https://kit.fontawesome.com/73e64c23ef.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta</title>
</head>
<body>
    <form action="add_user.php" method="post">
        <section>
            <div class="contenedor">
                <div class="formulario">
                    <form action="#">
                        <h2>Crear Usuario</h2>
                        <div class="input-contenedor">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" required name="username">
                            <label>Nombre de usuario</label>
                        </div>
                        <div class="input-contenedor">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" required name="email">
                            <label>Correo electrónico</label>
                        </div>
                        <div class="input-contenedor">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" required name="password">
                            <label>Contraseña</label>
                        </div>
                        <div class="input-contenedor">
                            <i class="fa-solid fa-id-badge"></i>
                            <select required name="rol">
                                <option value="">Seleccione un rol</option>
                                <option value="Admin">Admin</option>
                                <option value="Tecnico">Tecnico</option>
                                <option value="Usuario">Usuario</option>
                            </select>
                        </div>
                        
                        <div class="input-contenedor">
                            
                            <select required name="departamento">
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
                            <button>Crear cuenta</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </form>
</body>
</html>