<?php
require_once __DIR__ . "/../modelos/MaModelo.php";

class MaController {
    private $modelo;

    public function __construct() {
        $this->modelo = new MaModelo();
    }

    public function listar() {
        return $this->modelo->listar();
    }

    public function registrar($data) {
        return $this->modelo->registrar($data);
    }

    public function eliminar($id) {
        return $this->modelo->eliminar($id);
    }

    public function buscarPorId($id) {
        return $this->modelo->buscarPorId($id);
    }

    public function editar($data) {
        return $this->modelo->editar($data);
    }
}

// Manejo de acciones desde formularios
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $accion = $_POST["accion"] ?? null;
    $controller = new MaController();

    if ($accion === "registrar") {
        $controller->registrar($_POST);
        header("Location: /Taller/vistas/mantenimientos/MaListar.php");
    } elseif ($accion === "editar") {
        $controller->editar($_POST);
        header("Location: /Taller/vistas/mantenimientos/MaListar.php");
    } elseif ($accion === "eliminar") {
        $controller->eliminar($_POST["MaId"]);
        header("Location: /Taller/vistas/mantenimientos/MaListar.php");
    }
}
