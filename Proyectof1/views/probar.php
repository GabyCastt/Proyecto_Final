<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit;
}
$idUsuario = $_SESSION['id_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Amigos</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="amigos.js"></script>
</head>
<body>
    <h1>Mis Amigos</h1>
    <div id="listaAmigos"></div>
    
    <h2>Agregar Amigo</h2>
    <input type="text" id="nuevoAmigo" placeholder="ID del nuevo amigo">
    <button onclick="agregarAmigo()">Agregar</button>

    <script>
        var idUsuario = <?php echo $idUsuario; ?>;
    </script>
</body>
</html>