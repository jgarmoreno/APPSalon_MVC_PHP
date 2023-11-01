<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;

class LoginController {
    public static function login(Router $router) {
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth -> validarLogin();

            if(empty($alertas)) {
                // Verificar el email (que exista)
                $usuario = Usuario::where('email', $auth -> email);
                if($usuario){
                    // Verificar el password y cuenta confirmada
                    if($usuario -> verificarPassAndConfirmado($auth -> password)){
                        // Autenticar al usuario
                        session_start();

                        $_SESSION['id'] = $usuario -> id;
                        $_SESSION['nombre'] = $usuario -> nombre . " " . $usuario -> apellido;
                        $_SESSION['email'] = $usuario -> email;
                        $_SESSION['login'] = true;

                        // Redirección en función del rol
                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario -> admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        
        $router -> render('auth/login', [
            'alertas' => $alertas
        ]);
    }
    public static function logout() {
        session_start();

        $_SESSION = [];

        header('Location: /');
    }
    public static function olvide(Router $router) {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth -> validarEmail();
            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth -> email);
                if($usuario && $usuario->confirmado === '1'){
                    // Generar token
                    $usuario -> crearToken();
                    $usuario -> guardar();
                    // Enviar email
                    $email = new Email($usuario -> email, $usuario -> nombre, $usuario -> token);
                    $email -> enviarResetPassword();
                    // Alerta de éxito
                    Usuario::setAlerta('exito', 'Revisa tu email para reestablecer tu contraseña');
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o la cuenta no ha sido confirmada');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router -> render('auth/password-reset', [
            'alertas' => $alertas
        ]);
    }
    public static function recuperar(Router $router) {
        $alertas = [];
        $error = false;
        $token = s($_GET['token']);

        // Buscar usuario
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        } 
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = new Usuario($_POST);
            $alertas = $password -> validarPassword();
            if(empty($alertas)) {
                $usuario -> password = null;
                $usuario -> password = $password -> password;
                $usuario -> hashPassword();
                $usuario -> token = null;
                $resultado = $usuario -> guardar();
                if($resultado) {
                    // Crear mensaje de exito
                    Usuario::setAlerta('exito', 'Contraseña actualizada');
                                    
                    // Redireccionar al login tras 3 segundos
                    header('Refresh: 3; url=/');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router -> render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }
    public static function crear(Router $router) {
        $usuario = new Usuario;
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario -> sincronizar($_POST);
            $alertas = $usuario -> validarNuevaCuenta();

            if(empty($alertas)) {
                // Verificar que el usuario no esté registrado
                $resultado = $usuario -> existeUsuario();
                if($resultado -> num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear Password
                    $usuario -> hashPassword();
                    // Generar token
                    $usuario -> crearToken();
                    // Enviar email
                    $email = new Email($usuario -> email, $usuario -> nombre, $usuario -> token);
                    $email -> enviarConfirmacion();
                    // Crea el usuario
                    $resultado = $usuario -> guardar();
                    if($resultado){
                        header('Location: /confirm');
                    }
                }
            }
        }

        $router -> render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    public static function mensaje(Router $router) {

        $router -> render('auth/confirm', [

        ]);
    }
    public static function confirmar(Router $router){
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            // Fracaso confirmando
            Usuario::setAlerta('error', 'La cuenta no pudo confirmarse');
        } else {
            // Éxito confirmando
            $usuario -> confirmado = '1';
            $usuario -> token = null;
            $usuario -> guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
        }

        // Obtener alertas
        $alertas = Usuario::getAlertas();

        // Renderizado a la vista
        $router -> render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}