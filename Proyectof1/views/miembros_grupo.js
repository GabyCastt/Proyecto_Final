// Función para listar miembros de un grupo
function listarMiembros(idUsuario) {
    $.ajax({
        url: 'controladores/miembros.controller.php',
        method: 'POST',
        data: {
            accion: 'listarMiembros',
            id_usuario1: idUsuario
        },
        dataType: 'json',
        success: function(response) {
            // Limpiar cuerpo de la tabla de miembros
            $('#cuerpoMiembros').empty();

            // Iterar sobre los miembros recibidos y agregar filas a la tabla
            response.forEach(function(miembro, index) {
                var fila = '<tr>' +
                           '<td>' + (index + 1) + '</td>' +
                           '<td>' + miembro.nombre_grupo + '</td>' +
                           '<td>' + miembro.nombre_completo + '</td>' +
                           '<td>' + miembro.fecha_union + '</td>' +
                           '<td>' +
                           '<button type="button" class="btn btn-sm btn-danger" onclick="eliminarMiembro(' + miembro.id_miembro + ')">Eliminar</button>' +
                           '</td>' +
                           '</tr>';
                $('#cuerpoMiembros').append(fila);
            });
        },
        error: function(xhr, status, error) {
            // Manejar errores de AJAX
            console.error('Error en la solicitud AJAX para listar miembros:', status, error);
        }
    });
}

// Función para agregar un nuevo miembro a un grupo
function agregarMiembro(idGrupo, idUsuario) {
    $.ajax({
        url: 'controladores/miembros.controller.php',
        method: 'POST',
        data: {
            accion: 'agregarMiembro',
            id_grupo: idGrupo,
            id_usuario: idUsuario
        },
        success: function(response) {
            if (response === 'success') {
                // Actualizar la lista de miembros del grupo
                listarMiembros(idUsuario);

                // Cerrar modal (si estás usando uno)
                $('#modalAgregarMiembro').modal('hide');

                // Mostrar mensaje de éxito (opcional)
                Swal.fire({
                    icon: 'success',
                    title: 'Miembro agregado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                // Mostrar mensaje de error (opcional)
                Swal.fire({
                    icon: 'error',
                    title: 'Error al agregar el miembro',
                    text: 'Por favor, intenta nuevamente más tarde',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        },
        error: function(xhr, status, error) {
            // Manejar errores de AJAX
            console.error('Error en la solicitud AJAX para agregar miembro:', status, error);
        }
    });
}

// Función para eliminar un miembro de un grupo
function eliminarMiembro(idMiembro) {
    $.ajax({
        url: 'controladores/miembros.controller.php',
        method: 'POST',
        data: {
            accion: 'eliminarMiembro',
            id_miembro: idMiembro
        },
        success: function(response) {
            if (response === 'success') {
                // Actualizar la lista de miembros del grupo
                listarMiembros();

                // Mostrar mensaje de éxito (opcional)
                Swal.fire({
                    icon: 'success',
                    title: 'Miembro eliminado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                // Mostrar mensaje de error (opcional)
                Swal.fire({
                    icon: 'error',
                    title: 'Error al eliminar el miembro',
                    text: 'Por favor, intenta nuevamente más tarde',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        },
        error: function(xhr, status, error) {
            // Manejar errores de AJAX
            console.error('Error en la solicitud AJAX para eliminar miembro:', status, error);
        }
    });
}
