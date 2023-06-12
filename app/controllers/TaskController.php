<?php
namespace App\Controllers;

use App\Cores\Router;
use App\Models\Task;
use App\Models\Project;

class TaskController {

  public static function allTasks( string $project = '') {
    $isAuth = isAuth();
    if (!$isAuth) return ['error' => 'No hay usuario autenticado'];

    $project = sanitize($project);

    if ($project === '') Router::redirect('/dashboard');
    $projectExist = Project::findOne('projectName', $project);

    if (!$projectExist || $projectExist->user_id !== $_SESSION['userId']) return json_encode(['error' => 'No existe el proyecto']);
    $task = Task::belongsTo('project_id', $projectExist->id);
    
    return $task;
  }

  public static function getTask( string $id = '') {
    $isAuth = isAuth();
    if (!$isAuth) return ['error' => 'No hay usuario autenticado'];

    $id = sanitize($id);

    if ($id === '') return json_encode(['error' => 'No existe la tarea']);
    $task = Task::findOne('id', $id);

    if (!$task) return json_encode(['error' => 'No existe la tarea']);
    
    return $task;
  }

  public function createTask() {
    $isAuth = isAuth();
    if (!$isAuth) return ['error' => 'No hay usuario autenticado'];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $project = Project::findOne('projectName', $_POST['project_id']);

      if (!$project || $project->user_id !== $_SESSION['userId']) {
        $response = [
          'tipo' => 'error',
          'mensaje' => 'Hubo un error al agregar la tarea'
        ];

        return $response;
      }
      
      $task = new Task($_POST);
      $task->project_id = $project->id;
      $result = $task->save();
      $response = [
        'id' => $result['id'],
        'name' => $task->name,
        'project_id' => $task->project_id,
        'status' => $task->status
      ];

      return $response;
    }
  }

  public function updateTask() {
    $isAuth = isAuth();
    if (!$isAuth) return ['error' => 'No hay usuario autenticado'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $project = Project::findOne('id', $_POST['project_id']);
      if (!$project || $project->user_id !== $_SESSION['userId']) {
        $response = [
          'tipo' => 'error',
          'mensaje' => 'Hubo un error al actualizar la tarea'
        ];
        
        return $response;
      }

      $task = new Task($_POST);
      $task->project_id = $project->id;
      $result = $task->save();
      $response = [
        'id' => $task->id,
        'name' => $task->name,
        'project_id' => $project->id,
        'status' => $task->status
      ];

      return $response;
    }
  }

  public static function deleteTask( string $id = '') {
    $isAuth = isAuth();
    if (!$isAuth) return ['error' => 'No hay usuario autenticado'];
    
    $id = sanitize($id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $project = Project::findOne('projectName', $_POST['projectId']);

      if (!$project || $project->user_id !== $_SESSION['userId']) {
        $response = [
          'tipo' => 'error',
          'mensaje' => 'Hubo un error al Eliminar la tarea'
        ];
        
        return $response;
      }

      $task = new Task(['id' => $id]);
      $task->project_id = $project->id;
      $result = $task->delete();
      return $result;
    }
  }
}