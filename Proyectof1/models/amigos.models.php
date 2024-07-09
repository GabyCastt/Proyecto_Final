<?php
require_once('../config/conexion.php');

class Clase_Amigos{
     
    public function listarAmigos()
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT * FROM amigos";
        $todos = mysqli_query($con, $cadena);
        $con->close();
        return $todos;
    }
    public function uno ($id_amigo){
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "SELECT * FROM amigos WHERE id = $id_amigo";
        $uno = mysqli_query($con, $cadena);
        $con->close();
        return $uno;
    }
}