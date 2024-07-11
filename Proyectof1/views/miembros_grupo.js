// miembros_grupo.js

// Función para cargar los miembros de un grupo específico
function cargarMiembrosGrupo(idGrupo) {
    $.ajax({
        url: 'controladores/miembros_grupos.controller.php',
        type: 'GET',
        data: { id_grupo: idGrupo },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                mostrarMiembrosGrupo(response.data);
            } else {
                console.error('Error al cargar miembros del grupo:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });
}

// Función para mostrar los miembros del grupo en la tabla
function mostrarMiembrosGrupo(miembros) {
    var cuerpoMiembros = $('#cuerpoMiembros');
    cuerpoMiembros.empty();
    $.each(miembros, function(index, miembro) {
        var fila = `<tr>
                        <td>${index + 1}</td>
                        <td>${miembro.nombre_grupo}</td>
                        <td>${miembro.nombre_completo}</td>
                        <td>${miembro.fecha_union}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" onclick="eliminarMiembro(${miembro.id_miembro})">Eliminar</button>
                        </td>
                    </tr>`;
        cuerpoMiembros.append(fila);
    });
}

// Función para abrir el modal de inserción de miembro al grupo
function abrirModalMiembro(tipo, idGrupo = null) {
    // Aquí puedes implementar la lógica para abrir el modal y manejar la inserción de miembros al grupo
    // Puedes usar SweetAlert2 o Bootstrap modals según tu preferencia
}

// Función para agregar un nuevo miembro a un grupo
function agregarMiembroAGrupo(idGrupo, idUsuario) {
    $.ajax({
        url: 'controladores/miembros_grupos.controller.php',
        type: 'POST',
        data: { id_grupo: idGrupo, id_usuario: idUsuario },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Recargar la lista de miembros del grupo
                cargarMiembrosGrupo(idGrupo);
                // Aquí puedes agregar una notificación o mensaje de éxito
            } else {
                console.error('Error al agregar miembro al grupo:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });
}

// Cargar miembros de grupo al cargar la página (puedes implementar según necesites)
$(document).ready(function() {
    // Puedes llamar a la función cargarMiembrosGrupo() aquí si necesitas mostrar los miembros de un grupo específico al cargar la página
});
