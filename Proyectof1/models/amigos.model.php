<?php
require_once('../config/conexion.php');

class Amigos_Model {
    private $conn;

    public function __construct() {
        $conectar = new Clase_Conectar();
        $this->conn = $conectar->Procedimiento_Conectar();
    }

    public function listarAmigos($id_usuario) {
        $sql = "SELECT u.id_usuario, u.nombre, u.apellido
                FROM Amigos a
                JOIN Usuarios u ON (a.id_usuario1 = u.id_usuario OR a.id_usuario2 = u.id_usuario)
                WHERE (a.id_usuario1 = ? OR a.id_usuario2 = ?) AND u.id_usuario != ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $id_usuario, $id_usuario, $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function listarAmigosUsuarioActual($id_usuario) {
        // Este método es idéntico a listarAmigos, así que podemos llamar a ese método
        return $this->listarAmigos($id_usuario);
    }

    public function buscarUsuarios($busqueda, $id_usuario) {
        $busqueda = "%$busqueda%";
        $sql = "SELECT id_usuario, nombre, apellido
                FROM Usuarios
                WHERE (nombre LIKE ? OR apellido LIKE ?) AND id_usuario != ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $busqueda, $busqueda, $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function agregarAmigo($id_usuario1, $id_usuario2) {
        $sql = "INSERT INTO Amigos (id_usuario1, id_usuario2, fecha_amistad) VALUES (?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $id_usuario1, $id_usuario2);
        return $stmt->execute();
    }

    public function eliminarAmigo($id_usuario1, $id_usuario2) {
        $sql = "DELETE FROM Amigos WHERE (id_usuario1 = ? AND id_usuario2 = ?) OR (id_usuario1 = ? AND id_usuario2 = ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiii", $id_usuario1, $id_usuario2, $id_usuario2, $id_usuario1);
        return $stmt->execute();
    }
}
?>