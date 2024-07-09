document.addEventListener('DOMContentLoaded', function () {
    listarGrupos();

    document.getElementById('frm_grupos').addEventListener('submit', function (event) {
        event.preventDefault();
        guardarGrupo();
    });
});

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

function abrirModal(tipo) {
    document.getElementById('frm_grupos').reset();
    document.getElementById('id_grupo').value = '';
    document.getElementById('exampleModalLabel').innerText = tipo === 'insertar' ? 'Nuevo Grupo' : 'Editar Grupo';
    $('#modalGrupo').modal('show');
}

function guardarGrupo() {
    const formData = new FormData(document.getElementById('frm_grupos'));
    formData.append('action', document.getElementById('id_grupo').value ? 'editarGrupo' : 'insertarGrupo');

    fetch('../controllers/grupos.controller.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                $('#modalGrupo').modal('hide');
                listarGrupos();
                Swal.fire('Éxito', data.message, 'success');
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        });
}

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
                document.getElementById('id_grupo').value = data.data.id_grupo;
                document.getElementById('nombre_grupo').value = data.data.nombre_grupo;
                document.getElementById('descripcion').value = data.data.descripcion;
                abrirModal('editar');
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        });
}

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
