<?php
require_once('../config/conexion.php');

class Clase_Miembros_Grupo
{
    private $conexion;

    public function __construct()
    {
        $con = new Clase_Conectar();
        $this->conexion = $con->Procedimiento_Conectar();
    }

    public function todos()
    {
        $query = "SELECT mg.id_miembro, g.nombre_grupo, u.nombre, u.apellido, mg.fecha_union
                  FROM Miembros_Grupo mg
                  INNER JOIN Grupos g ON mg.id_grupo = g.id_grupo
                  INNER JOIN Usuarios u ON mg.id_usuario = u.id_usuario";
        $resultado = mysqli_query($this->conexion, $query);

        if (!$resultado) {
            throw new Exception("Error al listar miembros del grupo: " . mysqli_error($this->conexion));
        }

        return $resultado;
    }

    public function uno($id_miembro)
    {
        $query = "SELECT * FROM miembros_grupo WHERE id_miembro = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_miembro);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (!$resultado) {
            throw new Exception("Error al obtener miembro del grupo: " . mysqli_error($this->conexion));
        }

        return $resultado;
    }

    public function insertar($id_grupo, $id_usuario, $fecha_union)
    {
        $query = "INSERT INTO miembros_grupo (id_grupo, id_usuario, fecha_union) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "iis", $id_grupo, $id_usuario, $fecha_union);
        $resultado = mysqli_stmt_execute($stmt);

        if (!$resultado) {
            throw new Exception("Error al insertar miembro del grupo: " . mysqli_error($this->conexion));
        }

        return $resultado;
    }

    public function eliminar($id_miembro)
    {
        $query = "DELETE FROM miembros_grupo WHERE id_miembro = ?";
        $stmt = mysqli_prepare($this->conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_miembro);
        $resultado = mysqli_stmt_execute($stmt);

        if (!$resultado) {
            throw new Exception("Error al eliminar miembro del grupo: " . mysqli_error($this->conexion));
        }

        return $resultado;
    }

    public function obtenerGrupos()
    {
        $query = "SELECT id_grupo, CONCAT(nombre_grupo, descripcion) AS grupo FROM grupos";
        $result = mysqli_query($this->conexion, $query);

        if (!$result) {
            throw new Exception("Error al obtener grupos: " . mysqli_error($this->conexion));
        }

        $grupos = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        return $grupos;
    }
    public function obtenerUsuarios()
    {
        $query = "SELECT id_usuario, CONCAT(nombre, ' ', apellido) AS nombre_completo FROM Usuarios";
        $result = mysqli_query($this->conexion, $query);

        if (!$result) {
            throw new Exception("Error al obtener usuarios: " . mysqli_error($this->conexion));
        }

        $usuarios = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        return $usuarios;
    }
}
