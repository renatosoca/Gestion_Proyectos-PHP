<?php
namespace App\Models;

class Project extends Model {
  protected static string $table = 'projects';
  protected static array $columnsDB = ['id', 'name', 'projectName', 'user_id'];

  public string $id;
  public string $name;
  public string $projectName;
  public string $user_id;

  function __construct($args = []) {
    $this->id = $args['id'] ?? '';
    $this->name = $args['name'] ?? '';
    $this->projectName = $args['projectName'] ?? '';
    $this->user_id = $args['user_id'] ?? '';
  }

  public function validar() {
    if (!$this->name ) {
      self::$alerts['error'][] = 'El Nombre del proyecto es obligatorio';
    }
    return self::$alerts;
  }

  public function generarURL() {
    $this->projectName = uniqid();
  }
}