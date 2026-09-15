<?php
require_once __DIR__ . "/../../controladores/MantenimientoController.php";
$controller = new MantenimientoController();

if (isset($_GET['placa'])) {
    $placa = $_GET['placa'];
    $fechaInicio = $_GET['fechaInicio'] ?? null;
    $fechaFin = $_GET['fechaFin'] ?? null;

    $historial = $controller->consultarHistorial($placa, $fechaInicio, $fechaFin);

    if ($historial->num_rows > 0) {
        $primerRegistro = $historial->fetch_assoc();
        $clienteNombre = $primerRegistro['CliNombre'] ?? "Cliente no registrado";
        $clienteApellido = $primerRegistro['CliApellido'] ?? "";
        $historial->data_seek(0);

        echo "<h3>Historial de mantenimientos para placa: $placa</h3>";
        echo "<p><strong>Cliente:</strong> $clienteNombre $clienteApellido</p>";

        echo "<table class='tabla'>
                <tr>
                    <th>Placa</th>
                    <th>Marca</th>
                    <th>Año</th>
                    <th>Kilometraje</th>
                    <th>Cilindraje</th>
                    <th>Estado Vehículo</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Estado Mantenimiento</th>
                </tr>";
        while ($fila = $historial->fetch_assoc()) {
            echo "<tr>
                    <td>{$fila['VePlaca']}</td>
                    <td>{$fila['VeMarca']}</td>
                    <td>{$fila['VeAño']}</td>
                    <td>{$fila['VeKilometraje']}</td>
                    <td>{$fila['VeCilindraje']}</td>
                    <td>{$fila['VeEstado']}</td>
                    <td>{$fila['MaTipo']}</td>
                    <td>{$fila['MaFecha']}</td>
                    <td>{$fila['MaEstado']}</td>
                  </tr>";

            // Agrupamos todas las descripciones en un solo bloque debajo de la fila
            $descripcion = "";
            if (!empty($fila['MaDescripcionIncidencia'])) {
                $descripcion .= "<p><strong>Inicial:</strong> {$fila['MaDescripcionIncidencia']}</p>";
            }
            if (!empty($fila['MaDescripcionSalida'])) {
                $descripcion .= "<p><strong>Entregado:</strong> {$fila['MaDescripcionSalida']}</p>";
            }
            if (!empty($fila['MaDescripcion'])) {
                $descripcion .= "<p><strong>Observaciones:</strong> {$fila['MaDescripcion']}</p>";
            }

            if (!empty($descripcion)) {
                echo "<tr><td colspan='9'>$descripcion</td></tr>";
            }
        }
        echo "</table>";

        echo "<div class='acciones-pdf'>";
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            echo "<a href='pdfHistorial.php?placa=$placa&fechaInicio=$fechaInicio&fechaFin=$fechaFin' target='_blank' class='boton'>Generar PDF filtrado</a>";
        }
        echo "<a href='pdfHistorial.php?placa=$placa&todo=1' target='_blank' class='boton'>Ver historial completo en PDF</a>";
        echo "</div>";
    } else {
        echo "<p>No se encontraron mantenimientos para la placa ingresada.</p>";
    }
} else {
    echo "<p>Primero selecciona una placa para consultar.</p>";
}
?>
