<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Grupos y Miembros</title>
</head>
<body>
    <h1>Gestión de Grupos y Miembros</h1>

    <h2>Crear Nuevo Grupo</h2>
    <input type="text" id="nombreGrupo" placeholder="Nombre del Grupo">
    <textarea id="descripcionGrupo" placeholder="Descripción del Grupo"></textarea>
    <button id="btnCrearGrupo">Crear Grupo</button>

    <h2>Grupos Existentes</h2>
    <ul id="listaGrupos">
        <!-- Los grupos se cargarán dinámicamente aquí -->
    </ul>

    <h2>Agregar Miembro a Grupo</h2>
    <select id="selectGrupo">
        <!-- Los grupos se cargarán dinámicamente aquí -->
    </select>
    <select id="selectAmigos">
        <!-- Los amigos se cargarán dinámicamente aquí -->
    </select>
    <button id="btnAgregarMiembro">Agregar al Grupo</button>

    <h2>Miembros del Grupo</h2>
    <ul id="listaMiembros">
        <!-- Los miembros se cargarán dinámicamente aquí -->
    </ul>

    <script src="grupos_miembros.js"></script>
</body>
</html>