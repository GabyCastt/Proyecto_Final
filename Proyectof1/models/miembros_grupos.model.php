<?php
// models/miembros_grupo.php

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
