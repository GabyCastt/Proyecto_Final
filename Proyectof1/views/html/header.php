<nav class="navbar navbar-expand bg-dark navbar-light sticky-top px-4 py-0">
    <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>
    <form class="d-none d-md-flex ms-4">
        <input class="form-control border-0" type="search" placeholder="Search">
    </form>
    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-envelope me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">Comentarios</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <a href="#" class="dropdown-item">
                    <div class="d-flex align-items-center">
                        <img class="rounded-circle" src="../../public/img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="ms-2">
                            <h6 class="fw-normal mb-0">MENSAJE EJEMPLO</h6>
                            <small>15 minutes ago</small>
                        </div>
                    </div>
                </a>
                </a>
                <hr class="dropdown-divider">
                <a href="./comentario.php" class="dropdown-item text-center">Todas los comentarios</a>
            </div>
        </div>
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-bell me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">Publicaciones</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                </a>
                <hr class="dropdown-divider">
                <a href="./publicaciones.php" class="dropdown-item text-center">Todas las publicaciones</a>
            </div>
        </div>
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                <span class="d-none d-lg-inline-flex"></span>
                <small class="text-muted"></small>

            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">

                <a href="./html/salir.php" class="dropdown-item">Log Out</a>
            </div>
        </div>
    </div>
</nav>