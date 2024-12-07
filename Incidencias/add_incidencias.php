<?php
    include("../User/ObtenerUser.php");
    include("Obtener_edificios.php");
    // Esto es asumido como que es el nombre del usuario o su identificador
?>

<html lang="es">
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/dash.js"></script>
    <link rel="stylesheet" href="css/Style_add_ins.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de Mantenimiento</title>
</head>
<body>
    <div class="container">
        <h2 class="titulo">Solicitud de Mantenimiento</h2>

        <form action="add_incidenciaBD.php" method="post">
            <?php
            $fecha = date("Y-m-d");
            ?>
            <div class="form-grid">
                <div class="form-group">
                    <label for="fecha">Fecha de la Solicitud:</label>
                    <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="departamento">Departamento:</label>
                    <select id="departamento" name="departamento">
                        <option value="<?php echo $department_name; ?>"><?php echo $department_name; ?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edificio">Edificio:</label>
                    <select id="edificio" name="edificio">
                        <option value="">Selecciona un Edificio</option>
                        <?php
                        foreach ($edificios as $edificio) {
                            echo '<option value="' . $edificio['id_edificio'] . '">' . htmlspecialchars($edificio['nombre']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="salon">Salón:</label>
                    <select id="salon" name="salon">
                        <option value="">Selecciona un salón</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="computadoras">Computadora:</label>
                    <select id="computadoras" name="computadora">
                        <option value="">Selecciona una computadora</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="proyectores">Proyector:</label>
                    <select id="proyectores" name="proyector">
                        <option value="">Selecciona un proyector</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="impresoras">Impresora:</label>
                    <select id="impresoras" name='impresora'>
                        <option value="">Selecciona una impresora</option>   
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipo_servicio">Tipo de servicio:</label>
                    <select name="tipo_servicio" id="tipo_servicio">
                        <option value="">Selecciona una opción</option>
                        <option value="Instalación de aplicación">Instalación de aplicación</option>
                        <option value="Cambio de componente">Cambio de componente</option>
                        <option value="Mantenimiento de equipo">Mantenimiento de equipo</option>
                        <option value="software">Falla del sistema</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" rows="4" cols="50"></textarea>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="enviar">Enviar Solicitud</button>
                <a href="../User/view_usuario.php" class="regresar">Regresar al Menú</a>
            </div>

        </form>
    </div>
</body>
</html>
