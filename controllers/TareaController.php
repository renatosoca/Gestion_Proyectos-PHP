<?php
namespace Controller;

use Model\Proyecto;
use Model\Tarea;

class TareaController {

    public static function index() {
        session_start();
        $url = s($_GET['token']);

        if (!$url) header('Location: /dashboard');
        $proyecto = Proyecto::where('url', $url);

        if (!$proyecto || $proyecto->usuarioId !== $_SESSION['id']) header('Location: /404');
        $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);
        echo json_encode($tareas);
    }

    public static function crear() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = Proyecto::where('url', $_POST['proyectoId']);

            if (!$proyecto || $proyecto->usuarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al agregar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            }
            
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();
            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'mensaje' => 'Agregado Correctamente',
                'proyectoId' => $proyecto->id
            ];
            echo json_encode($respuesta);
        }
    }

    public static function actualizar() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = Proyecto::where('url', $_POST['proyectoId']);
            if (!$proyecto || $proyecto->usuarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al actualizar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            }
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();
            $respuesta = [
                'tipo' => 'exito',
                'id' => $tarea->id,
                'mensaje' => 'Actualizado Correctamente',
                'proyectoId' => $proyecto->id
            ];
            echo json_encode($respuesta);
        }
    }

    public static function eliminar() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = Proyecto::where('url', $_POST['proyectoId']);

            if (!$proyecto || $proyecto->usuarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al Eliminar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            }

            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->eliminar();
            if ($resultado) {
                $respuesta = [
                    'tipo' => 'exito',
                    'id' => $tarea->id,
                    'mensaje' => 'Actualizado Correctamente',
                    'proyectoId' => $proyecto->id
                ];
                echo json_encode($respuesta);
            }
        }
    }
}