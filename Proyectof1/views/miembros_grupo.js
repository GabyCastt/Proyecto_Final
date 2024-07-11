$(document).ready(function () {
    cargarGrupos();
    cargarAmigos();

    $('#selectGrupos').change(function () {
        let id_grupo = $(this).val();
        if (id_grupo) {
            cargarMiembrosGrupo(id_grupo);
        } else {
            $('#listaMiembros').empty();
        }
    });

    $('#btnAgregarMiembro').click(function () {
        let id_grupo = $('#selectGrupos').val();
        if (id_grupo) {
            $('#idGrupoSeleccionado').val(id_grupo);
            $('#modalAgregarMiembro').modal('show');
        } else {
            alert('Selecciona un grupo primero.');
        }
    });

    $('#btnGuardarMiembro').click(function () {
        let id_grupo = $('#idGrupoSeleccionado').val();
        let id_usuario = $('#selectAmigos').val();

        if (id_usuario) {
            $.post('../controllers/miembros_grupos.controller.php', {
                accion: 'agregarMiembroGrupo',
                id_grupo: id_grupo,
                id_usuario: id_usuario
            }, function (data) {
                if (data.success) {
                    $('#modalAgregarMiembro').modal('hide');
                    cargarMiembrosGrupo(id_grupo);
                } else {
                    alert('Error al agregar miembro.');
                }
            }, 'json');
        } else {
            alert('Selecciona un amigo para agregar.');
        }
    });
});

function cargarGrupos() {
    $.get('../controllers/miembros_grupos.controller.php', {accion: 'obtenerGrupos'}, function (data) {
        let selectGrupos = $('#selectGrupos');
        selectGrupos.empty();
        selectGrupos.append('<option value="">Seleccione un grupo</option>');
        $.each(data, function (index, grupo) {
            selectGrupos.append(`<option value="${grupo.id_grupo}">${grupo.nombre}</option>`);
        });
    }, 'json');
}

function cargarMiembrosGrupo(id_grupo) {
    $.get('../controllers/miembros_grupos.controller.php', {
        accion: 'obtenerMiembrosGrupo',
        id_grupo: id_grupo
    }, function (data) {
        let listaMiembros = $('#listaMiembros');
        listaMiembros.empty();
        $.each(data, function (index, miembro) {
            listaMiembros.append(`<tr><td>${miembro.nombre} ${miembro.apellido}</td></tr>`);
        });
    }, 'json');
}

function cargarAmigos() {
    $.get('../controllers/miembros_grupos.controller.php', {accion: 'obtenerAmigos'}, function (data) {
        let selectAmigos = $('#selectAmigos');
        selectAmigos.empty();
        $.each(data, function (index, amigo) {
            selectAmigos.append(`<option value="${amigo.id_usuario}">${amigo.nombre} ${amigo.apellido}</option>`);
        });
    }, 'json');
}
