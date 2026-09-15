<?php
session_start();
require_once __DIR__ . "/../modelos/Usuario.php";

class LoginController
{
    private $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function iniciarSesion($usuario, $password)
    {
        $datosUsuario = $this->usuario->iniciarSesion($usuario, $password);

        if ($datosUsuario !== false) {
            session_regenerate_id(true);

            $_SESSION["usuario"]   = $datosUsuario["UsuLogin"];
            $_SESSION["rol"]       = $datosUsuario["RollId"];
            $_SESSION["tipoRol"]   = $datosUsuario["RollTipo"] ?? null;

            header("Location: /Taller/vistas/inicio/inicio.php");
            exit();
        } else {
            return "Usuario o contraseña incorrectos. Intente nuevamente.";
        }
    }
}
?>
