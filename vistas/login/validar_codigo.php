<?php
session_start();
require_once __DIR__ . "/../../config/Conexion.php";

$mensajeError = "";
$mensajeExito = "";
$email = $_SESSION["correo_recuperacion"] ?? "";
$codigoGenerado = $_SESSION["codigo_generado"] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conexion = (new Conexion())->conectar();
    $email = $_POST["UsuEmail"];
    $codigoIngresado = $_POST["Codigo"];
    $nuevaClave = password_hash($_POST["UsuPassword"], PASSWORD_DEFAULT);

    $sql = "SELECT * FROM recuperacion WHERE UsuEmail=? AND Codigo=? AND Expira > NOW()";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $email, $codigoIngresado);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Código válido → actualizar contraseña
        $sqlUpdate = "UPDATE usuario SET UsuPassword=? WHERE UsuEmail=?";
        $stmtUpdate = $conexion->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ss", $nuevaClave, $email);
        $stmtUpdate->execute();

        // Eliminar el código usado
        $sqlDel = "DELETE FROM recuperacion WHERE UsuEmail=?";
        $stmtDel = $conexion->prepare($sqlDel);
        $stmtDel->bind_param("s", $email);
        $stmtDel->execute();

        $mensajeExito = "Contraseña restablecida correctamente. Ahora puede iniciar sesión.";
        unset($_SESSION["codigo_generado"], $_SESSION["correo_recuperacion"]);
    } else {
        $mensajeError = "Código inválido o expirado.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validar código</title>
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>
    <div class="login-contenedor">
        <h2>Validar código</h2>
        <form method="POST" class="form-contenedor">
            <div class="grupo-formulario">
                <label for="UsuEmail">Correo electrónico</label>
                <input type="email" name="UsuEmail" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <div class="grupo-formulario">
                <label for="Codigo">Código recibido</label>
                <input type="text" name="Codigo" required>
                <?php if (!empty($codigoGenerado)) { ?>
                    <p class="mensaje-exito">Código generado (solo pruebas): <strong><?php echo $codigoGenerado; ?></strong></p>
                <?php } ?>
            </div>

            <div class="grupo-formulario">
                <label for="UsuPassword">Nueva Contraseña</label>
                <input type="password" name="UsuPassword" required>
            </div>

            <button type="submit" class="boton">Validar y cambiar</button>
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
