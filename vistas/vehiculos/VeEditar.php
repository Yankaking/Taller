<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: /Taller/vistas/login/login.php");
    exit();
}

require_once __DIR__ . "/../../controladores/VeController.php";
require_once __DIR__ . "/../../controladores/CliController.php";

$controller = new VeController();
$clienteController = new ClienteController();

$placa = $_GET["placa"] ?? null;
if (!$placa) {
    die("Placa no especificada");
}

$vehiculo = $controller->buscarPorPlaca($placa);
$clientes = $clienteController->listar();

if (!$vehiculo) {
    die("Vehículo no encontrado");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Vehículo</title>
    <link rel="stylesheet" href="/Taller/css/estilos.css">
</head>
<body>
    <?php include __DIR__ . "/../layout/header.php"; ?>

    <main class="contenedor-principal">
        <h2>Editar Vehículo</h2>
        <form action="/Taller/controladores/VeController.php" method="POST" class="form-contenedor">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="VePlaca" value="<?php echo $vehiculo['VePlaca']; ?>">

            <div class="grupo-formulario">
                <label for="CliId">Cliente</label>
                <select id="CliId" name="CliId" required>
                    <?php while ($cli = $clientes->fetch_assoc()) { ?>
                        <option value="<?php echo $cli['CliId']; ?>" 
                            <?php echo ($vehiculo['CliId'] == $cli['CliId']) ? 'selected' : ''; ?>>
                            <?php echo $cli['CliNombre'] . " " . $cli['CliApellido']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="grupo-formulario">
                <label for="VeMarca">Marca</label>
                <input type="text" id="VeMarca" name="VeMarca" value="<?php echo $vehiculo['VeMarca']; ?>" required>
            </div>

            <div class="grupo-formulario">
                <label for="VeAño">Año</label>
                <input type="number" id="VeAño" name="VeAño" value="<?php echo $vehiculo['VeAño']; ?>" required>
            </div>

            <!-- ✅ Nuevo campo Kilometraje -->
            <div class="grupo-formulario">
                <label for="VeKilometraje">Kilometraje</label>
                <input type="number" id="VeKilometraje" name="VeKilometraje" value="<?php echo $vehiculo['VeKilometraje']; ?>" min="0" step="1" required>
            </div>

            <div class="grupo-formulario">
                <label for="VeCilindraje">Cilindraje</label>
                <input type="text" id="VeCilindraje" name="VeCilindraje" value="<?php echo $vehiculo['VeCilindraje']; ?>">
            </div>

            <div class="grupo-formulario">
                <label for="VeEstado">Estado / Descripción</label>
                <textarea id="VeEstado" name="VeEstado"><?php echo $vehiculo['VeEstado']; ?></textarea>
            </div>

            <!-- Botones de acción -->
            <button type="submit" class="boton">Guardar cambios</button>
            <a href="/Taller/vistas/vehiculos/VeListar.php" class="boton-cancelar">Cancelar</a>
        </form>
    </main>
</body>
</html>
