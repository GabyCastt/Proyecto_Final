// Función para listar grupos
function listarGrupos() {
    $.ajax({
        url: 'controladores/grupos.controller.php',
        method: 'POST',
        data: { accion: 'listar' },
        dataType: 'json',
        success: function(response) {
            // Limpiar cuerpo de la tabla de grupos
            $('#cuerpoGrupos').empty();

            // Iterar sobre los grupos recibidos y agregar filas a la tabla
            response.forEach(function(grupo, index) {
                var fila = '<tr>' +
                           '<td>' + (index + 1) + '</td>' +
                           '<td>' + grupo.nombre_grupo + '</td>' +
                           '<td>' + grupo.descripcion + '</td>' +
                           '<td>' +
                           '<button type="button" class="btn btn-sm btn-primary" onclick="editarGrupo(' + grupo.id_grupo + ')">Editar</button> ' +
                           '<button type="button" class="btn btn-sm btn-danger" onclick="eliminarGrupo(' + grupo.id_grupo + ')">Eliminar</button>' +
                           '</td>' +
                           '</tr>';
                $('#cuerpoGrupos').append(fila);
            });
        },
        error: function(xhr, status, error) {
            // Manejar errores de AJAX
            console.error('Error en la solicitud AJAX para listar grupos:', status, error);
        }
    });
}

// Función para insertar un nuevo grupo
function insertarGrupo() {
    var nombreGrupo = $('#nombreGrupo').val();
    var descripcionGrupo = $('#descripcionGrupo').val();

    $.ajax({
        url: 'controladores/grupos.controller.php',
        method: 'POST',
        data: {
            accion: 'insertar',
            nombre_grupo: nombreGrupo,
            descripcion: descripcionGrupo
        },
        success: function(response) {
            if (response === 'success') {
                // Actualizar la lista de grupos
                listarGrupos();

                // Cerrar modal (si estás usando uno)
                $('#modalInsertarGrupo').modal('hide');

                // Mostrar mensaje de éxito (opcional)
                Swal.fire({
                    icon: 'success',
                    title: 'Grupo insertado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                // Mostrar mensaje de error (opcional)
                Swal.fire({
                    icon: 'error',
                    title: 'Error al insertar el grupo',
                    text: 'Por favor, intenta nuevamente más tarde',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        },
        error: function(xhr, status, error) {
            // Manejar errores de AJAX
            console.error('Error en la solicitud AJAX para insertar grupo:', status, error);
        }
    });
}

// Función para editar un grupo
function editarGrupo(idGrupo) {
    // Implementar función de edición si es necesario
}

// Función para eliminar un grupo
function eliminarGrupo(idGrupo) {
    // Implementar función de eliminación si es necesario
}
