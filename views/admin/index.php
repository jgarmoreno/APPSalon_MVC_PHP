<h1 class="nombre-pagina">Panel de Administración</h1>

<?php
    include_once __DIR__ . '/../templates/barra.php';
?>

<?php if(isset($_SESSION['admin'])) { ?>
    <div class="barra-servicios">
            <a class="boton actual" href="/admin">Citas</a>
            <a class="boton" href="/servicios">Servicios</a>
            <a class="boton" href="/servicios/crear">Crear servicios</a>
    </div>
<?php } ?>

<h2>Buscador de citas</h2>

<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha;?>">
        </div>
    </form>
</div>

<?php
    if(count($citas) === 0){
        echo "<h2 class='alertaFecha'>No hay citas en la fecha seleccionada</h2>";
    }
?>

<div id="citas-admin">
    <ul class="citas">

    <?php
    $idCita = 0; // Se le da un valor previo para que no tire error de que la variable no está definida
        foreach( $citas as $key => $cita ) :
            if($idCita !== $cita -> id) {
                $total = 0;
    ?>
        <li>
            <p><span>ID </span><?php echo $cita->id;?></p>
            <p><span>Hora </span><?php echo $cita->hora;?></p>
            <p><span>Cliente </span><?php echo $cita->cliente;?></p>
            <p><span>Email </span><?php echo $cita->email;?></p>
            <p><span>Telefono </span><?php echo $cita->telefono;?></p>
            <h3>Servicios</h3>
            <?php 
                $idCita = $cita -> id; // Hay que añadir esto antes del if porque $idCita hay que nombrarla, crearla y asignarle un valor
            } 
                $total += $cita -> precio;
            ?>
            <p class="servicio"><?php echo $cita -> servicio . " " ?> <span><?php echo $cita->precio;?> €</span></p> 
            <?php  
                $actual = $cita -> id;
                $proximo = $citas[$key + 1] -> id ?? 0;

                if(esUltimo($actual, $proximo)) { ?>             
                    <p><span>Total </span><?php echo $total; ?>€</p>              
                    <form action="/api/eliminar" method="POST" id="formEliminar" >                 
                        <input type="hidden" name="id" value="<?php echo $cita->id; ?>">                  
                        <input type="submit" class="boton-eliminar" value="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar esta cita?')">              
                    </form>       
                <?php   }     ?>                      
                <?php  endforeach; ?>         
            </li>     
        </ul> 
    </div>  
<?php  
    $script = "     
        <script src='build/js/buscador.js'></script>     
        <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script> 
        ";   
?>
