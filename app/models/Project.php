<?php
namespace App\Models;

class Project extends Model {
  protected static string $table = 'proyectos';
  protected static array $columnsDB = ['id', 'proyecto', 'url', 'usuarioId'];

  public string $id;
  public string $proyecto;
  public string $url;
  public string $usuarioId;

  function __construct($args = []) {
    $this->id = $args['id'] ?? '';
    $this->proyecto = $args['nombre'] ?? '';
    $this->url = $args['url'] ?? '';
    $this->usuarioId = $args['usuarioId'] ?? '';
  }

  public function validar() {
    if (!$this->proyecto ) {
      self::$alerts['error'][] = 'El Nombre del proyecto es obligatorio';
    }
    return self::$alerts;
  }

  public function generarURL() {
    $this->url = uniqid();
  }
}