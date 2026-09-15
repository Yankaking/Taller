<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: /Taller/vistas/login/login.php");
    exit();
}

require_once __DIR__ . "/../../controladores/CliController.php";
$clienteController = new ClienteController();
$clientes = $clienteController->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Vehículo</title>
    <link rel="stylesheet" href="/Taller/css/estilos.css">
</head>
<body>
    <?php include __DIR__ . "/../layout/header.php"; ?>

    <main class="contenedor-principal">
        <h2>Registrar Nuevo Vehículo</h2>
        <form action="/Taller/controladores/VeController.php" method="POST" class="form-contenedor">
            <input type="hidden" name="accion" value="registrar">

            <div class="grupo-formulario">
                <label for="VePlaca">Placa</label>
                <input type="text" id="VePlaca" name="VePlaca" required>
            </div>

            <div class="grupo-formulario">
                <label for="CliId">Cliente</label>
                <select id="CliId" name="CliId" required>
                    <option value="">Seleccione un cliente</option>
                    <?php while ($cli = $clientes->fetch_assoc()) { ?>
                        <option value="<?php echo $cli['CliId']; ?>">
                            <?php echo $cli['CliNombre'] . " " . $cli['CliApellido']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="grupo-formulario">
                <label for="VeMarca">Marca</label>
                <input type="text" id="VeMarca" name="VeMarca" required>
            </div>

            <div class="grupo-formulario">
                <label for="VeAño">Año</label>
                <input type="number" id="VeAño" name="VeAño" min="1900" max="2099" required>
            </div>

            <!-- Nuevo campo: Kilometraje -->
            <div class="grupo-formulario">
                <label for="VeKilometraje">Kilometraje</label>
                <input type="number" id="VeKilometraje" name="VeKilometraje" min="0" step="1" required>
            </div>

            <div class="grupo-formulario">
                <label for="VeCilindraje">Cilindraje</label>
                <input type="text" id="VeCilindraje" name="VeCilindraje">
            </div>

            <div class="grupo-formulario">
                <label for="VeEstado">Estado / Descripción</label>
                <textarea id="VeEstado" name="VeEstado"></textarea>
            </div>

            <button type="submit" class="boton">Registrar</button>
            <a href="/Taller/vistas/vehiculos/VeListar.php" class="boton-cancelar">Cancelar</a>
        </form>
    </main>
</body>
</html>
