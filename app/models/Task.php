<?php
namespace App\Models;

class Task extends Model {

  protected static string $table = 'tasks';
  protected static array $columnsDB = ['id', 'name', 'project_id', 'status'];

  public string $id;
  public string $name;
  public string $project_id;
  public string $status;

  function __construct($args = []) {
    $this->id = $args['id'] ?? '';
    $this->name = $args['name'] ?? '';
    $this->project_id = $args['project_id'] ?? '';
    $this->status = $args['status'] ?? 'pending';
  }
}