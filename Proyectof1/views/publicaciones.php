<?php
require_once '../config/conexion.php';
require_once '../controllers/publicaciones.controller.php';

$conexionObj = new Clase_Conectar();
$conexion = $conexionObj->Procedimiento_Conectar();

$controller = new PublicacionesController($conexion);

// Crear nueva publicación si se reciben datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    $controller->crearPublicacion();
}

// Editar publicación si se reciben datos del formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $controller->editarPublicacion();
}

// Eliminar publicación si se recibe el parámetro id_publicacion
if (isset($_GET['eliminar']) && isset($_GET['id_publicacion'])) {
    $controller->eliminarPublicacion();
}

// Obtener detalles de una publicación si se recibe el parámetro id_publicacion
$publicacion = null;
if (isset($_GET['id_publicacion'])) {
    $publicacion = $controller->obtenerPublicacion();
}
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

            <!-- Publicaciones Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row">
                    <div class="col-md-12">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <a class="navbar-brand" href="#">Gestión de Publicaciones</a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="#">Crear Publicación <span class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Listado de Publicaciones</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title"><?php echo $publicacion ? 'Editar Publicación' : 'Crear Nueva Publicación'; ?></h5>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <?php if ($publicacion) : ?>
                                        <input type="hidden" name="id_publicacion" value="<?php echo $publicacion['id_publicacion']; ?>">
                                        <input type="hidden" name="editar">
                                    <?php else : ?>
                                        <input type="hidden" name="crear">
                                    <?php endif; ?>

                                    <div class="form-group">
                                        <label for="titulo">Título</label>
                                        <input type="text" id="titulo" name="titulo" class="form-control" value="<?php echo $publicacion ? htmlspecialchars($publicacion['titulo']) : ''; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="contenido">Contenido</label>
                                        <textarea id="contenido" name="contenido" class="form-control" rows="4" required><?php echo $publicacion ? htmlspecialchars($publicacion['contenido']) : ''; ?></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><?php echo $publicacion ? 'Guardar Cambios' : 'Crear Publicación'; ?></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Listado de Publicaciones</h5>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Título</th>
                                            <th>Contenido</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($controller->listarPublicaciones() as $pub) : ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($pub['id_publicacion']); ?></td>
                                                <td><?php echo htmlspecialchars($pub['titulo']); ?></td>
                                                <td><?php echo htmlspecialchars($pub['contenido']); ?></td>
                                                <td>
                                                    <a href="comentario.php?id_publicacion=<?php echo $pub['id_publicacion']; ?>" class="btn btn-sm btn-primary">Ver Comentarios</a>
                                                    <a href="?id_publicacion=<?php echo $pub['id_publicacion']; ?>" class="btn btn-sm btn-info">Editar</a>
                                                    <a href="?eliminar&id_publicacion=<?php echo $pub['id_publicacion']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar esta publicación?');">Eliminar</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container mt-3">
                    <a href="dashboard.php" class="btn btn-primary">Regresar al Dashboard</a>
                </div>
            </div>
            <!-- Publicaciones End -->

            <!-- Footer Start -->
            <?php require_once('./html/footer.php') ?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr('.custom-flatpickr', {
                enableTime: true,
                dateFormat: 'Y-m-d H:i',
                time_24hr: true,
                altInput: true,
                altFormat: 'F j, Y (h:i K)',
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                        longhand: [
                            'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'
                        ]
                    },
                    months: {
                        shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                        longhand: [
                            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                        ]
                    }
                }
            });

            setTimeout(function() {
                var spinner = document.getElementById('spinner');
                if (spinner) {
                    spinner.classList.remove('show');
                }
            }, 1000);
        });
    </script>
</body>

</html>