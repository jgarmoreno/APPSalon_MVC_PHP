<h1 class="nombre-pagina">Recupera tu cuenta</h1>
<p class="descripcion-pagina">Introduce una nueva contraseña para recuperar tu cuenta en AppSalon.</p>

<?php
    include_once __DIR__ . '/../templates/alertas.php';
?>
<?php if($error) return; ?>
<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Tu nueva contraseña">
    </div>
    <input type="submit" class="boton" value="Guardar cambios">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/crear-cuenta">Crea tu cuenta</a>
</div>
