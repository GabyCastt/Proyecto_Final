<?php
class Clase_Conectar
{
    public $conexion;
    protected $db;
    private $server = "localhost";
    private $usu = "root";
<<<<<<< HEAD
    private $clave = "";  //contrasenia super usuario en mamp
    private $base = "proyecto_final";
     
    public function Procedimiento_Conectar()
    {
        $this->conexion = mysqli_connect($this->server, $this->usu, $this->clave, $this->base);
        mysqli_query($this->conexion, "SET NAMES 'utf8'");
        if ($this->conexion == 0) die("error al conectarse con mysql ");
=======
    private $clave = "";  // Sin contraseña, asegurarse de que esté exactamente así, sin espacios.
    private $base = "ejercicio_calvache_castillo";

   // private $port = 3307; // Especificar el puerto MySQL personalizado

    public function Procedimiento_Conectar()
    {
        // Intentar conectar a la base de datos, especificando el puerto
        $this->conexion = mysqli_connect($this->server, $this->usu, $this->clave, $this->base); //$this->port);

        // Verificar si la conexión fue exitosa
        if (!$this->conexion) {
            die("Error al conectarse con MySQL: " . mysqli_connect_error());
        }

        // Configurar la conexión para usar el juego de caracteres UTF-8
        if (!mysqli_set_charset($this->conexion, "utf8")) {
            die("Error al configurar el juego de caracteres UTF-8: " . mysqli_error($this->conexion));
        }

        // Seleccionar la base de datos (aunque mysqli_connect ya lo hace)
>>>>>>> fe0185adf2ea3cf20ee59574a4732dbf97dbd98d
        $this->db = mysqli_select_db($this->conexion, $this->base);
        if ($this->db == 0) die("error conexión con la base de datos ");
        return $this->conexion;
    }
}