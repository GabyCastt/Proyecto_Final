$(document).ready(function() {
    // Función para cargar grupos y miembros al cargar la página
    function cargarGrupos() {
        $.ajax({
            url: '../controllers/miembros_grupos.controller.php',
            type: 'GET',
            data: { accion: 'obtenerGrupos' },
            dataType: 'json',
            success: function(data) {
                var opcionesGrupos = '';
                $.each(data, function(index, grupo) {
                    opcionesGrupos += '<option value="' + grupo.id_grupo + '">' + grupo.nombre_grupo + '</option>';
                });
                $('#selectGrupos').html(opcionesGrupos);
            }
        });
    }

    // Cargar grupos al cargar la página
    cargarGrupos();

    // Función para cargar miembros de un grupo
    $('#selectGrupos').change(function() {
        var id_grupo = $(this).val();
        $.ajax({
            url: '../controllers/miembros_grupos.controller.php',
            type: 'GET',
            data: { accion: 'obtenerMiembrosGrupo', id_grupo: id_grupo },
            dataType: 'json',
            success: function(data) {
                var listaMiembros = '';
                $.each(data, function(index, miembro) {
                    listaMiembros += '<tr>';
                    listaMiembros += '<td>' + miembro.nombre + ' ' + miembro.apellido + '</td>';
                    listaMiembros += '<td><button class="btn btn-danger btn-sm eliminarMiembro" data-id="' + index + '">Eliminar</button></td>';
                    listaMiembros += '</tr>';
                });
                $('#listaMiembros').html(listaMiembros);
            }
        });
    });

    // Evento al hacer click en Eliminar Miembro
    $('#listaMiembros').on('click', '.eliminarMiembro', function() {
        var id_miembro = $(this).data('id');
        $.ajax({
            url: '../controllers/miembros_grupos.controller.php',
            type: 'POST',
            data: { accion: 'eliminarMiembroGrupo', id_miembro: id_miembro },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    cargarGrupos();
                } else {
                    alert('Error al eliminar miembro del grupo.');
                }
            }
        });
    });

    // Evento al abrir modal para agregar miembro a un grupo
    $('#btnAgregarMiembro').click(function() {
        $('#modalAgregarMiembro').modal('show');
    });

    // Evento al seleccionar grupo para agregar miembro
    $('#selectGruposModal').change(function() {
        var id_grupo = $(this).val();
        $.ajax({
            url: '../controllers/miembros_grupos.controller.php',
            type: 'GET',
            data: { accion: 'obtenerMiembrosGrupo', id_grupo: id_grupo },
            dataType: 'json',
            success: function(data) {
                var opcionesAmigos = '';
                $.each(data, function(index, amigo) {
                    opcionesAmigos += '<option value="' + amigo.id_usuario + '">' + amigo.nombre + ' ' + amigo.apellido + '</option>';
                });
                $('#selectAmigos').html(opcionesAmigos);
            }
        });
    });

    // Evento al agregar miembro a un grupo desde el modal
    $('#btnGuardarMiembro').click(function() {
        var id_grupo = $('#selectGruposModal').val();
        var id_usuario = $('#selectAmigos').val();
        $.ajax({
            url: '../controllers/miembros_grupos.controller.php',
            type: 'POST',
            data: { accion: 'agregarMiembroGrupo', id_grupo: id_grupo, id_usuario: id_usuario },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#modalAgregarMiembro').modal('hide');
                    cargarGrupos();
                } else {
                    alert('Error al agregar miembro al grupo.');
                }
            }
        });
    });
});
