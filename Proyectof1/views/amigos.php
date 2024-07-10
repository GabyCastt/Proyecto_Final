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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Amigos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Gestión de Amigos</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
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

    <div class="container mt-3">
        <a href="dashboard.php" class="btn btn-primary">Regresar al Menú</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="amigos.js"></script>
</body>
</html>
