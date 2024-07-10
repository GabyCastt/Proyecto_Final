<?php
require_once('../config/conexion.php');

class Miembros_Model{
    private $conn;

    public function __construct() {
        $conectar = new Clase_Conectar();
        $this->conn = $conectar->Procedimiento_Conectar();
}
public function listarMiembros($id_usuario1) {
    $query = "SELECT CONCAT(u.nombre, ' ', u.apellido) AS nombre_completo 
              FROM Amigos a 
              JOIN Usuarios u ON a.id_usuario2 = u.id_usuario 
              WHERE a.id_usuario1 = ?";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $id_usuario1);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    $miembros = [];
    while ($row = $result->fetch_assoc()) {
        $miembros[] = $row['nombre_completo'];
    }
    
    return $miembros;
}

}