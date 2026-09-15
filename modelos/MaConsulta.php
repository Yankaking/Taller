<?php
require_once __DIR__ . "../../config/conexion.php";

class MaConsulta {
    private $conexion;

    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->conectar();
    }

    public function consultarPorPlacaYRango($placa, $fechaInicio = null, $fechaFin = null) {
        $sql = "SELECT v.VePlaca, v.VeMarca, v.VeAño, v.VeKilometraje, v.VeCilindraje, v.VeEstado,
                       m.MaTipo, m.MaFecha, m.MaDescripcionIncidencia, m.MaEstado, 
                       m.MaDescripcionSalida, m.MaDescripcion
                FROM mantenimientos m
                INNER JOIN vehiculos v ON m.VePlaca = v.VePlaca
                WHERE v.VePlaca = ?";

        // Si se pasan fechas, agregamos el filtro
        if ($fechaInicio && $fechaFin) {
            $sql .= " AND m.MaFecha BETWEEN ? AND ?";
        }

        $sql .= " ORDER BY m.MaFecha DESC";

        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error en la consulta: " . $this->conexion->error);
        }

        if ($fechaInicio && $fechaFin) {
            $stmt->bind_param("sss", $placa, $fechaInicio, $fechaFin);
        } else {
            $stmt->bind_param("s", $placa);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado;
    }
}
?>
