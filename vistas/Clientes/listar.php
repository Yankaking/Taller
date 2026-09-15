<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: /Taller/vistas/login/login.php");
    exit();
}

require_once __DIR__ . "/../../controladores/CliController.php";
$controller = new ClienteController();
$clientes = $controller->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="/Taller/css/estilos.css">
</head>
<body>
    <?php include __DIR__ . "/../layout/header.php"; ?>

    <main class="contenedor-principal">
        <h2>Clientes registrados</h2>
        <a href="/Taller/vistas/clientes/registrar.php" class="boton">Registrar nuevo cliente</a>
        <table class="tabla">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Dirección</th>
                    <th>Email</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($cli = $clientes->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $cli['CliId']; ?></td>
                        <td><?php echo $cli['CliNombre']; ?></td>
                        <td><?php echo $cli['CliApellido']; ?></td>
                        <td><?php echo $cli['CliDireccion']; ?></td>
                        <td><?php echo $cli['CliEmail']; ?></td>
                        <td><?php echo $cli['CliFecha']; ?></td>
                        <td>
                            <!-- Botón Editar siempre visible -->
                            <a href="/Taller/vistas/clientes/editar.php?id=<?php echo $cli['CliId']; ?>" class="boton">Editar</a>
                            
                            <!-- Botón Eliminar solo para Admin -->
                            <?php if ($_SESSION["rol"] === "01"): ?>
                                <form action="/Taller/controladores/CliController.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <input type="hidden" name="CliId" value="<?php echo $cli['CliId']; ?>">
                                    <button type="submit" class="boton-cancelar" onclick="return confirm('¿Seguro que deseas eliminar este cliente?');">Eliminar</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>
</html>
