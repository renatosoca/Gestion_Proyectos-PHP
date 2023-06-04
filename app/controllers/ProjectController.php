<?php

namespace App\Controllers;

use App\Router;
use App\Models\Project;

class ProjectController {

  public static function index() {
    session_start();
    //isAuth();

    $projects = Project::findAll('user_id', $_SESSION['userId']);

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
    
    $projectExist = Project::findOne('projectName', $project);

    if (empty($projectExist)) return Router::redirect('/dashboard');

    if ($projectExist->user_id !== $_SESSION['userId']) return Router::redirect('/dashboard');

    Router::render('dashboard/project', 'ProjectLayout', [
      'title' => $projectExist->name,
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
        $project->user_id = $_SESSION['userId'];
        
        $result = $project->save();

        if (is_array($result)) Router::redirect('/project/'.$project->projectName);
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