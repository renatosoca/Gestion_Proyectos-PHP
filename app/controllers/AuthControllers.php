<?php

namespace App\Controllers;

use App\Router;

use App\Utils\Email;
use Model\Usuario;

class AuthController {

  public static function login() {
    $alertas = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user = new Usuario($_POST);
      $alertas = $user->validar();

      if (empty( $alertas )) {
        //Comprobar si existe el usuario
        $user = Usuario::where('email', $user->email);
        if ($user && $user->confirmado === '1') {
          if ( password_verify($_POST['password'], $user->password) ) {
            session_start();
            $_SESSION['id'] = $user->id;
            $_SESSION['nombre'] = $user->nombre;
            $_SESSION['email'] = $user->email;
            $_SESSION['login'] = true;

            header('Location: /dashboard');
          } else {
            Usuario::setAlerta('error', 'Password Incorrecto');
          }
        } else {
          Usuario::setAlerta('error', 'Usuario no encontrado');
        }
      }
    }

    $alertas = Usuario::getAlertas();

    Router::render('auth/login', '', [
      'titulo' => 'login',
      'alertas' => $alertas
    ]);

    return;
  }

  public static function crear( ) {
    $alertas = [];
    $usuario = new Usuario;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $usuario = new Usuario($_POST);
      $alertas = $usuario->validarNuevoUsuario();

      if (empty($alertas)) {
        $existeUsuario = Usuario::where('email', $usuario->email);

        if ($existeUsuario) {
          Usuario::setAlerta('error', 'El email ya existe');
        } else {
          $usuario->hashPassword();
          //unset($usuario->password2); //Eliminar un campo del modelo
          $usuario->generarToken();
          $resultado = $usuario->guardar();

          /* $email = new Email($usuario->nombre, $usuario->lastname, $usuario->email, $usuario->token);
          $email->SendMail(
            'forgotPassword',
            'Recuperar Contraseña',
            'Recuperar Contraseña',
            $_ENV['HOST']. '/forgot-password/' . $usuario->token,
          ); */

          if ($resultado) {
            header('Location: /mensaje');
          }
        }
      }
    }

    $alertas = Usuario::getAlertas();
    Router::render('auth/crear', '', [
      'titulo' => 'Crear Cuenta',
      'usuario' => $usuario,
      'alertas' => $alertas
    ]);

    return;
  }

  public static function olvide() {
    $alertas = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $usuario = new Usuario($_POST);
      $alertas = $usuario->validarEmail();

      if (empty($alertas)) {
        $usuario = Usuario::where('email', $usuario->email);

        if ( $usuario && $usuario->confirmado === '1' ) {
          $usuario->generarToken();
          unset($usuario->password2);
          $usuario->guardar();

          $email = new Email($usuario->nombre, $usuario->lastname, $usuario->email, $usuario->token);
          $email->SendMail(
            'forgotPassword',
            'Recuperar Contraseña',
            'Recuperar Contraseña',
            $_ENV['HOST']. '/forgot-password/' . $usuario->token,
          );

          Usuario::setAlerta('exito', 'Revisa tu Email');
        } else {
          Usuario::setAlerta('error', 'El usuario no existe o no está confirmado');
        }
      }
    }

    $alertas = Usuario::getAlertas();
    Router::render('auth/olvide', '', [
      'titulo' => 'Olvide',
      'alertas' => $alertas
    ]);
  }

  public static function recuperar() {
    $token = s($_GET['token']);
    $mostrar = true;

    if( !$token) return header('Location: /');
    $usuario = Usuario::where('token', $token);

    if (empty($usuario) || $usuario->token === '') {
      $alertas = Usuario::setAlerta('error', 'No existe el Token');
      $mostrar = false;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $usuario->sincronizar($_POST);
      $alertas = $usuario->validarPass();
      if (empty($alertas)) {
        $usuario->hashPassword();
        $usuario->token = '';
        $resultado = $usuario->guardar();
        if ($resultado) {
          header('Location: /');
        }
      }
    }

    $alertas = Usuario::getAlertas();
    Router::render('auth/recuperar', '', [
      'titulo' => 'Recuperar Clave',
      'alertas' => $alertas,
      'mostrar' => $mostrar
    ]);
  }

  public static function mensaje() {

    Router::render('auth/mensaje', '', [
      'titulo' => 'Mensaje'
    ]);
  }

  public static function confirmar() {
    $token = s($_GET['token']);

    if( !$token) return header('Location: /');

    $usuario = Usuario::where('token', $token);

    if (empty($usuario) || $usuario->token === '') {
      $alertas = Usuario::setAlerta('error', 'No existe el Token');
    } else {
      $usuario->confirmado = 1;
      $usuario->token = '';
      unset($usuario->password2);

      $usuario->guardar();
      Usuario::setAlerta('exito', 'Cuenta Confirmada Correctamente');
    }

    $alertas = Usuario::getAlertas();
    Router::render('auth/confirmar', '', [
      'titulo' => 'Confirmar Cuenta',
      'alertas' => $alertas
    ]);
  }
}