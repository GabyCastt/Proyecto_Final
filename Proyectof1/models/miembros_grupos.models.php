<?php
require_once('../config/conexion.php');

class Clase_Miembros_Grupos
{
    public function todos()
    {
        $con = new Clase_Conectar();
        $conexion = $con->Procedimiento_Conectar();
        $query = "SELECT * FROM miembros_grupo";
        $resultado = mysqli_query($conexion, $query);
        
        if (!$resultado) {
            $con->cerrarConexion();
            throw new Exception("Error al listar miembros: " . mysqli_error($conexion));
        }

        $con->cerrarConexion();
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
            $con->cerrarConexion();
            throw new Exception("Error al obtener miembro: " . mysqli_error($conexion));
        }

        $con->cerrarConexion();
        return $resultado;
    }

    public function insertar($id_grupo, $id_usuario, $fecha_union)
    {
        $con = new Clase_Conectar();
        $conexion = $con->Procedimiento_Conectar();
        $query = "INSERT INTO miembros_grupo (id_miembro, id_grupo, id_usuario, fecha_union) VALUES (NULL, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "iis", $id_grupo, $id_usuario, $fecha_union);
        $resultado = mysqli_stmt_execute($stmt);
        
        if (!$resultado) {
            $con->cerrarConexion();
            throw new Exception("Error al insertar miembro: " . mysqli_error($conexion));
        }

        $con->cerrarConexion();
        return $resultado;
    }

    public function actualizar($id_miembro, $id_grupo, $id_usuario, $fecha_union)
    {
        $con = new Clase_Conectar();
        $conexion = $con->Procedimiento_Conectar();
        $query = "UPDATE miembros_grupo SET id_grupo = ?, id_usuario = ?, fecha_union = ? WHERE id_miembro = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "iisi", $id_grupo, $id_usuario, $fecha_union, $id_miembro);
        $resultado = mysqli_stmt_execute($stmt);
        
        if (!$resultado) {
            $con->cerrarConexion();
            throw new Exception("Error al actualizar miembro: " . mysqli_error($conexion));
        }

        $con->cerrarConexion();
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
            $con->cerrarConexion();
            throw new Exception("Error al eliminar miembro: " . mysqli_error($conexion));
        }

        $con->cerrarConexion();
        return $resultado;
    }
}
?>
