$(document).ready(function() {
    cargarGrupos();
    cargarAmigos();

    $('#selectGrupos').change(function() {
        cargarMiembrosGrupo($(this).val());
    });

    $('#btnAgregarMiembro').click(function() {
        $('#modalAgregarMiembro').modal('show');
    });

    $('#btnGuardarMiembro').click(function() {
        agregarMiembroGrupo();
    });

    $('#tablaGrupos').on('click', '.btnEliminarMiembro', function() {
        var id_miembro = $(this).data('id');
        eliminarMiembroGrupo(id_miembro);
    });
});

function cargarGrupos() {
    $.ajax({
        url: '../controllers/miembros_grupos.controller.php',
        type: 'GET',
        data: { accion: 'obtenerGrupos' },
        dataType: 'json',
        success: function(data) {
            var opcionesGrupos = '<option value="">Seleccione un grupo</option>';
            $.each(data, function(index, grupo) {
                opcionesGrupos += '<option value="' + grupo.id_grupo + '">' + grupo.nombre_grupo + '</option>';
            });
            $('#selectGrupos, #selectGruposModal').html(opcionesGrupos);
        }
    });
}

function cargarMiembrosGrupo(id_grupo) {
    $.ajax({
        url: '../controllers/miembros_grupos.controller.php',
        type: 'GET',
        data: { accion: 'obtenerMiembrosGrupo', id_grupo: id_grupo },
        dataType: 'json',
        success: function(data) {
            var tablaMiembros = '';
            $.each(data, function(index, miembro) {
                tablaMiembros += '<tr>';
                tablaMiembros += '<td>' + miembro.nombre + ' ' + miembro.apellido + '</td>';
                tablaMiembros += '<td><button class="btn btn-danger btn-sm btnEliminarMiembro" data-id="' + miembro.id_usuario + '">Eliminar</button></td>';
                tablaMiembros += '</tr>';
            });
            $('#listaMiembros').html(tablaMiembros);
        }
    });
}

function cargarAmigos() {
    $.ajax({
        url: '../controllers/miembros_grupos.controller.php',
        type: 'GET',
        data: { accion: 'obtenerAmigos' },
        dataType: 'json',
        success: function(data) {
            var opcionesAmigos = '<option value="">Seleccione un amigo</option>';
            $.each(data, function(index, amigo) {
                opcionesAmigos += '<option value="' + amigo.id_usuario + '">' + amigo.nombre + ' ' + amigo.apellido + '</option>';
            });
            $('#selectAmigos').html(opcionesAmigos);
        }
    });
}

function agregarMiembroGrupo() {
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
                cargarMiembrosGrupo(id_grupo);
            } else {
                alert('Error al agregar miembro al grupo.');
            }
        }
    });
}

function eliminarMiembroGrupo(id_miembro) {
    if (confirm('¿Está seguro de eliminar este miembro del grupo?')) {
        $.ajax({
            url: '../controllers/miembros_grupos.controller.php',
            type: 'POST',
            data: { accion: 'eliminarMiembroGrupo', id_miembro: id_miembro },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    cargarMiembrosGrupo($('#selectGrupos').val());
                } else {
                    alert('Error al eliminar miembro del grupo.');
                }
            }
        });
    }
}