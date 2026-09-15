<?php
require_once __DIR__ . "/../config/Conexion.php";

class Usuario
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->conectar();
    }

    public function iniciarSesion($usuario, $password)
    {
        $sql = "SELECT * FROM usuario WHERE UsuLogin = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();

            if (password_verify($password, $fila["UsuPassword"])) {
                return $fila;
            }
            if ($password === $fila["UsuPassword"]) { // solo para pruebas
                return $fila;
            }
        }
        return false;
    }

    public function registrar($nombre, $email, $login, $password, $rol)
    {
        $sql = "INSERT INTO usuario (UsuNombre, UsuEmail, UsuLogin, UsuPassword, RollId) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssss", $nombre, $email, $login, $password, $rol);
        return $stmt->execute();
    }

    public function restablecerClave($email, $nuevaClave)
    {
        $sql = "UPDATE usuario SET UsuPassword=? WHERE UsuEmail=?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ss", $nuevaClave, $email);
        return $stmt->execute();
    }

    public function existeCorreo($email) {
    $sql = "SELECT * FROM usuario WHERE UsuEmail = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado->num_rows > 0;
}
}
?>
