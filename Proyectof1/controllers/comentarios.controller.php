<?php
require_once('../models/comentario.model.php');

class ComentarioController {
    private $model;

    public function __construct() {
        $this->model = new ComentarioModel();
    }

    public function agregarComentario($id_publicacion, $id_usuario, $nombre_usuario, $contenido) {
        $resultado = $this->model->agregarComentario($id_publicacion, $id_usuario, $contenido);
        if ($resultado) {
            return [
                'status' => 'success',
                'nombre_usuario' => $nombre_usuario,
                'contenido' => $contenido,
                'fecha_comentario' => date('Y-m-d H:i:s')
            ];
        } else {
            return ['status' => 'error'];
        }
    }

    public function obtenerComentariosPorPublicacion($id_publicacion) {
        return $this->model->obtenerComentariosPorPublicacion($id_publicacion);
    }
}

// Manejo de solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ComentarioController();
    $resultado = $controller->agregarComentario(
        $_POST['id_publicacion'],
        $_POST['id_usuario'],
        $_POST['nombre_usuario'],
        $_POST['contenido']
    );
    echo json_encode($resultado);
}