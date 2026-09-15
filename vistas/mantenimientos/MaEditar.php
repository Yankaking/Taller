<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: /Taller/vistas/login/login.php");
    exit();
}

require_once __DIR__ . "/../../controladores/MaController.php";
require_once __DIR__ . "/../../controladores/VeController.php";

$controller = new MaController();
$vehiculoController = new VeController();

$id = $_GET["id"] ?? null;
if (!$id) {
    die("ID no especificado");
}

$mantenimiento = $controller->buscarPorId($id);
$vehiculos = $vehiculoController->listar();

if (!$mantenimiento) {
    die("Mantenimiento no encontrado");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Mantenimiento</title>
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
        <h2>Editar Mantenimiento</h2>
        <form action="/Taller/controladores/MaController.php" method="POST" class="form-contenedor">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="MaId" value="<?php echo $mantenimiento['MaId']; ?>">

            <!-- Vehículo -->
            <div class="grupo-formulario">
                <label for="VePlaca">Vehículo</label>
                <select id="VePlaca" name="VePlaca" required>
                    <?php while ($ve = $vehiculos->fetch_assoc()) { ?>
                        <option value="<?php echo $ve['VePlaca']; ?>" 
                            <?php echo ($mantenimiento['VePlaca'] == $ve['VePlaca']) ? 'selected' : ''; ?>>
                            <?php echo $ve['VePlaca'] . " - " . $ve['VeMarca']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Tipo -->
            <div class="grupo-formulario">
                <label for="MaTipo">Tipo de mantenimiento</label>
                <select id="MaTipo" name="MaTipo" required>
                    <option value="Motor" <?php echo ($mantenimiento['MaTipo']=="Motor")?'selected':''; ?>>Motor</option>
                    <option value="Frenos" <?php echo ($mantenimiento['MaTipo']=="Frenos")?'selected':''; ?>>Frenos</option>
                    <option value="Suspensión" <?php echo ($mantenimiento['MaTipo']=="Suspensión")?'selected':''; ?>>Suspensión</option>
                    <option value="Dirección" <?php echo ($mantenimiento['MaTipo']=="Dirección")?'selected':''; ?>>Dirección</option>
                    <option value="Transmisión" <?php echo ($mantenimiento['MaTipo']=="Transmisión")?'selected':''; ?>>Transmisión</option>
                    <option value="Refrigeración" <?php echo ($mantenimiento['MaTipo']=="Refrigeración")?'selected':''; ?>>Refrigeración</option>
                    <option value="Lubricación" <?php echo ($mantenimiento['MaTipo']=="Lubricación")?'selected':''; ?>>Lubricación</option>
                    <option value="Kit de carretera" <?php echo ($mantenimiento['MaTipo']=="Kit de carretera")?'selected':''; ?>>Kit de carretera</option>
                    <option value="Cambio de aceite" <?php echo ($mantenimiento['MaTipo']=="Cambio de aceite")?'selected':''; ?>>Cambio de aceite</option>
                </select>
            </div>

            <!-- Descripción de incidencia -->
            <div class="grupo-formulario">
                <label for="MaDescripcionIncidencia">Descripción de incidencia</label>
                <textarea id="MaDescripcionIncidencia" name="MaDescripcionIncidencia"><?php echo $mantenimiento['MaDescripcionIncidencia']; ?></textarea>
            </div>

            <!-- Estado -->
            <div class="grupo-formulario">
                <label for="MaEstado">Estado</label>
                <select id="MaEstado" name="MaEstado" onchange="toggleSalida()" required>
                    <option value="En proceso" <?php echo ($mantenimiento['MaEstado']=="En proceso")?'selected':''; ?>>En proceso</option>
                    <option value="Entregado" <?php echo ($mantenimiento['MaEstado']=="Entregado")?'selected':''; ?>>Entregado</option>
                </select>
            </div>

            <!-- Descripción de salida -->
            <div class="grupo-formulario" id="descripcionSalida" style="<?php echo ($mantenimiento['MaEstado']=="Entregado")?'display:block':'display:none'; ?>">
                <label for="MaDescripcionSalida">Descripción de salida</label>
                <textarea id="MaDescripcionSalida" name="MaDescripcionSalida"><?php echo $mantenimiento['MaDescripcionSalida']; ?></textarea>
            </div>

            <!-- Fecha -->
            <div class="grupo-formulario">
                <label for="MaFecha">Fecha</label>
                <input type="date" id="MaFecha" name="MaFecha" value="<?php echo $mantenimiento['MaFecha']; ?>" required>
            </div>

            <!-- Botones -->
            <button type="submit" class="boton">Guardar cambios</button>
            <a href="/Taller/vistas/mantenimientos/MaListar.php" class="boton-cancelar">Cancelar</a>
        </form>
    </main>
</body>
</html>
