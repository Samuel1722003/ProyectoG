function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    
    // Obtener todos los elementos con la clase "tabcontent"
    tabcontent = document.getElementsByClassName("tabcontent");
    
    // Obtener la pestaña que queremos mostrar
    var currentTab = document.getElementById(tabName);
    
    // Verificar si currentTab es nulo
    if (!currentTab) {
        console.error(`No se encontró la pestaña con el id ${tabName}`);
        return; // Salir de la función si la pestaña no se encuentra
    }
    
    // Si la pestaña ya está visible, ocultarla
    if (currentTab.style.display === "block") {
        currentTab.style.display = "none";
        evt.currentTarget.className = evt.currentTarget.className.replace(" active", "");
        return;
    }
    
    // Ocultar todos los contenidos de las pestañas
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    
    // Eliminar la clase "active" de todos los enlaces de las pestañas
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Mostrar la pestaña seleccionada
    currentTab.style.display = "block";
    evt.currentTarget.className += " active";
}

    function openEquipmentTab(evt, tabName) {
        var i, tabcontent, tablinks;

        // Obtener todas las tabcontent y ocultarlas
        tabcontent = document.getElementsByClassName("equipment-tab");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none"; // Ocultar todas las secciones
        }

        // Obtener todos los botones y eliminar la clase "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", ""); // Remover "active"
        }

        // Mostrar la sección correspondiente al tab seleccionado
        document.getElementById(tabName).style.display = "block"; // Mostrar la sección
        evt.currentTarget.className += " active"; // Añadir "active" al botón seleccionado
    }
    function openIncidenciasTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("incidencias-tab");
        
        // Oculta todas las tablas
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Elimina la clase "active" de todos los botones
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Muestra la tabla seleccionada
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active"; // Añade clase "active" al botón
    }

