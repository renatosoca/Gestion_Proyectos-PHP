<?php
namespace App\Controllers;

use App\Router;
use App\Models\Project;
use App\Models\Task;

class TaskController {

  public static function allTasks( string $project = '') {
    session_start();
    $url = sanitize($project);

    if (!$url) return Router::redirect('/dashboard');
    $projectExist = Project::findOne('url', $url);

    if (!$projectExist || $projectExist->usuarioId !== $_SESSION['id']) header('Location: /404');
    $tareas = Task::belongsTo('proyectoId', $projectExist->id);
    
    return $tareas;
  }

  public static function createTask() {
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $proyecto = Project::findOne('url', $_POST['proyectoId']);

      if (!$proyecto || $proyecto->usuarioId !== $_SESSION['id']) {
        $respuesta = [
          'tipo' => 'error',
          'mensaje' => 'Hubo un error al agregar la tarea'
        ];

        return $respuesta;
      }
      
      $tarea = new Task($_POST);
      $tarea->proyectoId = $proyecto->id;
      $resultado = $tarea->save();
      $respuesta = [
        'tipo' => 'exito',
        'id' => $resultado['id'],
        'mensaje' => 'Agregado Correctamente',
        'proyectoId' => $proyecto->id
      ];

      return $respuesta;
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
      $tarea->proyectoId = $proyecto->id;
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
      $tarea->proyectoId = $proyecto->id;
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