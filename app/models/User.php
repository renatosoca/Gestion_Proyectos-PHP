<?php
namespace App\Models;

class User extends Model {

    protected static string $table = 'users';
    protected static array $columnsDB = ['id', 'name', 'lastname', 'email', 'password', 'hasVerifiedEmail', 'token'];

    public string $id;
    public $name;
    public $lastname;
    public $email;
    public $password;
    public $password2;
    public $password_actual;
    public $password_nuevo;
    public $token;
    public $hasVerifiedEmail;

    function __construct($args = []) {
      $this->id = $args['id'] ?? '';
      $this->name = $args['name'] ?? '';
      $this->lastname = $args['lastname'] ?? '';
      $this->email = $args['email'] ?? '';
      $this->password = $args['password'] ?? '';
      $this->password2 = $args['password2'] ?? '';
      $this->password_actual = $args['password_actual'] ?? '';
      $this->password_nuevo = $args['password_nuevo'] ?? '';
      $this->token = $args['token'] ?? '';
      $this->hasVerifiedEmail = $args['hasVerifiedEmail'] ?? '';
    }

    public function userValidate() {
      if (!$this->email) self::$alerts['error'][] = 'El Email es obligatorio';
      if ($this->email && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) self::$alerts['error'][] = 'El Email no válido';
      if (!$this->password) self::$alerts['error'][] = 'La contraseña es obligatorio';
      if (!$this->password && strlen( $this->password)) self::$alerts['error'][] = 'La contraseña debe ser mayor a 6 caracteres';
  
      return self::$alerts;
    }

    public function validateData(): array {
      if ($this->password !== $this->password2) {
        self::$alerts['error'][] = 'Los password son diferentes';
      }

      if (!$this->name) self::$alerts['error'][] = 'El Nombre es Obligatorio';
      if (!$this->lastname) self::$alerts['error'][] = 'El Apellido es Obligatorio';
      if (!$this->email) self::$alerts['error'][] = 'El Email es Obligatorio';
      if (!$this->password) self::$alerts['error'][] = 'La contraseña es Obligatorio';
      if ($this->password && strlen($this->password) < 6) self::$alerts['error'][] = 'La contraseña debe tener al menos 6 caracteres';
  
      return self::$alerts;
    }

    public function validateEmail(): array {
      if (!$this->email) self::$alerts['error'][] = 'El Email es Obligatorio';
      if ($this->email && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) self::$alerts['error'][] = 'El Email no válido';
  
      return self::$alerts;
    }

    public function validatePassword(): array {
      if (!$this->password) self::$alerts['error'][] = 'La contraseña es Obligatorio';
      if (strlen($this->password) < 6) self::$alerts['error'][] = 'La contraseña debe tener al menos 6 caracteres';
  
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

    public function hashPassword(): void {
      $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function verifyPassword(string $password): bool {
      $response = password_verify($password, $this->password);
  
      return $response;
    }

    public function generateToken(): void {
      $this->token = bin2hex(random_bytes(32));
    }
}