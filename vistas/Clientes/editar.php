<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: /Taller/vistas/login/login.php");
    exit();
}

require_once __DIR__ . "/../../controladores/CliController.php";

$controller = new ClienteController();
$id = $_GET["id"] ?? null;
if (!$id) {
    die("Documento no especificado");
}

$cliente = $controller->buscarPorId($id);
if (!$cliente) {
    die("Cliente no encontrado");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>
    <?php include __DIR__ . "/../layout/header.php"; ?>  

    <main class="contenedor-principal">
        <h2>Editar Cliente</h2>
        <form action="../../controladores/CliController.php" method="POST" class="form-contenedor">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="CliId" value="<?php echo $cliente['CliId']; ?>">

            <div class="grupo-formulario">
                <label for="CliNombre">Nombre</label>
                <input type="text" id="CliNombre" name="CliNombre" value="<?php echo $cliente['CliNombre']; ?>" required>
            </div>
            <div class="grupo-formulario">
                <label for="CliApellido">Apellido</label>
                <input type="text" id="CliApellido" name="CliApellido" value="<?php echo $cliente['CliApellido']; ?>" required>
            </div>
            <div class="grupo-formulario">
                <label for="CliDireccion">Dirección</label>
                <input type="text" id="CliDireccion" name="CliDireccion" value="<?php echo $cliente['CliDireccion']; ?>">
            </div>
            <div class="grupo-formulario">
                <label for="CliEmail">Email</label>
                <input type="email" id="CliEmail" name="CliEmail" value="<?php echo $cliente['CliEmail']; ?>">
            </div>
            <div class="grupo-formulario">
                <label for="CliFecha">Fecha</label>
                <input type="date" id="CliFecha" name="CliFecha" value="<?php echo $cliente['CliFecha']; ?>">
            </div>

            <!-- Botón con estilo -->
            <button type="submit" class="boton">Guardar cambios</button>
            <a href="listar.php" class="boton-cancelar">Cancelar</a>
        </form>
    </main>
</body>
</html>
