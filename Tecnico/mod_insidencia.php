<?php
    include("../ConexionBD.php");

    if (isset($_POST['folio'])) {
        // Recibes un solo folio, no un array, ya que cada botón envía un solo folio.
        $folio = $_POST['folio'];
        
        // Obtener los demás valores seleccionados para este folio.
        $estatus = $_POST['estatus'];
        $tiempo = $_POST['tiempo'];
    
        // Aquí puedes hacer la actualización en la base de datos para la incidencia correspondiente
        // Ejemplo de query:
        $query = "UPDATE incidencias SET estatus = '$estatus', tiempo_servicio = '$tiempo' WHERE folio = '$folio'";
         mysqli_query($conn, $query);
        header('location: ../Tecnico/view_tecnico.php');
    } else {
        echo "No se envió ningún folio.";
    }
    
?> 