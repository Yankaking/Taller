<?php

class Conexion
{
    private $servidor = "localhost";
    private $usuario = "root";
    private $password = "";
    private $baseDatos = "taller";

    public function conectar()
    {
        $conexion = new mysqli(
            $this->servidor,
            $this->usuario,
            $this->password,
            $this->baseDatos
        );

        if ($conexion->connect_errno) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $conexion->set_charset("utf8");

        return $conexion;
    }
}
?>
