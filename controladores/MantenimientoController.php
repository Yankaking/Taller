<?php
require_once __DIR__ . "/../config/conexion.php";

class MantenimientoController {
    private $conexion;

    public function __construct() {
        $db = new Conexion();
        $this->conexion = $db->conectar();
    }

    public function consultarHistorial($placa, $fechaInicio = null, $fechaFin = null) {
        $sql = "SELECT v.VePlaca, v.VeMarca, v.VeAño, v.VeKilometraje, v.VeCilindraje, v.VeEstado,
                       m.MaTipo, m.MaFecha, m.MaEstado, m.MaDescripcionIncidencia, m.MaDescripcionSalida, m.MaDescripcion,
                       c.CliNombre, c.CliApellido
                FROM vehiculos v
                INNER JOIN mantenimientos m ON v.VePlaca = m.VePlaca
                INNER JOIN clientes c ON v.CliId = c.CliId
                WHERE v.VePlaca = ?";

        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $sql .= " AND m.MaFecha BETWEEN ? AND ?";
        }

        // Ordenamos por fecha descendente
        $sql .= " ORDER BY m.MaFecha DESC";

        $stmt = $this->conexion->prepare($sql);

        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $stmt->bind_param("sss", $placa, $fechaInicio, $fechaFin);
        } else {
            $stmt->bind_param("s", $placa);
        }

        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
