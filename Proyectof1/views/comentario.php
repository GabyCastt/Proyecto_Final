<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit();
}

$usuario_nombre = $_SESSION['usuario']['nombre'];
$usuario_id = $_SESSION['usuario']['id_usuario'];
$id_publicacion = isset($_GET['id_publicacion']) ? $_GET['id_publicacion'] : 0;

require_once('../models/comentario.model.php');
$comentarioModel = new ComentarioModel();
$comentarios = $comentarioModel->obtenerComentariosPorPublicacion($id_publicacion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios de Publicación</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: linear-gradient(to bottom, #34C759, #2E865F);
            background-size: 100% 100vh;
            background-position: 0% 100%;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        #comentarios-lista {
            max-height: 70vh;
            overflow-y: auto;
            width: 100%;
            max-width: 600px;
        }
        .form-group {
            width: 100%;
            max-width: 600px;
        }
        #form-comentario {
            width: 100%;
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center text-white mb-4">Comentarios de la Publicación</h1>
        <div id="comentarios-lista" class="mb-4">
            <?php if (!empty($comentarios)): ?>
                <ul class="list-unstyled">
                    <?php foreach ($comentarios as $comentario): ?>
                        <li class="mb-3 bg-white p-3 rounded">
                            <strong><?php echo htmlspecialchars($comentario['nombre_usuario']); ?>:</strong>
                            <p><?php echo htmlspecialchars($comentario['contenido']); ?></p>
                            <small class="text-muted">Fecha: <?php echo htmlspecialchars($comentario['fecha_comentario']); ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-white">No hay comentarios aún.</p>
            <?php endif; ?>
        </div>
        <form id="form-comentario" method="post" class="mb-4">
            <input type="hidden" name="id_publicacion" value="<?php echo htmlspecialchars($id_publicacion); ?>">
            <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario_id); ?>">
            <input type="hidden" name="nombre_usuario" value="<?php echo htmlspecialchars($usuario_nombre); ?>">
            <div class="form-group">
                <label for="contenido" class="text-white">Nuevo Comentario (<?php echo htmlspecialchars($usuario_nombre); ?>)</label>
                <textarea class="form-control" id="contenido" name="contenido" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar Comentario</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="comentario.js"></script>
</body>
</html>