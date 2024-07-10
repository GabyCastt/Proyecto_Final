<?php
require_once '../models/comentario.model.php';

class ComentariosController
{
    private $comentarioModel;

    public function __construct()
    {
        $this->comentarioModel = new ComentarioModel();
    }

    public function crearComentario($id_publicacion, $id_usuario, $contenido)
    {
        $resultado = $this->comentarioModel->crearComentario($id_publicacion, $id_usuario, $contenido);
        if ($resultado) {
            return [
                'success' => true,
                'message' => 'Comentario creado correctamente.',
                'comentario' => $resultado
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al crear el comentario.'
            ];
        }
    }

    public function obtenerComentariosPorPublicacion($id_publicacion)
    {
        return $this->comentarioModel->obtenerComentariosPorPublicacion($id_publicacion);
    }
}

// Procesar la solicitud AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ComentariosController();

    $id_publicacion = filter_input(INPUT_POST, 'id_publicacion', FILTER_SANITIZE_NUMBER_INT);
    $id_usuario = 1; // Asumiendo que tienes una forma de obtener el ID del usuario
    $contenido = filter_input(INPUT_POST, 'contenido', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($id_publicacion && $contenido) {
        $response = $controller->crearComentario($id_publicacion, $id_usuario, $contenido);
    } else {
        $response = ['success' => false, 'message' => 'Datos de entrada inválidos.'];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>