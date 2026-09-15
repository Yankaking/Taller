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
    <title>Consultas de Mantenimientos</title>
    <link rel="stylesheet" href="/Taller/css/estilos.css">
</head>
<body>
    <?php include __DIR__ . "/../layout/header.php"; ?>

    <main class="contenedor-principal">
        <h2>Consultar historial por placa</h2>
        <form id="formConsulta">
            <label for="placa">Placa del vehículo:</label>
            <input type="text" name="placa" id="placa" placeholder="Ej: ABC123" required>

            <label for="fechaInicio">Fecha inicio:</label>
            <input type="date" name="fechaInicio" id="fechaInicio">

            <label for="fechaFin">Fecha fin:</label>
            <input type="date" name="fechaFin" id="fechaFin">

            <button type="submit" class="boton">Buscar</button>
        </form>

        <div id="resultado"></div>
    </main>

    <script>
    document.getElementById("formConsulta").addEventListener("submit", function(e){
        e.preventDefault();
        let placa = document.getElementById("placa").value;
        let fechaInicio = document.getElementById("fechaInicio").value;
        let fechaFin = document.getElementById("fechaFin").value;

        fetch("ajaxHistorial.php?placa=" + placa + "&fechaInicio=" + fechaInicio + "&fechaFin=" + fechaFin)
            .then(response => response.text())
            .then(data => {
                document.getElementById("resultado").innerHTML = data;
            });
    });
    </script>
</body>
</html>
