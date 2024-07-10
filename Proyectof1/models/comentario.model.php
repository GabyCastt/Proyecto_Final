<?php
require_once('../config/conexion.php');

class ComentarioModel {
    private $conn;

    public function __construct() {
        $conectar = new Clase_Conectar();
        $this->conn = $conectar->Procedimiento_Conectar();
    }

    public function agregarComentario($id_publicacion, $id_usuario, $contenido) {
        $sql = "INSERT INTO Comentarios (id_publicacion, id_usuario, contenido, fecha_comentario) VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $id_publicacion, $id_usuario, $contenido);
        return $stmt->execute();
    }

    public function obtenerComentariosPorPublicacion($id_publicacion) {
        $sql = "SELECT c.*, u.nombre as nombre_usuario FROM Comentarios c 
                JOIN Usuarios u ON c.id_usuario = u.id_usuario 
                WHERE c.id_publicacion = ? 
                ORDER BY c.fecha_comentario DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_publicacion);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}