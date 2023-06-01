<?php
namespace Controller;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

class DashboardController {

    public static function index( Router $router) {
        session_start();
        isAuth();

        $proyectos = Proyecto::belongsTo('usuarioId', $_SESSION['id']);

        $router->render('dashboard/index', [
            'titulo' => 'Dashboard',
            'proyectos' => $proyectos
        ]);
    }

    public static function crear_proyecto( Router $router) {
        session_start();
        isAuth();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = new Proyecto($_POST);
            $alertas = $proyecto->validar();

            if (empty($alertas)) {
                $proyecto->generarURL();
                $proyecto->usuarioId = $_SESSION['id'];
                
                $resultado = $proyecto->guardar();
                if ($resultado) {
                    header('Location: /proyecto?id='.$proyecto->url);
                }
            }
        }

        $router->render('dashboard/crear-proyecto', [
            'titulo' => 'Crear Proyecto',
            'alertas' => $alertas
        ]);
    }

    public static function proyecto( Router $router) {
        session_start();
        isAuth();

        $token = s($_GET['token']);
        if (!$token) header('Location: /dashboard');
        $proyecto = Proyecto::where('url', $token);

        if ($proyecto->usuarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }

        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto
        ]);
    }

    public static function perfil( Router $router ) {
        session_start();
        isAuth();
        $alertas = [];
        $usuario = Usuario::find($_SESSION['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarUSuario();

            if (empty( $alertas )) {
                $existeUsuario = Usuario::where('email', $usuario->email);
                if ($existeUsuario && $existeUsuario->id !== $usuario->id) {
                    Usuario::setAlerta('error', 'El Email no está disponible');
                } else {
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        $_SESSION['nombre'] = $usuario->nombre;
                        Usuario::setAlerta('exito', 'Actualizado correctamente');
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }

    public static function cambiar_clave( Router $router ) {
        session_start();
        isAuth();
        $alertas = [];
        $usuario = Usuario::find($_SESSION['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarPassNuevo();

            if (empty( $alertas )) {
                $resultado = $usuario->comprobarPassword();
                if ($resultado) {
                    $usuario->password = $usuario->password_nuevo;

                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);

                    $usuario->hashPassword();
                    $resultado = $usuario->guardar();
                    
                    if ($resultado) {
                        Usuario::setAlerta('exito', 'Actualizado Correctamente');
                    }
                } else {
                    Usuario::setAlerta('error', 'Password Incorrecto');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('dashboard/cambiar_password', [
            'titulo' => 'Cambiar Contraseña',
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }
}