<?php

require_once('../models/miembros_grupos.model.php');

class ControladorMiembrosGrupos {
    private $modeloMiembrosGrupo;

    public function __construct() {
        $this->modeloMiembrosGrupo = new ModeloMiembrosGrupo();
    }

    public function obtenerAmigosComoMiembros($idUsuario) {
        return $this->modeloMiembrosGrupo->obtenerAmigosComoMiembros($idUsuario);
    }

    public function agregarMiembroAGrupo($idGrupo, $idUsuario) {
        return $this->modeloMiembrosGrupo->agregarMiembroAGrupo($idGrupo, $idUsuario);
    }

    // Puedes agregar más funciones aquí según sea necesario
}

?>
