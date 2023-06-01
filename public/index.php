<?php 

require_once __DIR__ . '/../app/main.php';

use App\Router;

use Controller\LoginController;
use Controller\TareaController;
use Controller\DashboardController;

Router::get('/', [LoginController::class, 'login']);
Router::post('/', [LoginController::class, 'login']);

Router::get('/logout', function() {
  session_start();
  $_SESSION = [];
  Router::redirect('/');
});

Router::get('/crear', [LoginController::class, 'crear']);
Router::post('/crear', [LoginController::class, 'crear']);

Router::get('/olvide', [LoginController::class, 'olvide']);
Router::post('/olvide', [LoginController::class, 'olvide']);

Router::get('/recuperar', [LoginController::class, 'recuperar']);
Router::post('/recuperar', [LoginController::class, 'recuperar']);

Router::get('/mensaje', [LoginController::class, 'mensaje']);
Router::get('/confirmar', [LoginController::class, 'confirmar']);


Router::get('/dashboard', [DashboardController::class, 'index']);

Router::get('/crear-proyecto', [DashboardController::class, 'crear_proyecto']);
Router::post('/crear-proyecto', [DashboardController::class, 'crear_proyecto']);

Router::get('/proyecto', [DashboardController::class, 'proyecto']);

Router::get('/perfil', [DashboardController::class, 'perfil']);
Router::post('/perfil', [DashboardController::class, 'perfil']);

Router::get('/cambiar-clave', [DashboardController::class, 'cambiar_clave']);
Router::post('/cambiar-clave', [DashboardController::class, 'cambiar_clave']);


//API para las tareas
Router::get('/api/tareas', [TareaController::class, 'index']);
Router::post('/api/tarea', [TareaController::class, 'crear']);
Router::post('/api/tarea/actualizar', [TareaController::class, 'actualizar']);
Router::post('/api/tarea/eliminar', [TareaController::class, 'eliminar']);

Router::dispatch();