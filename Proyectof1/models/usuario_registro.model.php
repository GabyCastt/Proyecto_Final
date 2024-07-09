<?php
require_once '../config/conexion.php';

class UsuarioRegistroModel {
    private $conexion;

    public function __construct() {
        $conectar = new Clase_Conectar();
        $this->conexion = $conectar->Procedimiento_Conectar();
    }

    public function correoExiste($correo) {
        $query = "SELECT COUNT(*) as count FROM Usuarios WHERE correo_electronico = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "s", $correo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        return $row['count'] > 0;
    }

    public function registrarUsuario($nombre, $apellido, $correo, $contrasena) {
        $query = "INSERT INTO Usuarios (nombre, apellido, correo_electronico, contrasena) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $nombre, $apellido, $correo, $contrasena);
        return mysqli_stmt_execute($stmt);
    }
}