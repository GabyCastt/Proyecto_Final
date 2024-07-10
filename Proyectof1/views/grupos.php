<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once('./html/head.php') ?>
    <link href="../public/lib/calendar/lib/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        .custom-flatpickr {
            display: flex;
            align-items: center;
        }
        .custom-flatpickr input {
            margin-right: 5px;
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <?php require_once('./html/menu.php') ?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <?php require_once('./html/header.php') ?>
            <!-- Navbar End -->

            <!-- Grupos Start -->
            <div class="container-fluid pt-4 px-4">
                <button type="button" class="btn btn-primary" onclick="abrirModal('insertar')">
                    Nuevo Grupo
                </button>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Lista de grupos</h6>
                </div>
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoGrupos">
                    </tbody>
                </table>
            </div>
            <!-- Grupos End -->

            <!-- Miembros de Grupo Start -->
            <div class="container-fluid pt-4 px-4">
                <h6 class="mb-0">Miembros del Grupo</h6>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <button type="button" class="btn btn-primary" onclick="abrirModalMiembro('insertar')">
                        Agregar Miembro
                    </button>
                </div>
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Grupo</th>
                            <th>Nombre de Usuario</th>
                            <th>Fecha de Unión</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoMiembros">
                    </tbody>
                </table>
            </div>
            <!-- Miembros de Grupo End -->

            <!-- Footer Start -->
            <?php require_once('./html/footer.php') ?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- Modales -->
    <!-- Modal para Grupos -->
    <div class="modal fade" id="modalGrupo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Grupo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="frm_grupos">
                    <div class="modal-body">
                        <input type="hidden" name="id_grupo" id="id_grupo">
                        <div class="form-group">
                            <label for="nombre_grupo">Nombre</label>
                            <input type="text" name="nombre_grupo" id="nombre_grupo" placeholder="Ingrese el nombre del grupo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" id="descripcion" placeholder="Ingrese la descripción del grupo" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Miembros de Grupo -->
    <div class="modal fade" id="modalMiembro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="frm_miembros">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nuevo Miembro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_miembro" name="id_miembro">
                        <div class="form-group">
                            <label for="id_grupo">Grupo</label>
                            <select class="form-control" id="id_grupo" name="id_grupo" required></select>
                        </div>
                        <div class="form-group">
                            <label for="id_usuario">Usuario</label>
                            <select class="form-control" id="id_usuario" name="id_usuario" required></select>
                        </div>
                        <div class="form-group">
                            <label for="fecha_union">Fecha de Unión</label>
                            <input type="date" class="form-control" id="fecha_union" name="fecha_union" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <?php require_once('./html/scripts.php') ?>
    <script src="./grupos.js"></script>
    <script src="./miembros_grupo.js"></script>
    <script>
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

        document.addEventListener('DOMContentLoaded', function () {
            listarGrupos();

            // Escuchar el envío del formulario para guardar o editar grupo
            $('#frm_grupos').submit(function (event) {
                event.preventDefault();
                guardarGrupo();
            });

            // Función para guardar o editar un grupo utilizando Ajax
            function guardarGrupo() {
                var formData = $('#frm_grupos').serialize();
                $.ajax({
                    url: '../controllers/grupos.controller.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            $('#modalGrupo').modal('hide');
                            listarGrupos();
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

        document.addEventListener('DOMContentLoaded', function () {
            // Inicialización de flatpickr
            flatpickr('.flatpickr', {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true
            });
        });
    </script>
</body>
</html>
