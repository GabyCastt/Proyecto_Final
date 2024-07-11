<?php
require_once("../config/conexion.php");

class GruposMiembrosModel {
    private $conexion;

    public function __construct() {
        $conectar = new Clase_Conectar();
        $this->conexion = $conectar->Procedimiento_Conectar();
    }

    // CRUD para Grupos
    public function crearGrupo($nombre, $descripcion) {
        $query = "INSERT INTO Grupos (nombre_grupo, descripcion) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "ss", $nombre, $descripcion);
        return mysqli_stmt_execute($stmt);
    }

    public function obtenerGrupos() {
        $query = "SELECT * FROM Grupos";
        $resultado = mysqli_query($this->conexion, $query);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    public function actualizarGrupo($id, $nombre, $descripcion) {
        $query = "UPDATE Grupos SET nombre_grupo = ?, descripcion = ? WHERE id_grupo = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $nombre, $descripcion, $id);
        return mysqli_stmt_execute($stmt);
    }

    public function eliminarGrupo($id) {
        $query = "DELETE FROM Grupos WHERE id_grupo = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }

    // CRUD para Miembros de Grupo
    public function agregarMiembro($idGrupo, $idUsuario) {
        $fechaUnion = date("Y-m-d H:i:s");
        $query = "INSERT INTO Miembros_Grupo (id_grupo, id_usuario, fecha_union) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "iis", $idGrupo, $idUsuario, $fechaUnion);
        return mysqli_stmt_execute($stmt);
    }

    public function obtenerMiembrosGrupo($idGrupo) {
        $query = "SELECT mg.*, u.nombre, u.apellido FROM Miembros_Grupo mg 
                  INNER JOIN Usuarios u ON mg.id_usuario = u.id_usuario 
                  WHERE mg.id_grupo = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $idGrupo);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    public function eliminarMiembro($idMiembro) {
        $query = "DELETE FROM Miembros_Grupo WHERE id_miembro = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $idMiembro);
        return mysqli_stmt_execute($stmt);
    }

    public function obtenerAmigos($idUsuario) {
        $query = "SELECT u.id_usuario, u.nombre, u.apellido 
                  FROM Usuarios u 
                  INNER JOIN Amigos a ON (u.id_usuario = a.id_usuario1 OR u.id_usuario = a.id_usuario2) 
                  WHERE (a.id_usuario1 = ? OR a.id_usuario2 = ?) AND u.id_usuario != ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "iii", $idUsuario, $idUsuario, $idUsuario);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
}
?>