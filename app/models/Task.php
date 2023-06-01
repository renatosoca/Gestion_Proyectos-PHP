<?php
namespace App\Models;

class Task extends Model {

  protected static $table = 'tareas';
  protected static $columnsDB = ['id', 'nombre', 'estado', 'proyectoId'];

  public string $id;
  public string $nombre;
  public int $estado;
  public string $proyectoId;

  function __construct($args = []) {
    $this->id = $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? '';
    $this->estado = $args['estado'] ?? 0;
    $this->proyectoId = $args['proyectoId'] ?? '';
  }
}