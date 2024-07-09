<?php
require_once '../models/amigos.model.php';

class Controlador_Amigos {
    private $modelo;

    public function __construct() {
        $this->modelo = new Modelo_Amigos();
    }

    public function getAmigos($id_usuario) {
        // Implementación del método GET para listar amigos de un usuario
        if ($id_usuario) {
            $resultados = $this->modelo->listarAmigos($id_usuario);
            echo json_encode($resultados);
        } else {
            http_response_code(400);
            echo json_encode(array("mensaje" => "Falta el parámetro ID de usuario"));
        }
    }

    public function agregarAmigo() {
        // Implementación del método POST para agregar un amigo
        $datos = json_decode(file_get_contents("php://input"));

        if (!empty($datos->id_usuario1) && !empty($datos->id_usuario2) && !empty($datos->fecha_amistad)) {
            $id_usuario1 = $datos->id_usuario1;
            $id_usuario2 = $datos->id_usuario2;
            $fecha_amistad = $datos->fecha_amistad;

            $resultado = $this->modelo->agregarAmigo($id_usuario1, $id_usuario2, $fecha_amistad);
            echo json_encode(array("success" => $resultado));
        } else {
            http_response_code(400);
            echo json_encode(array("mensaje" => "Datos incompletos para agregar amigo"));
        }
    }

    public function actualizarAmigo($id_amigo) {
        // Implementación del método PUT para actualizar amigo (no usado directamente para amigos en este caso)
        http_response_code(405);
        echo json_encode(array("mensaje" => "Método no permitido"));
    }

    public function eliminarAmigo($id_amigo) {
        // Implementación del método DELETE para eliminar un amigo
        if ($id_amigo) {
            $resultado = $this->modelo->eliminarAmigo($id_amigo);
            echo json_encode(array("success" => $resultado));
        } else {
            http_response_code(400);
            echo json_encode(array("mensaje" => "Falta el parámetro ID de amigo"));
        }
    }

    public function __destruct() {
        $this->modelo->cerrarConexion();
    }
}

// Enrutamiento de la solicitud HTTP
$controlador = new Controlador_Amigos();

// Obtener el método de solicitud HTTP (GET, POST, PUT, DELETE)
$metodo = $_SERVER['REQUEST_METHOD'];

// Según el método de solicitud, ejecutar la acción correspondiente
switch ($metodo) {
    case 'GET':
        if (isset($_GET['id_usuario'])) {
            $controlador->getAmigos($_GET['id_usuario']);
        } else {
            http_response_code(400);
            echo json_encode(array("mensaje" => "Falta el parámetro ID de usuario"));
        }
        break;
    case 'POST':
        $controlador->agregarAmigo();
        break;
    case 'PUT':
        parse_str(file_get_contents("php://input"), $_PUT);
        $id_amigo = $_PUT['id_amigo'] ?? null;
        $controlador->actualizarAmigo($id_amigo);
        break;
    case 'DELETE':
        parse_str(file_get_contents("php://input"), $_DELETE);
        $id_amigo = $_DELETE['id_amigo'] ?? null;
        $controlador->eliminarAmigo($id_amigo);
        break;
    default:
        http_response_code(405);
        echo json_encode(array("mensaje" => "Método no permitido"));
        break;
}
?>
