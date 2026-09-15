<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: /Taller/vistas/login/login.php");
    exit();
}

require_once __DIR__ . "/../../controladores/VeController.php";
$controller = new VeController();
$vehiculos = $controller->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Vehículos</title>
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>
    <?php include __DIR__ . "/../layout/header.php"; ?>

    <main class="contenedor-principal">
        <h2>Vehículos registrados</h2>
        <a href="VeRegistrar.php" class="boton">Registrar nuevo vehículo</a>
        <table class="tabla">
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Cliente</th>
                    <th>Marca</th>
                    <th>Año</th>
                    <th>Kilometraje</th>
                    <th>Cilindraje</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($ve = $vehiculos->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $ve['VePlaca']; ?></td>
                        <td><?php echo $ve['CliNombre'] . " " . $ve['CliApellido']; ?></td>
                        <td><?php echo $ve['VeMarca']; ?></td>
                        <td><?php echo $ve['VeAño']; ?></td>
                        <td><?php echo $ve['VeKilometraje']; ?></td>
                        <td><?php echo $ve['VeCilindraje']; ?></td>
                        <td><?php echo $ve['VeEstado']; ?></td>
                        <td>
                            <!-- Botón Editar siempre visible -->
                            <a href="VeEditar.php?placa=<?php echo $ve['VePlaca']; ?>" class="boton">Editar</a>
                            
                            <!-- Botón Eliminar solo para Admin -->
                            <?php if ($_SESSION["rol"] === "01"): ?>
                                <form action="../../controladores/VeController.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <input type="hidden" name="VePlaca" value="<?php echo $ve['VePlaca']; ?>">
                                    <button type="submit" class="boton-cancelar" onclick="return confirm('¿Seguro que deseas eliminar este vehículo?');">Eliminar</button>
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
