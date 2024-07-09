<?php
require_once('../config/conexion.php');

class Clase_Miembros_Grupo
{
    public function todos()
    {
        $con = new Clase_Conectar();
        $conexion = $con->Procedimiento_Conectar();
        $query = "SELECT * FROM miembros_grupo";
        $resultado = mysqli_query($conexion, $query);

        if (!$resultado) {
            throw new Exception("Error al listar miembros del grupo: " . mysqli_error($conexion));
        }

        return $resultado;
    }

    public function uno($id_miembro)
    {
        $con = new Clase_Conectar();
        $conexion = $con->Procedimiento_Conectar();
        $query = "SELECT * FROM miembros_grupo WHERE id_miembro = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_miembro);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (!$resultado) {
            throw new Exception("Error al obtener miembro del grupo: " . mysqli_error($conexion));
        }

        return $resultado;
    }

    public function insertar($id_grupo, $id_usuario, $fecha_union)
    {
        $con = new Clase_Conectar();
        $conexion = $con->Procedimiento_Conectar();
        $query = "INSERT INTO miembros_grupo (id_grupo, id_usuario, fecha_union) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "iis", $id_grupo, $id_usuario, $fecha_union);
        $resultado = mysqli_stmt_execute($stmt);

        if (!$resultado) {
            throw new Exception("Error al insertar miembro del grupo: " . mysqli_error($conexion));
        }

        return $resultado;
    }

    public function eliminar($id_miembro)
    {
        $con = new Clase_Conectar();
        $conexion = $con->Procedimiento_Conectar();
        $query = "DELETE FROM miembros_grupo WHERE id_miembro = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_miembro);
        $resultado = mysqli_stmt_execute($stmt);

        if (!$resultado) {
            throw new Exception("Error al eliminar miembro del grupo: " . mysqli_error($conexion));
        }

        return $resultado;
    }
}
?>
