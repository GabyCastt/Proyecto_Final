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
    <div class="modal fade" id="ModalAgregarGrupo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo Miembro de Grupo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_miembro" name="id_miembro">
                    <div class="form-group">
                        <label for="id_grupo">Grupo</label>
                        <select class="form-control" id="id_grupo" name="id_grupo" required>
                            <!-- Options will be dynamically filled by JavaScript -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_usuario">Usuario</label>
                        <select class="form-control" id="id_usuario" name="id_usuario" required>
                            <!-- Options will be dynamically filled by JavaScript -->
                        </select>
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
<!-- Modal para Editar Grupo -->
<div class="modal fade" id="modalEditarGrupo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frm_editar_grupo">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Grupo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id_grupo" name="id_grupo">
                    <div class="form-group">
                        <label for="nombre_grupo">Nombre del Grupo</label>
                        <input type="text" class="form-control" id="nombre_grupo" name="nombre_grupo" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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
        function abrirModal(tipo) {
        if (tipo === 'insertar') {
            document.getElementById('frm_grupos').reset();
            document.getElementById('id_grupo').value = '';
            $('#ModalAgregarGrupo').modal('show'); // Cambiado a ModalAgregarGrupo
        }
    }

    function abrirModalMiembro(tipo) {
        if (tipo === 'insertar') {
            document.getElementById('frm_miembros').reset();
            document.getElementById('id_miembro').value = '';
            cargarSelectoresMiembro();
            $('#modalMiembro').modal('show');
        }
    }

    function cargarSelectoresMiembro() {
        // Supongamos que tienes funciones para obtener los grupos y los usuarios
        obtenerGrupos(function(grupos) {
            let selectGrupo = document.getElementById('nombre_grupo');
            selectGrupo.innerHTML = ''; // Limpiar opciones anteriores
            grupos.forEach(grupo => {
                let option = document.createElement('option');
                option.value = grupo.id_grupo;
                option.text = grupo.nombre_grupo;
                selectGrupo.add(option);
            });
        });

        obtenerUsuarios(function(usuarios) {
            let selectUsuario = document.getElementById('id_usuario');
            selectUsuario.innerHTML = ''; // Limpiar opciones anteriores
            usuarios.forEach(usuario => {
                let option = document.createElement('option');
                option.value = usuario.id_usuario;
                option.text = usuario.nombre_usuario;
                selectUsuario.add(option);
            });
        });
    }

    function obtenerGrupos(callback) {
        $.ajax({
            url: '../miembros_grupo.js',
            type: 'GET',
            success: function(response) {
                let grupos = JSON.parse(response);
                callback(grupos);
            }
        });
    }

    function obtenerUsuarios(callback) {
        $.ajax({
            url: '../miembros_grupos.js',
            type: 'GET',
            success: function(response) {
                let usuarios = JSON.parse(response);
                callback(usuarios);
            }
        });
    }
    </script>
</body>
</html>
