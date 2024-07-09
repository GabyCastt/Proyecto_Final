<!DOCTYPE html>
<html lang='es'>

<head>
    <?php require_once('./html/head.php') ?>
    <link href='../public/lib/calendar/lib/main.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./amigos.js"></script> <!-- Archivo JavaScript para la funcionalidad de amigos -->
    <style>
        .custom-flatpickr {
            display: flex;
            align-items: center;
        }

        .custom-flatpickr input {
            margin-right: 5px;
            flex: 1;
        }
    </style>
</head>

<body>
    <div class='container-xxl position-relative bg-white d-flex p-0'>
        <!-- Spinner Start -->
        <div id='spinner' class='show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center'>
            <div class='spinner-border text-primary' style='width: 3rem; height: 3rem;' role='status'>
                <span class='sr-only'>Cargando...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <?php require_once('./html/menu.php') ?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class='content'>
            <!-- Navbar Start -->
            <?php require_once('./html/header.php') ?>
            <!-- Navbar End -->

            <!-- Amigos Start -->
            <div class='container-fluid pt-4 px-4'>
                <button type="button" class="btn btn-primary" onclick="abrirModal('insertar')">
                    Nuevo Amigo
                </button>
                <div class='d-flex align-items-center justify-content-between mb-4'>
                    <h6 class='mb-0'> Lista de amigos </h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpoamigos">
                            <!-- Aquí se cargarán dinámicamente los datos de los amigos -->
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Amigos End -->

            <!-- Footer Start -->
            <?php require_once('./html/footer.php') ?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href='#' class='btn btn-lg btn-primary btn-lg-square back-to-top'><i class='bi bi-arrow-up'></i></a>
    </div>

    <!-- Modales -->
    <div class="modal fade" id="modalAmigo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Amigo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="frm_amigos">
                    <div class="modal-body">
                        <input type="hidden" name="id_amigo" id="id_amigo">
                        <div class="form-group">
                            <label for="nombre_amigo">Nombre</label>
                            <input type="text" name="nombre_amigo" id="nombre_amigo" placeholder="Ingrese el nombre del amigo" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <?php require_once('./html/scripts.php') ?>
    <script>
        // Función para cargar la lista de amigos al cargar la página
        $(document).ready(function () {
            cargarListaAmigos(); // Llama a la función que carga la lista de amigos
        });
    </script>
</body>

</html>
