<?php

namespace App\Controllers;

use App\Cores\Router;
use App\Models\Project;

class ProjectController {

  public static function index() {
    $isAuth = isAuth();
    if (!$isAuth) Router::redirect('/');

    $projects = Project::findAll('user_id', $_SESSION['userId']);

    Router::render('projects/index', 'ProjectLayout', [
      'title' => 'Tus Proyectos',
      'projects' => $projects,
      'name' => explode( ' ', $_SESSION['name'])[0] ?? '',
      'lastname' => explode( ' ', $_SESSION['lastname'])[0] ?? '',
    ]);

    exit;
  }

  public static function project( string $project = '') {
    $isAuth = isAuth();
    if (!$isAuth) Router::redirect('/');

    $project = sanitize($project);
    
    $projectExist = Project::findOne('projectName', $project);

    if (empty($projectExist)) return Router::redirect('/dashboard');

    if ($projectExist->user_id !== $_SESSION['userId']) return Router::redirect('/dashboard');

    Router::render('projects/project', 'ProjectLayout', [
      'title' => $projectExist->name,
      'name' => explode( ' ', $_SESSION['name'])[0] ?? '',
      'lastname' => explode( ' ', $_SESSION['lastname'])[0] ?? '',
    ]);

    exit;
  }

  public static function createProject() {
    $isAuth = isAuth();
    if (!$isAuth) Router::redirect('/');

    $alerts = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $project = new Project($_POST);
      $alerts = $project->validar();

      if (empty($alerts)) {
        $project->generarURL();
        $project->user_id = $_SESSION['userId'];
        
        $result = $project->save();

        if (is_array($result)) Router::redirect('/project/'.$project->projectName);
      }
    }

    Router::render('projects/createProject', 'ProjectLayout', [
      'title' => 'Crear Proyecto',
      'alerts' => $alerts,
      'name' => explode( ' ', $_SESSION['name'])[0] ?? '',
      'lastname' => explode( ' ', $_SESSION['lastname'])[0] ?? '',
    ]);

    exit;
  }
}