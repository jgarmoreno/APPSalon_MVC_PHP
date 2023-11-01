<h1 class="nombre-pagina">Añade un nuevo servicio</h1>
<p class="descripcion-pagina">Llene los campos para crear un nuevo servicio</p>

<?php
    include_once __DIR__ . '/../templates/barra.php';
?>

<?php if(isset($_SESSION['admin'])) { ?>
    <div class="barra-servicios">
            <a class="boton" href="/admin">Citas</a>
            <a class="boton" href="/servicios">Servicios</a>
            <a class="boton  actual" href="/servicios/crear">Crear servicios</a>
    </div>
<?php } ?>

<?php
    include_once __DIR__ . '/../templates/alertas.php';
?>


<form action="/servicios/crear" method="POST" class="formulario">
    <?php include_once __DIR__ . '/formulario.php';?>
    
    <input type="submit" class="boton" value="Crear">
</form>