<?php 

require_once __DIR__ . '/../app/main.php';

use App\Router;
use App\Controllers\AuthController;
use App\Controllers\TaskController;
use App\Controllers\ProjectController;

Router::get('/', [AuthController::class, 'AuthUser']);
Router::post('/', [AuthController::class, 'AuthUser']);

Router::get('/logout', function() {
  session_start();
  $_SESSION = [];
  Router::redirect('/');
});

Router::get('/register', [AuthController::class, 'createUser']);
Router::post('/register', [AuthController::class, 'createUser']);
Router::get('/confirm-account/:token', [AuthController::class, 'confirmAccount']);

Router::get('/forgot-password', [AuthController::class, 'forgotPassword']);
Router::post('/forgot-password', [AuthController::class, 'forgotPassword']);

Router::get('/reset-password/:token', [AuthController::class, 'reserPassword']);
Router::post('/reset-password/:token', [AuthController::class, 'reserPassword']);

Router::get('/message', function() {
  Router::render('auth/message', 'AuthLayout', [
    'title' => 'Mensaje'
  ]);
});


Router::get('/dashboard', [ProjectController::class, 'index']);

Router::get('/create-project', [ProjectController::class, 'createProject']);
Router::post('/create-project', [ProjectController::class, 'createProject']);

Router::get('/project/:project', [ProjectController::class, 'project']);

Router::get('/user/profile', [AuthController::class, 'profile']);
Router::post('/user/profile', [AuthController::class, 'profile']);

Router::get('/user/change-password', [AuthController::class, 'changePassword']);
Router::post('/user/change-password', [AuthController::class, 'changePassword']);


//API para las tareas
Router::get('/api/v1/tasks/:project', [TaskController::class, 'allTasks']);
Router::get('/api/v1/task/get/:id', [TaskController::class, 'getTask']);
Router::post('/api/v1/task/create', [TaskController::class, 'createTask']);
Router::post('/api/v1/task/update/:id', [TaskController::class, 'updateTask']);
Router::post('/api/v1/task/delete/:id', [TaskController::class, 'deleteTask']);

Router::dispatch();