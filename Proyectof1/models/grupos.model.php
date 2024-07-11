<?php
require_once('../config/conexion.php');
class Clase_Grupos
{
    public function todos()
    {
        $con = new Clase_Conectar();
        $conexion = $con->Procedimiento_Conectar();
        $query = "SELECT * FROM grupos";
        $resultado = mysqli_query($conexion, $query);
        if (!$resultado) {
            throw new Exception("Error al listar grupos: " . mysqli_error($conexion));
        }
        return $resultado;
    }
    public function uno($id_grupo)
    {
        $con = new Clase_Conectar();
        $conexion = $con->Procedimiento_Conectar();
        $query = "SELECT * FROM grupos WHERE id_grupo = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_grupo);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        if (!$resultado) {
            throw new Exception("Error al obtener grupo: " . mysqli_error($conexion));
        }
        return $resultado;
    }
    public function insertar($nombre_grupo, $descripcion)
    {
        $con = new Clase_Conectar();
        $conexion = $con->Procedimiento_Conectar();
        $query = "INSERT INTO `grupos`(`nombre_grupo`, `descripcion`) VALUES (?, ?)";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "ss", $nombre_grupo, $descripcion);
        $resultado = mysqli_stmt_execute($stmt);
        if (!$resultado) {
            throw new Exception("Error al insertar grupo: " . mysqli_error($conexion));
        }
        return $resultado;
    }
    public function actualizar($id_grupo, $nombre_grupo, $descripcion)
    {
        $con = new Clase_Conectar();
        $conexion = $con->Procedimiento_Conectar();
        $query = "UPDATE grupos SET nombre_grupo = ?, descripcion = ? WHERE id_grupo = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $nombre_grupo, $descripcion, $id_grupo);
        $resultado = mysqli_stmt_execute($stmt);
        if (!$resultado) {
            throw new Exception("Error al actualizar grupo: " . mysqli_error($conexion));
        }
        return $resultado;
    }
    public function eliminar($id_grupo)
    {
        $con = new Clase_Conectar();
        $conexion = $con->Procedimiento_Conectar();
        $query = "DELETE FROM grupos WHERE id_grupo = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_grupo);
        $resultado = mysqli_stmt_execute($stmt);
        if (!$resultado) {
            throw new Exception("Error al eliminar grupo: " . mysqli_error($conexion));
        }
        return $resultado;
    }
    public function obtenerNombresGrupos()
    {
        $con = new Clase_Conectar();
        $conexion = $con->Procedimiento_Conectar();
        $query = "SELECT id_grupo, nombre_grupo, descripcion FROM grupos";
        $resultado = mysqli_query($conexion, $query);

        if (!$resultado) {
            throw new Exception("Error al obtener nombres de grupos: " . mysqli_error($conexion));
        }

        return $resultado;
    }
}
?>
