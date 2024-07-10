<?php
// models/usuarios.model.php

require_once(__DIR__ . '/../config/conexion.php');

class Clase_Usuarios {
    public function login($correo_electronico, $contrasena) {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $correo_electronico = $con->real_escape_string($correo_electronico);
        $contrasena = $con->real_escape_string($contrasena);
        $cadena = "SELECT * FROM Usuarios WHERE correo_electronico = '$correo_electronico' AND contrasena = '$contrasena'";
        $resultado = mysqli_query($con, $cadena);
        $usuario = mysqli_fetch_assoc($resultado);
        $con->close();
        return $usuario;
    }

    public function registrar($nombre, $apellido, $correo_electronico, $contrasena) {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $nombre = $con->real_escape_string($nombre);
        $apellido = $con->real_escape_string($apellido);
        $correo_electronico = $con->real_escape_string($correo_electronico);
        $contrasena = $con->real_escape_string($contrasena);
        $cadena = "INSERT INTO Usuarios (nombre, apellido, correo_electronico, contrasena) VALUES ('$nombre', '$apellido', '$correo_electronico', '$contrasena')";
        $resultado = mysqli_query($con, $cadena);
        $con->close();
        return $resultado;
    }
    public function obtenerUsuarios() {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();

        $query = "SELECT id_usuario, nombre FROM Usuarios";
        $resultado = mysqli_query($con, $query);

        $usuarios = [];
        while ($row = mysqli_fetch_assoc($resultado)) {
            $usuarios[] = $row;
        }

        $con->close();
        return $usuarios;
    }

}
?>
