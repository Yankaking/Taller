<?php
session_start();
require_once __DIR__ . "/../../controladores/UsuarioController.php";

$mensajeError = "";
$mensajeExito = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $controller = new UsuarioController();

    $nombre   = $_POST["UsuNombre"];
    $email    = $_POST["UsuEmail"];
    $login    = $_POST["UsuLogin"];
    $password = password_hash($_POST["UsuPassword"], PASSWORD_DEFAULT);
    $rol      = $_POST["RollId"];

    if ($controller->registrar($nombre, $email, $login, $password, $rol)) {
        $mensajeExito = "Usuario registrado correctamente. Ahora puede iniciar sesión.";
    } else {
        $mensajeError = "Error al registrar usuario. Intente nuevamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrarse</title>
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>
    <div class="login-contenedor">
        <h2>Crear cuenta</h2>
        <form method="POST" class="form-contenedor">
            <div class="grupo-formulario">
                <label for="UsuNombre">Nombre completo</label>
                <input type="text" name="UsuNombre" required>
            </div>

            <div class="grupo-formulario">
                <label for="UsuEmail">Correo electrónico</label>
                <input type="email" name="UsuEmail" required>
            </div>

            <div class="grupo-formulario">
                <label for="UsuLogin">Usuario</label>
                <input type="text" name="UsuLogin" required>
            </div>

            <div class="grupo-formulario">
                <label for="UsuPassword">Contraseña</label>
                <input type="password" name="UsuPassword" required>
            </div>

            <div class="grupo-formulario">
                <label for="RollId">Rol</label>
                <select name="RollId" required>
                    <option value="01">Administrador</option>
                    <option value="02">Empleado</option>
                </select>
            </div>

            <button type="submit" class="boton">Registrarse</button>
            <a href="login.php" class="boton-cancelar">Volver</a>
        </form>

        <?php if (!empty($mensajeExito)) { ?>
            <p class="mensaje-exito"><?php echo $mensajeExito; ?></p>
        <?php } ?>
        <?php if (!empty($mensajeError)) { ?>
            <p class="mensaje-error"><?php echo $mensajeError; ?></p>
        <?php } ?>
    </div>
</body>
</html>
