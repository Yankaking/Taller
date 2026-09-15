<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="barra-superior">
    <div class="titulo-sistema">
        <h1>MPS INGENIRÍA</h1>
    </div>
    <div class="usuario-sesion">
        <span>Usuario: <?php echo $_SESSION["usuario"] ?? 'Invitado'; ?></span>
    </div>
    <div class="botones-sesion">
        <a href="/Taller/vistas/inicio/inicio.php" class="boton">Inicio</a>
        <a href="/Taller/controladores/LogoutController.php" class="boton-cancelar">Cerrar sesión</a>
    </div>
</header>
