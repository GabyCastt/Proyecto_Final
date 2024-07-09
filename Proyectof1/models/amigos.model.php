<?php
require_once('../config/conexion.php'); // Asegúrate de incluir tu archivo de conexión

class Clase_Amigos
{

    public function listarTodos()
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $query = "SELECT * FROM amigos";
        $result = mysqli_query($con, $query);
        $con->close();
        return $result;
    }

    public function buscarPorId($id_amigo)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $query = "SELECT * FROM amigos WHERE id_amigo = $id_amigo";
        $result = mysqli_query($con, $query);
        $con->close();
        return $result;
    }

    public function agregarAmigo($id_usuario1, $id_usuario2)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $fecha_amistad = date('Y-m-d H:i:s');
        $query = "INSERT INTO amigos (id_usuario1, id_usuario2, fecha_amistad) VALUES ($id_usuario1, $id_usuario2, '$fecha_amistad')";
        $result = mysqli_query($con, $query);
        $con->close();
        return $result;
    }

    public function eliminarAmigo($id_amigo)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $query = "DELETE FROM amigos WHERE id_amigo = $id_amigo";
        $result = mysqli_query($con, $query);
        $con->close();
        return $result;
    }
    public function actualizarAmigo($id_amigo, $id_usuario1, $id_usuario2)
    {
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();

        // Construir la consulta SQL para actualizar el amigo
        $query = "UPDATE amigos SET id_usuario1 = $id_usuario1, id_usuario2 = $id_usuario2 WHERE id_amigo = $id_amigo";

        // Ejecutar la consulta
        $result = mysqli_query($con, $query);

        // Cerrar la conexión
        $con->close();

        // Retornar el resultado de la consulta (true/false)
        return $result;
    }
}
