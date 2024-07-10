<?php
// amigos.model.php

require_once('Clase_Conectar.php');

class AmigosModel {
    private $conexion;
    private $db; // Agregar propiedad para la conexión mysqli
    
    public function __construct($conexion) {
        $this->conexion = $conexion;
        $this->db = $conexion; // Asignar la conexión a la propiedad $db
    }
    
    public function listarAmigos() {
        $query = "SELECT a.id_amigo, u1.nombre AS nombre_usuario1, u2.nombre AS nombre_usuario2, a.fecha_amistad 
                  FROM amigos a
                  INNER JOIN usuarios u1 ON a.id_usuario1 = u1.id_usuario
                  INNER JOIN usuarios u2 ON a.id_usuario2 = u2.id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $amigos = $result->fetch_all(MYSQLI_ASSOC);
        return $amigos;
    }

    public function obtenerAmigoPorId($id_amigo) {
        $query = "SELECT a.id_amigo, a.id_usuario1, u1.nombre AS nombre_usuario1, a.id_usuario2, u2.nombre AS nombre_usuario2, a.fecha_amistad 
                  FROM amigos a
                  INNER JOIN usuarios u1 ON a.id_usuario1 = u1.id_usuario
                  INNER JOIN usuarios u2 ON a.id_usuario2 = u2.id_usuario
                  WHERE a.id_amigo = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_amigo);
        $stmt->execute();
        $result = $stmt->get_result();
        $amigo = $result->fetch_assoc();
        return $amigo;
    }

    public function insertarAmigo($id_usuario1, $id_usuario2, $fecha_amistad) {
        $query = "INSERT INTO amigos (id_usuario1, id_usuario2, fecha_amistad) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iis", $id_usuario1, $id_usuario2, $fecha_amistad);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarAmigo($id_amigo, $id_usuario1, $id_usuario2, $fecha_amistad) {
        $query = "UPDATE amigos SET id_usuario1 = ?, id_usuario2 = ?, fecha_amistad = ? WHERE id_amigo = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iisi", $id_usuario1, $id_usuario2, $fecha_amistad, $id_amigo);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function eliminarAmigo($id_amigo) {
        $query = "DELETE FROM amigos WHERE id_amigo = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_amigo);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>