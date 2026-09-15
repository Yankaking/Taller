<?php
require_once __DIR__ . "/../../config/Conexion.php";
$conexion = (new Conexion())->conectar();

// Normalizamos fechas
$fechaInicio = isset($_POST["fechaInicio"]) ? date("Y-m-d", strtotime(str_replace("/", "-", $_POST["fechaInicio"]))) : date("Y-m-d", strtotime("-30 days"));
$fechaFin    = isset($_POST["fechaFin"]) ? date("Y-m-d", strtotime(str_replace("/", "-", $_POST["fechaFin"]))) : date("Y-m-d");

if ($fechaInicio === $fechaFin) {
    $sqlEnProceso = "SELECT COUNT(*) AS total FROM mantenimientos WHERE MaEstado = 'En proceso' AND MaFecha = ?";
    $stmt = $conexion->prepare($sqlEnProceso);
    $stmt->bind_param("s", $fechaInicio);
    $stmt->execute();
    $numEnProceso = $stmt->get_result()->fetch_assoc()["total"];

    $sqlEntregado = "SELECT COUNT(*) AS total FROM mantenimientos WHERE MaEstado = 'Entregado' AND MaFecha = ?";
    $stmt = $conexion->prepare($sqlEntregado);
    $stmt->bind_param("s", $fechaInicio);
    $stmt->execute();
    $numEntregado = $stmt->get_result()->fetch_assoc()["total"];
} else {
    $sqlEnProceso = "SELECT COUNT(*) AS total FROM mantenimientos WHERE MaEstado = 'En proceso' AND MaFecha BETWEEN ? AND ?";
    $stmt = $conexion->prepare($sqlEnProceso);
    $stmt->bind_param("ss", $fechaInicio, $fechaFin);
    $stmt->execute();
    $numEnProceso = $stmt->get_result()->fetch_assoc()["total"];

    $sqlEntregado = "SELECT COUNT(*) AS total FROM mantenimientos WHERE MaEstado = 'Entregado' AND MaFecha BETWEEN ? AND ?";
    $stmt = $conexion->prepare($sqlEntregado);
    $stmt->bind_param("ss", $fechaInicio, $fechaFin);
    $stmt->execute();
    $numEntregado = $stmt->get_result()->fetch_assoc()["total"];
}

echo json_encode([
    "enProceso" => $numEnProceso,
    "entregados" => $numEntregado
]);
