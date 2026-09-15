<?php
require_once __DIR__ . "/../modelos/CliModelo.php";

class ClienteController
{
    private $cliente;

    public function __construct()
    {
        $this->cliente = new Cliente();
    }

    public function listar()
    {
        return $this->cliente->listar();
    }

    public function registrar($id, $nombre, $apellido, $direccion, $email, $fecha)
    {
        return $this->cliente->registrar($id, $nombre, $apellido, $direccion, $email, $fecha);
    }

    public function buscarPorId($id)
    {
        return $this->cliente->buscarPorId($id);
    }

    public function editar($id, $nombre, $apellido, $direccion, $email, $fecha)
    {
        return $this->cliente->editar($id, $nombre, $apellido, $direccion, $email, $fecha);
    }

    public function eliminar($id)
    {
        return $this->cliente->eliminar($id);
    }
}

/* --- Procesar acciones desde formularios --- */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $accion = $_POST["accion"] ?? "";
    $controller = new ClienteController();

    if ($accion === "registrar") {
        $id        = $_POST["CliId"];
        $nombre    = $_POST["CliNombre"];
        $apellido  = $_POST["CliApellido"];
        $direccion = $_POST["CliDireccion"];
        $email     = $_POST["CliEmail"];
        $fecha     = $_POST["CliFecha"];

        $resultado = $controller->registrar($id, $nombre, $apellido, $direccion, $email, $fecha);

        if ($resultado === true) {
            header("Location: http://localhost/Taller/vistas/clientes/listar.php");
            exit();
        } else {
            die($resultado);
        }
    }

    if ($accion === "editar") {
        $id        = $_POST["CliId"];
        $nombre    = $_POST["CliNombre"];
        $apellido  = $_POST["CliApellido"];
        $direccion = $_POST["CliDireccion"];
        $email     = $_POST["CliEmail"];
        $fecha     = $_POST["CliFecha"];

        if ($controller->editar($id, $nombre, $apellido, $direccion, $email, $fecha)) {
            header("Location: http://localhost/Taller/vistas/clientes/listar.php");
            exit();
        } else {
            die("Error al editar cliente");
        }
    }

    if ($accion === "eliminar") {
        $id = $_POST["CliId"];
        if ($controller->eliminar($id)) {
            header("Location: http://localhost/Taller/vistas/clientes/listar.php");
            exit();
        } else {
            die("Error al eliminar cliente");
        }
    }
}
