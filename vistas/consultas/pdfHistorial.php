<?php
require_once __DIR__ . "/../../controladores/MantenimientoController.php";
require_once __DIR__ . "/../../librerias/fpdf/fpdf.php";

$controller = new MantenimientoController();

if (isset($_GET['placa'])) {
    $placa = $_GET['placa'];
    $fechaInicio = $_GET['fechaInicio'] ?? null;
    $fechaFin = $_GET['fechaFin'] ?? null;
    $verTodo = $_GET['todo'] ?? null;

    if ($verTodo === "1") {
        $fechaInicio = null;
        $fechaFin = null;
    } elseif (empty($fechaInicio) || empty($fechaFin)) {
        echo "Debes seleccionar un rango de fechas o usar la opción de historial completo.";
        exit();
    }

    $historial = $controller->consultarHistorial($placa, $fechaInicio, $fechaFin);

    if ($historial->num_rows > 0) {
        $primerRegistro = $historial->fetch_assoc();
        $clienteNombre = $primerRegistro['CliNombre'] ?? "Cliente no registrado";
        $clienteApellido = $primerRegistro['CliApellido'] ?? "";
        $historial->data_seek(0);

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="historial_'.$placa.'.pdf"');

        $pdf = new FPDF('P','mm','Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',14);

        // Título
        $titulo = "Historial de Mantenimientos - Placa: $placa | Cliente: $clienteNombre $clienteApellido";
        if ($verTodo === "1") {
            $titulo .= " (Todo el historial)";
        } elseif (!empty($fechaInicio) && !empty($fechaFin)) {
            $titulo .= " (del $fechaInicio al $fechaFin)";
        }

        $pdf->MultiCell(0,10,utf8_decode($titulo),0,'C');
        $pdf->Ln(10);

        // Encabezados (todos con utf8_decode)
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(20,8,utf8_decode("Placa"),1);
        $pdf->Cell(25,8,utf8_decode("Marca"),1);
        $pdf->Cell(15,8,utf8_decode("Año"),1); // ñ corregida
        $pdf->Cell(20,8,utf8_decode("Km"),1);
        $pdf->Cell(20,8,utf8_decode("Cilindraje"),1);
        $pdf->Cell(25,8,utf8_decode("Tipo"),1);
        $pdf->Cell(25,8,utf8_decode("Fecha"),1);
        $pdf->Cell(25,8,utf8_decode("Estado Mant."),1);
        $pdf->Ln();

        // Datos
        $pdf->SetFont('Arial','',8);

        $registros = [];
        while ($fila = $historial->fetch_assoc()) {
            $registros[] = $fila;
        }

        usort($registros, function($a, $b) {
            return strcmp($b['MaFecha'], $a['MaFecha']);
        });

        foreach ($registros as $fila) {
            $pdf->Cell(20,8,utf8_decode($fila['VePlaca']),1);
            $pdf->Cell(25,8,utf8_decode($fila['VeMarca']),1);
            $pdf->Cell(15,8,utf8_decode($fila['VeAño']),1); // ñ en datos
            $pdf->Cell(20,8,utf8_decode($fila['VeKilometraje']),1);
            $pdf->Cell(20,8,utf8_decode($fila['VeCilindraje']),1);
            $pdf->Cell(25,8,utf8_decode($fila['MaTipo']),1);
            $pdf->Cell(25,8,utf8_decode($fila['MaFecha']),1);
            $pdf->Cell(25,8,utf8_decode($fila['MaEstado']),1);
            $pdf->Ln();

            // Descripciones
            if (!empty($fila['MaDescripcionIncidencia'])) {
                $pdf->MultiCell(0,8,utf8_decode("Descripción inicial: ".$fila['MaDescripcionIncidencia']),1);
            }
            if (!empty($fila['MaDescripcionSalida'])) {
                $pdf->MultiCell(0,8,utf8_decode("Descripción entregado: ".$fila['MaDescripcionSalida']),1);
            }
            if (!empty($fila['MaDescripcion'])) {
                $pdf->MultiCell(0,8,utf8_decode("Observaciones: ".$fila['MaDescripcion']),1);
            }

            $pdf->Ln(5);
        }

        $pdf->Output('I');
    } else {
        echo "No se encontraron mantenimientos para la placa ingresada.";
    }
}
?>
