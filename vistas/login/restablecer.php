<?php
session_start();
require_once __DIR__ . "/../../controladores/UsuarioController.php";

$mensajeError = "";
$mensajeExito = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller = new UsuarioController();

    $email = $_POST["UsuEmail"];
    $nuevaClave = password_hash($_POST["UsuPassword"], PASSWORD_DEFAULT);

    if ($controller->restablecerClave($email, $nuevaClave)) {
        $mensajeExito = "Contraseña restablecida correctamente. Ahora puede iniciar sesión.";
    } else {
        $mensajeError = "Error al restablecer contraseña. Verifique el correo ingresado.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>
    <div class="login-contenedor">
        <h2>Restablecer Contraseña</h2>
        <p>Seleccione una opción:</p>
        <a href="solicitar_codigo.php" class="boton">Solicitar código</a>
        <a href="validar_codigo.php" class="boton">Validar código</a>
        <a href="login.php" class="boton-cancelar">Volver</a>
    </div>
</body>
</html>