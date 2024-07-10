<?php
require_once('../config/conexion.php');
class Grupos_Model
{
    private $conn;
    public function __construct()
    {
        $conectar = new Clase_Conectar();
        $this->conn = $conectar->Procedimiento_Conectar();
    }
    public function Listar_Grupos()
    {
        $sql = "SELECT nombre_grupo FROM Grupos";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $grupos = [];
        while ($row = $result->fetch_assoc()) {
            $grupos[] = $row['nombre_grupo'];
        }
        return $grupos;
    }
    public function Insertar_Grupo($nombre_grupo, $descripcion)
    {
        $sql = "INSERT INTO Grupos (nombre_grupo, descripcion) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $nombre_grupo, $descripcion);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function Editar_Grupo($id_grupo, $nombre_grupo, $descripcion)
    {
        $sql = "UPDATE Grupos SET nombre_grupo = ?, descripcion = ? WHERE id_grupo = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $nombre_grupo, $descripcion, $id_grupo);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function Eliminar_Grupo($id_grupo)
    {
        $sql = "DELETE FROM Grupos WHERE id_grupo = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_grupo);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
