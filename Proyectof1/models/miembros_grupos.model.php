<?php
// models/miembros_grupo.php

class Clase_Miembros_Grupo
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function obtenerGrupos()
    {
        $query = "SELECT * FROM Grupos";
        $resultado = mysqli_query($this->conexion, $query);
        return $resultado;
    }

    public function obtenerMiembrosGrupo($id_grupo)
    {
        $query = "SELECT u.id_usuario, u.nombre, u.apellido 
                  FROM Miembros_Grupo mg 
                  JOIN Usuarios u ON mg.id_usuario = u.id_usuario 
                  WHERE mg.id_grupo = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_grupo);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        return $resultado;
    }

    public function obtenerAmigosUsuario($id_usuario)
    {
        $query = "SELECT u.id_usuario, u.nombre, u.apellido 
                  FROM Amigos a 
                  JOIN Usuarios u ON (a.id_usuario1 = u.id_usuario OR a.id_usuario2 = u.id_usuario) 
                  WHERE (a.id_usuario1 = ? OR a.id_usuario2 = ?) AND u.id_usuario != ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "iii", $id_usuario, $id_usuario, $id_usuario);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        return $resultado;
    }

    public function agregarMiembroGrupo($id_grupo, $id_usuario)
    {
        $query = "INSERT INTO Miembros_Grupo (id_grupo, id_usuario, fecha_union) VALUES (?, ?, NOW())";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "ii", $id_grupo, $id_usuario);
        return mysqli_stmt_execute($stmt);
    }

    public function eliminarMiembroGrupo($id_miembro)
    {
        $query = "DELETE FROM Miembros_Grupo WHERE id_miembro = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_miembro);
        return mysqli_stmt_execute($stmt);
    }
}
?>
