let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    id: '',
    nombre : '',
    fecha : '',
    hora : '',
    servicios : []

}

document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});

function iniciarApp() { // No incluyo checkpassword porque al ser de paginas diferentes no encuentra las variables (getElementById) al iniciarApp si estoy desde /cita comprobando todo el IniciarApp
    mostrarSeccion();
    tabs();
    botonesPaginador();
    paginaAnterior();
    paginaSiguiente();

    // Traer los servicios del backend a través de una API
    consultarAPI();

    // Llenar el objeto de la cita con los datos.
    idCliente();
    nombreCliente();
    seleccionarFecha();
    seleccionarHora();
    mostrarResumen();

}

function checkPassword() {
    const input = document.getElementById('password_confirm');
    if (document.getElementById('password_confirm').value != document.getElementById('password').value) {
        input.setCustomValidity('Las contraseñas deben ser similares');
    } else {
        // input is valid -- reset the error message
        input.setCustomValidity('');
    }
}

function mostrarSeccion() {
    // 2º Ocultar la sección borrando clase mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }
    // 1º Seleccionar sección y mostrarla
    const seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add('mostrar');

    // Eliminar clase actual (resaltado tab)
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior) {
        tabAnterior.classList.remove('actual');
    }
    // Agregar clase actual (resaltado tab)
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');
    botones.forEach( boton => {
        boton.addEventListener('click', function (e) {
            paso = parseInt(e.target.dataset.paso); // Se consigue el numero del paso y luego muestra seccion
            mostrarSeccion();
            botonesPaginador();
        })
    })
}

function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if(paso === 3) {
        paginaSiguiente.classList.add('ocultar');
        paginaAnterior.classList.remove('ocultar');
        mostrarResumen();
    } else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    mostrarSeccion();
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function(){
        if(paso<=pasoInicial) return;
        paso--;
        botonesPaginador();
    });
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function(){
        if(paso>=pasoFinal) return;
        paso++;
        botonesPaginador();
    });
}

async function consultarAPI () {
    try {
        const url = `${location.origin}/api/servicios`;
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}
function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        const {id, nombre, precio } = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `${precio} €`;

        const divServicio = document.createElement('DIV');
        divServicio.classList.add('servicio');
        divServicio.dataset.idServicio = id;
        divServicio.onclick = function () {
            seleccionarServicio(servicio);
        }

        divServicio.appendChild(nombreServicio);
        divServicio.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(divServicio);
    })
}
function seleccionarServicio(servicio){
    const {id} = servicio;
    const {servicios} = cita;

    // Identificar el elemento que se clica
    const servicioDiv = document.querySelector(`[data-id-servicio="${id}"]`);

    // Comprobar si un servicio ya fue agregado
    if(servicios.some(agregado => agregado.id === id)) { 
        // Ya agregado. Eliminar clase.
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        servicioDiv.classList.remove('seleccionado');
    } else {
        // No agregado. Agregar clase.
        cita.servicios = [...servicios, servicio];
        servicioDiv.classList.add('seleccionado');
    }
    console.log(cita);
}
function idCliente() {
    cita.id = document.querySelector('#id').value;
}

function nombreCliente() {
    cita.nombre = document.querySelector('#nombre').value;
}
function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e){
        const dia = new Date(e.target.value).getUTCDay();
        if([6,0].includes(dia)){
            e.target.value = '';
            mostrarAlerta('Solo días laborables', 'error', '.formulario');
        } else {
            cita.fecha = e.target.value;
        }
    });
}
function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e){
        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];
        if(hora < 10 || hora >= 20) {
            e.target.value = '';
            mostrarAlerta('Seleccione una hora válida', 'error', '.formulario');
        } else {
            cita.hora = e.target.value;
            // console.log(cita);
        }
    });
}
function mostrarAlerta (mensaje, tipo, elemento, desaparece = true) {
    // Prevenir que la alerta se muestre más de una vez
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia) {
        alerta.remove();
    }
    // Scripting
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if(desaparece) {
        // Eliminar alerta
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
}

function mostrarResumen () {
    const resumen = document.querySelector('.contenido-resumen');

    // Limpiar el contenido del resumen
    while(resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    if(Object.values(cita).includes('')) {
        mostrarAlerta('Rellene los datos de la cita', 'error', '.contenido-resumen', false);
        return;
    } 
    const {nombre, fecha, hora, servicios} = cita;

    // Heading para el servicio
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Servicios seleccionados';
    resumen.appendChild(headingServicios);

    servicios.forEach(servicio => {
        const {id, precio, nombre} = servicio;

        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> ${precio}€`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);
        resumen.appendChild(contenedorServicio);
    })
    
    // Heading para el servicio
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Datos de la cita';
    resumen.appendChild(headingCita);
    
    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    // Formatear la fecha en español
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date (Date.UTC(year, mes, dia));

    const opciones = {weekday: 'long', year:'numeric', month: 'long', day:'numeric'}
    const fechaFormateada = fechaUTC.toLocaleDateString('es-ES', opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora}`;

    // Botón para crear cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar cita';
    botonReservar.onclick = reservarCita;
    
    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    resumen.appendChild(botonReservar);
}

async function reservarCita() {
    const {nombre, fecha, hora, servicios, id } = cita;
    // Dif. entre map y foreach. Foreach solo itera, map itera y guarda las coincidencias

    const idServicios = servicios.map(servicio => servicio.id);
    
    const datos = new FormData();
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);
    // console.log([...datos]);  Para que se pueda ver el Form Data en consola antes de enviarlo.

    try {
        // Petición hacia la API
            const url = `${location.origin}/api/citas`;

            const respuesta = await fetch (url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();
            console.log(resultado.resultado);

            if(resultado.resultado) {
                Swal.fire({
                    icon: 'success',
                    title: 'Cita creada',
                    text: 'Tu cita fue reservada correctamente',
                    button: 'OK',
                }).then(() => {
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                });
            }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'La cita no pudo ser creada',
          })
    }
}
