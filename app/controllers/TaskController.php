<?php
namespace App\Controllers;

use App\Router;
use App\Models\Project;
use App\Models\Task;

class TaskController {

  public static function allTasks( string $project = '') {
    if (session_status() === PHP_SESSION_NONE) session_start();

    $project = sanitize($project);

    if ($project === '') Router::redirect('/dashboard');
    $projectExist = Project::findOne('projectName', $project);

    if (!$projectExist || $projectExist->user_id !== $_SESSION['userId']) return json_encode(['error' => 'No existe el proyecto']);
    $task = Task::belongsTo('project_id', $projectExist->id);
    
    return $task;
  }

  public static function getTask( string $id = '') {
    if (session_status() === PHP_SESSION_NONE) session_start();

    $id = sanitize($id);

    if ($id === '') return json_encode(['error' => 'No existe la tarea']);
    $task = Task::findOne('id', $id);

    if (!$task || $task->user_id !== $_SESSION['userId']) return json_encode(['error' => 'No existe la tarea']);
    
    return $task;
  }

  public function createTask() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    
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
        'project_id' => $project->id,
        'status' => $task->status
      ];

      return $response;
    }
  }

  public static function updateTask() {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $proyecto = Project::findOne('url', $_POST['proyectoId']);
      if (!$proyecto || $proyecto->usuarioId !== $_SESSION['id']) {
        $respuesta = [
          'tipo' => 'error',
          'mensaje' => 'Hubo un error al actualizar la tarea'
        ];
        echo json_encode($respuesta);
        return;
      }
      $tarea = new Task($_POST);
      $tarea->project_id = $proyecto->id;
      $resultado = $tarea->save();
      $respuesta = [
        'tipo' => 'exito',
        'id' => $tarea->id,
        'mensaje' => 'Actualizado Correctamente',
        'proyectoId' => $proyecto->id
      ];

      return $respuesta;
    }
  }

  public static function deleteTask() {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $proyecto = Project::findOne('url', $_POST['proyectoId']);

      if (!$proyecto || $proyecto->usuarioId !== $_SESSION['id']) {
        $respuesta = [
          'tipo' => 'error',
          'mensaje' => 'Hubo un error al Eliminar la tarea'
        ];
        
        return $respuesta;
      }

      $tarea = new Task($_POST);
      $tarea->project_id = $proyecto->id;
      $resultado = $tarea->delete();
      if ($resultado) {
        $respuesta = [
          'tipo' => 'exito',
          'id' => $tarea->id,
          'mensaje' => 'Actualizado Correctamente',
          'proyectoId' => $proyecto->id
        ];
        
        return $respuesta;
      }
    }
  }
}