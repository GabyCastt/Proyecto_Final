<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit();
}
$usuario_nombre = $_SESSION['usuario']['nombre'];
?>

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

        .welcome-hero {
            background-image: linear-gradient(to bottom, #34C759, #2E865F);
            background-size: 100% 300px;
            background-position: 0% 100%;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        .welcome-hero h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .welcome-hero p {
            font-size: 18px;
            margin-bottom: 20px;
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

            <div class="container-fluid pt-4 px-4">
                <div class="welcome-hero">
                    <h1 class="display-3 fw-bold">BIENVENID@, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?>!</h1>
                    <p class="lead">TE ENCUENTRAS EN GESTIÓN DE GRUPOS!</p>
                </div>

                <div class='d-flex align-items-center justify-content-between mb-4'>
                    <div class="container mt-5">
                        <h1 class="mb-4">Administrar Grupos</h1>
                        
                        <!-- Botón para abrir modal de agregar grupo -->
                        <button type="button" class="btn btn-primary mb-3" onclick="abrirModalAgregar()">Nuevo Grupo</button>
                        
                        <!-- Tabla para listar grupos -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="listaGrupos">
                                <!-- Aquí se cargarán dinámicamente los grupos -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal para agregar y editar grupo -->
                    <div class="modal fade" id="modalGrupo" tabindex="-1" role="dialog" aria-labelledby="modalGrupoLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalGrupoLabel">Nuevo Grupo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulario para agregar o editar grupo -->
                                    <form id="formGrupo">
                                        <input type="hidden" id="grupoId">
                                        <div class="form-group">
                                            <label for="nombre_grupo">Nombre del Grupo</label>
                                            <input type="text" class="form-control" id="nombre_grupo" name="nombre_grupo" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="descripcion">Descripción</label>
                                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" onclick="guardarGrupo()">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Start -->
            <?php require_once('./html/footer.php') ?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href='#' class='btn btn-lg btn-primary btn-lg-square back-to-top'><i class='bi bi-arrow-up'></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <?php require_once('./html/scripts.php') ?>
    <script src="dashboard.js"></script>
    <!-- jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Archivo JavaScript personalizado -->
    <script src="./grupos.js"></script>
</body>

</html>
