function setFechaActual() {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0'); // Los meses van de 0 a 11
    const dd = String(today.getDate()).padStart(2, '0');

}

const fechaInput = document.getElementById('fecha');

function submitForm(select) {
    // Envía el formulario
    document.getElementById("myForm").submit();

    // Mantén la selección
    select.selectedIndex = select.selectedIndex; // Esto es redundante; puedes omitirlo
}

$(document).ready(function() {
    // Evento para cuando cambia el select de edificios
    $('#edificio').change(function() {
        var edificio_id = $(this).val();

        if (edificio_id) {
            $.ajax({
                type: 'POST',
                url: 'Obtener_salones.php',
                data: { edificio_id: edificio_id },
                success: function(response) {
                    $('#salon').html(response);
                },
                error: function() {
                    alert('Error al cargar los salones');
                }
            });
        } else {
            $('#salon').html('<option value="">Selecciona un salón</option>');
            $('#computadoras').html('<option value="">Selecciona una computadora</option>'); // Limpiar computadoras
        }
    });
});
$(document).ready(function() {
    // Evento para cuando cambia el select de edificios
    $('#edificio').change(function() {
        var edificio_id = $(this).val();

        if (edificio_id) {
            $.ajax({
                type: 'POST',
                url: 'Obtener_salones.php',
                data: { edificio_id: edificio_id },
                success: function(response) {
                    $('#salon').html(response);
                    $('#computadoras').html('<option value="">Selecciona una computadora</option>'); // Limpiar computadoras
                    $('#impresoras').html('<option value="">Selecciona una impresora</option>'); // Limpiar impresoras
                    $('#proyectores').html('<option value="">Selecciona un proyector</option>'); // Limpiar proyectores
                },
                error: function() {
                    alert('Error al cargar los salones');
                }
            });
        } else {
            $('#salon').html('<option value="">Selecciona un salón</option>');
            $('#computadoras').html('<option value="">Selecciona una computadora</option>'); // Limpiar computadoras
            $('#impresoras').html('<option value="">Selecciona una impresora</option>'); // Limpiar impresoras
            $('#proyectores').html('<option value="">Selecciona un proyector</option>'); // Limpiar proyectores
        }
    });

    $('#salon').change(function() {
        var salon_id = $(this).val(); // Obtener el ID del salón seleccionado

        if (salon_id) {
            // Llamada AJAX para obtener computadoras
            $.ajax({
                type: 'POST',
                url: 'Obtener_computadoras.php', // Archivo PHP para obtener computadoras
                data: { id_salon: salon_id },
                success: function(response) {
                    $('#computadoras').html(response); // Insertar opciones en el select de computadoras
                },
                error: function() {
                    alert('Error al cargar las computadoras');
                }
            });

            // Llamada AJAX para obtener impresoras
            $.ajax({
                type: 'POST',
                url: 'Obtener_impresoras.php', // Archivo PHP para obtener impresoras
                data: { id_salon: salon_id },
                success: function(response) {
                    console.log("Respuesta del servidor: ", response); // Para verificar la respuesta
                    
                    // Comprobar si la respuesta es nula o vacía
                    if (response.trim() === '') {
                        $('#impresoras').html('<option value="No tiene">No tiene impresoras</option>');
                    } else {
                        $('#impresoras').html(response); // Insertar opciones en el select de impresoras
                    }
                },
                error: function() {
                    alert('Error al cargar las impresoras');
                }
            });

            // Llamada AJAX para obtener proyectores
            $.ajax({
                type: 'POST',
                url: 'Obtener_proyectores.php', // Archivo PHP para obtener proyectores
                data: { id_salon: salon_id },
                success: function(response) {
                    $('#proyectores').html(response); // Insertar opciones en el select de proyectores
                },
                error: function() {
                    alert('Error al cargar los proyectores');
                }
            });
        } else {
            $('#computadoras').html('<option value="">Selecciona una computadora</option>'); // Limpiar computadoras
            $('#impresoras').html('<option value="">Selecciona una impresora</option>'); // Limpiar impresoras
            $('#proyectores').html('<option value="">Selecciona un proyector</option>'); // Limpiar proyectores
        }
    });
});