<h1 class="nombre-pagina">Crea tu cuenta</h1>
<p class="descripcion-pagina">Llena los datos del formulario para crear tu cuenta</p>

<?php
    include_once __DIR__ . '/../templates/alertas.php'
?>

<form class="formulario" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" placeholder="Tu nombre" name="nombre" value="<?php echo s($usuario -> nombre)?>">
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" placeholder="Tu apellido" name="apellido" value="<?php echo s($usuario -> apellido)?>">
    </div>
    <div class="campo">
        <label for="telefono">Télefono</label>
        <input type="tel" id="telefono" placeholder="Tu télefono" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" name="telefono" value="<?php echo s($usuario -> telefono)?>">
    </div>
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu email" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" name="email" value="<?php echo s($usuario -> email)?>">
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" placeholder="Tu contraseña" name="password" oninput="checkPassword(this)">
    </div>
    <div class="campo">
        <label for="password_confirm">Confirma tu contraseña</label>
        <input type="password" id="password_confirm" placeholder="Tu contraseña" name="password_confirm" oninput="checkPassword()">
    </div>
    
    <input type="submit" value="Crear cuenta" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/password-reset">¿Olvidaste tu contraseña?</a>
</div>

<?php
    $script = "<script src='build/js/app.js'></script>";
?>