<?php
class PublicacionesModel {
    private $conn;

    public function __construct($conexion) {
        $this->conn = $conexion;
    }

    public function crearPublicacion($idUsuario, $titulo, $contenido) {
        $sql = "INSERT INTO Publicaciones (id_usuario, titulo, contenido, fecha_publicacion) VALUES (?, ?, ?, NOW())";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $idUsuario, $titulo, $contenido);
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultado;
    }

    public function obtenerPublicacion($idPublicacion) {
        $sql = "SELECT * FROM Publicaciones WHERE id_publicacion = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idPublicacion);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $publicacion = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);
        return $publicacion;
    }

    public function editarPublicacion($idPublicacion, $titulo, $contenido) {
        $sql = "UPDATE Publicaciones SET titulo = ?, contenido = ? WHERE id_publicacion = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $titulo, $contenido, $idPublicacion);
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultado;
    }

    public function eliminarPublicacion($idPublicacion) {
        $sql = "DELETE FROM Publicaciones WHERE id_publicacion = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $idPublicacion);
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultado;
    }

    public function listarPublicaciones() {
        $sql = "SELECT * FROM Publicaciones ORDER BY fecha_publicacion DESC";
        $result = mysqli_query($this->conn, $sql);
        if (!$result) {
            throw new Exception("Error en la consulta: " . mysqli_error($this->conn));
        }
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
?>