<?php
require_once('../config/conexion.php');

class Clase_Miembros_Grupo
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function obtenerGrupos()
    {
        $query = "SELECT * FROM grupos";
        $resultado = mysqli_query($this->conexion, $query);
        if (!$resultado) {
            throw new Exception("Error al listar grupos: " . mysqli_error($this->conexion));
        }
        return $resultado;
    }

    public function obtenerMiembrosGrupo($id_grupo)
    {
        $query = "SELECT Usuarios.nombre, Usuarios.apellido FROM Miembros_Grupo 
                  JOIN Usuarios ON Miembros_Grupo.id_usuario = Usuarios.id_usuario
                  WHERE Miembros_Grupo.id_grupo = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_grupo);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        if (!$resultado) {
            throw new Exception("Error al obtener miembros del grupo: " . mysqli_error($this->conexion));
        }
        return $resultado;
    }

    public function obtenerAmigos($id_usuario)
    {
        $query = "SELECT Usuarios.id_usuario, Usuarios.nombre, Usuarios.apellido FROM Amigos 
                  JOIN Usuarios ON (Amigos.id_usuario1 = Usuarios.id_usuario OR Amigos.id_usuario2 = Usuarios.id_usuario)
                  WHERE (Amigos.id_usuario1 = ? OR Amigos.id_usuario2 = ?) AND Usuarios.id_usuario != ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "iii", $id_usuario, $id_usuario, $id_usuario);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        if (!$resultado) {
            throw new Exception("Error al obtener amigos del usuario: " . mysqli_error($this->conexion));
        }
        return $resultado;
    }

    public function agregarMiembroGrupo($id_grupo, $id_usuario)
    {
        $query = "INSERT INTO Miembros_Grupo (id_grupo, id_usuario, fecha_union) VALUES (?, ?, NOW())";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "ii", $id_grupo, $id_usuario);
        $resultado = mysqli_stmt_execute($stmt);
        if (!$resultado) {
            throw new Exception("Error al agregar miembro al grupo: " . mysqli_error($this->conexion));
        }
        return $resultado;
    }

    public function eliminarMiembroGrupo($id_miembro)
    {
        $query = "DELETE FROM Miembros_Grupo WHERE id_miembro = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_miembro);
        $resultado = mysqli_stmt_execute($stmt);
        if (!$resultado) {
            throw new Exception("Error al eliminar miembro del grupo: " . mysqli_error($this->conexion));
        }
        return $resultado;
    }
}

