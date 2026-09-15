<?php

require_once "./config/conexion.php";

$conexion = new Conexion();

$conexion->conectar();

echo "Conexión exitosa con la base de datos";

?>