<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Grupos y Miembros</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Mis Grupos y Miembros</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Grupo</th>
                    <th>Miembros</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select id="selectGrupos" class="form-control">
                            <!-- Options cargados dinámicamente por JavaScript -->
                        </select>
                    </td>
                    <td>
                        <table class="table">
                            <tbody id="listaMiembros">
                                <!-- Miembros del grupo cargados dinámicamente por JavaScript -->
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <button id="btnAgregarMiembro" class="btn btn-primary">Agregar Miembro</button>
    </div>

    <!-- Modal para agregar miembro a un grupo -->
    <div class="modal fade" id="modalAgregarMiembro" tabindex="-1" role="dialog" aria-labelledby="modalAgregarMiembroLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarMiembroLabel">Agregar Miembro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarMiembro">
                        <div class="form-group">
                            <label for="selectAmigos">Amigos</label>
                            <select id="selectAmigos" class="form-control">
                                <!-- Options cargados dinámicamente por JavaScript -->
                            </select>
                        </div>
                        <input type="hidden" id="idGrupoSeleccionado">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="btnGuardarMiembro" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="miembros_grupo.js"></script>
</body>
</html>
