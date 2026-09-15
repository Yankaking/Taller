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
    <title>Inicio - Taller</title>
    <link rel="stylesheet" href="/Taller/css/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/Taller/js/graficos.js"></script>
</head>
<body>
    <?php include __DIR__ . "/../layout/header.php"; ?>

    <main class="contenedor-principal">
        <h2>Gestión del sistema</h2>
        <div class="menu-principal">
            <!-- Bloque Clientes -->
            <div class="card-menu">
                <h3>Clientes</h3>
                <p>Administrar clientes registrados en el taller.</p>
                <a href="/Taller/vistas/clientes/listar.php" class="boton">Ver clientes</a>
                <a href="/Taller/vistas/clientes/registrar.php" class="boton">Registrar cliente</a>
            </div>

            <!-- Bloque Vehículos -->
            <div class="card-menu">
                <h3>Vehículos</h3>
                <p>Administrar vehículos asociados a clientes.</p>
                <a href="/Taller/vistas/vehiculos/VeListar.php" class="boton">Ver vehículos</a>
                <a href="/Taller/vistas/vehiculos/VeRegistrar.php" class="boton">Registrar vehículo</a>
            </div>

            <!-- Bloque Mantenimientos -->
            <div class="card-menu">
                <h3>Mantenimientos</h3>
                <p>Registrar y consultar mantenimientos de vehículos.</p>
                <a href="/Taller/vistas/mantenimientos/MaListar.php" class="boton">Ver mantenimientos</a>
                <a href="/Taller/vistas/mantenimientos/MaRegistrar.php" class="boton">Registrar mantenimiento</a>
            </div>

            <!-- Bloque Consultas -->
            <div class="card-menu">
                <h3>Consultas</h3>
                <p>Consultar historial de mantenimientos por placa.</p>
                <a href="/Taller/vistas/consultas/Consultas.php" class="boton">Ir a consultas</a>
            </div>
        </div>

        <!-- Tarjeta con filtro y gráfico juntos -->
        <section class="estadisticas-container">
            <h3>Mantenimientos por estado (filtrados por fecha)</h3>
            <div class="estadisticas-content">
                <div class="filtro-fechas">
                    <form id="formFechas" class="form-contenedor">
                        <label for="fechaInicio">Fecha inicio:</label>
                        <input type="date" name="fechaInicio" id="fechaInicio" required>
                        <label for="fechaFin">Fecha fin:</label>
                        <input type="date" name="fechaFin" id="fechaFin" required>
                        <button type="submit" class="boton">Filtrar</button>
                    </form>
                </div>

                <div class="grafico-mantenimientos">
                    <canvas id="graficoMantenimientos" width="250" height="150"></canvas>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
