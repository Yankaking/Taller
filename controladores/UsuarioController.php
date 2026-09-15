<?php
require_once __DIR__ . "/../modelos/Usuario.php";

class UsuarioController {
    private $usuario;

    public function __construct() {
        $this->usuario = new Usuario();
    }

    public function registrar($nombre, $email, $login, $password, $rol) {
        return $this->usuario->registrar($nombre, $email, $login, $password, $rol);
    }

    public function restablecerClave($email, $nuevaClave) {
        return $this->usuario->restablecerClave($email, $nuevaClave);
    }
}

/* --- Procesar acciones desde formularios --- */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $accion = $_POST["accion"] ?? "";
    $controller = new UsuarioController();

    if ($accion === "registrar") {
        $nombre   = $_POST["UsuNombre"];
        $email    = $_POST["UsuEmail"];
        $login    = $_POST["UsuLogin"];
        $password = password_hash($_POST["UsuPassword"], PASSWORD_DEFAULT);
        $rol      = $_POST["RollId"];

        if ($controller->registrar($nombre, $email, $login, $password, $rol)) {
            header("Location: /Taller/vistas/login/login.php");
            exit();
        } else {
            die("Error al registrar usuario");
        }
    }

    if ($accion === "restablecer") {
        $email = $_POST["UsuEmail"];
        $nuevaClave = password_hash($_POST["UsuPassword"], PASSWORD_DEFAULT);

        if ($controller->restablecerClave($email, $nuevaClave)) {
            header("Location: /Taller/vistas/login/login.php");
            exit();
        } else {
            die("Error al restablecer contraseña");
        }
    }
}
?>
