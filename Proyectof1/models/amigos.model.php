<?php
require_once 'Clase_Conectar.php';

class Modelo_Amigos {
    private $conexion;

    public function __construct() {
        $this->conexion = new Clase_Conectar();
    }

    public function listarAmigos($id_usuario) {
        $query = "SELECT * FROM Amigos WHERE id_usuario1 = ? OR id_usuario2 = ?";
        $stmt = mysqli_prepare($this->conexion->Procedimiento_Conectar(), $query);
        mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_usuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $amigos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $amigos[] = $row;
        }
        mysqli_stmt_close($stmt);
        return $amigos;
    }

    public function agregarAmigo($id_usuario1, $id_usuario2, $fecha_amistad) {
        $query = "INSERT INTO Amigos (id_usuario1, id_usuario2, fecha_amistad) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion->Procedimiento_Conectar(), $query);
        mysqli_stmt_bind_param($stmt, "iis", $id_usuario1, $id_usuario2, $fecha_amistad);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $success;
    }

    public function eliminarAmigo($id_amigo) {
        $query = "DELETE FROM Amigos WHERE id_amigo = ?";
        $stmt = mysqli_prepare($this->conexion->Procedimiento_Conectar(), $query);
        mysqli_stmt_bind_param($stmt, "i", $id_amigo);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $success;
    }

    public function cerrarConexion() {
        $this->conexion->cerrarConexion();
    }
}
?>
