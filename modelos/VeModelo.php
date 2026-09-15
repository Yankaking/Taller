<?php
require_once __DIR__ . "/../config/conexion.php";

class Vehiculo {
    private $conexion;

    public function __construct() {
        $conexion = new Conexion();
        $this->conexion = $conexion->conectar();
    }

    public function listar() {
        $sql = "SELECT v.*, c.CliNombre, c.CliApellido 
                FROM vehiculos v 
                INNER JOIN clientes c ON v.CliId = c.CliId
                ORDER BY v.VePlaca ASC";
        return $this->conexion->query($sql);
    }

    public function registrar($placa, $cliId, $marca, $anio, $kilometraje, $cilindraje, $estado) {
        $sql = "INSERT INTO vehiculos (VePlaca, CliId, VeMarca, VeAño, VeKilometraje, VeCilindraje, VeEstado)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssssiss", $placa, $cliId, $marca, $anio, $kilometraje, $cilindraje, $estado);
        return $stmt->execute();
    }

    public function buscarPorPlaca($placa) {
        $sql = "SELECT * FROM vehiculos WHERE VePlaca = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $placa);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function editar($placa, $cliId, $marca, $anio, $kilometraje, $cilindraje, $estado) {
        $sql = "UPDATE vehiculos 
                SET CliId=?, VeMarca=?, VeAño=?, VeKilometraje=?, VeCilindraje=?, VeEstado=? 
                WHERE VePlaca=?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssissss", $cliId, $marca, $anio, $kilometraje, $cilindraje, $estado, $placa);
        return $stmt->execute();
    }

    public function eliminar($placa) {
        $sql = "DELETE FROM vehiculos WHERE VePlaca = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $placa);
        return $stmt->execute();
    }
}
?>
