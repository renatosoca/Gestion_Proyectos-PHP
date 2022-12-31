<?php
namespace Controller;

use Model\Proyecto;
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

    public static function perfil( Router $router) {
        session_start();
        isAuth();

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil'
        ]);
    }
}