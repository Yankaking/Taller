<?php
require_once __DIR__ . "/../config/conexion.php";

class MaModelo {
    private $conexion;

    public function __construct() {
        $this->conexion = (new Conexion())->conectar();
    }

    public function listar() {
        return $this->conexion->query("SELECT * FROM mantenimientos");
    }

    public function registrar($data) {
        $stmt = $this->conexion->prepare("INSERT INTO mantenimientos (VePlaca, MaTipo, MaFecha, MaDescripcionIncidencia, MaEstado, MaDescripcionSalida) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $data['VePlaca'], $data['MaTipo'], $data['MaFecha'], $data['MaDescripcionIncidencia'], $data['MaEstado'], $data['MaDescripcionSalida']);
        return $stmt->execute();
    }

    public function eliminar($id) {
        $stmt = $this->conexion->prepare("DELETE FROM mantenimientos WHERE MaId = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function buscarPorId($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM mantenimientos WHERE MaId = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function editar($data) {
        $stmt = $this->conexion->prepare("UPDATE mantenimientos SET VePlaca=?, MaTipo=?, MaFecha=?, MaDescripcionIncidencia=?, MaEstado=?, MaDescripcionSalida=? WHERE MaId=?");
        $stmt->bind_param("ssssssi", $data['VePlaca'], $data['MaTipo'], $data['MaFecha'], $data['MaDescripcionIncidencia'], $data['MaEstado'], $data['MaDescripcionSalida'], $data['MaId']);
        return $stmt->execute();
    }
}
