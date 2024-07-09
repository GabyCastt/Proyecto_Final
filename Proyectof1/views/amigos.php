<?php
// Aquí puedes incluir tu estructura HTML y usar PHP para integrar datos dinámicos
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Amigos</title>
    <!-- Incluir estilos CSS si es necesario -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Mis Amigos</h1>

        <!-- Formulario para agregar amigo -->
        <form id="formAgregarAmigo">
            <label for="idUsuario2">ID del amigo:</label>
            <input type="text" id="idUsuario2" name="idUsuario2" required>
            <button type="submit">Agregar Amigo</button>
        </form>

        <!-- Lista de amigos -->
        <div id="listaAmigos">
            <!-- Aquí se mostrarán los amigos dinámicamente -->
        </div>
    </div>

    <!-- Incluir jQuery y archivo JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./amigos.js"></script>
</body>
</html>
