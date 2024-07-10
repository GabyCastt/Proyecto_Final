document.addEventListener('DOMContentLoaded', function () {
    listarGrupos();

    // Escuchar el envío del formulario para guardar o editar grupo
    $('#frm_grupos').submit(function (event) {
        event.preventDefault();
        guardarGrupo();
    });

    // Función para abrir el modal y preparar para insertar un nuevo grupo
    function abrirModal(tipo) {
        $('#modalGrupo').modal('show');
        limpiarFormulario();
        $('#exampleModalLabel').text(tipo === 'insertar' ? 'Nuevo Grupo' : 'Editar Grupo');
    }

    // Función para limpiar los campos del formulario en el modal
    function limpiarFormulario() {
        $('#id_grupo').val('');
        $('#nombre_grupo').val('');
        $('#descripcion').val('');
    }

   // Función para guardar un nuevo grupo utilizando Ajax
function guardarGrupo() {
    var nombre_grupo = $('#nombre_grupo').val();
    var descripcion = $('#descripcion').val();

    // Validación básica de campos
    if (nombre_grupo.trim() === '' || descripcion.trim() === '') {
        Swal.fire('Error', 'Todos los campos son requeridos', 'error');
        return;
    }

    $.ajax({
        url: '../controllers/grupos.controller.php',
        type: 'POST',
        data: {
            action: 'crearGrupo',
            nombre_grupo: nombre_grupo,
            descripcion: descripcion
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#modalGrupo').modal('hide');
                listarGrupos(); // Llama a tu función para listar grupos actualizada
                Swal.fire('Éxito', response.message, 'success');
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud AJAX: ' + status + ' - ' + error);
            Swal.fire('Error', 'Hubo un problema al intentar guardar el grupo.', 'error');
        }
    });
}

    // Función para listar grupos desde el servidor
    function listarGrupos() {
        fetch('../controllers/grupos.controller.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'listarGrupos'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const cuerpoGrupos = document.getElementById('cuerpoGrupos');
                cuerpoGrupos.innerHTML = '';
                data.data.forEach(grupo => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${grupo.id_grupo}</td>
                        <td>${grupo.nombre_grupo}</td>
                        <td>${grupo.descripcion}</td>
                        <td>
                            <button class="btn btn-warning" onclick="editarGrupo(${grupo.id_grupo})">Editar</button>
                            <button class="btn btn-danger" onclick="eliminarGrupo(${grupo.id_grupo})">Eliminar</button>
                        </td>
                    `;
                    cuerpoGrupos.appendChild(tr);
                });
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        });
    }

    // Función para editar un grupo
    function editarGrupo(id_grupo) {
        fetch('../controllers/grupos.controller.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'obtenerGrupo',
                id_grupo: id_grupo
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                $('#id_grupo').val(data.data.id_grupo);
                $('#nombre_grupo').val(data.data.nombre_grupo);
                $('#descripcion').val(data.data.descripcion);
                abrirModal('editar');
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        });
    }

    // Función para eliminar un grupo
    function eliminarGrupo(id_grupo) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../controllers/grupos.controller.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        action: 'eliminarGrupo',
                        id_grupo: id_grupo
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        listarGrupos();
                        Swal.fire('Eliminado', data.message, 'success');
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                });
            }
        });
    }
});
