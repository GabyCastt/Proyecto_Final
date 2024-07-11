<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Miembros de Grupo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Gestión de Miembros de Grupo</h1>

        <!-- Select para elegir grupo -->
        <div class="form-group">
            <label for="selectGrupos">Seleccionar Grupo:</label>
            <select id="selectGrupos" class="form-control"></select>
        </div>

        <!-- Tabla para listar miembros -->
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="listaMiembros"></tbody>
        </table>

        <!-- Botón para abrir modal de agregar miembro -->
        <button id="btnAgregarMiembro" class="btn btn-primary">Agregar Miembro</button>

        <!-- Modal para agregar miembro -->
        <div class="modal fade" id="modalAgregarMiembro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Miembro al Grupo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="selectGruposModal">Seleccionar Grupo:</label>
                            <select id="selectGruposModal" class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label for="selectAmigos">Seleccionar Amigo:</label>
                            <select id="selectAmigos" class="form-control"></select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" id="btnGuardarMiembro" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./miembros_grupo.js"></script>
    <script src="./grupos.js"></script>
    <script src="./amigos.js"></script>
</body>

</html>