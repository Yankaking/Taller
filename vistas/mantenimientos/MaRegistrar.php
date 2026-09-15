<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: /Taller/vistas/login/login.php");
    exit();
}

require_once __DIR__ . "/../../controladores/VeController.php";
$vehiculoController = new VeController();
$vehiculos = $vehiculoController->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Mantenimiento</title>
    <link rel="stylesheet" href="/Taller/css/estilos.css">
    <script>
        function toggleSalida() {
            const estado = document.getElementById("MaEstado").value;
            const salidaDiv = document.getElementById("descripcionSalida");
            salidaDiv.style.display = (estado === "Entregado") ? "block" : "none";
        }
    </script>
</head>
<body>
    <?php include __DIR__ . "/../layout/header.php"; ?>
    <main class="contenedor-principal">
        <h2>Registrar Mantenimiento</h2>
        <form action="/Taller/controladores/MaController.php" method="POST" class="form-contenedor">
            <input type="hidden" name="accion" value="registrar">

            <div class="grupo-formulario">
                <label for="VePlaca">Vehículo</label>
                <select id="VePlaca" name="VePlaca" required>
                    <option value="">Seleccione un vehículo</option>
                    <?php while ($ve = $vehiculos->fetch_assoc()) { ?>
                        <option value="<?php echo $ve['VePlaca']; ?>">
                            <?php echo $ve['VePlaca'] . " - " . $ve['VeMarca']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="grupo-formulario">
                <label for="MaTipo">Tipo de mantenimiento</label>
                <select id="MaTipo" name="MaTipo" required>
                    <option value="Motor">Motor</option>
                    <option value="Frenos">Frenos</option>
                    <option value="Suspensión">Suspensión</option>
                    <option value="Dirección">Dirección</option>
                    <option value="Transmisión">Transmisión</option>
                    <option value="Refrigeración">Refrigeración</option>
                    <option value="Lubricación">Lubricación</option>
                    <option value="Kit de carretera">Kit de carretera</option>
                    <option value="Cambio de aceite">Cambio de aceite</option>
                </select>
            </div>

            <div class="grupo-formulario">
                <label for="MaDescripcionIncidencia">Descripción de incidencia</label>
                <textarea id="MaDescripcionIncidencia" name="MaDescripcionIncidencia"></textarea>
            </div>

            <div class="grupo-formulario">
                <label for="MaEstado">Estado</label>
                <select id="MaEstado" name="MaEstado" onchange="toggleSalida()" required>
                    <option value="En proceso">En proceso</option>
                    <option value="Entregado">Entregado</option>
                </select>
            </div>

            <div class="grupo-formulario" id="descripcionSalida" style="display:none;">
                <label for="MaDescripcionSalida">Descripción de salida</label>
                <textarea id="MaDescripcionSalida" name="MaDescripcionSalida"></textarea>
            </div>

            <div class="grupo-formulario">
                <label for="MaFecha">Fecha</label>
                <input type="date" id="MaFecha" name="MaFecha" required>
            </div>

            <button type="submit" class="boton">Registrar</button>
            <a href="/Taller/vistas/mantenimientos/MaListar.php" class="boton-cancelar">Cancelar</a>
        </form>
    </main>
</body>
</html>
