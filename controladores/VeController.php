<?php
require_once __DIR__ . "/../modelos/VeModelo.php";

class VeController {
    private $vehiculo;

    public function __construct() {
        $this->vehiculo = new Vehiculo();
    }

    public function listar() {
        return $this->vehiculo->listar();
    }

    public function registrar($placa, $cliId, $marca, $anio, $kilometraje, $cilindraje, $estado) {
        return $this->vehiculo->registrar($placa, $cliId, $marca, $anio, $kilometraje, $cilindraje, $estado);
    }

    public function buscarPorPlaca($placa) {
        return $this->vehiculo->buscarPorPlaca($placa);
    }

    public function editar($placa, $cliId, $marca, $anio, $kilometraje, $cilindraje, $estado) {
        return $this->vehiculo->editar($placa, $cliId, $marca, $anio, $kilometraje, $cilindraje, $estado);
    }

    public function eliminar($placa) {
        return $this->vehiculo->eliminar($placa);
    }
}

/* --- Procesar acciones desde formularios --- */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $accion = $_POST["accion"] ?? "";
    $controller = new VeController();

    if ($accion === "registrar") {
        $placa       = $_POST["VePlaca"];
        $cliId       = $_POST["CliId"];
        $marca       = $_POST["VeMarca"];
        $anio        = $_POST["VeAño"];
        $kilometraje = $_POST["VeKilometraje"];   // ✅ Nuevo campo
        $cilindraje  = $_POST["VeCilindraje"];
        $estado      = $_POST["VeEstado"];

        if ($controller->registrar($placa, $cliId, $marca, $anio, $kilometraje, $cilindraje, $estado)) {
            header("Location: http://localhost/Taller/vistas/vehiculos/VeListar.php");
            exit();
        } else {
            die("Error al registrar vehículo");
        }
    }

    if ($accion === "editar") {
        $placa       = $_POST["VePlaca"];
        $cliId       = $_POST["CliId"];
        $marca       = $_POST["VeMarca"];
        $anio        = $_POST["VeAño"];
        $kilometraje = $_POST["VeKilometraje"];   // ✅ Nuevo campo
        $cilindraje  = $_POST["VeCilindraje"];
        $estado      = $_POST["VeEstado"];

        if ($controller->editar($placa, $cliId, $marca, $anio, $kilometraje, $cilindraje, $estado)) {
            header("Location: http://localhost/Taller/vistas/vehiculos/VeListar.php");
            exit();
        } else {
            die("Error al editar vehículo");
        }
    }

    if ($accion === "eliminar") {
        $placa = $_POST["VePlaca"];
        if ($controller->eliminar($placa)) {
            header("Location: http://localhost/Taller/vistas/vehiculos/VeListar.php");
            exit();
        } else {
            die("Error al eliminar vehículo");
        }
    }
}
