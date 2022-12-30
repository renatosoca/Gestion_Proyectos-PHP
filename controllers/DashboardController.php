<?php
namespace Controller;

use MVC\Router;

class DashboardController {

    public static function index( Router $router) {

        $router->render('dashboard/index', [
            'titulo' => '| Dashboard'
        ]);
    }
}