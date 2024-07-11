<?php
// models/miembros_grupo.php

<<<<<<< HEAD
class MiembrosGrupo {
    private $conexion;

    public function __construct($db) {
        $this->conexion = $db;
    }

    // Función para obtener los miembros de un grupo específico
    public function obtenerMiembrosGrupo($idGrupo) {
        $query = "SELECT u.id_usuario, u.nombre, u.apellido, mg.id_miembro
                  FROM Usuarios u
                  INNER JOIN Miembros_Grupo mg ON u.id_usuario = mg.id_usuario
                  WHERE mg.id_grupo = ?
                  ORDER BY u.nombre";

        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $idGrupo);
        $stmt->execute();
        $result = $stmt->get_result();

        $miembros = array();
        while ($row = $result->fetch_assoc()) {
            $miembros[] = $row;
        }
        return $miembros;
    }

    // Función para agregar un nuevo miembro a un grupo
    public function agregarMiembroGrupo($idGrupo, $idUsuario) {
        $query = "INSERT INTO Miembros_Grupo (id_grupo, id_usuario, fecha_union)
                  VALUES (?, ?, NOW())";

        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("ii", $idGrupo, $idUsuario);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Función para eliminar un miembro de un grupo
    public function eliminarMiembroGrupo($idMiembro) {
        $query = "DELETE FROM Miembros_Grupo WHERE id_miembro = ?";

        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $idMiembro);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
=======
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
>>>>>>> 05b22097c6d7fd8551f2fbc1c0a67bf5c12c9c6f
