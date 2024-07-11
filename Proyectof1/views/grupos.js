// Función para abrir el modal de agregar grupo
function abrirModalAgregar() {
    // Limpiar los campos del formulario
    $('#grupoId').val('');
    $('#nombre_grupo').val('');
    $('#descripcion').val('');

    // Cambiar título del modal
    $('#modalGrupoLabel').text('Nuevo Grupo');

    // Mostrar el modal usando Bootstrap modal
    $('#modalGrupo').modal('show');
}

// Función para abrir el modal de editar grupo
function abrirModalEditar(idGrupo) {
    // Realizar una solicitud AJAX para obtener los detalles del grupo
    $.ajax({
        url: '../controllers/grupos.controller.php',
        type: 'POST',
        dataType: 'json',
        data: { action: 'obtenerGrupo', id_grupo: idGrupo },
        success: function(response) {
            if (response.status === 'success') {
                // Llenar el formulario con los datos del grupo
                $('#grupoId').val(response.data.id_grupo);
                $('#nombre_grupo').val(response.data.nombre_grupo);
                $('#descripcion').val(response.data.descripcion);

                // Cambiar título del modal
                $('#modalGrupoLabel').text('Editar Grupo');

                // Mostrar el modal usando Bootstrap modal
                $('#modalGrupo').modal('show');
            } else {
                console.error(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

// Función para guardar o actualizar un grupo
function guardarGrupo() {
    let grupoId = $('#grupoId').val();
    let nombreGrupo = $('#nombre_grupo').val();
    let descripcion = $('#descripcion').val();

    // Determinar si es una operación de agregar o actualizar
    let action = (grupoId === '') ? 'crearGrupo' : 'actualizarGrupo';

    // Datos a enviar al servidor
    let formData = {
        action: action,
        nombre_grupo: nombreGrupo,
        descripcion: descripcion
    };

    // Si es una actualización, agregar el ID del grupo
    if (grupoId !== '') {
        formData.id_grupo = grupoId;
    }

    // Realizar la solicitud AJAX para guardar o actualizar el grupo
    $.ajax({
        url: '../controllers/grupos.controller.php',
        type: 'POST',
        dataType: 'json',
        data: formData,
        success: function(response) {
            if (response.status === 'success') {
                console.log(response.message);

                // Cerrar el modal después de guardar o actualizar
                $('#modalGrupo').modal('hide');

                // Actualizar la lista de grupos
                obtenerNombresGrupos();
            } else {
                console.error(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

// Función para eliminar un grupo
function eliminarGrupo(idGrupo) {
    if (confirm('¿Estás seguro de eliminar este grupo?')) {
        $.ajax({
            url: '../controllers/grupos.controller.php',
            type: 'POST',
            dataType: 'json',
            data: { action: 'eliminarGrupo', id_grupo: idGrupo },
            success: function(response) {
                if (response.status === 'success') {
                    console.log(response.message);
                    // Actualizar la lista de grupos después de eliminar
                    obtenerNombresGrupos();
                } else {
                    console.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
}

// Función para cargar la lista de grupos solo con nombres
function obtenerNombresGrupos() {
    $.ajax({
        url: '../controllers/grupos.controller.php',
        type: 'POST',
        dataType: 'json',
        data: { action: 'obtenerNombresGrupos' },
        success: function(response) {
            if (response.status === 'success') {
                // Limpiar la lista de grupos
                $('#listaGrupos').empty();

                // Iterar sobre los grupos recibidos y agregarlos a la tabla
                response.data.forEach(function(grupo) {
                    let row = '<tr>' +
                        '<td>' + grupo.id_grupo + '</td>' +
                        '<td>' + grupo.nombre_grupo + '</td>' +
                        '<td>' + grupo.descripcion + '</td>' +
                        '<td>' +
                            '<button type="button" class="btn btn-primary btn-sm" onclick="abrirModalEditar(' + grupo.id_grupo + ')">Editar</button> ' +
                            '<button type="button" class="btn btn-danger btn-sm" onclick="eliminarGrupo(' + grupo.id_grupo + ')">Eliminar</button>' +
                        '</td>' +
                        '</tr>';
                    $('#listaGrupos').append(row);
                });
            } else {
                console.error(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

// Inicializar la lista de grupos al cargar la página
$(document).ready(function() {
    obtenerNombresGrupos();
});
