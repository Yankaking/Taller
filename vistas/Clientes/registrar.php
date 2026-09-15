<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: /Taller/vistas/login/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Cliente</title>
    <link rel="stylesheet" href="/Taller/css/estilos.css">
</head>
<body>
    <?php include __DIR__ . "/../layout/header.php"; ?>

    <main class="contenedor-principal">
        <h2>Registrar Nuevo Cliente</h2>
        <form action="/Taller/controladores/CliController.php" method="POST" class="form-contenedor">
            <input type="hidden" name="accion" value="registrar">

            <div class="grupo-formulario">
                <label for="CliId">Documento de identidad</label>
                <input type="text" id="CliId" name="CliId" required>
            </div>

            <div class="grupo-formulario">
                <label for="CliNombre">Nombre</label>
                <input type="text" id="CliNombre" name="CliNombre" required>
            </div>

            <div class="grupo-formulario">
                <label for="CliApellido">Apellido</label>
                <input type="text" id="CliApellido" name="CliApellido" required>
            </div>

            <div class="grupo-formulario">
                <label for="CliDireccion">Dirección</label>
                <input type="text" id="CliDireccion" name="CliDireccion">
            </div>

            <div class="grupo-formulario">
                <label for="CliEmail">Email</label>
                <input type="email" id="CliEmail" name="CliEmail">
            </div>

            <div class="grupo-formulario">
                <label for="CliFecha">Fecha</label>
                <input type="date" id="CliFecha" name="CliFecha">
            </div>

            <!-- Botones de acción -->
            <button type="submit" class="boton">Registrar</button>
            <a href="/Taller/vistas/clientes/listar.php" class="boton-cancelar">Cancelar</a>
        </form>
    </main>
</body>
</html>

