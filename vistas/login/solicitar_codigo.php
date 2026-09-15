<?php
session_start();
require_once __DIR__ . "/../../modelos/Usuario.php";
require_once __DIR__ . "/../../config/Conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = new Usuario();
    $email = $_POST["UsuEmail"];

    if ($usuario->existeCorreo($email)) {
        $codigo = rand(100000, 999999); // Código de 6 dígitos
        $expira = date("Y-m-d H:i:s", strtotime("+15 minutes"));

        // Guardar en tabla recuperacion
        $conexion = (new Conexion())->conectar();
        $sql = "INSERT INTO recuperacion (UsuEmail, Codigo, Expira) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sss", $email, $codigo, $expira);
        $stmt->execute();

        // Guardar en sesión para usar en validar_codigo.php
        $_SESSION["codigo_generado"] = $codigo;
        $_SESSION["correo_recuperacion"] = $email;

        // Redirigir a validar_codigo.php
        header("Location: validar_codigo.php");
        exit();
    } else {
        $mensajeError = "El correo ingresado no está registrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitar código</title>
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>
    <div class="login-contenedor">
        <h2>Recuperar contraseña</h2>
        <form method="POST" class="form-contenedor">
            <div class="grupo-formulario">
                <label for="UsuEmail">Correo electrónico</label>
                <input type="email" name="UsuEmail" required>
            </div>
            <button type="submit" class="boton">Generar código</button>
            <a href="login.php" class="boton-cancelar">Volver</a>
        </form>

        <?php if (!empty($mensajeError)) { ?>
            <p class="mensaje-error"><?php echo $mensajeError; ?></p>
        <?php } ?>
    </div>
</body>
</html>
