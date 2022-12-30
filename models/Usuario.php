<?php
namespace Model;

class Usuario extends ActiveRecord {

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $token;
    public $confirmado;

    function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? '';
    }

    public function validar() {
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if (strlen( $this->password ) < 6 ) {
            self::$alertas['error'][] = 'El password debe ser mayor a 6 caracteres';
        }
        return self::$alertas;
    }

    public function validarNuevoUsuario( ) {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if (strlen( $this->password ) < 6 ) {
            self::$alertas['error'][] = 'El password debe ser mayor a 6 caracteres';
        }
        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Los password son diferentes';
        }

        return self::$alertas;
    }

    public function validarEmail() {
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }

        return self::$alertas;
    }

    public function validarPass() {
        if (!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if (strlen( $this->password ) < 6 ) {
            self::$alertas['error'][] = 'El password debe ser mayor a 6 caracteres';
        }
        return self::$alertas;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function generarToken() {
        $this->token = uniqid();
    }
}