<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Listado de las prestaciones ofrecidas</p>

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

<ul class="servicios">
    <?php foreach($servicios as $servicio) { ?>
        <li>
            <p><span>Nombre</span> <?php echo $servicio->nombre;?></p>
            <p><span>Precio</span> <?php echo $servicio->precio;?> €</p>

            <div class="acciones">
                <a class="boton-actualizar" href="/servicios/actualizar?id=<?php echo $servicio -> id; ?>">Actualizar</a>

                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio -> id;?>">
                    <input type="submit" value="Eliminar" class="boton-eliminar" onclick="return confirm('¿Seguro que deseas eliminar este servicio?')">
                </form>
            </div>
        </li>
    <?php } ?>
</ul>