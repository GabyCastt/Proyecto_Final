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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Publicaciones</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Archivo de estilos personalizado -->
    <style>
        body {
            background-image: linear-gradient(to bottom, #34C759, #2E865F);
            background-size: 100% 100vh;
            background-position: 0% 100%;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #3E8E41; /* Verde oscuro */
            color: #fff;
        }
        .card {
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #F7F7F7; /* Blanco claro */
        }
        .card-header {
            background-color: #3E8E41; /* Verde oscuro */
            color: #fff;
        }
        .card-body {
            padding: 20px;
        }
        .table {
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .btn-primary {
            background-color: #34C759; /* Verde claro */
            border-color: #34C759;
        }
        .btn-danger {
            background-color: #d9534f;
            border-color: #d9534f;
        }
        .nav-link {
            color: #fff;
        }
        .nav-link:hover {
            color: #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
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
                            <?php if ($publicacion): ?>
                                <input type="hidden" name="id_publicacion" value="<?php echo $publicacion['id_publicacion']; ?>">
                                <input type="hidden" name="editar">
                            <?php else: ?>
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
                                <?php foreach ($controller->listarPublicaciones() as $pub): ?>
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
    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="publicaciones.js"></script>
</body>
</html>
