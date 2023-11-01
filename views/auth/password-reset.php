<h1 class="nombre-pagina">Reestablecer contraseña</h1>
<p class="descripcion-pagina">Introduce la dirección de correo usada en el registro. Te enviaremos un enlace para reestablecer tu contraseña.</p>

<?php
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" method="POST" action="/password-reset">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu email" name="email">
    </div>
    <input type="submit" class="boton" value="Enviar">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/crear-cuenta">Crea tu cuenta</a>
</div>
