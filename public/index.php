<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\APIController;
use Controllers\CitaController;
use Controllers\AdminController;
use Controllers\LoginController;
use Controllers\ServicioController;

$router = new Router();

// Iniciar sesión
$router -> get('/', [LoginController::class, 'login']);
$router -> post('/', [LoginController::class, 'login']);
$router -> get('/logout', [LoginController::class, 'logout']);

// Recuperar password
$router -> get('/password-reset', [LoginController::class, 'olvide']);
$router -> post('/password-reset', [LoginController::class, 'olvide']);
$router -> get('/recuperar-cuenta', [LoginController::class, 'recuperar']);
$router -> post('/recuperar-cuenta', [LoginController::class, 'recuperar']);

// Crear cuenta
$router -> get('/crear-cuenta', [LoginController::class, 'crear']);
$router -> post('/crear-cuenta', [LoginController::class, 'crear']);

// Confirmar cuenta
$router -> get('/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router -> get('/confirm', [LoginController::class, 'mensaje']);

// Área privada
$router -> get('/cita', [CitaController::class, 'index']);
$router -> get('/admin', [AdminController::class, 'index']);

// API de servicios
$router -> get('/api/servicios', [APIController::class, 'index']);
$router -> post('/api/citas', [APIController::class, 'guardar']);
$router -> post('/api/eliminar', [APIController::class, 'eliminar']);

// CRUD Servicios
$router -> get('/servicios', [ServicioController::class, 'index']);
$router -> get('/servicios/crear', [ServicioController::class, 'crear']);
$router -> post('/servicios/crear', [ServicioController::class, 'crear']);
$router -> get('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router -> post('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router -> post('/servicios/eliminar',[ServicioController::class, 'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();