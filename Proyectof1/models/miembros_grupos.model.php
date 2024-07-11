<?php

require_once('config/conexion.php');

class ModeloMiembrosGrupo {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Clase_Conectar())->Procedimiento_Conectar();
    }

    public function obtenerAmigosComoMiembros($idUsuario) {
        $query = "SELECT u.id_usuario, CONCAT(u.nombre, ' ', u.apellido) AS nombre_completo 
                  FROM Usuarios u 
                  INNER JOIN Amigos a ON u.id_usuario = a.id_usuario2 
                  WHERE a.id_usuario1 = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $idUsuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $amigos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $amigos[] = [
                'id_usuario' => $row['id_usuario'],
                'nombre_completo' => $row['nombre_completo']
            ];
        }
        mysqli_stmt_close($stmt);
        return $amigos;
    }

    public function agregarMiembroAGrupo($idGrupo, $idUsuario) {
        $query = "INSERT INTO Miembros_Grupo (id_grupo, id_usuario, fecha_union) VALUES (?, ?, NOW())";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "ii", $idGrupo, $idUsuario);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $success;
    }
}

?>
