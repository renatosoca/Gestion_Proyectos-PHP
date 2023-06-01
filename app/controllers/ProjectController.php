<?php

namespace App\Controllers;

use App\Models\Project;
use App\Router;
use Model\Usuario;
use Model\Proyecto;

class ProjectController {

  public static function index() {
    session_start();
    //isAuth();

    //$proyectos = Proyecto::belongsTo('usuarioId', $_SESSION['id']);
    $projects = Project::findAll('usuarioId', /*$_SESSION['userId']*/ 1);

    Router::render('dashboard/index', 'ProjectLayout', [
      'title' => 'Dashboard',
      'projects' => $projects,
      'name' => $_SESSION['name'] ?? '',
      'lastname' => $_SESSION['lastname'] ?? '',
    ]);

    exit;
  }

  public static function project( string $project = '') {
    session_start();
    isAuth();
    $project = sanitize($project);
    
    $projectExist = Project::findOne('url', $project);

    if (!$projectExist) return Router::redirect('/dashboard');

    if ($projectExist->user_id !== $_SESSION['id']) return Router::redirect('/dashboard');

    Router::render('dashboard/project', 'ProjectLayout', [
      'title' => $projectExist->proyecto,
      'name' => $_SESSION['name'] ?? '',
    ]);

    exit;
  }

  public static function createProject() {
    session_start();
    isAuth();

    $alerts = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $project = new Project($_POST);
      $alerts = $project->validar();

      if (empty($alerts)) {
        $project->generarURL();
        $project->usuarioId = $_SESSION['userId'] ?? 1;
        
        $resultado = $project->save();
        if ($resultado) {
          header('Location: /project/'.$project->url);
        }
      }
    }

    Router::render('dashboard/createProject', 'ProjectLayout', [
      'title' => 'Crear Proyecto',
      'alerts' => $alerts,
      'name' => $_SESSION['name'] ?? '',
    ]);

    exit;
  }
}