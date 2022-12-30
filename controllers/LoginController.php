<?php

namespace Controller;

use Model\Usuario;
use MVC\Router;

class LoginController {

    public static function login( Router $router ) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }

        $router->render('auth/login', [
            'titulo' => '| login'
        ]);
    }

    public static function logout() {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    public static function crear( Router $router ) {
        $alertas = [];
        $usuario = new Usuario;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarNuevoUsuario();
        }

        $router->render('auth/crear', [
            'titulo' => '| Crear Cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function olvide( Router $router ) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }

        $router->render('auth/olvide', [
            'titulo' => '| Olvidé'
        ]);
    }

    public static function recuperar( Router $router ) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }

        $router->render('auth/recuperar', [
            'titulo' => '| Recuperar Clave'
        ]);
    }

    public static function mensaje( Router $router ) {

        $router->render('auth/mensaje', [

        ]);
    }

    public static function confirmar( Router $router ) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }

        $router->render('auth/confirmar', [

        ]);
    }
}