<?php
class Clase_Conectar {
    private $conexion;
    private $server = "localhost";
    private $usu = "root";
    private $clave = "";  // Contraseña de tu base de datos
    private $base = "proyecto_final";

    public function Procedimiento_Conectar() {
        $this->conexion = mysqli_connect($this->server, $this->usu, $this->clave, $this->base);
        mysqli_query($this->conexion, "SET NAMES 'utf8'");
        if ($this->conexion === false) {
            die("Error de conexión: " . mysqli_connect_error());
        }
        return $this->conexion;
    }

    public function cerrarConexion() {
        if ($this->conexion) {
            mysqli_close($this->conexion);
            $this->conexion = null;
        }
    }
}
?>
