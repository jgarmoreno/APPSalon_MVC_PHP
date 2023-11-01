<h1 class="nombre-pagina">Actualiza un servicio</h1>
<p class="descripcion-pagina">Llene los campos para actualizar el servicio</p>

<?php
    include_once __DIR__ . '/../templates/barra.php';
?>

<?php if(isset($_SESSION['admin'])) { ?>
    <div class="barra-servicios">
            <a class="boton" href="/admin">Citas</a>
            <a class="boton actual" href="/servicios">Servicios</a>
            <a class="boton" href="/servicios/crear">Crear servicios</a>
    </div>
<?php } ?>
<?php
    include_once __DIR__ . '/../templates/alertas.php';
?>

<div class="acciones">
    <form method="POST" class="formulario">
        <?php include_once __DIR__ . '/formulario.php';?>
        
        <input type="submit" class="boton" value="Actualizar">
    </form>

</div>
<a class="boton-volver" href="/servicios">Volver</a>
