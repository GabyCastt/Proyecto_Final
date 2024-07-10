<?php
require_once '../config/conexion.php';

class ComentarioModel
{
    private $conexion;

    public function __construct()
    {
        $conectar = new Clase_Conectar();
        $this->conexion = $conectar->Procedimiento_Conectar();
    }

    public function crearComentario($id_publicacion, $id_usuario, $contenido)
    {
        $query = "INSERT INTO Comentarios (id_publicacion, id_usuario, contenido, fecha_comentario) VALUES (?, ?, ?, NOW())";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('iis', $id_publicacion, $id_usuario, $contenido);
        
        if ($stmt->execute()) {
            $id_comentario = $stmt->insert_id;
            $stmt->close();
            return $this->obtenerComentarioPorId($id_comentario);
        } else {
            $stmt->close();
            return false;
        }
    }

    public function obtenerComentariosPorPublicacion($id_publicacion)
    {
        $query = "SELECT * FROM Comentarios WHERE id_publicacion = ? ORDER BY fecha_comentario DESC";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('i', $id_publicacion);
        $stmt->execute();
        $result = $stmt->get_result();
        $comentarios = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $comentarios;
    }

    private function obtenerComentarioPorId($id_comentario)
    {
        $query = "SELECT * FROM Comentarios WHERE id_comentario = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('i', $id_comentario);
        $stmt->execute();
        $result = $stmt->get_result();
        $comentario = $result->fetch_assoc();
        $stmt->close();
        return $comentario;
    }
}
?>