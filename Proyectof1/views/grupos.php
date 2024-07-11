<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Grupos</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Administrar Grupos</h1>
    
    <!-- Botón para abrir modal de agregar grupo -->
    <button type="button" class="btn btn-primary mb-3" onclick="abrirModalAgregar()">Nuevo Grupo</button>
    
    <!-- Tabla para listar grupos -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="listaGrupos">
            <!-- Aquí se cargarán dinámicamente los grupos -->
        </tbody>
    </table>
</div>

<!-- Modal para agregar y editar grupo -->
<div class="modal fade" id="modalGrupo" tabindex="-1" role="dialog" aria-labelledby="modalGrupoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGrupoLabel">Nuevo Grupo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para agregar o editar grupo -->
                <form id="formGrupo">
                    <input type="hidden" id="grupoId">
                    <div class="form-group">
                        <label for="nombre_grupo">Nombre del Grupo</label>
                        <input type="text" class="form-control" id="nombre_grupo" name="nombre_grupo" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarGrupo()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Archivo JavaScript personalizado -->
<script src="./grupos.js"></script>

</body>
</html>
