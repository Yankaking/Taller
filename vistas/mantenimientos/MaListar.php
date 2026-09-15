<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: /Taller/vistas/login/login.php");
    exit();
}

require_once __DIR__ . "/../../controladores/MaController.php";
$controller = new MaController();
$mantenimientos = $controller->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Mantenimientos</title>
    <link rel="stylesheet" href="/Taller/css/estilos.css">
</head>
<body>
    <?php include __DIR__ . "/../layout/header.php"; ?>

    <main class="contenedor-principal">
        <h2>Mantenimientos registrados</h2>
        <a href="/Taller/vistas/mantenimientos/MaRegistrar.php" class="boton">Registrar nuevo mantenimiento</a>
        <table class="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Placa</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Descripción de incidencia</th>
                    <th>Estado</th>
                    <th>Descripción de salida</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($ma = $mantenimientos->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $ma['MaId']; ?></td>
                        <td><?php echo $ma['VePlaca']; ?></td>
                        <td><?php echo $ma['MaTipo']; ?></td>
                        <td><?php echo $ma['MaFecha']; ?></td>
                        <td><?php echo $ma['MaDescripcionIncidencia']; ?></td>
                        <td><?php echo $ma['MaEstado']; ?></td>
                        <td><?php echo $ma['MaDescripcionSalida']; ?></td>
                        <td>
                            <!-- Botón Editar siempre visible -->
                            <a href="/Taller/vistas/mantenimientos/MaEditar.php?id=<?php echo $ma['MaId']; ?>" class="boton">Editar</a>
                            
                            <!-- Botón Eliminar solo para Admin -->
                            <?php if ($_SESSION["rol"] === "01"): ?>
                                <form action="/Taller/controladores/MaController.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <input type="hidden" name="MaId" value="<?php echo $ma['MaId']; ?>">
                                    <button type="submit" class="boton-cancelar" onclick="return confirm('¿Seguro que deseas eliminar este mantenimiento?');">Eliminar</button>
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
