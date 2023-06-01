<?php
namespace App\Models;

class User extends Model {

    protected static $table = 'usuarios';
    protected static $columnsDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public $id;
    public $nombre;
    public $lastname;
    public $email;
    public $password;
    public $password2;
    public $password_actual;
    public $password_nuevo;
    public $token;
    public $confirmado;

    function __construct($args = []) {
      $this->id = $args['id'] ?? '';
      $this->nombre = $args['nombre'] ?? '';
      $this->lastname = $args['lastname'] ?? '';
      $this->email = $args['email'] ?? '';
      $this->password = $args['password'] ?? '';
      $this->password2 = $args['password2'] ?? '';
      $this->password_actual = $args['password_actual'] ?? '';
      $this->password_nuevo = $args['password_nuevo'] ?? '';
      $this->token = $args['token'] ?? '';
      $this->confirmado = $args['confirmado'] ?? '';
    }

    public function validar() {
      if (!$this->email) {
        self::$alerts['error'][] = 'El email es obligatorio';
      }
      if (!$this->password) {
        self::$alerts['error'][] = 'El password es obligatorio';
      }
      if (strlen( $this->password ) < 6 ) {
        self::$alerts['error'][] = 'El password debe ser mayor a 6 caracteres';
      }
      return self::$alerts;
    }

    public function validarUSuario() {
      if (!$this->nombre) {
        self::$alerts['error'][] = 'El nombre es obligatorio';
      }
      if (!$this->email) {
        self::$alerts['error'][] = 'El email es obligatorio';
      }
      if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        self::$alerts['error'][] = 'Email no válido';
      }
      return self::$alerts;
    }

    public function validarNuevoUsuario( ) {
      if (!$this->nombre) {
        self::$alerts['error'][] = 'El nombre es obligatorio';
      }
      if (!$this->email) {
        self::$alerts['error'][] = 'El email es obligatorio';
      }
      if (!$this->password) {
        self::$alerts['error'][] = 'El password es obligatorio';
      }
      if (strlen( $this->password ) < 6 ) {
        self::$alerts['error'][] = 'El password debe ser mayor a 6 caracteres';
      }
      if ($this->password !== $this->password2) {
        self::$alerts['error'][] = 'Los password son diferentes';
      }

      return self::$alerts;
    }

    public function validarEmail() {
      if (!$this->email) {
        self::$alerts['error'][] = 'El email es obligatorio';
      }
      if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        self::$alerts['error'][] = 'Email no válido';
      }

      return self::$alerts;
    }

    public function validarPass() {
      if (!$this->password) {
        self::$alerts['error'][] = 'El password es obligatorio';
      }
      if (strlen( $this->password ) < 6 ) {
        self::$alerts['error'][] = 'El password debe ser mayor a 6 caracteres';
      }
      return self::$alerts;
    }

    public function validarPassNuevo() {
      if (!$this->password_actual) {
        self::$alerts['error'][] = 'El password actual es obligatorio';
      }
      if (!$this->password_nuevo) {
        self::$alerts['error'][] = 'El password nuevo es obligatorio';
      }
      if (strlen( $this->password_nuevo ) < 6 ) {
        self::$alerts['error'][] = 'El password debe ser mayor a 6 caracteres';
      }
      return self::$alerts;
    }

    public function comprobarPassword(): bool {
      return password_verify($this->password_actual, $this->password);
    }

    public function hashPassword(): void {
      $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function generarToken(): void {
      $this->token = uniqid();
    }
}