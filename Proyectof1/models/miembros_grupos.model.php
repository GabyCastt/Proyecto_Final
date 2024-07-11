<?php
require_once('../config/conexion.php');

class Clase_Miembros_Grupo
{
    private $conn;

    public function __construct($conexion)
    {
        $this->conn = $conexion->conexion; // Usamos la propiedad $conexion->conexion de Clase_Conectar
    }

    // Función para obtener todos los grupos
    public function obtenerGrupos()
    {
        $query = "SELECT id_grupo, nombre_grupo FROM Grupos";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Función para obtener los miembros de un grupo dado
    public function obtenerMiembrosGrupo($id_grupo)
    {
        $query = "SELECT u.nombre, u.apellido 
                  FROM Usuarios u 
                  JOIN miembros_grupo mg ON u.id_usuario = mg.id_usuario 
                  WHERE mg.id_grupo = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_grupo);
        $stmt->execute();
        return $stmt;
    }

    // Función para agregar un usuario a un grupo
    public function agregarMiembroGrupo($id_grupo, $id_usuario)
    {
        $query = "INSERT INTO miembros_grupo (id_grupo, id_usuario, fecha_union) 
                  VALUES (?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id_grupo, $id_usuario);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Función para eliminar un usuario de un grupo
    public function eliminarMiembroGrupo($id_miembro)
    {
        $query = "DELETE FROM miembros_grupo WHERE id_miembro = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_miembro);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
