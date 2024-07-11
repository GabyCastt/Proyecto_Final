$(document).ready(function() {
    var idUsuario = 1; // Aquí asigna el ID del usuario actual según tu lógica de sesión o autenticación

    // Función para cargar grupos y miembros al cargar la página
    function cargarGrupos() {
        $.ajax({
            url: '../controllers/grupos.controller.php',
            type: 'GET',
            data: { accion: 'obtenerNombresGrupos' },
            dataType: 'json',
            success: function(data) {
                var opcionesGrupos = '';
                $.each(data, function(index, grupo) {
                    opcionesGrupos += '<option value="' + grupo.id_grupo + '">' + grupo.nombre_grupo + '</option>';
                });
                $('#selectGrupos, #selectGruposModal').html(opcionesGrupos);

                // Al cargar los grupos, también cargamos los miembros del primer grupo (si hay)
                var primerGrupo = data.length > 0 ? data[0].id_grupo : null;
                if (primerGrupo) {
                    obtenerMiembrosGrupo(primerGrupo); // Llama a la función para obtener los miembros del grupo seleccionado
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener nombres de grupos:', error);
            }
        });
    }

    // Función para obtener miembros de un grupo específico
    function obtenerMiembrosGrupo(idGrupo) {
        $.ajax({
            url: '../controllers/miembros_grupos.controller.php',
            type: 'GET',
            data: { accion: 'obtenerMiembrosGrupo', id_grupo: idGrupo },
            dataType: 'json',
            success: function(data) {
                var listaMiembros = '';
                $.each(data, function(index, miembro) {
                    listaMiembros += '<tr>';
                    listaMiembros += '<td>' + miembro.nombre + ' ' + miembro.apellido + '</td>';
                    listaMiembros += '<td><button class="btn btn-danger btn-sm eliminarMiembro" data-id="' + miembro.id_miembro + '">Eliminar</button></td>';
                    listaMiembros += '</tr>';
                });
                $('#listaMiembros').html(listaMiembros);
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener miembros del grupo:', error);
            }
        });
    }

    // Evento al cambiar el grupo seleccionado
    $('#selectGrupos').change(function() {
        var idGrupo = $(this).val();
        obtenerMiembrosGrupo(idGrupo);
    });

    // Función para cargar amigos en el modal de agregar miembro
    function cargarAmigos() {
        $.ajax({
            url: '../controllers/amigos.controller.php',
            type: 'GET',
            data: { accion: 'listarAmigos', id_usuario: idUsuario },
            dataType: 'json',
            success: function(data) {
                var opcionesAmigos = '';
                $.each(data, function(index, amigo) {
                    opcionesAmigos += '<option value="' + amigo.id_usuario + '">' + amigo.nombre + ' ' + amigo.apellido + '</option>';
                });
                $('#selectAmigos').html(opcionesAmigos);
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener amigos:', error);
            }
        });
    }

    // Evento al abrir modal para agregar miembro a un grupo
    $('#btnAgregarMiembro').click(function() {
        $('#modalAgregarMiembro').modal('show');
        cargarAmigos(); // Llama a la función para cargar amigos en el modal
    });

    // Evento al agregar miembro a un grupo desde el modal
    $('#btnGuardarMiembro').click(function() {
        var idGrupo = $('#selectGruposModal').val();
        var idUsuario = $('#selectAmigos').val();
        $.ajax({
            url: '../controllers/miembros_grupos.controller.php',
            type: 'POST',
            data: { accion: 'agregarMiembroGrupo', id_grupo: idGrupo, id_usuario: idUsuario },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#modalAgregarMiembro').modal('hide');
                    obtenerMiembrosGrupo(idGrupo); // Actualiza la lista de miembros al grupo después de agregar uno nuevo
                } else {
                    alert('Error al agregar miembro al grupo.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al agregar miembro al grupo:', error);
            }
        });
    });

    // Evento al hacer click en Eliminar Miembro
    $('#listaMiembros').on('click', '.eliminarMiembro', function() {
        var idMiembro = $(this).data('id');
        $.ajax({
            url: '../controllers/miembros_grupos.controller.php',
            type: 'POST',
            data: { accion: 'eliminarMiembroGrupo', id_miembro: idMiembro },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var idGrupoSeleccionado = $('#selectGrupos').val();
                    obtenerMiembrosGrupo(idGrupoSeleccionado); // Actualiza la lista de miembros después de eliminar uno
                } else {
                    alert('Error al eliminar miembro del grupo.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al eliminar miembro del grupo:', error);
            }
        });
    });

    // Inicialmente, carga los grupos al cargar la página
    cargarGrupos();
});
