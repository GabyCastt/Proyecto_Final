<?php
require_once '../config/conexion.php';
require_once '../controllers/comentarios.controller.php';

$conexionObj = new Clase_Conectar();
$conexion = $conexionObj->Procedimiento_Conectar();

$controller = new ComentariosController();

$comentarios = [];
if (isset($_GET['id_publicacion'])) {
    $id_publicacion = filter_input(INPUT_GET, 'id_publicacion', FILTER_SANITIZE_NUMBER_INT);
    $comentarios = $controller->obtenerComentariosPorPublicacion($id_publicacion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios de Publicación</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Comentarios de la Publicación</h1>
        <div id="comentarios-lista">
            <?php if (!empty($comentarios)): ?>
                <ul class="list-unstyled">
                    <?php foreach ($comentarios as $comentario): ?>
                        <li class="mb-3">
                            <strong><?php echo htmlspecialchars($comentario['id_usuario']); ?>:</strong>
                            <p><?php echo htmlspecialchars($comentario['contenido']); ?></p>
                            <small>Fecha: <?php echo htmlspecialchars($comentario['fecha_comentario']); ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No hay comentarios aún.</p>
            <?php endif; ?>
        </div>
        <form id="form-comentario" method="post">
            <input type="hidden" name="id_publicacion" value="<?php echo isset($_GET['id_publicacion']) ? htmlspecialchars($_GET['id_publicacion']) : '0'; ?>">
            <div class="form-group">
                <label for="contenido">Nuevo Comentario</label>
                <textarea class="form-control" id="contenido" name="contenido" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar Comentario</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#form-comentario').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: '../controllers/comentarios.controller.php',
                    data: formData,
                    dataType: 'json',
                    encode: true
                })
                .done(function(response) {
                    if (response && response.success) {
                        alert(response.message);
                        $('#comentarios-lista').append(
                            '<li class="mb-3">' +
                            '<strong>' + (response.comentario.id_usuario || 'Usuario') + ':</strong>' +
                            '<p>' + response.comentario.contenido + '</p>' +
                            '<small>Fecha: ' + response.comentario.fecha_comentario + '</small>' +
                            '</li>'
                        );
                        $('#contenido').val('');
                    } else {
                        alert('Error al enviar comentario: ' + (response.message || 'Error desconocido'));
                    }
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    console.error("Error AJAX:", textStatus, errorThrown);
                    alert('Error al conectar con el servidor. Por favor, inténtelo de nuevo.');
                });
            });
        });
    </script>
</body>
</html>