<?php
session_start();
require_once('../controllers/amigos.controller.php');

if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit();
}

$controller = new Amigos_Controller();
$id_usuario = $_SESSION['usuario']['id_usuario'];
$amigos = $controller->listarAmigos($id_usuario);
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

            <!-- Amigos Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="display-4">*GESTIÓN DE AMIGOS*</h1>
                                <p class="lead">Busca y gestiona tus amigos</p>
                                <div class="mb-3">
                                    <input type="text" id="buscarUsuario" class="form-control" placeholder="Buscar usuarios...">
                                </div>
                                <div id="resultadosBusqueda"></div>
                                <h2 class="mt-4">Mis Amigos</h2>
                                <ul id="listaAmigos" class="list-group">
                                    <?php foreach ($amigos as $amigo): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="mr-2"><?= htmlspecialchars($amigo['nombre'] . ' ' . $amigo['apellido']); ?></span>
                                            <button class="btn btn-danger btn-sm eliminarAmigo" data-id="<?= $amigo['id_usuario']; ?>">Eliminar</button>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Amigos End -->

            <div class="container mt-3">
                <a href="dashboard.php" class="btn btn-primary">Regresar al Menú</a>
            </div>

            <!-- Footer Start -->
            <?php require_once('./html/footer.php') ?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="amigos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                var spinner = document.getElementById('spinner');
                if (spinner) {
                    spinner.classList.remove('show');
                }
            }, 1000);
        });
    </script>
</body>
</html>
