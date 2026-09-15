<?php
require_once "../../controladores/LoginController.php";

$mensajeError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = new LoginController();
    $mensajeError = $login->iniciarSesion($_POST["usuario"], $_POST["contraseña"]);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - MPS Ingeniería Automotriz</title>
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>
    <div class="login-contenedor">
        <div class="logo">
            <img src="../../img/Logo.jpg" alt="Logo Empresa" class="logo-login">
            <h1>MPS INGENIERÍA AUTOMOTRÍZ</h1>
        </div>

        <h2>Inicio Sesión</h2>

        <form action="" method="POST" class="form-contenedor">
            <div class="grupo-formulario">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
            </div>
            <div class="grupo-formulario">
                <label for="contraseña">Contraseña</label>
                <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="boton">Iniciar sesión</button>
        </form>
        <p>
            <a href="registrar.php">Registrarse</a><br>
            <a href="restablecer.php">¿Olvidaste tu contraseña?</a>
        </p>


        <?php if (!empty($mensajeError)): ?>
            <div class="mensaje-error"><?= $mensajeError ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
